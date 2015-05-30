<?php

require_once("config.php");

class QuestionDatabase {
	function __construct() {
		
		$this->questions = json_decode(file_get_contents(DATABASE_QUESTIONS_FILE), true);
		
	}

	function getQuestion($id) {
		return $this->questions[$id];
	}

	function listQuestions() {
		$questions = array();
		foreach ($this->questions as $key => $value) {
			$question = $value;
			$question['id'] = $key;
			array_push($questions,$question);
		}
			
		return $questions;
	}

	

}