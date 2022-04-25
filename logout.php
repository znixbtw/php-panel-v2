<?php

include './app/require.php';

Util::userCheck();
(new authController())->logout();
Util::redirect(BASE_PATH.'login.php');