<?php

require_once('inc/utils.php');
date_default_timezone_set('America/Los_Angeles');

// make sure there's a valid access token available
session_start();
$token = "";
$uid = isset($_SESSION['uid']) ? (int)$_SESSION['uid'] : 0;

if ($uid) {
  $tokenService = new Token($uid);
  $token = $tokenService->getToken();
}

if ($token == "") {
  header('Location: login.php?e=4');
  exit;
}

?>

<!doctype html>
<html lang="en" ng-app="app">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E2 Courier</title>

  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/courier.css">

</head>
<body>
  
  <nav class="navbar navbar-inverse" role="navigation">
    <div class="container-fluid">

      <!-- brand and toggle get grouped -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
        data-target="#navlinks">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a ui-sref="home" class="navbar-brand">E2 Courier</a>
      </div>

      <!-- nav links -->
      <div class="collapse navbar-collapse" id="navlinks">
        <ul class="nav navbar-nav">
          <li ui-sref-active="active"><a ui-sref="home">Home</a></li>
          <li ui-sref-active="active"><a ui-sref="contacts">Contacts</a></li>
          <li ui-sref-active="active"><a ui-sref="messages">Messages</a></li>
        </ul>
      </div>

    </div>  
  </nav>
  
  <div id="main-container" class="container">
    <div ui-view></div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

  <script src="js/angular.js"></script>
  <script src="js/angular-ui-router.min.js"></script>
  <script src="app/app.js"></script>
</body>
</html>