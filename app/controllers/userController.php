<?php
defined('BASE_PATH') or exit('No direct script access allowed');

require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Invite.php';
require_once __DIR__.'/../models/Subscription.php';
require_once __DIR__.'/../helpers/ValidatorHelper.php';

if (!Session::get('login')) {
    http_response_code(403);
    exit();
}

class userController
{

    public string $username;

    public function __construct()
    {
        $this->username = Session::get('username');
    }

    public function getCount()
    {
        // Init models
        $User = new User();
        return $User->getCount();
    }

    public function getCountBanned()
    {
        // Init models
        $User = new User();
        return $User->getCountBanned();
    }

    public function getCountActive()
    {
        // Init models
        $User = new User();
        return $User->getCountActive();
    }

    public function getNew()
    {
        // Init models
        $User = new User();
        return $User->getNew();
    }

    public function updatePassword($data): string
    {
        // Init models
        $User = new User();

        // Bind login data
        $currentPassword = (string) $data['currentPassword'];
        $newPassword = (string) $data['newPassword'];
        $confirmPassword = (string) $data['confirmPassword'];

        // Validate data
        $validationError = Validator::updatePasswordForm($currentPassword, $newPassword, $confirmPassword);
        if ($validationError) {
            return $validationError;
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $User->updatePassword($currentPassword, $hashedPassword, $this->username);
    }

    public function addSubscription($data)
    {
        // Init models
        $User = new User();
        $Subscription = new Subscription();

        // Bind login data
        $subCode = $data['subCode'];

        if (empty($subCode)) {
            return 'Please enter a code.';
        }

        if (!$Subscription->getSubCode($subCode)) {
            return 'Subscription code is invalid.';
        }

        if ($this->getSubscription($this->username) > 0) {
            return 'You already have an active subscription!';
        }

        $date = new DateTime(); // Get current date
        $date->add(new DateInterval('P32D')); // Adds 32 days
        $duration = $date->format('Y-m-d'); // Format Year-Month-Day

        $response = $User->addSubscription($subCode, $this->username, $duration);
        if ($response) {
            $Subscription->deleteSubCode($subCode);
            return 'Your subscription is now active!';
        } else {
            return 'Something went wrong';
        }

    }

    public function getSubscription(): int
    {
        // Init models
        $User = new User();
        return $User->getSubscription($this->username);
    }


}
