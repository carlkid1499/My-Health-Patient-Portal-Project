<?php
date_default_timezone_set("America/Los_Angeles");
$date = date("l jS \of F Y h:i:s A");
//========== Database Connection ==========

$dbservername = "localhost";
$dbusername = "myhealth2";
$dbpassword = "CIOjh^J8h^?b";
$dbname = "myhealth2";

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn -> connect_error) {
  die("Connection failed: ".$conn -> connect_error);
  echo "Connection failed: to DB";
}

# This is a query to search by First Name, Last Name, DOB
# Values must be set before the query is run.
$name_first = "";
$name_last = "";
$DOB = "";
$first_last_dob_query = "SELECT * FROM myhealth2.PatientInfo WHERE name_first like '%$name_first%' AND name_last like '%$name_last%' AND DOB='$DOB'";

# This query will search for a given PID
$PID = NULL;
$patient_id_query = "SELECT * FROM myhealth2.PatientInfo WHERE PID='$PID'";

# This query will search for a given phone number.
$phone_number = "";
$phone_number_query = "SELECT * FROM myhealth2.PatientInfo WHERE phone like '%$phone_number%'";

?>
