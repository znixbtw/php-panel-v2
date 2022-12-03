<?php
header("Content-Type: application/json; charset=UTF-8");

require_once 'app/require.php';
require_once 'app/controllers/apiController.php';

$apiController = new apiController;

// Check data
if (empty($_POST['user']) || empty($_POST['pass']) || empty($_POST['hwid']) || empty($_POST['key'])) {
	
	$response = array('status' => 'failed', 'error' => 'Missing arguments');

} else {

	$username = $_POST['user'];
	$password = $_POST['pass'];
	$hwid = $_POST['hwid'];
	$key = $_POST['key'];

	if (API_KEY === $key) {

		$response = $apiController->getUserInfo($username, $password, $hwid);

	} else {

		$response = array('status' => 'failed', 'error' => 'Invalid API key');
		
	}

}

echo (json_encode($response));
