<?php

class User
{

    private $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function checkEmail($email)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $response = $this->connect->first($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getUserWdetails($email)
    {
        try {
            // user_details.id AS uidd,
            $sql = "SELECT users.*, user_details.user_id, user_details.bday, user_details.gender, user_details.profile 
            FROM `users` INNER JOIN `user_details` ON users.id = user_details.user_id WHERE users.email = '$email' ";
            $response = $this->connect->first($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function addAbout($uuid, $userId, $cat, $about)
    {
        try {
            $sql = "INSERT INTO `abouts`(`id`, `user_id`, `category`, `text`) VALUES 
            ('$uuid','$userId','$cat','$about')";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function fetchAbouts($userId)
    {
        try {
            $sql = "SELECT * FROM `abouts` WHERE `user_id` = '$userId' ";
            $response = $this->connect->get($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function updateUserInfo($userid, $data)
    {
        try {
            $sql = "UPDATE `users` SET `first_name`='$data->first_name',`last_name`='$data->last_name' WHERE `id` = '$userid'";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function updatingPassword($userid, $password)
    {
        $password = $password;
        $userid = $userid;
    }

    public function updateUserDetails($userid, $data)
    {
        try {
            $sql = "UPDATE `user_details` SET `bday`='$data->bday', `gender`='$data->gender' WHERE `user_id`='$userid' ";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function updateLogincred($id, $email, $password)
    {
        try {
            $password = md5($password);
            $sql = "UPDATE `users` SET `email`='$email',`password`='$password' WHERE `id`='$id'";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getUserWdetails2($userId)
    {
        try {
            // user_details.id AS uidd,
            $sql = "SELECT users.*, user_details.user_id, user_details.bday, user_details.gender, user_details.profile 
            FROM `users` INNER JOIN `user_details` ON users.id = user_details.user_id WHERE users.id = '$userId' ";
            $response = $this->connect->first($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getUsesrWdetails()
    {
        try {
            // user_details.id AS uidd,
            $sql = "SELECT users.*, user_details.user_id, user_details.bday, user_details.gender, user_details.profile 
            FROM `users` INNER JOIN `user_details` ON users.id = user_details.user_id ";
            $response = $this->connect->first($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function statusChange($condition, $user_id)
    {
        try {
            $sql = "UPDATE `users` SET `status`= '$condition' WHERE id = '$user_id' ";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function save($id, $fname, $lname, $email, $password)
    {
        try {
            $password = md5($password);
            $sql = "INSERT INTO `users`(`id`, `first_name`, `last_name`, `email`, `password`) VALUES 
            ('$id','$fname','$lname','$email','$password')";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }
    //getUsers
    public function getUsersSuggestFriend($user_id)
    {
        try {
            // $sql = "SELECT * FROM users WHERE id != '$user_id' AND id NOT IN (SELECT user_request_id FROM chat_request) AND
            //  id NOT IN (SELECT user_id  FROM chats  WHERE user_id != '$user_id') AND id NOT IN (SELECT friend_id  FROM chats  WHERE user_id != '$user_id')";
            $sql = "SELECT users.*, user_details.id AS uidd, user_details.user_id, user_details.bday, user_details.gender, user_details.profile 
            FROM `users` INNER JOIN `user_details` ON users.id = user_details.user_id 
            WHERE users.id != '$user_id' AND users.id NOT IN (SELECT user_request_id FROM chat_request WHERE user_id = '$user_id') 
            AND users.id NOT IN (SELECT user_id  FROM chat_request WHERE user_request_id = '$user_id') AND users.id NOT IN 
            (SELECT friend_id FROM chats WHERE user_id = '$user_id') AND users.id NOT IN 
            (SELECT user_id FROM chats WHERE friend_id = '$user_id')";
            // AND users.id NOT IN (SELECT user_id  FROM chats  WHERE user_id != '$user_id')
            $response = $this->connect->get($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function saveDetails($id, $user_id, $month, $year, $day, $gender)
    {
        try {
            $date = $year . '-' . $month . '-' . $day;
            $profile = 'default-profile.png';
            $sql = "INSERT INTO `user_details`(`id`, `user_id`, `bday`, `gender`, `profile`) VALUES ('$id','$user_id','$date','$gender','$profile')";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function checkFriendRequest($userid)
    {
        try {
            $sql = "SELECT * FROM chat_request WHERE user_request_id = '$userid'";
            $response = $this->connect->first($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function removeFriendRequest($id)
    {
        try {
            $sql = "DELETE FROM `chat_request` WHERE id = '$id'";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function addFriendRequest($userid, $friend_id, $id)
    {
        try {
            date_default_timezone_set('Asia/Manila');
            $datetime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO `chat_request`(`id`,`user_id`, `date`, `user_request_id`) VALUES ('$id','$userid','$datetime','$friend_id')";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function acceptFriendRequest($id, $userid, $friend_id)
    {
        try {
            $sql = "INSERT INTO `chats`(`id`, `user_id`, `friend_id`, `type`) VALUES ('$id','$userid', '$friend_id', 'people')";
            $response = $this->connect->execute($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getFriendRequest($userid)
    {
        try {
            $sql = "SELECT chat_request.*, users.id as iduser, users.first_name, users.last_name, users.email, 
            user_details.user_id as uid, user_details.profile FROM `chat_request`
            INNER JOIN users ON users.id = chat_request.user_id 
            INNER JOIN user_details ON users.id = user_details.user_id
            WHERE chat_request.user_request_id = '$userid'";
            $response = $this->connect->get($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getCountsFriends($userid)
    {
        try {
            $sql = "SELECT COUNT(*) as total_friend FROM chats WHERE `user_id`='$userid' OR `friend_id`='$userid'";
            $response = $this->connect->get($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function returnFriendRequest($id)
    {
        try {
            $sql = "SELECT chat_request.*, users.id as iduser, users.first_name, users.last_name, users.email FROM `chat_request`
            INNER JOIN users ON users.id = chat_request.user_id 
            WHERE chat_request.id = '$id'";
            $response = $this->connect->first($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function fetchChatMessages($userid, $chatmate_id)
    {
        try {
            $sql = "SELECT chats.id as c_id, chats.user_id as c_user_id, chats.friend_id as c_friend_id, chats.created_at as c_created_at,
            -- users.id as uid, users.first_name, users.last_name, users.email, users.status,
            messages.id as m_id, messages.chat_id as m_chat_id, messages.send_date as m_send_date,  
            messages.message as m_message, messages.type as m_type, messages.seen_status as m_seen_status, 
            messages.sender as m_sender
            FROM `chats`
            -- LEFT JOIN users ON users.id = chats.friend_id
            LEFT JOIN messages ON messages.chat_id = chats.id 
            WHERE (chats.friend_id = '$userid' AND chats.user_id = '$chatmate_id')
            OR (chats.friend_id = '$chatmate_id' AND chats.user_id = '$userid')
            ORDER BY messages.send_date";
            return $this->connect->get($sql);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function updateLastInteraction($chatid)
    {
        date_default_timezone_set('Asia/Manila');
        $datetime = date("Y-m-d H:i:s");
        $sql = "UPDATE `chats` SET `created_at`='$datetime ' WHERE `id`='$chatid'";
        return $this->connect->execute($sql);
    }

    public function updateProfilePicture($picture, $userid)
    {
        $sql = "UPDATE `user_details` SET `profile`='$picture ' WHERE `user_id`='$userid'";
        return $this->connect->execute($sql);
    }

    public function fetchChatMessage($id)
    {
        try {
            $sql = "SELECT chats.id as c_id, chats.user_id as c_user_id, chats.friend_id as c_friend_id, chats.created_at as c_created_at,
            messages.id as m_id, messages.chat_id as m_chat_id, messages.send_date as m_send_date,  
            messages.message as m_message, messages.type as m_type, messages.seen_status as m_seen_status, 
            messages.sender as m_sender
            FROM `chats`
            LEFT JOIN messages ON messages.chat_id = chats.id 
            WHERE messages.id = '$id'";
            return $this->connect->first($sql);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function saveMessage($id, $message, $chatmate, $sender)
    {
        try {
            date_default_timezone_set('Asia/Manila');
            $datetime = date("Y-m-d H:i:s");
            $sqlSelect = "SELECT `id` FROM `chats` WHERE (user_id = '$chatmate' AND friend_id = '$sender') OR 
            (user_id = '$sender' AND friend_id = '$chatmate')";
            $chat = $this->connect->first($sqlSelect);
            if ($chat) {
                $sql = "INSERT INTO `messages`(`id`, `message`, `sender`, `type`, `send_date`, `chat_id`) 
                VALUES ('$id','$message','$sender','text','$datetime','$chat->id')";
                $this->updateLastInteraction($chat->id);
                return $this->connect->execute($sql);
            } else {
                return false;
            }
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getUser($user_id)
    {
        try {
            $sql = "SELECT * FROM users WHERE id = '$user_id'";
            $response = $this->connect->first($sql);
            return $response;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function fetchChatFriends($userid)
    {
        try {
            // ORDER BY COALESCE(messages.send_date)

            $sql2 = "SELECT * FROM chats WHERE friend_id = '$userid' OR user_id = '$userid'";
            $res = $this->connect->first($sql2);

            if ($res) {
                $sql = "(SELECT chats.id as c_id, chats.user_id, chats.friend_id, chats.created_at,
                users.id as uid, users.first_name, users.last_name, users.email, users.status, 
                user_details.user_id, user_details.bday, user_details.gender, user_details.profile 
                FROM `chats`
                LEFT JOIN users ON users.id = chats.user_id 
                LEFT JOIN user_details ON user_details.user_id = users.id
                WHERE chats.friend_id = '$userid')
                UNION 
                (SELECT chats.id as c_id, chats.user_id, chats.friend_id, chats.created_at, 
                users.id as uid, users.first_name, users.last_name, users.email, users.status,
                user_details.user_id, user_details.bday, user_details.gender, user_details.profile
                FROM `chats`
                LEFT JOIN users ON users.id = chats.friend_id 
                LEFT JOIN user_details ON user_details.user_id = users.id
                WHERE chats.user_id = '$userid')
                ORDER BY created_at DESC ";

                return $this->connect->get($sql);
            } else {
                return [];
            }
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage(), 'status' => 500]);
        }
    }
}
