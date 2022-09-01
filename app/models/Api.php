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

				if ($row->hwid === NULL) {

					$this->prepare('UPDATE `users` SET `hwid` = ? WHERE `username` = ?');
					$this->statement->execute([$hwid, $username]);

				}
				
				$response = array(
					'status' => 'success', 
					'uid' => $row->uid,
					'username' => $row->username,
					'hwid' => $row->hwid,
					'admin' => $row->admin,
					'sub' => $row->sub,
					'banned' => $row->banned,
					'invitedBy' => $row->invitedBy,
					'createdAt' => $row->createdAt
				);

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
