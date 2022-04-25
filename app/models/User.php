<?php

require_once SITE_ROOT.'/app/core/Database.php';

class User extends Database
{
    // Check if username exists
    protected function usernameCheck($username): bool
    {
        $this->prepare('SELECT * FROM `users` WHERE `username` = ?');
        $this->statement->execute([$username]);
        return $this->statement->rowCount() > 0;
    }

    // Check if invite code is valid
    protected function invCodeCheck($invCode): bool
    {
        $this->prepare('SELECT * FROM `invites` WHERE `code` = ?');
        $this->statement->execute([$invCode]);
        return $this->statement->rowCount() > 0;
    }

    // Check if sub code is valid
    protected function subCodeCheck($subCode): bool
    {
        $this->prepare('SELECT * FROM `subscription` WHERE `code` = ?');
        $this->statement->execute([$subCode]);
        return $this->statement->rowCount() > 0;
    }

    // Login - Sends data to DB
    protected function loginUser($username, $password): bool|object
    {
        // Get user by username
        $this->prepare('SELECT * FROM `users` WHERE `username` = ?');
        $this->statement->execute([$username]);
        $row = $this->statement->fetch();
        // If username is correct
        return $row && password_verify($password, $row->password) ? $row : false;
    }

    protected function registerUser($username, $hashedPassword, $invCode): bool
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

    // Change user password
    protected function changePassword($currentPassword, $hashedPassword, $username): bool
    {
        // Get user by username
        $this->prepare('SELECT * FROM `users` WHERE `username` = ?');
        $this->statement->execute([$username]);
        $row = $this->statement->fetch();
        // Fetch current password from database
        $currentHashedPassword = $row->password;
        if (password_verify($currentPassword, $currentHashedPassword)) {
            $this->prepare('UPDATE `users` SET `password` = ? WHERE `username` = ?');
            $this->statement->execute([$hashedPassword, $username]);
            return true;
        } else {
            return false;
        }
    }

    protected function subscription($subCode, $username): string
    {
        $sub = $this->subActiveCheck($username);
        if ($sub > 0) {
            return 'You already have an active subscription!';
        }
        $date = new DateTime(); // Get current date
        $date->add(new DateInterval('P32D')); // Adds 32 days
        $subTime = $date->format('Y-m-d'); // Format Year-Month-Day
        $this->prepare('UPDATE `users` SET `sub` = ? WHERE `username` = ?');
        if ($this->statement->execute([$subTime, $username])) {
            // Delete the sub code
            $this->prepare('DELETE FROM `subscription` WHERE `code` = ?');
            $this->statement->execute([$subCode]);
            return 'Your subscription is now active!';
        } else {
            return 'Something went wrong';
        }

    }

    protected function subActiveCheck($username)
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

    // Get number of users
    protected function userCount()
    {
        $this->prepare('SELECT * FROM `users`');
        $this->statement->execute();
        return $this->statement->rowCount();
    }

    // Get number of banned users
    protected function bannedUserCount()
    {
        $this->prepare('SELECT * FROM `users` WHERE `banned` =  1');
        $this->statement->execute();
        return $this->statement->rowCount();
    }

    // Get number of users with sub
    protected function activeUserCount()
    {
        $this->prepare('SELECT * FROM `users` WHERE `sub` > CURRENT_DATE()');
        $this->statement->execute();
        return $this->statement->rowCount();
    }

    // Get name of the latest registered user
    protected function newUser()
    {
        $this->prepare('SELECT `username` FROM `users` WHERE `uid` = (SELECT MAX(`uid`) FROM `users`)');
        $this->statement->execute();
        $result = $this->statement->fetch();
        return $result->username;
    }
}