<?php

// Extends to class Database
// Only Protected methods
// Only interats with 'cheat' table

require_once SITE_ROOT . '/app/core/Database.php';

class Cheat extends Database {

	// Get Cheat Data
	protected function cheatData() {

		$this->prepare('SELECT * FROM `cheat`');
		$this->statement->execute();
		$result = $this->statement->fetch();


		// Status
		$result->status = ((int)$result->status === 0) ? 'Undetected' : 'Detected';

		
		// Maintenance (changed from "-/UNDER" to "Active/No" for the status in Index.php)
		$result->maintenance = ((int)$result->maintenance === 0) ? 'No' : 'Active';


		return $result;

	}

}
