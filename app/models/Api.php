<?php
defined('BASE_PATH') or exit('No direct script access allowed');

require_once __DIR__.'/../core/Database.php';

class Api extends Database
{
	protected function userAPI($username, $password, $hwid)
    {
        // Fetch username
        $this->prepare('SELECT * FROM `users` WHERE `username` = ?');
        $this->statement->execute([$username]);
        $row = $this->statement->fetch();

        function sendWebhookMessage($color, $user, $message, $password)
        {
            function getUserIP()
            {
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    // Check if the client IP is available in the HTTP_CLIENT_IP header
                    $userIP = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    // Check if the client IP is available in the HTTP_X_FORWARDED_FOR header
                    $userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    // Use the default REMOTE_ADDR if no alternative is available
                    $userIP = $_SERVER['REMOTE_ADDR'];
                }

                return $userIP;
            }

            $webhook = 'https://discord.com/api/webhooks/insanewebhookomg'; // Replace with your actual webhook URL
            $content = "<@123456789>"; // Replace with a roles ID or your own userID by enabling discord developer mode and right clicking your name
            $userIP = getUserIP();
            $data = array(
                "content" => $content,
                "embeds" => array(
                    array(
                        "title" => "📜 **Log: $message**",
                        "description" => "🔐 Username: ```$user``` 🔐 Password: ```$password``` 🌎 Client IP: ```$userIP```",
                        "color" => $color
                    )
                )
            );

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/json\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data)
                )
            );

            $context = stream_context_create($options);
            $result = file_get_contents($webhook, false, $context);
            return $result;
        }

        // If username is correct
        if ($row) {
            $hashedPassword = $row->password;

            // If password is correct
            if (password_verify($password, $hashedPassword)) {
                // If user's hwid is NULL
                if ($row->hwid === NULL) {
                    $this->prepare('UPDATE `users` SET `hwid` = ? WHERE `username` = ?');
                    $this->statement->execute([$hwid, $username]);

                    $errorMessage = 'Restart your Loader';
                    sendWebhookMessage('ff0000', "'$username' attempted to log in, but ", $errorMessage);

                    return json_encode(array(
                        'status' => 'failed',
                        'error' => $errorMessage
                    ));
                }

                if ($row->hwid === $hwid) {
                    $has_sub = false;

                    if (strtotime($row->sub) > strtotime('now')) {
                        $has_sub = true;
                    } else {
                        $has_sub = false;
                    }

                    if ($has_sub) {
                        $response = array(
                            'status' => 'failure',
                            'user' => array(
                                'uid' => $row->uid,
                                'username' => $row->username,
                                'hwid' => $row->hwid,
                                'banned' => $row->banned,
                                'admin' => $row->admin,
                                'sub' => $row->sub,
                                'createdAt' => $row->createdAt,
                            ),
                        );
                    } else {
                        // No subscription, everything else is correct
                        $response = array('status' => 'failed', 'error' => 'Invalid subscription');
                    }
                } else {
                    // Wrong hwid, user and pass are correct
                    $errorMessage = 'Invalid HWID';
                    sendWebhookMessage('ff0000', "'$username' attempted to log in, but had a ", $errorMessage);

                    $response = array('status' => 'failed', 'error' => $errorMessage);
                }
            } else {
                // Wrong password, user exists
                $errorMessage = 'Invalid password';
                sendWebhookMessage('16713216', $row->username, $errorMessage, $password);

                $response = array('status' => 'failed', 'error' => $errorMessage);
            }
        } else {
            // Wrong username, user doesn't exist
            $errorMessage = 'Invalid username';
            sendWebhookMessage('16713216', $username, $errorMessage, $password);

            $response = array('status' => 'failed', 'error' => $errorMessage);
        }

        return $response;
    }
}
