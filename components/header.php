<?php 
    session_start();
    $secured = false;
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $secured = true;
    } elseif (! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || ! empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
        $secured = true;
    }

    $REQUEST_PROTOCOL = $secured ? 'https://' : 'http://';
    // name of project
    $project = dirname(__DIR__);
//  $project = $project[4];
    $project = str_replace("/","",$project);
//     define("DIRECTION", "" . $REQUEST_PROTOCOL . "" . $_SERVER['HTTP_HOST'] . "/" . $project . "");
    define("DIRECTION", "" . $REQUEST_PROTOCOL . "" . $_SERVER['HTTP_HOST']);
//     define("ASSET", "" . $REQUEST_PROTOCOL . "" . $_SERVER['HTTP_HOST'] . "/" . $project . "/public");\
    define("ASSET", "" . $REQUEST_PROTOCOL . "" . $_SERVER['HTTP_HOST'] . "/public");
    define("ROUTES_PATH", DIRECTION . "/");
    define("COMPONENTS", DIRECTION . "/components");
    define("CONTROLLER", DIRECTION . '/controller');

    if(!isset($_SESSION['user']) || !$_SESSION['user']) {
        $url = ROUTES_PATH."login.php";
        header("Location: $url");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PHP SOCIAL APP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" type="text/css" href="<?= DIRECTION ?>/assets/css/loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
	<script src="https://momentjs.com/downloads/moment.js"></script>
    <script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>
</head>
<body>
