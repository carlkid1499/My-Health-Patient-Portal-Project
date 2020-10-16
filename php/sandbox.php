<?php
//========== Global Parameters ==========

$test_var = date("l jS \of F Y h:i:s A");
$msgIndex = 0;

$targetDB = '';
$querytype = 'sql';
$inputQuery = '';

$tableName = '';
$selection = '';

$errorMsg = array('');
$successMsg = array('');
$defaultTables = ['PatientInfo'];

$search_result = null;

//========== Database Connection ==========

$servername = "localhost";
$username = "myhealth2";
$password = "CIOjh^J8h^?b";
$dbname = "myhealth2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn -> connect_error) {
  die("Connection failed: ".$conn -> connect_error);
  echo "Connection failed: to DB";
}

//========== Button Actions ==========

if (isset($_POST['submit'])) {
  $selection = $_POST['sqldblist'];

  if ($selection !== 'Select Database') { $targetDB = $selection; }

  // Create connection
  $conn = new mysqli($servername, $username, $password, $targetDB);
  // Check connection
  if ($conn -> connect_error) {
    die($conn -> connect_error);
  }

  $search_result = null;
  $inputQuery = trim($_POST['inputQuery']);

  if (strpos(strtolower('###'.$inputQuery), 'create database')) {
    //updateMessages('error', 'Database creation not allowed on this platform.');
  }
  else if (strpos(strtolower('###'.$inputQuery), 'drop database')) // prefixing with ### 
  {
    //updateMessages('error', 'Database deletion not allowed on this platform.');
  }
  // else
  {
    // Send the Query to the PHP SQL
    $search_result = $conn ->query($inputQuery);
  } 
}
?>