<?php

require_once("config.php");

class QuestionDatabase {
	function __construct() {
		
		$this->questions = array();
		array_push ( $this->questions, array (
		"title" => "Describe this space",
		"category" => "location",
		"image_question" => "Make both a selfie and write some text.",
		"text_question" => "Describe yourself in a few sentences."
				));
		array_push ( $this->questions, array (
				"title" => "Describe this space",
				"category" => "location",
				"image_question" => "Make both a selfie and write some text.",
				"text_question" => "Describe yourself in a few sentences." 
		) );
		array_push ( $this->questions, array (
				"title" => "Describe this space",
				"category" => "location",
				"image_question" => "Make both a selfie and write some text.",
				"text_question" => "Describe yourself in a few sentences." 
		) );
		
		array_push ( $this->questions, array (
			"title" => "Describe this space",
			"category" => "location",
			"image_question" => "Make both a selfie and write some text.",
			"text_question" => "Describe yourself in a few sentences." 
		));
		
		array_push($this->questions,array(
			"title" => "Describe yourself.",
			"category" => "people",
			"image_question" => "Make both a selfie and write some text.",
			"text_question" => "Describe yourself in a few sentences."
		));
		
		array_push($this->questions,array(
			"title" => "Tell us something about the people here.",
			"category" => "people",
			"image_question" => "Make only a selfie.",
			"text_question" => null
		));
		
		array_push($this->questions,array(
			"title" => "test2 event",
			"category" => "event",
			"image_question" => null,
			"text_question" => "Only Describe yourself in a few sentences."
		));
		array_push($this->questions,array(
			"title" => "test5 event",
			"category" => "event",
			"image_question" => null,
			"text_question" => "Lorem ipsum?"
		));
	}

	function create() {

	}

	function drop() {
		
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