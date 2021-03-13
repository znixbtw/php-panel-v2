<?php

ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.cookie_lifetime', 0);

require_once 'core/Config.php';
require_once 'controllers/UtilController.php';
require_once 'controllers/UserController.php';
