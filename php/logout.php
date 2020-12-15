<?php
   // Start the session to get the values
   session_start();
   // Clear all session values
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION['valid']);
   unset($_SESSION['timeout']);
   unset($_SESSION['userid']);
   unset($_SESSION['isemployee']);
   unset($_SESSION['pid']);
   unset($_SESSION['err_msg']);
   echo 'You have been logged out';
   header('Refresh: 2; URL = ../index.php');
   echo '<br> Feel free to close your browser session';
?>