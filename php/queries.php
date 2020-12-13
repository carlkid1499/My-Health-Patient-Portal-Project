<?php

/***** Begin: Database Connection Parameters *****/
$dbservername = "localhost";
$dbusername = "myhealth2";
$dbpassword = "CIOjh^J8h^?b";
$dbname = "myhealth2";
/***** End: Database Connection Parameters *****/

/***** BEGIN: Create database connection *****/ 
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn -> connect_error) {
  die("Connection failed: ".$conn -> connect_error);
  echo "Connection failed: to DB";
}
/***** END: Create database connection *****/ 


/***** BEGIN: Declare MySQL Query Statements *****/
# Get Patient Records Query
$patient_records = $conn->prepare("SELECT RecordTime, TCatID, PatientPayment FROM PatientRecords WHERE PID=?");

# Get the Treatment Category Name Query
$treament_category = $conn->prepare("SELECT TreatmentCategory FROM TreatmentCategory WHERE TCatID=?");

# Get Patient Notes Query
$patient_notes = $conn->prepare("SELECT ProvID, NoteTime, DiagnosisNotes, DrRecommendations FROM PatientNotes WHERE PID=?");

# Get the Provider Name Query
$healthprovider_name =  $conn->prepare("SELECT ProvName, ProvAddr FROM HealthProvider WHERE ProvID=?");

# Update Information Query
$update_info = $conn->prepare("UPDATE PatientInfo SET address=?, email=?, phone=?, Emergency_name=?, Emergency_phone=? WHERE PID=?");

$get_enrolled_query = $conn->prepare("SELECT PlanID,CompanyID FROM Enrolled WHERE PID=?");

$search_for_insprov_by_state_query = $conn->prepare("SELECT * FROM InsProvider WHERE Address like ?");

$get_planid_info_by_id_query = $conn->prepare("SELECT AnnualPrem, AnnualDeductible, AnnualCoverageLimit, LifetimeCoverage, Network FROM InsPlans WHERE PlanID=?");

$get_insprov_info_by_id_query = $conn->prepare("SELECT Company, PlanID, Category, Address, Email, Phone FROM InsProvider WHERE CompanyID=?");
# This is a query to search by First Name, Last Name, DOB
# Values must be set before the query is run.
$first_last_dob_query = $conn->prepare("SELECT * FROM myhealth2.PatientInfo WHERE name_first like ? AND name_last like ? AND DOB like ? ");

# This query will search for a given PID
$patient_id_query = $conn->prepare("SELECT name_first, name_last, DOB, Gender, address, email, phone, Emergency_name, Emergency_phone FROM myhealth2.PatientInfo WHERE PID=?");

# This query will search for a given phone number.
$phone_number_query = $conn->prepare("SELECT * FROM myhealth2.PatientInfo WHERE phone like ?");

$patient_appointments = $conn->prepare("SELECT Date, Time, Reason FROM Appointments WHERE PID=?");
# This is a query to search by First Name, Last Name, email
# Values must be set before the query is run.
$first_last_email_query = $conn->prepare("SELECT * FROM myhealth2.PatientInfo WHERE name_first like ? AND name_last like ? AND email like ? ");

$patient_record_by_search = $conn->prepare("SELECT NoteTime, DiagnosisNotes, DrRecommendations FROM PatientNotes WHERE PID=? ORDER BY `NoteTime` DESC");
#Try and sort records by date

/***** END: Declare MySQL Query Statements *****/
?>
