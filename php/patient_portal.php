<?php
/* This is the patient_portal.php file.
* All Patient information will be accessed
* through this page.
*/

# Start the session again to access session variables
session_start();
# Grab all the session values
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$isemployee = $_SESSION['isemployee'];
$pid = $_SESSION['pid'];

# import another php file and access it's variables
include 'queries.php';
echo $date;

# Global Vars
global $records_btn;
global $record_results;
?>

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Patient Portal </title>
  <link href='../css/style.css' rel='stylesheet'>
  <script src="../js/effects.js"></script>
  <!--- SOURCE: https://www.w3schools.com/php/php_includes.asp --->
</head>

<body>

  <h2>Patient Portal: <?php echo " Welcome - $username" ?></h2>

  <section name="patientinfo">
    <!-- This is the place where we get/print and patient informaton in the database. The patient must have access to only his/her info and no one else -->
    <table name="patientinfo_table">
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
      <!-- Populate table column values but let's get that data first! -->
      <?php

      // Variables for Patient information
      $name_fisrt = NULL;
      $name_last = NULL;
      $DOB = NULL;
      $gender = NULL;
      $address = NULL;
      $email = NULL;
      $phone = NULL;
      $e_name = NULL;
      $e_phone = NULL;

      // Query the PatientInfo database for the information
      $record_results = $conn->query("SELECT * FROM PatientInfo WHERE PID='$pid'");

      // Did we get any results
      if ($record_results->num_rows > 0) {
        // Get the Query Results
        while ($row = $record_results->fetch_assoc()) {
          $name_fisrt = $row["name_first"];
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
      ?>
      <tr>
        <td><?php echo "$pid" ?></td>
        <td><?php echo "$name_fisrt" ?></td>
        <td><?php echo "$name_last" ?></td>
        <td><?php echo "$DOB" ?></td>
        <td><?php echo "$gender" ?></td>
        <td><?php echo "$address" ?></td>
        <td><?php echo "$email" ?></td>
        <td><?php echo "$phone" ?></td>
        <td><?php echo "$e_name" ?></td>
        <td><?php echo "$e_phone" ?></td>
      </tr>
    </table>
  </section>

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
      <button class="sign-out-button" type="submit" name="logout">logout
        <!-- If the logout button is pushed -->
        <?php if (isset($_POST['logout'])) {
          header('Location: logout.php');
        }
        ?>
      </button>
      </button>
    </form>
  </section>

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
      $provid = null;
      $notetime = null;
      $diagnosisnotes = null;
      $drrecommendations = null;

      // Did we get any results
      if ($record_results->num_rows >0) {

        # Create the table
        echo "<!-- Populate table column names -->
        <table name=\"patientrecords_table\">
        <tr>
          <th> Record Time </th>
          <th> Treatment Category</th>
          <th> Patient Payment </th>
          <th> Provider Name </th>
          <th> Note Time </th>
          <th> Diagnosis Notes </th>
          <th> Dr. Recommendations </th>
        </tr>";

        // Get the Query Results
        while ($row = $record_results->fetch_assoc()) {
          $recordtime = $row["RecordTime"];
          $tcatid = $row["TCatID"];
          $patientpayment = $row["PatientPayment"];
          $treament_category->bind_param("i", $tcatid);
          $treament_category->execute();
          $treament_category_results = $treament_category->get_result();
          

          if($treament_category_results->num_rows >0)
          {
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

        while($row = $note_results->fetch_assoc())
        {
            $provid = $row["ProvID"];
            $notetime = $row["NoteTime"];
            $diagnosisnotes = $row["DiagnosisNotes"];
            $drrecommendations = $row["DrRecommendations"];

            $healthprovider_name->bind_param("i", $provid);
            $healthprovider_name->execute();
            $healthprovider_name_results = $healthprovider_name->get_result();

            if($healthprovider_name_results->num_rows>0)
            {
              $provid_row = $healthprovider_name_results->fetch_assoc();
              $provid_name = $provid_row["ProvName"];
            }

            # Print each table row
          echo "
          <tr>
          <td>$provid_name</td>
          <td>$notetime</td>
          <td>$diagnosisnotes</td>
          </tr>";
        }

        # Close the table
        echo "</table>";
      }
    } else {
      $records_btn = false;
    }
    ?>
  </section>
</body>

</html>