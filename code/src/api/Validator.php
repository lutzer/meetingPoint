<?php

	/* Validator Rules */
	const VALIDATE_RULE_REQUIRED = 1;
	const VALIDATE_RULE_NON_EMPTY_STRING = 2;
	const VALIDATE_RULE_YEAR = 4;
	const VALIDATE_RULE_TAGS = 8;
	const VALIDATE_RULE_ISBN = 16;

	class Validator {
		
		function __construct($data) {
			$this->data = $data;
		}
		
		function validate($rules) {
			$errors = array();
			foreach ($rules as $field => $rule) {
				$error = $this->validateField($field,$rule);
				if ($error)
					array_push($errors,$error);
			}
			return $errors;
		}
		
		function validateField($field,$rule) {
			
			//check if field is set
			if (($rule & VALIDATE_RULE_REQUIRED) == VALIDATE_RULE_REQUIRED) {
				if (!isset($this->data[$field]) || empty($this->data[$field]))
					return strtoupper($field)." is required.";
			} else {
				if (!isset($this->data[$field]))
					return null;
			}
			
			// check formats
			// check if its an empty string
			if (($rule & VALIDATE_RULE_NON_EMPTY_STRING) == VALIDATE_RULE_NON_EMPTY_STRING) {
				if (trim($this->data[$field])==='')
					return strtoupper($field)." is empty.";
			} 
			// check if its a year
			if (($rule & VALIDATE_RULE_YEAR) == VALIDATE_RULE_YEAR) {
				if (!preg_match("/^[1-9]\d*$/",$this->data[$field]))
					return strtoupper($field)." is not a valid year.";
			}
			//check if its only letters and spaces
			if (($rule & VALIDATE_RULE_TAGS) == VALIDATE_RULE_TAGS) {
				if (!preg_match("/^[\w ]+$/",$this->data[$field]))
					return strtoupper($field)." must contain space seperated words (no special characters).";
			}
			//check if its only numbers and - and x at end
			if (($rule & VALIDATE_RULE_ISBN) == VALIDATE_RULE_ISBN) {
				if (!preg_match("/^([0-9]+[- ]?)*[0-9]*[xX0-9]$/",$this->data[$field]))
					return strtoupper($field)." does not contain a valid isbn number.";
			}
			
			//passed validation
			return  null;			
		}
	
	}