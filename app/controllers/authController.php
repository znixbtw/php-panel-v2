<?php

require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../helpers/SessionHelper.php';

class authController extends User
{
    public function register($data): string
    {
        // Bind login data
        $username = trim($data['username']);
        $password = (string) $data['password'];
        $confirmPassword = (string) $data['confirmPassword'];
        $invCode = trim($data['invCode']);

        // Validate username
        $validateUsername = Util::validateUsername($username);
        if (!$validateUsername) {
            return (string) $validateUsername;
        }

        // Validate password
        $validatePassword = Util::validatePassword($password);
        if (!$validatePassword) {
            return (string) $validatePassword;
        }

        // Validate confirmPassword
        if (empty($confirmPassword) && $password != $confirmPassword) {
            return "Passwords do not match, please try again.";
        }

        // Validate invCode
        if (empty($invCode)) {
            return "Please enter an invite code.";
        }

        // Check if invite code exists
        $invCodeExists = User::invCodeCheck($invCode);
        if (!$invCodeExists) {
            return "Invite code is invalid or already used.";
        }

        // Check if username exists
        $userExists = User::usernameCheck($username);
        if ($userExists) {
            return "Username already exists, try another.";
        }

        // Hashing the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $response = User::registerUser($username, $hashedPassword, $invCode);

        return ($response) ? 'Registered successfully.' : 'Something went wrong.';
    }

    public function login($data)
    {
        // Bind login data
        $username = trim($data['username']);
        $password = (string) $data['password'];

        // Validate username
        $validateUsername = Util::validateUsername($username);
        if (!$validateUsername) {
            return (string) $validateUsername;
        }

        // Validate password
        $validatePassword = Util::validatePassword($password);
        if (!$validatePassword) {
            return (string) $validatePassword;
        }

        $response = User::loginUser($username, $password);
        if (!$response) {
            return 'Username/Password is wrong.';
        }

        Session::createUserSession($response);
        Util::redirect('/');
    }

    public function logout()
    {
        session_unset();
        $_SESSION = array();
        session_destroy();
    }
}