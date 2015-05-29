<?php

	require_once('config.php');
	require_once("SubmissionDatabase.php");
	require_once("QuestionDatabase.php");
	require_once('RestServer.php');
	

	class Controller {
		
		/* function authorizes user */
		function authorize() {
			if (!isset($_SERVER['PHP_AUTH_USER']))
				return false;

			// check password
			if ($_SERVER['PHP_AUTH_USER'] == "admin" &&
				$_SERVER['PHP_AUTH_PW'] == "letterbox")
				return true;
				
			return false;	
		}

		/**
		* @noAuth
		* @url GET /?submissions
		*/
		function listSubmissions() {
			$db = new SubmissionDatabase();
			$result = $db->listSubmissions();
			return $result;
		}
		
		/**
		 * @noAuth
		 * @url POST /?submissions
		 * @url PUT /?submissions/$id
		 */
		function insertSubmission($id = null,$data) {
			
			if ($data == null)
				$data = $_POST;
			
			//add new entry
			if ($id == null) {
				
				//check if file submitted
				$fileSubmitted = isset($_FILES['file']) && !empty($_FILES['file']['name']);
				$file = null;
				
				if ($fileSubmitted) {
					$file = $_FILES['file'];
					$data['image_result'] = $file['name'];
				}
				
				//insert into database
				$db = new SubmissionDatabase();
				$db->insertSubmission($data);
				$id = $db->lastInsertRowid();
				
				//upload file
				if ($fileSubmitted) {
					$upload_dir = DIR_SUBMISSION_FILES.'/'.$id;
					try {
						checkFileType($file['name'],array("jpg", "jpeg", "gif", "png"));
						uploadFile($file['tmp_name'],$upload_dir,$file['name']);
					} catch (Exception $e) {
						// delete entry if upload failed
						$db->deleteSubmission($id);
						throw new RestException(400, $e->getMessage());
					}
				}
			
				return $db->getSubmission($id);
			
			// modify entry
			} else {
				//insert Model and return it
				$db = new SubmissionDatabase();
				$db->insertSubmission($data);
				return $db->getSubmission($id);
			}
		}
		
		/**
		 *
		 * @url GET /?submissions/$id
		 */
		function deleteSubmission($id) {
			$db = new SubmissionDatabase();
			$result = $db->deleteSubmission($id);
			return array();
		}
		
		/**
		 * @noAuth
		 * @url GET /?questions
		 */
		function listQuestions() {
			$db = new QuestionDatabase();
			$result = $db->listQuestions();
			return $result;
		}
		
		/**
		 * @noAuth
		 * @url GET /?questions/$id
		 */
		function getQuestion($id) {
			$db = new QuestionDatabase();
			$result = $db->getQuestion($id);
			return $result;
		}

	}
	
	function checkFileType($fileName,$allowed_extensions) {
		
		$extension = pathinfo($fileName, PATHINFO_EXTENSION);
		if(!in_array($extension, $allowed_extensions)) {
			throw new Exception('Only these file extensions are allowed: '.implode(", ",$allowed_extensions));
		}
	}
	
	function uploadFile($tmp_file,$path,$filename) {
		
		//check if upload dir exists, else create it
		if(!is_dir($path))
			mkdir($path,0755);
		
		if (is_uploaded_file($tmp_file)) {
			// delete file if it exists
			$createFile = $path.'/'.$filename;
			if (is_file($createFile))
				unlink($createFile);
			move_uploaded_file($tmp_file,$createFile);
		} else {
			throw new Exception('Could not copy file');
		}
	}
	
	function deleteDirectory($directory) {
		
		//throw new RestException(400,$directory);
		
		if (!is_dir($directory))
			return;
		
		
		// delete content
		$files = glob($directory . '/*', GLOB_MARK);
		foreach ($files as $file) {
			unlink($file);
		}
		
		//delete empty directory
		rmdir($directory);
	}

	spl_autoload_register(); // don't load our classes unless we use them

	$mode = 'debug'; // 'debug' or 'production'
	$server = new RestServer($mode);

	$server->addClass('Controller');
	$server->handle();