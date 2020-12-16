<?php
# import another php file and access it's variables
include 'php/queries.php';
?>

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Welcome to My Health Portal</title>
  <link href="css/welcome.css" rel='stylesheet'>
  <link href="css/blue_theme.css" rel='stylesheet'>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="js/effects.js"></script>
  <!--- SOURCE: https://www.w3schools.com/php/php_includes.asp --->
</head>

<body>

  <!-- Call the login.php and execute it -->
  <?php include 'php/welcome.php' ?>

</body>

</html>