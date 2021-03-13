<?php

// Extends to class Admin
// Only Public methods

require_once SITE_ROOT . '/app/models/AdminModel.php';

class AdminController extends Admin {

	
	//
	public function getUserArray() {
		
		return $this->UserArray();

	}


	//
	public function getInvCodeArray() {

		return $this->invCodeArray();

	}


	//
	public function getSubCodeArray() {

		return $this->subCodeArray();

	}


	//
	public function getInvCodeGen($username) {

		$code = Util::randomCode(20);
		return $this->invCodeGen($code, $username);

	}


	//
	public function getSubCodeGen($username) {

		$code = Util::randomCode(20);
		return $this->subCodeGen($code, $username);

	}


	// 
	public function resetHWID($uid) {
		
		return $this->HWID($uid);

	}

	// 
	public function setBanned($uid) {
		
		return $this->banned($uid);

	}


	// 
	public function setAdmin($uid) {
		
		return $this->administrator($uid);

	}


	//
	public function setCheatStatus() {

		return $this->cheatStatus();
		
	}


	//
	public function setCheatMaint() {

		return $this->cheatMaint();

	}


	//
	public function setCheatVersion($data) {

		return $this->cheatVersion($data);

	}

}
