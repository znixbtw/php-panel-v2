<?php
defined('BASE_PATH') or exit('No direct script access allowed');

require_once __DIR__.'/../core/Database.php';

class Subscription extends Database
{
    // Get sub code
    public function getSubCode(string $subCode): stdClass
    {
        $this->prepare('SELECT * FROM `subscription` WHERE `code` = ? LIMIT 1');
        $this->statement->execute([$subCode]);
        return $this->statement->fetch();
    }

    // Delete sub code
    public function deleteSubCode(string $subCode): bool
    {
        $this->prepare('DELETE FROM `subscription` WHERE `code` = ?');
        return $this->statement->execute([$subCode]);
    }
}