<?php

require_once("config.php");

class TopicDatabase {
	function __construct() {
		
		$this->topics = array(
			array(
				"id" => 1,
				"title" => "test",
				"category_id" => ""
			),
			array(
					
			)
		);
	}

	function create() {

	}

	function drop() {
		
	}

	function getTopic($id) {
		return $this->topics[$id];
	}

	function listTopics() {
		return array();
	}

	

}