<?php
require_once('config.php');

session_start();

$mountemail = $_POST['mountemail2'];
$mountPassword1 = $_POST['mountPassword2'];

$sql = "SELECT * FROM mountlistings.userinfo WHERE mountemail = ? AND status = 1 LIMIT 1";
$stmtselect = $db->prepare($sql);
$result = $stmtselect->execute([$mountemail]);

if($result) {
  $mountemail = $stmtselect->fetch(PDO::FETCH_ASSOC);

  if(password_verify($mountPassword1, $mountemail['mountPassword'])) {
    if($stmtselect->rowCount() > 0) {
      $_SESSION['session'] = $mountemail;
      echo "1";

    }//else{
      //  "no";
    //}
  }
}
?>
