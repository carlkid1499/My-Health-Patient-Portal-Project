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
$patient_records = $conn->prepare("SELECT RecordTime, TCatID, PatientPayment FROM PatientRecords WHERE PID=? ORDER BY 'RecordTime' DESC");

# Get the Treatment Category Name Query
$treament_category = $conn->prepare("SELECT TreatmentCategory FROM TreatmentCategory WHERE TCatID=?");

# Get Patient Notes Query
$patient_notes = $conn->prepare("SELECT ProvID, NoteTime, DiagnosisNotes, DrRecommendations FROM PatientNotes WHERE PID=? ORDER BY `NoteTime` DESC");

# Get the Provider Name Query
$healthprovider_name =  $conn->prepare("SELECT ProvName, ProvAddr FROM HealthProvider WHERE ProvID=?");

# Update Information Query
$update_info = $conn->prepare("UPDATE PatientInfo SET address=?, email=?, phone=?, Emergency_name=?, Emergency_phone=? WHERE PID=?");

# update information by doctor query
$update_info_doctor = $conn->prepare("UPDATE PatientInfo SET name_first=?, name_last=?, DOB=?, Gender=?, address=?, email=?, phone=?, Emergency_name=?, Emergency_phone=? WHERE PID=?");

$get_enrolled_query = $conn->prepare("SELECT PlanID,CompanyID FROM Enrolled WHERE PID=?");

$search_for_insprov_by_state_query = $conn->prepare("SELECT * FROM InsProvider WHERE Address like ?");

$get_planid_info_by_id_query = $conn->prepare("SELECT AnnualPrem, AnnualDeductible, AnnualCoverageLimit, LifetimeCoverage, Network FROM InsPlans WHERE PlanID=?");

$get_insprov_info_by_id_query = $conn->prepare("SELECT PlanID, Company, Category, Address, Email, Phone FROM InsProvider WHERE CompanyID=?");
# This is a query to search by First Name, Last Name, DOB
# Values must be set before the query is run.
$first_last_dob_query = $conn->prepare("SELECT * FROM PatientInfo WHERE name_first like ? AND name_last like ? AND DOB like ? ");

# This query will search for a given PID
$patient_id_query = $conn->prepare("SELECT * FROM PatientInfo WHERE PID=?");

# This query will search for a given phone number.
$phone_number_query = $conn->prepare("SELECT * FROM PatientInfo WHERE phone like ?");

$patient_appointments = $conn->prepare("SELECT Date, Time, Reason FROM Appointments WHERE PID=? ORDER BY Date DESC");
# This is a query to search by First Name, Last Name, email
# Values must be set before the query is run.
$first_last_email_query = $conn->prepare("SELECT * FROM PatientInfo WHERE name_first like ? AND name_last like ? AND email like ? ");

$patient_record_by_search = $conn->prepare("SELECT NoteTime, DiagnosisNotes, DrRecommendations FROM PatientNotes WHERE PID=? ORDER BY NoteTime DESC");
#Try and sort records by date

# Grab a list of Health Providers ID's in a Network
$get_health_provid_in_net_list = $conn->prepare("SELECT ProvID FROM Membership WHERE NetworkID in (SELECT NetworkID FROM Network WHERE NetworkName like ?)");

# Grab Health Provider Info
$get_health_prov_info = $conn->prepare("SELECT ProvName, ProvAddr  FROM HealthProvider WHERE ProvID=?");

# Insert into Enrolled Table
$insert_into_enrolled = $conn->prepare("INSERT INTO Enrolled (PlanID, PID, CompanyID) VALUES ( ?, ?, (SELECT CompanyID FROM InsPlans WHERE PlanID=?))");

# Get network name and health providers in network using just planid
$get_in_net_health_prov_by_planid = $conn->prepare("SELECT ProvID FROM Membership WHERE NetworkID in (SELECT NetworkID FROM Network WHERE NetworkName in (SELECT Network FROM InsPlans WHERE  PlanID=?))");

# Get The billing information for a user by PID
$get_billing_info_by_pid = $conn->prepare("SELECT RecordTime, (SELECT TreatmentCategory  FROM TreatmentCategory WHERE TreatmentCategory.TCatID=PatientRecords.TCatID) AS TreatmentCategoryName, CostToIns, CostToPatient, InsPayment, PatientPayment, (CostToPatient-PatientPayment) AS  PatientOwes FROM PatientRecords WHERE PatientRecords.PID=? ORDER BY RecordTime ASC");

# Get the total amount for billing for a user by PID
$get_billing_total_by_pid = $conn->prepare("SELECT SUM(CostToPatient-PatientPayment) AS  PatientTotal FROM PatientRecords WHERE PID=?");

# Grab a list of Treatment Category Names
$get_treament_category_names = $conn->prepare("SELECT TreatmentCategory FROM TreatmentCategory");

# Grab a list of Health Provider Names
$get_health_provider_names = $conn->prepare("SELECT ProvName FROM HealthProvider");

#SELECT ProvID FROM healthprovider WHERE ProvName like 'Big River Hospital'

# Insert into the PatientNotes Table
$insert_into_patientnotes = $conn->prepare("INSERT INTO PatientNotes (PID, ProvID, NoteTime, DiagnosisNotes, DrRecommendations, Treatment) VALUES (?,(SELECT ProvID FROM HealthProvider WHERE ProvName like ?),NOW(),?,?,?)");
#INSERT INTO patientnotes (PID, ProvID, NoteTime, DiagnosisNotes, DrRecommendations, Treatment) VALUES (1111,(SELECT ProvID FROM HealthProvider WHERE ProvName like "Big River Hospital"),NOW(),"test","test",1)

# Get Treatment Category Name
$get_treament_categoryid = $conn->prepare("SELECT TCatID FROM TreatmentCategory WHERE TreatmentCategory=?");

# Insert into the PatientRecords Table
$insert_into_patientrecords = $conn->prepare("INSERT INTO PatientRecords (PID, RecordTime, TCatID, CostToIns, CostToPatient, InsPayment, PatientPayment) VALUES(?,NOW(),?,?,?,?,?)");


/***** END: Declare MySQL Query Statements *****/
?>
