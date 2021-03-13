<?php
header("Content-Type: application/json; charset=UTF-8");

require_once 'app/require.php';
require_once 'app/controllers/ApiController.php';

$API = new ApiController;

// Check data
if (empty($_GET['user']) || empty($_GET['pass']) || empty($_GET['hwid']) || empty($_GET['key'])) {
	
	$response = array('status' => 'failed', 'error' => 'Missing arguments');

} else {

	$username = $_GET['user'];
	$passwordHash = $_GET['pass'];
	$hwidHash = $_GET['hwid'];
	$key = $_GET['key'];

	if (API_KEY === $key) {

		// decode
		$password = base64_decode($passwordHash);
		$hwid = base64_decode($hwidHash);
		
		$response = $API->getUserAPI($username, $password, $hwid);

	} else {

		$response = array('status' => 'failed', 'error' => 'Invalid API key');
		
	}

}

echo (json_encode($response));