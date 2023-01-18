<?php

require_once(dirname(__FILE__, 2) . "/vendor/autoload.php");
require_once(dirname(__FILE__, 2) . "/class/class.php");

use Ramsey\Uuid\Uuid;
use Rakit\Validation\Validator;

$validator = new Validator;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['post-new-post-data'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }
        // make it
        $validation = $validator->make($_POST, [
            'details' => 'required',
            'image'   => 'required',
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
            $data = (object)'details';
            $data = (object)'image';
            $data = (object)'uuid';
            $data->details = $_POST['details'];
            $data->image = $_POST['image'];
            $data->uuid = Uuid::uuid4();
            $response = $post->newpost($_SESSION['user']->id, $data);

            if (!$response) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['errors' => 'Unable to upload new post!.', 'status' => 400]);
                die();
            }
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['message' => 'new post upload', 'status' => 200], 200);
        }
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}


if (isset($_GET['fetch-all-newsfeed'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $posts = $post->getnewsfeedpost($_SESSION['user']->id, $_GET['offset']);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['posts' => $posts], 200);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}

if (isset($_GET['fetch-all-news-comments'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $comments = $post->getnewsfeedcomments($_GET['postId'], $_GET['offset']);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['comments' => $comments], 200);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}

if (isset($_POST['post-new-comments'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $commentId = Uuid::uuid4();
        $response = $post->newcomment($commentId, $_SESSION['user']->id, $_POST['postId'], $_POST['comment']);

        if (!$response) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['errors' => 'Unable to post a comment!.', 'status' => 400]);
            die();
        }
        // $newcomment = $post->getcomment($commentId);
        $total_comments = $post->getCountsCommentsPost($_POST['postId']);
        $data = ['total_comment' => $total_comments, 'ref' => $_POST['postId'], 'commentId' => $commentId];
        $pusher->pusher->trigger('new-comment-alert-channel', 'new-comment-alert-event', $data);

        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['message' => 'Comment Post', 'total_comments' => $total_comments, 'comment' => $commentId, 'status' => 200], 200);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}


if (isset($_GET['fetch-comment'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }

        $comment = $post->getcomment($_GET['commentId']);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['comment' => $comment], 200);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}


if (isset($_GET['fetch-recent-photos-post'])) {
    try {

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'you are unauthenticated.', 'status' => 500]);
            die();
        }
        $userId = isset($_GET['userId']) ? $_GET['userId'] : $_SESSION['user']->id;
        $photospost = $post->getnewsfeedimages($userId, 0, $_GET['getall']);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['photospost' => $photospost, 'status' => 200], 200);
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Server cannot process your request', 'status' => 500]);
    }
}
