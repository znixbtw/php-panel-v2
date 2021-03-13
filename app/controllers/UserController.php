<?php

// Extends to class Users
// Only Public methods

require_once SITE_ROOT . '/app/models/UsersModel.php';
require_once 'SessionController.php';

class UserController extends Users {

	public function createUserSession($user) {

		//Session::init();
		Session::set("login", true);
		Session::set("uid", (int) $user->uid);
		Session::set("username", $user->username);
		//Session::set("hwid", $user->hwid);
		Session::set("admin", (int) $user->admin);
		Session::set("banned", (int) $user->banned);
		//Session::set("invitedBy", $user->invitedBy);
		//Session::set("createdBy", $user->createdBy);

	}


	public function logoutUser() {

		session_unset();
		$_SESSION = array();
		session_destroy();

	}


	public function registerUser($data) {

		// Bind login data 
		$username = trim($data['username']);
		$password = $data['password'];
		$confirmPassword = $data['confirmPassword'];
		$invCode = trim($data['invCode']);

		// Empty error vars
		$userError = $passError = "";
		$usernameValidation = "/^[a-zA-Z0-9]*$/";

		// Validate username on length and letters/numbers
		if (empty($username)) {

			return $userError  = "Please enter a username.";

		} elseif (strlen($username) < 3) {

			return $userError  = "Username is too short.";

		} elseif (strlen($username) > 14) {

			return $userError  = "Username is too long.";

		} elseif (!preg_match($usernameValidation, $username)) {

			return $userError  = "Username must only contain alphanumericals!";

		} else {

			// Check if username exists
			$userExists = $this->usernameCheck($username);
			if ($userExists) {

				return $userError  = "Username already exists, try another.";
	
			}

		}

		
		// Validate password on length
		if (empty($password)) {

			return $passError  = "Please enter a password.";

		} elseif (strlen($password) < 4) {

			return $passError  = "Password is too short.";

		} 


		// Validate confirmPassword on length
		if (empty($confirmPassword)) {

			return $passError  = "Please enter a password.";

		} elseif ($password != $confirmPassword) {

			return $passError  = "Passwords do not match, please try again.";

		}


		// Validate invCode
		if (empty($invCode)) {

			return $invCodeError  = "Please enter an invite code.";

		} else {

			// Check if invite code is valid
			$invCodeExists = $this->invCodeCheck($invCode);

			if (!$invCodeExists) {

				return $invCodeError  = "Invite code is invalid or already used.";

			}

		}


		// Check if all errors are empty
		if (empty($userError) && empty($passError) && empty($invCodeError) && empty($userExistsError)  && empty($invCodeError)) {

			// Hashing the password
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

			$result = $this->register($username, $hashedPassword, $invCode);

			// Session start
			if ($result) {

				Util::redirect('/login.php');

			} else {

				return 'Something went wrong.';
				
			}

		}

	}


	public function loginUser($data) {

		// Bind login data 
		$username = trim($data['username']);
		$password = $data['password'];

		// Empty error vars
		$userError = $passError = "";

		// Validate username
		if (empty($username)) {

			return $userError  = "Please enter a username.";

		}

		// Validate password
		if (empty($password)) {

			return $passError  = "Please enter a password.";

		}

		// Check if all errors are empty
		if (empty($userError) && empty($passError)) {

			$result = $this->login($username, $password);

			if ($result) {

				// Session start
				$this->createUserSession($result);
				Util::redirect('/');

			} else {

				return 'Username/Password is wrong.';

			}

		}

	}


	public function activateSub($data) {

		// Bind data
		$username = Session::get("username");
		$subCode = $data['subCode'];

		if (empty($subCode)) {

			return 'Please enter a code.';

		} else {

			$subCodeExists = $this->subCodeCheck($subCode);

			if ($subCodeExists) {

				return $this->subscription($subCode, $username);

			} else {

				return 'Subscription code is invalid.';
				
			}

		}

	}


	public function updateUserPass($data) {

		// Bind data
		$username = Session::get("username");
		$currentPassword = $data['currentPassword'];
		$newPassword = $data['newPassword'];
		$confirmPassword = $data['confirmPassword'];

		// Empty error vars
		$passError = "";


		// Validate password
		if (empty($currentPassword)) {

			return $passError  = "Please enter a password.";

		}


		if (empty($newPassword)) {

			return $passError  = "Please enter a password.";

		} elseif (strlen($newPassword) < 4) {

			return $passError  = "Password is too short.";

		} 


		if (empty($confirmPassword)) {

			return $passError  = "Please enter a password.";

		} elseif ($confirmPassword != $newPassword) {

			return $passError  = "Passwords do not match, please try again.";

		}


		// Check if all errors are empty
		if (empty($passError)) {

			// Hashing the password
			$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
			$result = $this->updatePass($currentPassword, $hashedPassword, $username);

			if ($result) {

				Util::redirect('/logout.php');

			} else {

				return 'Your current does not match.';

			}

		}

	}


	public function getUserCount() {
		return $this->userCount();
	}


	public function getBannedUserCount() {
		return $this->bannedUserCount();
	}


	public function getActiveUserCount() {
		return $this->activeUserCount();
	}
	

	public function getNewUser() {
		return $this->newUser();
	}


	public function getSubStatus() {
		
		// Bind data
		$username = Session::get("username");
		return $this->subActiveCheck($username);

	}

}
