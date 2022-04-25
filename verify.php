<?php
include('config.php');

if(isset($_POST['token'])) {
  $mountemail = $_POST['mountemail'];
  $token = $_POST['token'];
  $status = 0;

  $sql = "SELECT * FROM mountlistings.userinfo WHERE mountemail = ? AND token = ?";
  $stmtselect = $db->prepare($sql);
  $result = $stmtselect->execute([$mountemail, $token]);

  if($result) {
    $sql = "UPDATE mountlistings.userinfo SET status = 1 WHERE mountemail = ? AND token = ?";
    $stmtselect = $db->prepare($sql);
    $result = $stmtselect->execute([$mountemail, $token]);
  } //else {
    //$error = "<p> Your email or code were incorrect! </font> </p>";
  //}
}
?>



<html lang="en">
<head>
  <meta charset = "UTF-8">
  <meta http-equiv="X-UA-Compatible" content = "IE=edge">
  <meta name = "viewport" content = "width=device-width, initial-scale = 1">
  <link rel = "stylesheet" type = "text/css" href = "register.css">
  <!-- For google icons  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

<title>Verification form</title>
</head>



<body>
  <!-- for background -->
  <div class="background"></div>

  <h1>Mount Listings</h1>

  <!-- Login form container -->
  <div class = "container" id = "verifyForm">
    <h2>Verification</h2>
    <form action = "register.php" method = "post">
      <div class = "form-item">
        <span class = "material-icons-outlined">
          account_circle
        </span>
      <input type = "email" placeholder = "Enter Mount Email" name = "mountemail" id = "mountemail"  pattern = ".+@email.msmary.edu" required> <br>
      </div>

      <div class = "form-item">
        <span class = "material-icons-outlined">
          lock
        </span>
      <input type = "text" placeholder = "Enter Code" name = "token" id = "token" required>
      </div>

      <button type = "submit" id = "logSubmit" name = "logSubmit">Verify</button><br>

    </form>
  </div>

  <p>Your verification code has been sent to your email! <br> Reload the login page after verifying your account!</p>

  <?php
  if(isset($error) && !empty($error)){
      ?>
      <span class="error"><?= $error; ?></span>
      <?php
  }
  ?>

</body>
</html>
