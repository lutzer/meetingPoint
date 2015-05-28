<?php

	require("SubmissionDatabase.php");

	
	// DB TESTS
	
	echo "<h1>SUBMISSIONS DB</h1>";
	$db = new SubmissionDatabase();
	$db->create();
	
	//create topics id,title,text,image,category_id
	$db->insertSubmission(array(
			"id" => null,
			"title" => "Life",
			"text_question" => "Lorem ipsum?",
			"text_result" => "Lorem ipsum!",
			"image_question" => "blabla?",
			"image_result" => "sladhkjsad.jpg",
			"category" => "event"
	));
	$db->insertSubmission(array(
			"id" => null,
			"title" => "Life",
			"text_question" => null,
			"text_result" => null,
			"image_question" => "blabla?",
			"image_result" => "sladhkjsad.jpg",
			"category" => "location"
	));
	
	$result = $db->listSubmissions();
	var_dump($result);
