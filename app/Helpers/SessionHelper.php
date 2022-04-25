<?php

class Session
{

    public static function init()
    {
        session_start();
    }

    public static function get($key)
    {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : false;
    }

    public static function createUserSession($user)
    {
        Session::set("login", true);
        Session::set("uid", (int) $user->uid);
        Session::set("username", (string) $user->username);
        Session::set("hwid", (string) $user->hwid);
        Session::set("admin", (bool) $user->admin);
        Session::set("banned", (bool) $user->banned);
        Session::set("invitedBy", (string) $user->invitedBy);
        Session::set("createdAt", $user->createdAt);
    }

    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }
}