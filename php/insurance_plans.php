<?php
/* This is the patient_portal.php file.
* All Patient information will be accessed
* through this page.
*/

# import another php file and access it's variables
include 'queries.php';

# Start the session again to access session variables
session_start();
# Grab all the session values
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$isemployee = $_SESSION['isemployee'];
$pid = $_SESSION['pid'];
$name_first = $_SESSION['name_first'];
$name_last = $_SESSION['name_last'];

# Tell Browser not to cache anything
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");
?>
<!--end of php section-->

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Insurance Plans Portal </title>
  <link href='../css/welcome.css' rel='stylesheet'>
  <link href="../css/blue_theme.css" rel='stylesheet'>
  <link href="../css/patient_portal.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="../js/effects.js"></script>
  <!--- SOURCE: https://www.w3schools.com/php/php_includes.asp --->
</head>

<div class="w3-bar w3-theme-d5">
<!--Home Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button class="w3-bar-item w3-button" name="home" type="submit">Home
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['home']))
        {
          header('Location: ../index.php');
        } 
        ?>
        </button>
  </form>
<!--Refresh Page Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button class="w3-bar-item w3-button" name="patient_portal" type="submit">Patient Portal
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['patient_portal']))
        {
          header('Location: patient_portal.php');
        } 
        ?>
        </button>
  </form>
<!--Insurance Plans Page Button-->
<form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button class="w3-bar-item w3-button" name="insurance_plans" type="submit">Insurance Plans
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['insurance_plans']))
        {
          header('Location: insurance_plans.php');
        } 
        ?>
        </button>
  </form>
<!--Logout Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button class="w3-bar-item w3-button logoutbtn" name="logout" type="submit" style="float: right;">Logout
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['logout']))
        {
          header('Location: logout.php');
        } 
        ?>
        </button>
  </form>

</div>

<div class="header w3-theme-d2">
    <h1><b>My Health Patient Portal</b></h1>
</div>

<body>
<div class="container">
<div class="center">

  <h2>Insurance Plans Portal: <?php echo " Welcome - <B>$name_first</B>"?></h2>

  
</div>
</div>

<!--modal called to display update information form-->


<!--JS to close modal window on click outside of window-->
<script>
  // Get the modal
  var modals = document.getElementsByClassName('modal');

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    for(i=0; i<modals.length;i++)
      if (event.target == modals[i]) {
          modals[i].style.display = "none";
      }
  }
</script>

  <?php $conn->close(); ?>
</body>
</html>