<?php

// Extends to NO classes
// Only Public methods

class Util {

	public static function redirect($location) {

		header("location:". SUB_DIR.$location);
		exit;

	}


	public static function head($title) {

		include(SITE_ROOT . '/includes/head.inc.php');

	}


	public static function navbar() {

		include(SITE_ROOT . '/includes/navbar.inc.php');

	}


	public static function adminNavbar() {

		include(SITE_ROOT . '/admin/includes/adminNavbar.inc.php');

	}


	public static function footer() {

		include(SITE_ROOT . '/includes/footer.inc.php');

	}


	public static function display($string) {

		echo htmlspecialchars($string);

	}

	
	// Returns random string
	public static function randomCode($int) {

		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		
        for ($i = 0; $i < $int; $i++) {

            $index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
			
		}
		
        return $randomString;

	}


	// ban check
	public static function banCheck() {

		// If user is banned
		if (Session::isBanned()) {

			// Prevents infinite redirect loop
			if (basename($_SERVER['PHP_SELF']) != 'banned.php') {

				Util::redirect('/banned.php');

			}

		}

	}


	// admin check
	public static function adminCheck() {

		if (!Session::isAdmin()) {

			Util::redirect('/index.php');

		}

	}
	
}