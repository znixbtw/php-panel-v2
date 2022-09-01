<?php
defined('BASE_PATH') or exit('No direct script access allowed');

require_once __DIR__.'/../models/Api.php';

class apiController extends Api
{
    public function getUserInfo($username, $password, $hwid) 
    {
        return $this->userAPI($username, $password, $hwid);
    }
}