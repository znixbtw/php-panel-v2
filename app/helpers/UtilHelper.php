<?php
defined('BASE_PATH') or exit('No direct script access allowed');

class Util
{

    public static function head(string $title): void
    {
        include(SITE_ROOT.'/includes/head.inc.php');
    }

    public static function navbar(): void
    {
        include(SITE_ROOT.'/includes/navbar.inc.php');
    }

    public static function adminNavbar(): void
    {
        include(SITE_ROOT.'/admin/includes/adminNavbar.inc.php');
    }

    public static function footer(): void
    {
        include(SITE_ROOT.'/includes/footer.inc.php');
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
    public static function isUser(): void
    {
        // If user is logged in
        if (!Session::get('login')) {
            // Prevents infinite redirect loop
            if (basename($_SERVER['PHP_SELF']) !== 'login.php' && basename($_SERVER['PHP_SELF']) !== 'register.php') {
                Util::redirect('/login.php');
            }
        }
        // Prevents logged in users to access login or register
        if (Session::get('login')) {
            if (basename($_SERVER['PHP_SELF']) == 'login.php' || basename($_SERVER['PHP_SELF']) == 'register.php') {
                Util::redirect('/');
            }
        }
    }

    public static function redirect(string $location): void
    {
        header("location: ${BASE_PATH}.${location}");
        exit;
    }

    // Check if user is banned
    public static function isBanned(): void
    {
        // If user is banned
        if (Session::get('banned')) {
            // Prevents infinite redirect loop
            if (basename($_SERVER['PHP_SELF']) != 'banned.php') {
                Util::redirect('/banned.php');
            }
        }
        if (!Session::get('banned')) {
            if (basename($_SERVER['PHP_SELF']) == 'banned.php') {
                Util::redirect('/');
            }
        }
    }

    // Check is user is admin
    public static function isAdmin(): void
    {
        if (!Session::get('admin')) {
            Util::redirect('../');
        }
    }
}
