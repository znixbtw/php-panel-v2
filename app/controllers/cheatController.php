<?php
require_once __DIR__.'/../models/Cheat.php';

class cheatController extends Cheat
{
    // Get number of users
    public function getCheatData()
    {
        return $this->cheatData();
    }
}
