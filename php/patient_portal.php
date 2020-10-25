<?php
/* This is the patient_portal.php file.
* All Patient information will be accessed
* through this page.
*/

# import another php file and access it's variables
include 'sandbox.php';
echo $test_var;

# Start the session again to access session variables
session_start();
# Grab all the session values
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$isemployee = $_SESSION['isemployee'];
$pid = $_SESSION['pid'];
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

  <h2>Patient Portal: <?php echo " Welcome - $username"?></h2>

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

        // Create connection for log in
        $conn = new mysqli("localhost", "myhealth2", "CIOjh^J8h^?b", "myhealth2");
        // Check if connection is valid
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
          $msg = "Connection failed: to DB";
        }

        // Query the PatientInfo database for the information
        $results = $conn ->query("SELECT * FROM PatientInfo WHERE PID='$pid'");

        // Did we get any results
        if($results->num_rows >0)
        {
          // Get the Query Results
          while ($row = $results->fetch_assoc()) {
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
        <td><?php echo "$pid"?></td>
        <td><?php echo "$name_fisrt"?></td>
        <td><?php echo "$name_last"?></td>
        <td><?php echo "$DOB"?></td>
        <td><?php echo "$gender"?></td>
        <td><?php echo "$address"?></td>
        <td><?php echo "$email"?></td>
        <td><?php echo "$phone"?></td>
        <td><?php echo "$e_name"?></td>
        <td><?php echo "$e_phone"?></td>
      </tr>
    </table>
  </section>
  <section name="options">
    <!-- Let's put any actions the user (patient) can take. i.e update info, view records, etc -->
    <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
      <button class="update-info-button" type="submit" name="update information">update information</button>
      <button class="records-button" type="submit" name="records">view records</button> 
      <button class="sign-out-button" type="submit" name="logout">logout
        <!-- If the logout button is pushed -->
        <?php if(isset($_POST['logout']))
        {
          header('Location: logout.php');
        } 
        ?>
        </button>
      </button>
    </form>
  </section>
  <?php $conn->close(); ?>
</body>
</html>