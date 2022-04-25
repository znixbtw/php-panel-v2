<?php

class Util
{

    public static function head(string $title): void
    {
        include(SITE_ROOT.'./includes/head.inc.php');
    }

    public static function navbar(): void
    {
        include(SITE_ROOT.'./includes/navbar.inc.php');
    }

    public static function adminNavbar(): void
    {
        include(SITE_ROOT.'./admin/includes/adminNavbar.inc.php');
    }

    public static function footer(): void
    {
        include(SITE_ROOT.'./includes/footer.inc.php');
    }

    public static function display(string $string): string
    {
        return htmlspecialchars($string);
    }

    public static function randomCode(int $int): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $int; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    // Check if user is a valid user
    public static function userCheck(): void
    {
        // If user is logged in
        if (!Session::get('login')) {
            // Prevents infinite redirect loop
            if (basename($_SERVER['PHP_SELF']) !== 'login.php' && basename($_SERVER['PHP_SELF']) !== 'register.php') {
                Util::redirect('/login.php');
            }
        }
    }

    public static function redirect(string $location): void
    {
        header("location: ${location}");
        exit;
    }

    // Check if user is banned
    public static function banCheck(): void
    {
        // If user is banned
        if (Session::get('banned')) {
            // Prevents infinite redirect loop
            if (basename($_SERVER['PHP_SELF']) != 'banned.php') {
                Util::redirect('/banned.php');
            }
        }
    }

    // Check is user is admin
    public static function adminCheck(): void
    {
        if (!Session::get('admin')) {
            Util::redirect(__DIR__.'/../index.php');
        }
    }

    public static function validateUsername(string $username): string|bool
    {
        $usernameValidation = "/^[a-zA-Z0-9]*$/";
        if (empty($username)) {
            $error = "Please enter a username.";
        } elseif (strlen($username) < 3) {
            $error = "Username is too short.";
        } elseif (strlen($username) > 14) {
            $error = "Username is too long.";
        } elseif (!preg_match($usernameValidation, $username)) {
            $error = "Username must only contain alphanumerical!";
        } else {
            $error = true;
        }
        return $error;
    }

    public static function validatePassword(string $password): string|bool
    {
        if (empty($password)) {
            $error = "Please enter a password.";
        } elseif (strlen($password) < 4) {
            $error = "Password is too short.";
        } else {
            $error = true;
        }
        return $error;
    }

}