<?php
defined('BASE_PATH') or exit('No direct script access allowed');

require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Invite.php';
require_once __DIR__.'/../helpers/SessionHelper.php';
require_once __DIR__.'/../helpers/ValidatorHelper.php';

class authController
{
    public function register($data): string
    {
        // Init models
        $Invite = new Invite();
        $User = new User();

        // Bind login data
        $username = trim($data['username']);
        $password = (string) $data['password'];
        $confirmPassword = (string) $data['confirmPassword'];
        $code = trim($data['invCode']);

        // Validate data
        $validationError = Validator::registerForm($username, $password, $confirmPassword, $code);
        if ($validationError) {
            return $validationError;
        }

        // Check if invite code exists
        $invCodeExists = $Invite->getCode($code);
        if (!$invCodeExists) {
            return "Invite code is invalid or already used.";
        }

        // Check if username exists
        $userExists = $User->getByUsername($username);
        if ($userExists) {
            return "Username already exists, try another.";
        }

        // Hashing the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $response = $User->register($username, $hashedPassword, $code);

        return ($response) ? 'Registered successfully.' : 'Something went wrong.';
    }

    public function login($data): null|string
    {
        // Init models
        $User = new User();

        // Bind login data
        $username = trim($data['username']);
        $password = (string) $data['password'];

        // Validate data
        $validationError = Validator::loginForm($username, $password);
        if ($validationError) {
            return $validationError;
        }

        $response = $User->login($username, $password);
        if ($response) {
            Session::createUserSession($response);
            Util::redirect('/');

        } else {
            return 'Username/Password is wrong.';
        }

    }

    public function logout()
    {
        session_unset();
        $_SESSION = array();
        session_destroy();
    }
}
