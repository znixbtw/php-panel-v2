<?php
defined('BASE_PATH') or exit('No direct script access allowed');

require_once __DIR__.'/../core/Database.php';

class Api extends Database
{
	protected function userAPI($username, $password, $hwid) {

		// fetch username
		$this->prepare('SELECT * FROM `users` WHERE `username` = ?');
		$this->statement->execute([$username]);
		$row = $this->statement->fetch();
		
		// If username is correct
		if ($row) {

			$hashedPassword = $row->password;

			// If password is correct
			if (password_verify($password, $hashedPassword)) {

				// If user's hwid is NULL
				if ($row->hwid === NULL) {

					$this->prepare('UPDATE `users` SET `hwid` = ? WHERE `username` = ?');
					$this->statement->execute([$hwid, $username]);

					return array('status' => 'failed', 'error' => 'Restart your loader');
				}

				if ($row->hwid === $hwid) {

					$has_sub = false;

					if (strtotime($row->sub) > strtotime('now')) {
						$has_sub = true;
						} else {
						$has_sub = false;
					}

					if ($has_sub) {
						$response = array(
							'status' => 'success', 
							'user' => array(
								'uid' => $row->uid,
								'username' => $row->username,
								'hwid' => $row->hwid,
								'banned' => $row->banned,
								'admin' => $row->admin,
								'sub' => $row->sub,
								'createdAt' => $row->createdAt,
							),
						);
					} else {
						// No subscription, everything else is correct
						$response = array('status' => 'failed', 'error' => 'Invalid subscription');
					}
				} else {
					// Wrong hwid, user and pass are correct
					$response = array('status' => 'failed', 'error' => 'Invalid hwid');
				}
				
			} else {

				// Wrong pass, user exists
				$response = array('status' => 'failed', 'error' => 'Invalid password');

			}

		} else {

			// Wrong username, user doesnt exists
			$response = array('status' => 'failed', 'error' => 'Invalid username');

		}

		return $response;

	}   
}
