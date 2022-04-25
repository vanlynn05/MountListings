<?php
require_once('config.php');

session_start();

if(!isset($_SESSION['session'])) {
  header("Location: register.php");
}


if(isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION);
  header("Location: register.php");
}

?>

<div>
<!--PHP for posts -->
<?php
if(isset($_POST['postSubmit'])) {
  $user_id = $_SESSION['session']['id'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $mountemail = $_POST['mountemail'];
  $services = $_POST['services'];
  $description = $_POST['description'];
  $calendlylink = $_POST['calendlyLink'];




  $sql = "INSERT INTO mountlistings.postinfo(user_id, first_name, last_name, mountemail, services, description, calendlylink) VALUES(?, ?, ?, ?, ?, ?, ?)";
  $stmtinsert = $db->prepare($sql);
  $result = $stmtinsert->execute([$user_id, $first_name, $last_name, $mountemail, $services, $description, $calendlylink]);
  }


?>
</div>



<!DOCTYPE html>
<html>
<head>
<meta name = "MountListings" charset = "UTF-8" content = "width=device-width, initial-scale=1">
<link rel = "stylesheet" type = "text/css" href = "MountListings.css">
</head>



<body>
  <div class = "background"></div>

<!-- Holds Top Buttons -->
<div class = "topButtons">
<button onclick = "document.getElementById('id01').style.display = 'block'" class = "topButtons">Post</button>
<button style = "float: right;" class = "topButtons"><a href="mountlistings.php?logout=true">Logout</a></button>
<button style = "float: right;" class = "topButtons"><a href="https://calendly.com/" target="_blank" rel="noopener noreferrer">Calendly</a></button>
</div>



<div class = "header">
  <h1>Mount Listings</h1>
</div>



<div id = "id01" class = "modal">
  <form class = "modal-content animate" action = "MountListings.php" method = "post">
    <div class = "container">
      <label for = "first_name">First name:</label>
      <input type = "text" id = "first_name" name = "first_name" maxlength = "16" required> <br><br>

      <label for = "last_name">Last name:</label>
      <input type = "text" id = "last_name" name = "last_name" maxlength = "16" required> <br><br>

      <label for = "mountemail">Mount Email:</label>
      <input type = "email" id = "mountemail" name = "mountemail" pattern = ".+@email.msmary.edu" required> <br><br>

      <label for = "services">Service Category:</label>
      <select name = "services" id = "services">
        <option value = "School">School</option>
        <option value = "Beauty">Beauty</option>
        <option value = "Cleaning">Cleaning</option>
        <option value = "Pets">Pets</option>
        <option value = "Misc">Misc</option>
      </select> <br><br>

      <label for = "description">Description:</label><br>
      <textarea id = "description" name = "description" rows = "6" cols = "50" maxlength = "255"></textarea> <br> <br>

      <label for "calendlyLink">Calendly Link</label><br>
      <input type = "url" id = "calendlyLink" name = "calendlyLink" value = ""><br><br>

      <button type = "submit" id = "postSubmit" name = "postSubmit" class = "postbtn">Post</button>

      </div>

      <div class = "container" style = "background-color:#f1f1f1">
        <button type = "button" onclick = "document.getElementById('id01').style.display = 'none'" class = "cancelbtn">Cancel</button>
      </div>

  </form>
</div>



<script>
// Get the modal
var modal = document.getElementById('id01');
var modal2 = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }

    if (event.target == modal2) {
        modal2.style.display = "none";
    }
}
</script>



<!-- Holds Tabs -->
<div class = "tab">
  <button class = "tablinks" onclick = "openTab(event, 'Home')" name = "Home" id = "defaultOpen" style = "width: 17%">Home</button>
  <button class = "tablinks" onclick = "openTab(event, 'School')" name = "School" style = "width: 16%">School</button>
  <button class = "tablinks" onclick = "openTab(event, 'Beauty')" name = "Beauty" style = "width: 17%">Beauty</button>
  <button class = "tablinks" onclick = "openTab(event, 'Cleaning')" name = "Cleaning" style = "width: 17%">Cleaning</button>
  <button class = "tablinks" onclick = "openTab(event, 'Pets')" name = "Pets" style = "width: 16%">Pets</button>
  <button class = "tablinks" onclick = "openTab(event, 'Misc')" name = "Misc" style = "width: 17%">Misc</button>
