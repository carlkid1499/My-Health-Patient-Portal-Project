<?php
# import another php file and access it's variables
include 'php/sandbox.php';
?>

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>My Health Patient Portal</title>
  <link href="/css/style.css" rel='stylesheet'>
  <script src="/js/effects.js"></script>
  <!--- SOURCE: https://www.w3schools.com/php/php_includes.asp --->
</head>

<body>

  <!-- Call the login.php and execute it -->
  <?php include 'php/welcome.php' ?>

</body>

</html>