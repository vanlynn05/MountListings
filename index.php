<?php
require_once('config.php');

session_start();

if(isset($_SESSION['session'])) {
  header("Location: mountlistings.php");
}

?>

<div>
  <?php
  //PHPMailer
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;


  //Code that inserts registered info
  if(isset($_POST['regSubmit'])) {
    //Takes entered info and assigns to variables
    $mountemail = $_POST['mountemail'];
    $mountPassword = $_POST['mountPassword'];
    $passwordRepeat = $_POST['passwordRepeat'];


    //Generates random token to identify user
    $token = rand(10000,9999999);
    $status = 0;

    //Makes sure that password and password repeat match
    if ($mountPassword !== $passwordRepeat) {
      $error = "<p> <font = white> Your passwords did not match </font> </p>";
    }else {
      $hashPassword = password_hash($mountPassword, PASSWORD_DEFAULT);
      $passwordRepeat = password_hash($passwordRepeat, PASSWORD_DEFAULT);

      //Code that actually inserts info into database
      $sql = "INSERT INTO mountlistings.userinfo(mountemail, mountPassword, passwordRepeat, token, status) VALUES(?, ?, ?, ?, ?)";
      $stmtinsert = $db->prepare($sql);
      $result = $stmtinsert->execute([$mountemail, $hashPassword, $passwordRepeat, $token, $status]);

      if($result == true) {

        //Load Composer's autoloader
          require 'PHPMailer/src/Exception.php';
          require 'PHPMailer/src/PHPMailer.php';
          require 'PHPMailer/src/SMTP.php';

          //Create an instance; passing `true` enables exceptions
          $mail = new PHPMailer(true);

          try {
              //Server settings
              $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  //Enable verbose debug output
              $mail->isSMTP();                                           //Send using SMTP
              $mail->Host       = 'smtp.gmail.com';                      //Set the SMTP server to send through
              $mail->SMTPAuth   = true;                                  //Enable SMTP authentication
              $mail->Username   = 'mountlistings@gmail.com';             //SMTP username
              $mail->Password   = 'Mount2022';                           //SMTP password
              $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
              $mail->Port       = 465;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

              //Recipients
              $mail->setFrom('mountlistings@gmail.com', 'Mount Listings');
              $mail->addAddress($mountemail);     //Add a recipient


              //Content
              $mail->isHTML(true);                                      //Set email format to HTML
              $mail->Subject = 'Mount Listings';
              $mail->Body    = "This is your code!: ".$token;

              header('location:verify.php');

              $mail->send();
          //    echo '<script>alert("Please check your email to verify your account!: ")</script>';
          } catch (Exception $e) {
            //  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
      }
    }
  }
  ?>
</div>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset = "UTF-8">
  <meta http-equiv="X-UA-Compatible" content = "IE=edge">
  <meta name = "viewport" content = "width=device-width, initial-scale = 1">
  <link rel = "stylesheet" type = "text/css" href = "Register.css">
  <!-- For google icons  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

<title>Login form</title>
</head>


<body>
  <!-- for background -->
  <div class="background"></div>

<h1>Mount Listings</h1>
<p id = "message" name = "message" ><?php echo $message = ""?></p>


  <!-- Login form container -->
  <div class = "container" id = "logForm">
    <h2 style = "font-size: 40px;">Login</h2><br>
    <form action = "Register.php" method = "post">
      <div class = "form-item">
        <span class = "material-icons-outlined">
          account_circle
        </span>
      <input type = "email" placeholder = "Enter Mount Email" name = "mountemail2" id = "mountemail2"  pattern = ".+@email.msmary.edu" required> <br>
      </div>

      <div class = "form-item">
        <span class = "material-icons-outlined">
          lock
        </span>
      <input type = "password" placeholder = "Enter Password" name = "mountPassword2" id = "mountPassword2" required><br>
      </div>

      <button type = "submit" id = "logSubmit" name = "logSubmit">Login</button><br><br>

      <a href="#" id = "new_user" onclick = "appear()" style = "font-size: 20px;">New User?</a>

    </form>
  </div>



<script>
function appear() {
  if (logForm.style.display !== "none") {
    logForm.style.display = "none";
  } else {
  logForm.style.display = "flex";
  }

  if (regForm.style.display !== "none") {
    regForm.style.display = "none";
  } else {
  alert('DISCLAIMER: To register to Mount Listings you must temporarily disconnect from the schools Wi-Fi on your laptop and connect to a hot spot on your phone to recieve your verification email. Once you verify your account you can reconnect to the schools Wi-Fi. Thank you!');
  regForm.style.display = "flex";
  }
};
</script>



  <!-- Register form container -->
  <div class = "container" id = "regForm" style="display: none;">
    <h2 style = "font-size: 40px;">Register</h2><br>
    <form action = "Register.php" method = "post">
      <div class = "form-item">
        <span class = "material-icons-outlined">
          account_circle
        </span>
        <input type = "email" placeholder = "Enter Mount Email" name = "mountemail" id = "mountemail" pattern = ".+@email.msmary.edu" required> <br>
      </div>

      <div class = "form-item">
        <span class="material-icons-outlined">
          lock
        </span>
        <input type = "password" placeholder = "Enter Password" name = "mountPassword"  id = "mountPassword" minlength = "5" required> </br>
      </div>

      <div class = "form-item">
        <span class = "material-icons-outlined">
          lock
        </span>
        <input type = "password" placeholder = "Repeat Password" name = "passwordRepeat" id = "passwordRepeat" minlength = "5" required>

      </div>

        <button type = "submit" name = "regSubmit" id = "regSubmit">Register</button><br>

        <a href="#" id = "existing_user"  onclick = "appear()" style = "font-size: 20px;">Existing User?</a>
    </form>
  </div>


  <?php
  if(isset($error) && !empty($error)){
      ?>
      <span class="error"><?= $error; ?></span>
      <?php
  }
  ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
  $(function() {
    $('#logSubmit').click(function(e) {
      var valid = this.form.checkValidity();

      if(valid) {
        var mountemail2 = $('#mountemail2').val();
        var mountPassword2 = $('#mountPassword2').val();
      }

      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'login.php',
        data: {mountemail2: mountemail2, mountPassword2: mountPassword2},

        success: function(data) {
          if($.trim(data) === "1") {
            setTimeout('window.location.href = "mountlistings.php"', 1000);
          }
        },

        error: function(data) {
          alert('no');
        }
      });
    });
  });
</script>


</body>
</html>
