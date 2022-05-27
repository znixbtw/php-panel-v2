<?php

include './app/require.php';
include './app/controllers/authController.php';

Util::isUser();
(new authController())->logout();
Util::redirect('/login.php');