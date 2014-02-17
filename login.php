<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E2 Courier</title>

  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">  
</head>
<body>

  <div class="jumbotron">
    <div class="container">
      <h1>E2 Courier</h1>
      <p>Send Instant Messages to anyone in Second Life ... even if you're not logged in!</p>
    </div>
  </div>

  <!-- login form -->
  <div class="container">

<?php
// if there's an error being passed
$error = isset($_GET['e']) ? (int)$_GET['e'] : 0;

if ($error == 1) {
?>
<div class="alert alert-danger">
  <h4>Invalid Inputs</h4>
  <p>The values passed in the login form were invalid. Please try again.</p>
</div>
<?php
}

if ($error == 2) {
?>
<div class="alert alert-danger">
  <h4>Unknown Avatar</h4>
  <p>The avatar name you entered is not an owner of the Courier system. Please check your spelling and try again.</p>
</div>
<?php
}

if ($error == 3) {
?>
<div class="alert alert-danger">
  <h4>Incorrect Password</h4>
  <p>The password you entered does not match the password on file for this avatar name.</p>
  <p class="small">If you've forgotten your password, you can reset it using your
  Courier signup object in-world.</p>
</div>
<?php
}

if ($error == 4) {
?>
<div class="alert alert-warning">
  <h4>Session Expired</h4>
  <p>Your session has expired. Please log in again.</p>
</div>
<?php
}


?>  
    
    <div class="col-md-8 col-md-offset-2">
      <form role="form" action="handle-login.php" method="POST">
        <div class="form-group">
          <label for="avname">Avatar name:</label>
          <input class="form-control" type="text" id="avname" name="avname" placeholder="Avatar name" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>

  <footer>
    <div class="navbar navbar-fixed-bottom">
      <div class="container">
        <p class="small">Copyright &copy; 2014 DavidThomas Scorbal/E2 Designs</p>
        
      </div>
    </div>
  </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>