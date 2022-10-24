<?php

require_once './app/require.php';
require_once './app/controllers/cheatController.php';

Util::isUser();
Util::isBanned();

require_once './app/controllers/userController.php';

$user = new userController;
$cheat = new cheatController;

if ($user->getSubscription() <= 0) {
    Util::redirect('/');
}

$software = Util::randomCode(5).'.exe';

header('Content-type: application/x-dosexec');
header('Content-Disposition: attachment; filename="'.$software.'"');
readfile(LOADER_URL);
