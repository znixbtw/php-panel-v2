<?php

// Extends to class Cheat
// Only Public methods

require_once SITE_ROOT . '/app/models/CheatModel.php';

class CheatController extends Cheat {

	// Get number of users
	public function getCheatData() {
		return $this->cheatData();
	}

}
