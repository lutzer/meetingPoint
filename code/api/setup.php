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
			"text" => "Lorem ipsum",
			"image" => "sladhkjsad.jpg",
			"category_id" => 5,
			"category_text" => "cat2"
	));
	$db->insertSubmission(array(
			"id" => null,
			"title" => "Life 2",
			"text" => "Lorem ipsum 2",
			"image" => "2.jpg",
			"category_id" => 1,
			"category_text" => "cat1"
	));
	
	$result = $db->listSubmissions();
	var_dump($result);
