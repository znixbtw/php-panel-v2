<?php

class Session {

    public static function init() {

		session_start();
			
	}


    public static function set($key, $val) {

		$_SESSION[$key] = $val;
			
	}


    public static function get($key) {

		return (isset($_SESSION[$key])) ? $_SESSION[$key] : false;
			
	}


	public static function isLogged() {

		return (isset($_SESSION["login"]) && $_SESSION["login"] === true) ? true : false;

	}


	public static function isAdmin() {

		return (isset($_SESSION["login"]) && $_SESSION["admin"] === 1) ? true : false;

	}


	public static function isBanned() {

		return (isset($_SESSION["login"]) && $_SESSION["banned"] === 1 && $_SESSION["admin"] === 0) ? true : false;

	}

}