</div>



<!-- Home Tab Content -->
<div id = "Home" class = "tabcontent">
    <?php
    require_once('config.php');
    $query = "SELECT * from mountlistings.postinfo ORDER BY id DESC";
    $d = $db->query($query);
    ?>

    <?php foreach($d as $data) { ?>
    <div class = "panel-body">
        <div class = "fb-user-details">
            <h3>&nbsp;<?php echo $data['first_name']; echo " "; echo $data['last_name']; echo " - "; echo $data['services'];?></h3>
            <p>&nbsp;&nbsp;<?php echo $data['mountemail']; ?></p>
        </div>
        <div class = "clearfix"></div>
        <p class = "fb-user-status">&nbsp;&nbsp;&nbsp;<?php echo $data['description']; ?></p>
        <div class = "fb-status-container fb-border">
            <div class = "fb-time-action">
              <button id = "edit" name = "edit" style = "float: right;" class = "editbtn">Edit</button>&nbsp
              <button id = "edit" name = "edit" style = "float: right;" class = "deletebtn">Delete&nbsp</button>
              <link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
              <script src = "https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
              <a href = "" onclick = "Calendly.initPopupWidget({url: '<?php echo $data['calendlylink']; ?>'});return false;">Schedule time with me</a>
            </div>
        </div>
    </div>
<?php } ?>
</div>



<!-- School Tab Content -->
<div id = "School" class = "tabcontent">
  <?php
  require_once('config.php');
  $query = "SELECT * from mountlistings.postinfo WHERE services = 'school' ORDER BY id DESC";
  $d = $db->query($query);
  ?>

  <?php foreach($d as $data) { ?>
  <div class = "panel-body">
      <div class = "fb-user-details">
          <h3>&nbsp;<?php echo $data['first_name']; echo " "; echo $data['last_name']; echo " - "; echo $data['services'];?></h3>
          <p>&nbsp;&nbsp;<?php echo $data['mountemail']; ?></p>
      </div>
      <div class = "clearfix"></div>
      <p class = "fb-user-status">&nbsp;&nbsp;&nbsp;<?php echo $data['description']; ?></p>
      <div class = "fb-status-container fb-border">
          <div class = "fb-time-action">

            <button id = "edit" name = "edit" style = "float: right;" class = "editbtn">Edit</button>&nbsp
            <button id = "edit" name = "edit" style = "float: right;" class = "deletebtn">Delete&nbsp</button>

            <link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
            <script src = "https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
            <a href = "" onclick = "Calendly.initPopupWidget({url: '<?php echo $data['calendlylink']; ?>'});return false;">Schedule time with me</a>
          </div>
      </div>
  </div>
<?php } ?>
</div>



<!-- Beauty Tab Content -->
<div id = "Beauty" class = "tabcontent">
  <?php
  require_once('config.php');
  $query = "SELECT * from mountlistings.postinfo WHERE services = 'beauty' ORDER BY id DESC";
  $d = $db->query($query);
  ?>

  <?php foreach($d as $data) { ?>
  <div class = "panel-body">
      <div class = "fb-user-details">
          <h3>&nbsp;<?php echo $data['first_name']; echo " "; echo $data['last_name']; echo " - "; echo $data['services'];?></h3>
          <p>&nbsp;&nbsp;<?php echo $data['mountemail']; ?></p>
      </div>
      <div class = "clearfix"></div>
      <p class = "fb-user-status">&nbsp;&nbsp;&nbsp;<?php echo $data['description']; ?></p>
      <div class = "fb-status-container fb-border">
          <div class = "fb-time-action">
            <button id = "edit" name = "edit" style = "float: right;" class = "editbtn">Edit</button>&nbsp
            <button id = "edit" name = "edit" style = "float: right;" class = "deletebtn">Delete&nbsp</button>
            <link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
            <script src = "https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
            <a href = "" onclick = "Calendly.initPopupWidget({url: '<?php echo $data['calendlylink']; ?>'});return false;">Schedule time with me</a>
          </div>
      </div>
  </div>
<?php } ?>
</div>



