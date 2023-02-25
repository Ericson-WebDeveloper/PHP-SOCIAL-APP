<?php

require_once(dirname(__FILE__, 1) . "/vendor/autoload.php");
var_dump(getcwd());
die();
require_once(dirname(__FILE__) . "/class/class.php");

use Rakit\Validation\Validator;
use Ramsey\Uuid\Uuid;

$validator = new Validator;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['register-new-user'])) {
    // make it
    $validation = $validator->make($_POST, [
        'fname'    => 'required',
        'lname'    => 'required',
        'email'    => 'required|email',
        'password' => 'required|min:6',
        'month'    => 'required',
        'year'    => 'required',
        'day'    => 'required',
        'gender' => 'required',
    ]);

    // then validate
    $validation->validate();

    if ($validation->fails()) {
        // handling errors
        $errors = $validation->errors();
        header('Content-Type: application/json');
        http_response_code(422);
        echo json_encode(['errors' => $errors->firstOfAll(), 'status' => 422]);
        die();
    } else {
        $response = $user->checkEmail($_POST['email']);
        if ($response == false) {
            $uuid = Uuid::uuid4();
            $userdata = $user->save($uuid, $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password']);
            if ($userdata) {
                $userdetail = $user->saveDetails(Uuid::uuid4(), $uuid, $_POST['month'], $_POST['year'], $_POST['day'], $_POST['gender']);
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['message' => 'Success', 'status' => 200]);
            } else {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Soemthing wrong in creating account', 'status' => 400]);
            }
        } else {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => 'Email is already use', 'status' => 400]);
        }
    }
}

if (isset($_POST['login--user'])) {
    // make it
    $validation = $validator->make($_POST, [
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // then validate
    $validation->validate();
    if ($validation->fails()) {
        $errors = $validation->errors();
        header('Content-Type: application/json');
        http_response_code(422);
        echo json_encode(['errors' => $errors->firstOfAll(), 'status' => 422]);
        die();
    } else {
        $response = $user->checkEmail($_POST['email']);
        if ($response) {
            if ($response->password == md5($_POST['password'])) {
                // session_start();
                $userData = $user->getUserWdetails($_POST['email']);
                $_SESSION['user'] = $userData; // $response
                $user->statusChange(1, $_SESSION['user']->id);
                $pusher->pusher->trigger('online-alert-channel', 'online-alert-event', $response);
                // $pusher->pusher->trigger('online-alert-channel', 'online-alert-event', $response);
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['message' => 'Success', 'status' => 200]);
            } else {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Invalid credentials', 'status' => 400]);
            }
        } else {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => 'Invalid credentials', 'status' => 400]);
        }
    }
}

if (isset($_POST['signout--user'])) {
    try {
        // session_start();
        $userPerson = [
            'id' => $_SESSION['user']->id, 'first_name' => $_SESSION['user']->first_name,
            'last_name' => $_SESSION['user']->last_name, 'email' => $_SESSION['user']->email, 'status' => $_SESSION['user']->status
        ];
        // $userId = $_SESSION['user']->id;
        // var_dump($_SESSION['user']);
        // die();
        $user->statusChange(0, $_SESSION['user']->id);
        $pusher->pusher->trigger('offline-alert-channel', 'offline-alert-event', $userPerson);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['message' => 'Success', $userPerson, 'status' => 200]);
        unset($_SESSION['user']);
    } catch (\Exception $e) {
        // session_start();
        unset($_SESSION['user']);
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage(), 'status' => 400]);
    }
}
