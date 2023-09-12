<?php

require_once(dirname(__FILE__, 2) . "/vendor/autoload.php");
require_once(dirname(__FILE__, 2) . "/class/class.php");

use Ramsey\Uuid\Uuid;
use Rakit\Validation\Validator;

$validator = new Validator;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['fetch-all-users'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $users = $user->getUsersSuggestFriend($_SESSION['user']->id);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['users' => $users], 200);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}

if (isset($_GET['fetch-data-user'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $userfetch = $user->getUserWdetails2($_GET['userId']);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['userfetch' => $userfetch], 200);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}

if (isset($_POST['add-friend-request'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $response = $user->checkFriendRequest($_POST['ref']);

        if ($response || $response != false) {
            $response = $user->removeFriendRequest($_POST['ref']);
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Cancel Request.', 'status' => 200]);
            die();
        }
        $id = Uuid::uuid4();
        $response = $user->addFriendRequest($_SESSION['user']->id, $_POST['ref'], $id);
        if ($response) {
            $data = $user->returnFriendRequest($id);
            // $pusher->pusher->trigger('request-alert-channel', 'request-alert-event', $data);
            $pusher->pusher->trigger('friend-request-alert-channel', 'friend-request-alert-event', $data);
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Add Request.', 'status' => 200]);
        } else {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => 'Request Failed.', 'status' => 400]);
        }
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}


if (isset($_POST['accept-friend-request'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $response = $user->acceptFriendRequest(Uuid::uuid4(), $_SESSION['user']->id, $_POST['ref-key']);
        if (!$response) {
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Cannot Accept Request.', 'status' => 200]);
            die();
        }
        $response = $user->removeFriendRequest($_POST['ref-key-2']);
        if ($response) {
            $data = ['userId' => $_POST['ref-key'], 'acceptUserId' => $_SESSION['user']->id];
            $pusher->pusher->trigger('friend-request-alert-channel', 'acceptfriend-request-alert-event', $data);
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Accept Request Success.', 'status' => 200]);
        } else {

            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => 'Accept Request Failed.', 'status' => 400]);
        }
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}


if (isset($_POST['update-profilepic-user'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        if (!isset($_POST['picture']) || $_POST['picture'] == '' || $_POST['picture'] == null) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => 'Picture is empty.', 'status' => 400]);
            die();
        }

        $response = $user->updateProfilePicture($_POST['picture'], $_SESSION['user']->id);
        if ($response) {
            $_SESSION['user']->profile = $_POST['picture'];
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Updating Profile Picture Success.', 'status' => 200]);
        } else {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => 'Updating Profile Picture  Failed.', 'status' => 400]);
        }
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}


if (isset($_GET['get-all-request'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $request = $user->getFriendRequest($_SESSION['user']->id);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['request' => $request, 'status' => 200]);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}


if (isset($_GET['get-all-counts-friend'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }
        $userId = isset($_GET['userId']) ? $_GET['userId'] : $_SESSION['user']->id;
        $request = $user->getCountsFriends($userId);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['counts' => $request, 'status' => 200]);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}

if (isset($_GET['get-all-chat-friends'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $chats = $user->fetchChatFriends($_SESSION['user']->id);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['chats' => $chats, 'status' => 200]);

    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}

if (isset($_POST['update-login_credential-datas'])) {
    try {
        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }
        // make it
        $validation = $validator->make($_POST, [
            'email'    => 'required|email',
            'password' => 'required|min:6'
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
            $response = $user->updateLogincred($_SESSION['user']->id, $_POST['email'], $_POST['password']);
            if (!$response) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Unable to updated login credential data.', 'status' => 400]);
                die();
            }
            $newUserDatas = $user->getUserWdetails2($_SESSION['user']->id);
            $_SESSION['user'] = $newUserDatas;
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Updating login credential data Success.', 'status' => 200]);
        }
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}


if (isset($_POST['add-new-about'])) {
    try {
        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }
        // make it
        $validation = $validator->make($_POST, [
            'category'    => 'required',
            'about' => 'required'
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
            $uuid = Uuid::uuid4();
            $response = $user->addAbout($uuid, $_SESSION['user']->id, $_POST['category'], $_POST['about']);
            if (!$response) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Unable to add new About.', 'status' => 400]);
                die();
            }
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Adding new About Success.', 'status' => 200]);
        }
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}

if (isset($_GET['fetch-all-about'])) {
    try {
        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }
        $userId = isset($_GET['userId']) ? $_GET['userId'] : $_SESSION['user']->id;
        $abouts = $user->fetchAbouts($userId);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['abouts' => $abouts, 'status' => 200]);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}


if (isset($_POST['update-profile-datas'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }
        // make it
        $validation = $validator->make($_POST, [
            'first_name'    => 'required',
            'last_name'    => 'required',
            // 'email'    => 'required|email',
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
            $info = (object)'first_name';
            $info = (object)'last_name';
            $info->first_name = $_POST['first_name'];
            $info->last_name = $_POST['last_name'];

            $details = (object)'bday';
            $details = (object)'gender';
            $details->bday = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
            $details->gender = $_POST['gender'];
            // var_dump($details->bday);
            // die();
            $response1 = $user->updateUserInfo($_SESSION['user']->id, $info);
            if (!$response1) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Unable to updated information data.', 'status' => 400]);
                die();
            }
            $response2 = $user->updateUserDetails($_SESSION['user']->id, $details);
            if (!$response2) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['error' => 'Unable to updated details data.', 'status' => 400]);
                die();
            }
            $newUserDatas = $user->getUserWdetails2($_SESSION['user']->id);
            $_SESSION['user'] = $newUserDatas;
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'Information Datas Updating Success', 'status' => 200]);
        }
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}
