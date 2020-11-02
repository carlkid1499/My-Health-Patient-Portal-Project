<?php

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
