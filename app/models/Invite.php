<?php
defined('BASE_PATH') or exit('No direct script access allowed');

require_once __DIR__.'/../core/Database.php';

class Invite extends Database
{
//    public function getUserByCode(string $invCode): bool|string
//    {
//        // Get username of the person who invited
//        $this->prepare('SELECT `createdBy` FROM `invites` WHERE `code` = ? LIMIT 1');
//        $this->statement->execute([$invCode]);
//        return $this->statement->fetchOne();
//    }

    public function getCode($invCode): bool|stdClass
    {
        $this->prepare('SELECT * FROM `invites` WHERE `code` = ? LIMIT 1');
        $this->statement->execute([$invCode]);
        return $this->statement->fetch();
    }
}
