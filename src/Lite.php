<?php

/**
 * Created by PhpStorm.
 * User: ZhangZijing
 * Date: 2019/1/9
 * Time: 14:20
 */

namespace Abclove\Session;

class Lite
{
    public function __construct($name = 'sha1', $maxlifetime = 3600, bool $regenerate_id = false)
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set("session.use_cookies", 1); //防止注入
            ini_set("session.use_only_cookies", 1); //防止注入
            ini_set("session.cookie_httponly", 1); //防止XSS
            ini_set('session.gc_maxlifetime', $maxlifetime); //设置过期时间
            ini_set("session.use_trans_sid", 0);
            session_name($name);
            session_start();
            if ($regenerate_id == true) {
                session_regenerate_id(true);
            }
        }
    }

    public function __get($key)
    {
        if (isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        elseif ($key === 'session_id')
        {
            return session_id();
        }
        return NULL;
    }

    public function __isset($key)
    {
        if ($key === 'session_id')
        {
            return (session_status() === PHP_SESSION_ACTIVE);
        }
        return isset($_SESSION[$key]);
    }

    public function __set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public function destroy()
    {
        session_destroy();
    }
}