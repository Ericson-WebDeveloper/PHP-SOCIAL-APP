<?php

require_once(dirname(__FILE__, 2) . "/vendor/autoload.php");
require_once(dirname(__FILE__, 2) . "/class/class.php");

use Ramsey\Uuid\Uuid;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['fetch--message-chatmate'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $messages = $user->fetchChatMessages($_POST['user_reference'], $_POST['chatmate']);
        $userdata = $user->getUserWdetails2($_POST['chatmate']);
        $userdata2 = $user->getUserWdetails2($_POST['user_reference']);
        // $user = $user->getUser($_POST['chatmate']);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['messages' => $messages, 'user' => $userdata, 'user2' => $userdata2, 'status' => 200], 200);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}

if (isset($_POST['send--message--chatmate'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $id = Uuid::uuid4();

        $response = $user->saveMessage($id, $_POST['message'], $_POST['chatmate'], $_POST['sender']);
        $userdata = $user->getUserWdetails2($_POST['chatmate']);
        $userdata2 = $user->getUserWdetails2($_POST['sender']);
        if ($response) {
            $message = $user->fetchChatMessage($id);
            $data = ['sender' => $_POST['sender'], 'message' => $message, 'reciever' => $_POST['chatmate']];
            // $data2 = ['sender' => $_POST['sender'], 'message' => $message, 'reciever' => $_POST['chatmate']];
            // $pusher->pusher->trigger('message-active-alert-channel', 'message-active-alert-event', $data);
            $pusher->pusher->trigger('message-active-alert-channel', 'message-active-alert-event.' . $_POST['chatmate'], $data);
            // $pusher->pusher->trigger('message-active-alert-channel', 'messages-alert-event', $data);
            $pusher->pusher->trigger('message-active-alert-channel', 'messages-alert-event.' . $_POST['chatmate'], $data);
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['messages' => $response, 'message' => $message, 'sender' => $userdata2, 'chatmate' => $userdata, 'status' => 200], 200);
        }
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}
