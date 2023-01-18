<?php
require_once(dirname(__FILE__, 2).'./vendor/autoload.php');
require_once(dirname(__FILE__, 1).'./connect.db.php');
require_once(dirname(__FILE__, 1).'./UserClass.php');
require_once(dirname(__FILE__, 1).'./PostClass.php');
require_once(dirname(__FILE__, 1).'./pusherNotif.php');

$connect = new Connection();
$user = new User($connect);
$post = new Post($connect);
$pusher = new Notif();
