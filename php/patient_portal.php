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

//Populate table column values but let's get that data first!
// Variables for Patient information
$name_first = NULL;
$name_last = NULL;
$DOB = NULL;
$gender = NULL;
$address = NULL;
$email = NULL;
$phone = NULL;
$e_name = NULL;
$e_phone = NULL;

// Query the PatientInfo database for the information
$patient_id_query->bind_param("i",$pid);
$patient_id_query->execute();
$results = $patient_id_query->get_result();

// Did we get any results
if($results->num_rows >0)
{
  // Get the Query Results
  while ($row = $results->fetch_assoc()) {
    $name_first = $row["name_first"];
    $name_last = $row["name_last"];
    $DOB = $row["DOB"];
    $gender = $row["Gender"];
    $address = $row["address"];
    $email = $row["email"];
    $phone = $row["phone"];
    $e_name = $row["Emergency_name"];
    $e_phone = $row["Emergency_phone"];
  } 
}

# Global Vars
global $records_btn;
global $record_results;
?>
<!--end of php section-->

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Patient Portal </title>
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
      <button class="w3-bar-item w3-button" name="refresh" type="submit">Refresh Page
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['reload']))
        {
          header('Location: patient_portal.php');
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

  <h2>Patient Portal: <?php echo " Welcome - <B>$name_first</B>"?></h2>

  <section name="patientinfo" class="center">
    <!-- This is the place where we get/print and patient informaton in the database. The patient must have access to only his/her info and no one else -->
    <table name="patientinfo_table" class="center" style="width=95%;" border="3" cellpadding="1">
    <tbody>
      <!-- Populate table column names -->
      <tr>
        <th> Patient ID </th> 
        <th> First name </th>
        <th> Last name </th>
        <th> Birthday </th>
        <th> Gender </th>
        <th> Address </th>
        <th> Email </th>
        <th> Phone </th>
        <th> Emergency Contact Name </th>
        <th> Emergency Phone Number </th>
      </tr>
      <!-- Populate patient information-->
      <tr>
        <td><?php echo "$pid"?></td>
        <td><?php echo "$name_first"?></td>
        <td><?php echo "$name_last"?></td>
        <td><?php echo "$DOB"?></td>
        <td><?php echo "$gender"?></td>
        <td><?php echo "$address"?></td>
        <td><?php echo "$email"?></td>
        <td><?php echo "$phone"?></td>
        <td><?php echo "$e_name"?></td>
        <td><?php echo "$e_phone"?></td>
      </tr>
      </tbody>
    </table>
  </section>
</div>
</div>
<div class="center">
  <section name="options">
    <!-- Let's put any actions the user (patient) can take. i.e update info, view records, etc -->
    



     <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button class="update-info-button" type="submit" name="update information">update information</button>
      <button class="records-button" type="submit" name="records">view records
        <!-- If the view records button is pushed -->
        <?php if (isset($_POST['records'])) {
          $records_btn = true;
        }
        ?>
      </button>
    </form>

      <!--bring up form to make an appointment-->
      <button class="portal" onclick="document.getElementById('id01').style.display='block'" style="width:auto;"
        type="submit" name="appointment">Make Appointment
      </button>

  </section>
</div>









<!-- Lets create a patient records section -->
<section name="patientrecords">
    <?php if ($records_btn) {
      // Grab the information needed.
      $patient_records->bind_param("i", $pid);
      $patient_records->execute();
      $record_results = $patient_records->get_result();

      $patient_notes->bind_param("i", $pid);
      $patient_notes->execute();
      $note_results = $patient_notes->get_result();

      $treament_category_name = null;
      $provid_name = null;
      $provid_address = null;
      $provid = null;
      $notetime = null;
      $diagnosisnotes = null;
      $drrecommendations = null;

      // Did we get any results
      if ($record_results->num_rows > 0) {

        # Create the records table
        echo "
        <table name=\"patientrecords_table\">
        <tr>
          <th> Record Time </th>
          <th> Treatment Category</th>
          <th> Patient Payment </th>
        </tr>";

        // Get the Query Results
        while ($row = $record_results->fetch_assoc()) {
          $recordtime = $row["RecordTime"];
          $tcatid = $row["TCatID"];
          $patientpayment = $row["PatientPayment"];
          $treament_category->bind_param("i", $tcatid);
          $treament_category->execute();
          $treament_category_results = $treament_category->get_result();


          if ($treament_category_results->num_rows > 0) {
            $tcatrow = $treament_category_results->fetch_assoc();
            $treament_category_name = $tcatrow["TreatmentCategory"];
          }

          # Print each table row
          echo "<tr>
        <td>$recordtime</td>
        <td>$treament_category_name</td>
        <td>$patientpayment</td>
        </tr>";
        }
        # Close the records table
        echo "</table>";

        # Create the notestable
        echo "
        <table name=\"patientnotes_table\">
        <tr>
          <th> Provider Name </th>
          <th> Provider Address </th>
          <th> Note Time </th>
          <th> Diagnosis Notes </th>
          <th> Dr. Recommendations </th>
        </tr>";

        while ($row = $note_results->fetch_assoc()) {
          $provid = $row["ProvID"];
          $notetime = $row["NoteTime"];
          $diagnosisnotes = $row["DiagnosisNotes"];
          $drrecommendations = $row["DrRecommendations"];

          $healthprovider_name->bind_param("i", $provid);
          $healthprovider_name->execute();
          $healthprovider_name_results = $healthprovider_name->get_result();

          if ($healthprovider_name_results->num_rows > 0) {
            $provid_row = $healthprovider_name_results->fetch_assoc();
            $provid_name = $provid_row["ProvName"];
            $provid_address = $provid_row["ProvAddr"];
          }

          # Print each table row
          echo "
          <tr>
          <td>$provid_name</td>
          <td>$provid_address</td>
          <td>$notetime</td>
          <td>$diagnosisnotes</td>
          <td>$drrecommendations</td>
          </tr>";
        }
      }
    } else {
      $records_btn = false;
    }
    ?>
  </section>













<!--modal called to display login form-->
<div id="id01" class="modal">
  
  <form class="modal-content animate" method="post">
  <div class="imgcontainer">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    <div class="center">
      <h3>Make an Appointment</h3>
    </div>
  </div>

  <div class="container">
  <section class="make_appointment" id="make_appointment">
    <form class="form-signup" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                  ?>" method="post">
      <input type="date" class="form-signup" name="appointment_date" placeholder="Patient ID" required></br></br>
      <input type="text" class="form-signup" name="name_first" placeholder=<?php echo "$name_first"?> required></br></br>
      <input type="text" class="form-signup" name="name_last" placeholder=<?php echo "$name_last"?> required></br></br>
      <input type="text" class="form-signup" name="username" placeholder="Reason for Visit" required></br></br>

      <button class="loginbtn" type="submit" name="submit">submit
      </button>
    </form>
  </section>
    <div class="container">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </div>
  </form>
</div>

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