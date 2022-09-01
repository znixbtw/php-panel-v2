<?php
defined('BASE_PATH') or exit('No direct script access allowed');

require_once __DIR__.'/../models/Admin.php';

if (!Session::get('admin')) {
    http_response_code(403);
    exit();
}

class adminController extends Admin
{

    //
    public function getUserArray()
    {
        return $this->UserArray();
    }

    //
    public function getInvCodeArray()
    {
        return $this->invCodeArray();
    }

    //
    public function getSubCodeArray()
    {
        return $this->subCodeArray();
    }

    //
    public function getInvCodeGen($username)
    {
        $code = Util::randomCode(20);
        return $this->invCodeGen($code, $username);
    }

    //
    public function getSubCodeGen($username)
    {
        $code = Util::randomCode(20);
        return $this->subCodeGen($code, $username);
    }

    //
    public function resetHWID($uid)
    {
        return $this->HWID($uid);
    }

    //
    public function setBanned($uid)
    {
        return $this->banned($uid);
    }

    //
    public function setAdmin($uid)
    {
        return $this->administrator($uid);
    }

    //
    public function setCheatStatus()
    {
        return $this->cheatStatus();
    }

    //
    public function setCheatMaint()
    {
        return $this->cheatMaint();
    }

    //
    public function setCheatVersion($data)
    {
        return $this->cheatVersion($data);
    }
}
