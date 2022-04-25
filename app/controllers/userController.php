<?php

require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../helpers/SessionHelper.php';

class userController extends User
{
    public function activateSub($data): string
    {

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

    public function updateUserPass($data)
    {

        // Bind data
        $username = Session::get("username");
        $currentPassword = $data['currentPassword'];
        $newPassword = $data['newPassword'];
        $confirmPassword = $data['confirmPassword'];

        // Empty error vars
        $passError = "";

        // Validate password
        if (empty($currentPassword)) {

            return $passError = "Please enter a password.";

        }

        if (empty($newPassword)) {

            return $passError = "Please enter a password.";

        } elseif (strlen($newPassword) < 4) {

            return $passError = "Password is too short.";

        }

        if (empty($confirmPassword)) {

            return $passError = "Please enter a password.";

        } elseif ($confirmPassword != $newPassword) {

            return $passError = "Passwords do not match, please try again.";

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

    public function getUserCount()
    {
        return $this->userCount();
    }

    public function getBannedUserCount()
    {
        return $this->bannedUserCount();
    }

    public function getActiveUserCount()
    {
        return $this->activeUserCount();
    }

    public function getNewUser()
    {
        return $this->newUser();
    }

    public function getSubStatus()
    {

        // Bind data
        $username = Session::get("username");
        return $this->subActiveCheck($username);

    }

}
