<?php

# This is a query to search by First Name, Last Name, DOB
# Values must be set before the query is run.
$name_first = "";
$name_last = "";
$DOB = "";
$fisrt_last_dob_query = "SELECT * FROM myhealth2.PatientInfo WHERE name_first like '$name_first' AND name_last like '$name_last' AND DOB='$DOB'";

?>