<!-- Cleaning Tab Content -->
<div id = "Cleaning" class = "tabcontent">
  <?php
  require_once('config.php');
  $query = "SELECT * from mountlistings.postinfo WHERE services = 'cleaning' ORDER BY id DESC";
  $d = $db->query($query);
  ?>

  <?php foreach($d as $data) { ?>
  <div class = "panel-body">
      <div class = "fb-user-details">
          <h3>&nbsp;<?php echo $data['first_name']; echo " "; echo $data['last_name']; echo " - "; echo $data['services'];?></h3>
          <p>&nbsp;&nbsp;<?php echo $data['mountemail']; ?></p>
      </div>
      <div class = "clearfix"></div>
      <p class = "fb-user-status">&nbsp;&nbsp;&nbsp;<?php echo $data['description']; ?></p>
      <div class = "fb-status-container fb-border">
          <div class = "fb-time-action">
            <button id = "edit" name = "edit" style = "float: right;" class = "editbtn">Edit</button>&nbsp
            <button id = "edit" name = "edit" style = "float: right;" class = "deletebtn">Delete&nbsp</button>
            <link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
            <script src = "https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
            <a href = "" onclick = "Calendly.initPopupWidget({url: '<?php echo $data['calendlylink']; ?>'});return false;">Schedule time with me</a>
          </div>
      </div>
  </div>
<?php } ?>
</div>



<!-- Pets Tab Content -->
<div id = "Pets" class = "tabcontent">
  <?php
  require_once('config.php');
  $query = "SELECT * from mountlistings.postinfo WHERE services = 'pets' ORDER BY id DESC";
  $d = $db->query($query);
  ?>

  <?php foreach($d as $data) { ?>
  <div class = "panel-body">
      <div class = "fb-user-details">
          <h3>&nbsp;<?php echo $data['first_name']; echo " "; echo $data['last_name']; echo " - "; echo $data['services'];?></h3>
          <p>&nbsp;&nbsp;<?php echo $data['mountemail']; ?></p>
      </div>
      <div class = "clearfix"></div>
      <p class = "fb-user-status">&nbsp;&nbsp;&nbsp;<?php echo $data['description']; ?></p>
      <div class = "fb-status-container fb-border">
          <div class = "fb-time-action">
            <button id = "edit" name = "edit" style = "float: right;" class = "editbtn">Edit</button>&nbsp
            <button id = "edit" name = "edit" style = "float: right;" class = "deletebtn">Delete&nbsp</button>
            <link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
            <script src = "https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
            <a href = "" onclick = "Calendly.initPopupWidget({url: '<?php echo $data['calendlylink']; ?>'});return false;">Schedule time with me</a>
          </div>
      </div>
  </div>
<?php } ?>
</div>



<!-- Misc Tab Content -->
<div id = "Misc" class = "tabcontent">
  <?php
  require_once('config.php');
  $query = "SELECT * from mountlistings.postinfo WHERE services = 'misc' ORDER BY id DESC";
  $d = $db->query($query);
  ?>

  <?php foreach($d as $data) { ?>
  <div class = "panel-body">
      <div class = "fb-user-details">
          <h3>&nbsp;<?php echo " "; echo $data['first_name']; echo " "; echo $data['last_name']; echo " - "; echo $data['services'];?></h3>
          <p>&nbsp;&nbsp;<?php echo " "; echo $data['mountemail']; ?></p>
      </div>
      <div class = "clearfix"></div>
      <p class = "fb-user-status">&nbsp;&nbsp;&nbsp;<?php echo " "; echo $data['description']; ?></p>
      <div class = "fb-status-container fb-border">
          <div class = "fb-time-action">
            <button id = "edit" name = "edit" style = "float: right;" class = "editbtn">Edit</button>&nbsp
            <button id = "edit" name = "edit" style = "float: right;" class = "deletebtn">Delete&nbsp</button>
            <link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
            <script src = "https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
            <a href = "" onclick = "Calendly.initPopupWidget({url: '<?php echo $data['calendlylink']; ?>'});return false;">Schedule time with me</a>
          </div>
      </div>
  </div>
<?php } ?>
</div>



<!-- Script for changing tabs -->
<script>
document.getElementById("defaultOpen").click();

function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

</body>
</html>
