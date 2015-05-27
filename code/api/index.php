<?php

	require_once('config.php');
	require_once("SubmissionDatabase.php");
	require_once('RestServer.php');
	

	$UPLOAD_ALLOWED_EXTENSIONS = array("jpg", "jpeg", "gif", "png");

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

	}
	
	function checkFileType($fileName) {
		
		global $UPLOAD_ALLOWED_EXTENSIONS;
		
		$extension = pathinfo($fileName, PATHINFO_EXTENSION);
		if(!in_array($extension, $UPLOAD_ALLOWED_EXTENSIONS)) {
			throw new Exception('Only these file extensions are allowed: '.implode(", .",$UPLOAD_ALLOWED_EXTENSIONS));
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