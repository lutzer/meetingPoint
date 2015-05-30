<?php

	require_once('config.php');
	require_once("SubmissionDatabase.php");
	require_once("QuestionDatabase.php");
	require_once('RestServer.php');
	require_once('Validator.php');
	

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
			else 
				$data = get_object_vars($data);
			
			//var_dump($data);
			
			//check if file submitted
			$file = false;
			if (isset($_FILES['file']) && !empty($_FILES['file']['name']) && $_FILES['file']['size'] > 0) {
				$file = $_FILES['file'];
				$data['image_result'] = $file['name'];
			}
			
			//validate
			$validationRules = array();
			if (isset($data['text_question']) && !empty($data['text_question']))
				$validationRules['text_result'] = VALIDATE_RULE_NON_EMPTY_STRING | VALIDATE_RULE_REQUIRED;
			if (isset($data['image_question']) && !empty($data['image_question']))
				$validationRules['image_result'] = VALIDATE_RULE_NON_EMPTY_STRING | VALIDATE_RULE_REQUIRED;
			
			$validator = new Validator($data);
			$errors = $validator->validate($validationRules);
			if (!empty($errors))
				throw new RestException(400, implode(" ",$errors));
				
			
			//add new entry
			if ($id == null) {
				
				//insert into database
				$db = new SubmissionDatabase();
				$db->insertSubmission($data);
				$id = $db->lastInsertRowid();
				
				//upload file
				if ($file) {
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