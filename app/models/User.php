<?php
defined('BASE_PATH') or exit('No direct script access allowed');

require_once __DIR__.'/../core/Database.php';

class User extends Database
{
    public function register($username, $hashedPassword, $invCode): bool
    {
        // Get username of the person who invited
        $this->prepare('SELECT `createdBy` FROM `invites` WHERE `code` = ?');
        $this->statement->execute([$invCode]);
        $row = $this->statement->fetch();
        $invitedBy = $row->createdBy;
        // Sending the query - Register user
        $this->prepare('INSERT INTO `users` (`username`, `password`, `invitedBy`) VALUES (?, ?, ?)');
        // If user registered
        if ($this->statement->execute([$username, $hashedPassword, $invitedBy])) {
            // Delete invite code // used
            $this->prepare('DELETE FROM `invites` WHERE `code` = ?');
            $this->statement->execute([$invCode]);
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password): bool|object
    {
        // Get user by username
        $row = $this->getByUsername($username);
        // If username is correct
        return $row && password_verify($password, $row->password) ? $row : false;
    }

    public function getByUsername($username): bool|stdClass
    {
        $this->prepare('SELECT * FROM `users` WHERE `username` = ? LIMIT 1');
        $this->statement->execute([$username]);
        return $this->statement->fetch();
    }

    public function getCount()
    {
        $this->prepare('SELECT `uid` FROM `users`');
        $this->statement->execute();
        return $this->statement->rowCount();
    }

    public function getNew()
    {
        $this->prepare('SELECT `username` FROM `users` ORDER BY `uid` DESC LIMIT 1');
        $this->statement->execute();
        $result = $this->statement->fetch();
        return $result->username;
    }

    public function updatePassword($currentPassword, $hashedPassword, $username): string
    {
        // Get user by username
        $row = $this->getByUsername($username);
        // Fetch current password from database
        if (password_verify($currentPassword, $row->password)) {
            $this->prepare('UPDATE `users` SET `password` = ? WHERE `username` = ?');
            $this->statement->execute([$hashedPassword, $username]);
            return 'Password changed successfully.';
        } else {
            return 'Failed to change password.';
        }
    }

    public function addSubscription($subCode, $username, $duration): bool
    {
        $this->prepare('UPDATE `users` SET `sub` = ? WHERE `username` = ?');
        return (bool) $this->statement->execute([$duration, $username]);
    }

    public function getSubscription($username): int
    {
        $date = new DateTime(); // Get current date
        $currentDate = $date->format('Y-m-d'); // Format Year-Month-Day
        $this->prepare('SELECT `sub` FROM `users` WHERE `username` = ?');
        $this->statement->execute([$username]);
        $subTime = $this->statement->fetch();
        // Pasted from https://www.w3schools.com/php/phptryit.asp?filename=tryphp_func_date_diff
        $date1 = date_create($currentDate); // Convert String to date format
        $date2 = date_create($subTime->sub); // Convert String to date format
        $diff = date_diff($date1, $date2);
        return intval($diff->format("%R%a"));
    }

    public function getCountBanned()
    {
        $this->prepare('SELECT * FROM `users` WHERE `banned` =  1');
        $this->statement->execute();
        return $this->statement->rowCount();
    }

    public function getCountActive()
    {
        $this->prepare('SELECT * FROM `users` WHERE `sub` > CURRENT_DATE()');
        $this->statement->execute();
        return $this->statement->rowCount();
    }
}
