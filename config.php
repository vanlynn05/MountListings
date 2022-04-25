<?php

$db_user = "root";
$db_pass = "";
$db_name = "mountlistings";

$db = new PDO('mysql:host = localhost; dbname = mountlistings; charset = utf8', $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
