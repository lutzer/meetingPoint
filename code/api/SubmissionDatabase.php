<?php

require_once("config.php");

class SubmissionDatabase extends SQLite3 {
	function __construct() {
		$this->open(DATABASE_FILE);
	}

	function create() {

		$this->drop();

		//set encoding
		$this->exec("PRAGMA encoding = 'UTF-8'");

		// create document table
		$this->exec("CREATE TABLE ".DATABASE_TABLE_SUBMISSIONS." ".
			"(id INTEGER PRIMARY KEY AUTOINCREMENT,".
			"title TEXT DEFAULT '',".
			"text TEXT DEFAULT '',".
			"image TEXT DEFAULT '',".
			"category_id INTEGER,".
			"category_text TEXT DEFAULT '',".
			"created_at NUMERIC DEFAULT 0".
			")"
		);
	}

	function drop() {
		$this->exec("DROP TABLE ".DATABASE_TABLE_SUBMISSIONS);
	}


	function getSubmission($id) {
		$stmt = $this->prepare("SELECT * ".
		"FROM ".DATABASE_TABLE_SUBMISSIONS." ".
		"WHERE documents.id=:id");
		$stmt->bindValue(":id",$id);
		$result = $stmt->execute();
		if ($result)
			return $result->fetchArray(SQLITE3_ASSOC);
		return array();
	}

	function listSubmissions() {
		$query = "SELECT * FROM ".DATABASE_TABLE_SUBMISSIONS;
		$result = $this->query($query);
		if ($result)
			return $this->fetchAllRows($result,SQLITE3_ASSOC);
		return array();
	}

	//insert or edit
	function insertSubmission($submission) {
		$stmt = $this->prepare("INSERT OR REPLACE INTO ".DATABASE_TABLE_SUBMISSIONS." ".
			"(id,title,text,image,category_id,category_text) VALUES ".
			"(:id,:title,:text,:image,:category_id,:category_text)"
		);

		foreach ($submission as $key => $value)
			$stmt->bindValue(':'.$key,$value);

		$stmt->execute();
	}

	function deleteSubmission($submission) {
		$stmt = $this->prepare("DELETE FROM ".DATABASE_TABLE_SUBMISSIONS." WHERE id=:id");
		$stmt->bindValue(':id',$id);
		$stmt->execute();
	}

	// fetches all rows from a sqlite3 result
	public static function fetchAllRows($result) {
		$rows = array();
		while($row = $result->fetchArray(SQLITE3_ASSOC))
			array_push($rows,$row);
		return $rows;
	}

}