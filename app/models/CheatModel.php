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

		
		// Maintenance
		$result->maintenance = ((int)$result->maintenance === 0) ? '-' : 'UNDER';


		return $result;

	}

}
