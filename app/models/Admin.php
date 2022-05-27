<?php
defined('BASE_PATH') or exit('No direct script access allowed');

require_once __DIR__.'/../core/Database.php';

class Admin extends Database
{
    public function userArray()
    {
        $this->prepare('SELECT * FROM `users` ORDER BY uid ASC');
        $this->statement->execute();
        return $this->statement->fetchAll();
    }

    public function invCodeArray()
    {
        $this->prepare('SELECT * FROM `invites`');
        $this->statement->execute();
        return $this->statement->fetchAll();
    }

    public function invCodeGen($code, $createdBy)
    {
        $this->prepare('INSERT INTO `invites` (`code`, `createdBy`) VALUES (?, ?)');
        $this->statement->execute([$code, $createdBy]);
    }

    public function subCodeArray()
    {
        $this->prepare('SELECT * FROM `subscription`');
        $this->statement->execute();
        return $this->statement->fetchAll();
    }

    public function subCodeGen($code, $createdBy)
    {
        $this->prepare('INSERT INTO `subscription` (`code`, `createdBy`) VALUES (?, ?)');
        $this->statement->execute([$code, $createdBy]);
    }

    public function HWID($uid)
    {
        $this->prepare('UPDATE `users` SET `hwid` = NULL WHERE `uid` = ?');
        $this->statement->execute([$uid]);
    }

    public function banned($uid)
    {
        $this->prepare('SELECT `banned` FROM `users` WHERE `uid` = ?');
        $this->statement->execute([$uid]);
        $result = $this->statement->fetch();
        if ((int) $result->banned === 0) {
            $this->prepare('UPDATE `users` SET `banned` = 1 WHERE `uid` = ?');
        } else {
            $this->prepare('UPDATE `users` SET `banned` = 0 WHERE `uid` = ?');
        }
        $this->statement->execute([$uid]);
    }

    // Set user admin / non admin
    public function administrator($uid)
    {
        $this->prepare('SELECT `admin` FROM `users` WHERE `uid` = ?');
        $this->statement->execute([$uid]);
        $result = $this->statement->fetch();
        if ((int) $result->admin === 0) {
            $this->prepare('UPDATE `users` SET `admin` = 1 WHERE `uid` = ?');
        } else {
            $this->prepare('UPDATE `users` SET `admin` = 0 WHERE `uid` = ?');
        }
        $this->statement->execute([$uid]);
    }

    //
    public function cheatStatus()
    {
        $this->prepare('SELECT `status` FROM `cheat`');
        $this->statement->execute();
        $result = $this->statement->fetch();
        if ((int) $result->status === 0) {
            $this->prepare('UPDATE `cheat` SET `status` = 1');
        } else {
            $this->prepare('UPDATE `cheat` SET `status` = 0');
        }
        $this->statement->execute();
    }

    //
    public function cheatMaint()
    {
        $this->prepare('SELECT `maintenance` FROM `cheat`');
        $this->statement->execute();
        $result = $this->statement->fetch();
        if ((int) $result->maintenance === 0) {
            $this->prepare('UPDATE `cheat` SET `maintenance` = 1');
        } else {
            $this->prepare('UPDATE `cheat` SET `maintenance` = 0');
        }
        $this->statement->execute();
    }

    //
    public function cheatVersion($ver)
    {
        $this->prepare('UPDATE `cheat` SET `version` = ?');
        $this->statement->execute([$ver]);
    }
}
