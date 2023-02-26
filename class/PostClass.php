<?php

class Post
{

    private $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function newpost($userid, $data)
    {
        try {
            $sql = "INSERT INTO `posts`(`post_id`, `details`, `image`, `user_id`) VALUES ('$data->uuid','$data->details','$data->image','$userid')";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function updatingpost($userid, $id, $data)
    {
        try {
            $sql = "UPDATE `posts` SET `post_id`='$id',`details`='$data->details',`image`='$data->image',`user_id`='$userid'";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function deletepost($userid, $id)
    {
        try {
            $sql = "DELETE FROM `posts` WHERE `post_id`='$id' AND `user_id`='$userid'";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getnewsfeedpost($userid, $offset)
    {
//         user_details.user_id, user_details.bday, user_details.gender, user_details.profile,
        try {
            $sql = "SELECT posts.post_id, posts.details, posts.image, posts.created_at, posts.user_id,  
            users.id as user_user_id, users.first_name, users.last_name, users.email, 
            user_details.user_id as user_d_user_id, ANY_VALUE(user_details.bday), ANY_VALUE(user_details.gender), ANY_VALUE(user_details.profile),
            COUNT(comments.id_post) as comments_count
            FROM `posts` 
            INNER JOIN users ON users.id = posts.user_id
            INNER JOIN user_details ON user_details.user_id = users.id
            LEFT JOIN comments ON comments.id_post = posts.post_id 
            WHERE posts.user_id IN (SELECT user_id from chats WHERE friend_id = '$userid') 
            OR posts.user_id IN (SELECT friend_id from chats WHERE user_id = '$userid') 
            OR posts.user_id = '$userid'
            GROUP BY posts.post_id
            ORDER BY posts.created_at DESC LIMIT 5 OFFSET $offset";
            $response = $this->connect->get($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getnewsfeedcomments($postId, $offset)
    {
        // user_details.user_id, user_details.bday, user_details.gender, user_details.profile
        // SELECT comments.*, users.id as user_user_id, users.first_name, users.last_name, users.email, user_details.user_id, user_details.bday, user_details.gender, user_details.profile FROM `comments` INNER JOIN users ON users.id = comments.id_user INNER JOIN user_details ON user_details.user_id = users.id WHERE comments.id_post = 'd7add701-e536-40df-8f2b-560a90336cff';
        try {
            $offset = $offset == 0 ? 5 : $offset;
            $sql = "SELECT comments.*, 
            users.id as user_user_id, users.first_name, users.last_name, users.email, 
            user_details.user_id as user_d_user_id, user_details.bday, user_details.gender, user_details.profile
            FROM comments 
            INNER JOIN users ON comments.id_user = users.id 
            INNER JOIN user_details ON user_details.user_id = users.id
            WHERE comments.id_post = '$postId'
            ORDER BY comments.created_at DESC";
            //  LIMIT $offset
            // ORDER BY comments.created_at DESC LIMIT 5 OFFSET $offset";
            $response = $this->connect->get($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getcomment($commentId)
    {
        // SELECT comments.*, users.id as user_user_id, users.first_name, users.last_name, users.email, user_details.user_id, user_details.bday, user_details.gender, user_details.profile FROM `comments` INNER JOIN users ON users.id = comments.id_user INNER JOIN user_details ON user_details.user_id = users.id WHERE comments.id_post = 'd7add701-e536-40df-8f2b-560a90336cff';
        try {
            $sql = "SELECT comments.*, 
            users.id as user_user_id, users.first_name, users.last_name, users.email, 
            user_details.user_id, user_details.bday, user_details.gender, user_details.profile
            FROM comments 
            INNER JOIN users ON comments.id_user = users.id 
            INNER JOIN user_details ON user_details.user_id = users.id
            WHERE comments.comment_id = '$commentId'";
            $response = $this->connect->first($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getCountsCommentsPost($postId)
    {
        try {
            $sql = "SELECT COUNT(*) as total_comments FROM `comments` WHERE `id_post` = '$postId'";
            $response = $this->connect->get($sql);
            return $response[0];
        } catch (\Exception $e) {
            return ['total_comments' => 0];
        }
    }

    public function getnewsfeedimages($userid, $offset, $getall)
    {
        try {
            $sql = "SELECT posts.post_id, posts.user_id, posts.image, posts.created_at FROM `posts` WHERE posts.user_id = '$userid'
             ORDER BY posts.created_at DESC";
            if ($getall == 'false') {
                $sql .= " LIMIT 4";
            }
            $response = $this->connect->get($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    // add comment
    public function newcomment($uuid, $userid, $postid, $comment)
    {
        try {
            $sql = "INSERT INTO `comments`(`comment_id`, `id_post`, `id_user`, `comment`) VALUES ('$uuid','$postid','$userid','$comment')";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }
    // delete comment

    // like

}
