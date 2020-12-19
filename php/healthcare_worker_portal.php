<?php
/* This is the healthcare_worker_portal.php file.
* All healthcare worker information will be accessed
* through this page.
*/

# import another php file and access it's variables
include 'queries.php';


# Start the session again to access session variables
session_start();
# Grab all the session values
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$employeetype = $_SESSION['employeetype'];

$first_name = NULL;
$last_name = NULL;
$DOB = NULL;
$email_ad = NULL;

# Global Vars
global $records_btn;
global $record_results;
global $err_msg;
# Tell Browser not to cache anything
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");

?>

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Healthcare Worker Portal </title>
  <link href='../css/welcome.css' rel='stylesheet'>
  <link href='../css/patient_portal.css' rel='stylesheet'>
  <link href="../css/blue_theme.css" rel='stylesheet'>
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
          header('Location: healthcare_worker_portal.php');
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
  <h1><b>My Health Worker Portal</b></h1>
</div>

<body>
<div class="center">
  <h2>Healthcare Worker Portal: <?php echo " Welcome - $username"?></h2>
  <!-- This is the search bar: https://www.w3schools.com/howto/howto_css_search_button.asp -->
  <div class="container">
  <section class="searchbar-section">
    <form class="searchbar" id="searchbar" action="healthcare_worker_portal.php" method="post" style="margin:auto; max-width=75%">
      <input type="text" placeholder="Patient Search Criteria" name="searchbar-text">
      <div>
      <div class="container">
        <select name="search_by_options_list" class="align-middle">
          <option name="search_by_options" value="search_by_options">Search by:</option>
          <option name="search_by_options" value="search_by_FLB">Search by: First Name, Last Name, DOB</option>
          <option name="search_by_options" value="search_by_PID">Search by: Patient ID </option>
          <option name="search_by_options" value="search_by_FLE">Search by: First Name, Last Name, Email</option>          
        </select>
      </div>
        <button class="searchbtn" name = "searchbtn" id="searchbar-button" value="searchbar-button" onclick="return checkInput();">search</button>
      </div>
    </form>
  </div>
  </section> 
</div>
<?php 
if(isset($_POST["searchbtn"])){
  global $PID;
  if (isset($_POST["search_by_options_list"])){
    $options_list = $_POST["search_by_options_list"];
    $inp_string = $_POST["searchbar-text"];
    switch($options_list)
    {
      case "search_by_options": 
        echo("<ul>" . "Select an option from the dropdown menu." . "</ul>\n");
      break;
      case "search_by_FLB": 
        //echo "FLB";
        
        if($inp_string == NULL){
          echo("<ul>" . "Enter Firstname, Lastname and DOB" . "</ul>\n");
        }
        else{           
          list($first_name, $last_name, $DOB_search) = explode(",",$inp_string,3);
          //trim whitepace after parsing
          $first_name = trim($first_name);
          $last_name = trim($last_name);
          $DOB_search = trim($DOB_search);

          //declare null vars
          $pid_table = NULL;
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
          $first_last_dob_query->bind_param("sss",$first_name,$last_name,$DOB_search);
          $first_last_dob_query->execute();
          $first_last_dob_query->store_result();
          $first_last_dob_query->bind_result($pid_table, $name_first, $name_last, $DOB, $gender, $address, $email, $phone, $e_name, $e_phone);
          
          // Did we get any results
          if($first_last_dob_query->num_rows >0)
          {
            $records_btn=true;
            // Get the Query Results
            while ($first_last_dob_query->fetch()) {

              $_SESSION['PID'] = $pid_table;
              $_SESSION['name_first'] = $name_first;
              $_SESSION['name_last'] = $name_last;
              $_SESSION['DOB'] = $DOB;
              $_SESSION['gender'] = $gender;
              $_SESSION['address'] = $address;
              $_SESSION['email'] = $email;
              $_SESSION['phone'] = $phone;
              $_SESSION['e_name'] = $e_name;
              $_SESSION['e_phone'] = $e_phone;

              echo "<section name=\"patientinfo\" class=\"center\">
              <div class=\"center\">
                <h2>Patient Notes: <b>$name_first $name_last</b></h2><br>
              </div>

              <table name=\"patientinfo_table\" class=\"center\" style=\"width=95%;\" border=\"3\" cellpadding=\"1\">
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
                  <td>$pid_table</td>
                  <td>$name_first</td>
                  <td>$name_last</td>
                  <td>$DOB</td>
                  <td>$gender</td>
                  <td>$address</td>
                  <td>$email</td>
                  <td>$phone</td>
                  <td>$e_name</td>
                  <td>$e_phone</td>
                </tr>
                </tbody>
              </table>
            </section>";
            }

            $appointment_date = NULL;
            $appointment_time = NULL;
            $appointment_reason = NULL;

            //query datebase for appointments
            $patient_appointments->bind_param("i", $_SESSION['PID']);
            $patient_appointments->execute();
            $patient_appointments->store_result();
            $patient_appointments->bind_result($appointment_date, $appointment_time, $appointment_reason);

            echo "";

            if ($patient_appointments->num_rows() > 0) {
              echo "
            <div class=\"center\">
            <h3>Upcoming Appointments: </h3><br>
            <table name=\"patient_appointments\" class=\"center\" style=\"width=95%\" border=\"3\" cellpadding=\"1\">
              <tbody>
                <tr>
                  <th> Date </th>
                  <th> Time </th>
                  <th> Reason </th>
                </tr>
            ";
              while ($patient_appointments->fetch()) {
                echo "
                <tr>
                  <td> $appointment_date </td>
                  <td> $appointment_time </td>
                  <td> $appointment_reason </td>
                </tr> ";
              }
              echo " 
                  </tbody>
                </table>
              </div>
            ";
            }

            echo "
            <div class=\"center\">
              <section name=\"options\">
                
                <div class=\"container\">
                  <button class=\"portal\" onclick=\"document.getElementById('update-info').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\"  name=\"update-info\">update information
                  </button>

                  <button class=\"portal\" onclick=\"document.getElementById('view-records').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\" name=\"view-records\">View Records
                  </button>

                  <button class=\"portal\" onclick=\"document.getElementById('make-appointment').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\" name=\"make-appointment\">Make Appointment
                  </button>

                  <button class=\"portal\" onclick=\"document.getElementById('make-note').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\" name=\"make-record\">Make Note
                  </button>
                </div>
              </section>
            </div>
            "; 
          }
        }
      break;

      case "search_by_PID": 
        //$inp_string = $_POST["searchbar-txt"];
        if($inp_string == NULL){
          echo("<ul>" . "Enter Patient ID" . "</ul>\n");
        }
        $inp_string = trim($inp_string);

        //declare null vars
        $pid_table = NULL;
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
        $patient_id_query->bind_param("s",$inp_string);
        $patient_id_query->execute();
        $patient_id_query->store_result();
        $patient_id_query->bind_result($pid_table, $name_first, $name_last, $DOB, $gender, $address, $email, $phone, $e_name, $e_phone);

        if($patient_id_query->num_rows >0)
          {
            $records_btn=true;
            // Get the Query Results
            while ($patient_id_query->fetch()) {

              $_SESSION['PID'] = $pid_table;
              $_SESSION['name_first'] = $name_first;
              $_SESSION['name_last'] = $name_last;
              $_SESSION['DOB'] = $DOB;
              $_SESSION['gender'] = $gender;
              $_SESSION['address'] = $address;
              $_SESSION['email'] = $email;
              $_SESSION['phone'] = $phone;
              $_SESSION['e_name'] = $e_name;
              $_SESSION['e_phone'] = $e_phone;

              echo "<section name=\"patientinfo\" class=\"center\">
              <div class=\"center\">
                <h2>Patient Notes: <b>$name_first $name_last</b></h2><br>
              </div>

              <table name=\"patientinfo_table\" class=\"center\" style=\"width=95%;\" border=\"3\" cellpadding=\"1\">
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
                  <td>$inp_string</td>
                  <td>$name_first</td>
                  <td>$name_last</td>
                  <td>$DOB</td>
                  <td>$gender</td>
                  <td>$address</td>
                  <td>$email</td>
                  <td>$phone</td>
                  <td>$e_name</td>
                  <td>$e_phone</td>
                </tr>
                </tbody>
              </table>
            </section>";

            } 

            $appointment_date = NULL;
            $appointment_time = NULL;
            $appointment_reason = NULL;

            //query datebase for appointments
            $patient_appointments->bind_param("i", $_SESSION['PID']);
            $patient_appointments->execute();
            $patient_appointments->store_result();
            $patient_appointments->bind_result($appointment_date, $appointment_time, $appointment_reason);

            echo "";

            if ($patient_appointments->num_rows() > 0) {
              echo "
            <div class=\"center\">
            <h3>Upcoming Appointments: </h3><br>
            <table name=\"patient_appointments\" class=\"center\" style=\"width=95%\" border=\"3\" cellpadding=\"1\">
              <tbody>
                <tr>
                  <th> Date </th>
                  <th> Time </th>
                  <th> Reason </th>
                </tr>
            ";
              while ($patient_appointments->fetch()) {
                echo "
                <tr>
                  <td> $appointment_date </td>
                  <td> $appointment_time </td>
                  <td> $appointment_reason </td>
                </tr> ";
              }
              echo " 
                  </tbody>
                </table>
              </div>
            ";
            }

            echo "
            <div class=\"center\">
              <section name=\"options\">
                
                <div class=\"container\">
                  <button class=\"portal\" onclick=\"document.getElementById('update-info').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\"  name=\"update-info\">update information
                  </button>

                  <button class=\"portal\" onclick=\"document.getElementById('view-records').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\" name=\"view-records\">View Records
                  </button>

                  <button class=\"portal\" onclick=\"document.getElementById('make-appointment').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\" name=\"make-appointment\">Make Appointment
                  </button>

                  <button class=\"portal\" onclick=\"document.getElementById('make-note').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\" name=\"make-record\">Make Note
                  </button>
                </div>
              </section>
            </div>
            "; 
          }        
      break;

      case "search_by_FLE":
        if($inp_string == NULL){
          echo("<ul>" . "Enter Firstname, Lastname and Email" . "</ul>\n");
        }
        else{           
          list($first_name, $last_name, $email_ad) = explode(",",$inp_string,3);
          //remove whitespace from vars
          $first_name = trim($first_name);
          $last_name = trim($last_name);
          $email_ad = trim($email_ad);

          //declare null vars
          $pid_table = NULL;
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
          $first_last_email_query->bind_param("sss",$first_name,$last_name,$email_ad);
          $first_last_email_query->execute();
          $first_last_email_query->store_result();
          $first_last_email_query->bind_result($pid_table, $name_first, $name_last, $DOB, $gender, $address, $email, $phone, $e_name, $e_phone);
  
          // Did we get any results
          if($first_last_email_query->num_rows >0)
          {
            $records_btn=true;
            // Get the Query Results
            while ($first_last_email_query->fetch()) {

              $_SESSION['PID'] = $pid_table;
              $_SESSION['name_first'] = $name_first;
              $_SESSION['name_last'] = $name_last;
              $_SESSION['DOB'] = $DOB;
              $_SESSION['gender'] = $gender;
              $_SESSION['address'] = $address;
              $_SESSION['email'] = $email;
              $_SESSION['phone'] = $phone;
              $_SESSION['e_name'] = $e_name;
              $_SESSION['e_phone'] = $e_phone;

              echo "<section name=\"patientinfo\" class=\"center\">
              <div class=\"center\">
                <h2>Patient Notes: <b>$name_first $name_last</b></h2><br>
              </div>

              <table name=\"patientinfo_table\" class=\"center\" style=\"width=95%;\" border=\"3\" cellpadding=\"1\">
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
                  <td>$pid_table</td>
                  <td>$name_first</td>
                  <td>$name_last</td>
                  <td>$DOB</td>
                  <td>$gender</td>
                  <td>$address</td>
                  <td>$email</td>
                  <td>$phone</td>
                  <td>$e_name</td>
                  <td>$e_phone</td> 
                </tr>
                </tbody>
              </table>
            </section>";
            }

            $appointment_date = NULL;
            $appointment_time = NULL;
            $appointment_reason = NULL;

            //query datebase for appointments
            $patient_appointments->bind_param("i", $_SESSION['PID']);
            $patient_appointments->execute();
            $patient_appointments->store_result();
            $patient_appointments->bind_result($appointment_date, $appointment_time, $appointment_reason);

            echo "";

            if ($patient_appointments->num_rows() > 0) {
              echo "
            <div class=\"center\">
            <h3>Upcoming Appointments: </h3><br>
            <table name=\"patient_appointments\" class=\"center\" style=\"width=95%\" border=\"3\" cellpadding=\"1\">
              <tbody>
                <tr>
                  <th> Date </th>
                  <th> Time </th>
                  <th> Reason </th>
                </tr>
            ";
              while ($patient_appointments->fetch()) {
                echo "
                <tr>
                  <td> $appointment_date </td>
                  <td> $appointment_time </td>
                  <td> $appointment_reason </td>
                </tr> ";
              }
              echo " 
                  </tbody>
                </table>
              </div>
            ";
            }
            
            echo "
            <div class=\"center\">
              <section name=\"options\">
                
                <div class=\"container\">
                  <button class=\"portal\" onclick=\"document.getElementById('update-info').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\"  name=\"update-info\">update information
                  </button>

                  <button class=\"portal\" onclick=\"document.getElementById('view-records').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\" name=\"view-records\">View Records
                  </button>

                  <button class=\"portal\" onclick=\"document.getElementById('make-appointment').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\" name=\"make-appointment\">Make Appointment
                  </button>

                  <button class=\"portal\" onclick=\"document.getElementById('make-note').style.display='block'\" style=\"width:auto;\"
                    type=\"submit\" name=\"make-record\">Make Note
                  </button>
                </div>
              </section>
            </div>
            ";
          }
        }
      break;
    }
  }
}



?>

<div id="update-info" class="modal">
  
  <form class="modal-content animate" method="post">
  <div class="imgcontainer">
    <span onclick="document.getElementById('update-info').style.display='none'" class="close" title="Close Modal">&times;</span>
    <div class="center">
      <h3>Update Patient Information</h3>
    </div>
  </div>

  <div class="container">
  <section class="update_information" id="update_information">
          <form class="form-signup" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                        ?>" method="post">
            <input type="text" class="form-signup" name="name_first" placeholder="<?php echo $_SESSION['name_first'] ?>" ></br></br>
            <input type="text" class="form-signup" name="name_last" placeholder="<?php echo $_SESSION['name_last'] ?>" ></br></br>
            <input type="text" class="form-signup" name="DOB" placeholder="<?php echo $_SESSION['DOB'] ?>" ></br></br>
            <input type="text" class="form-signup" name="gender" placeholder="<?php echo $_SESSION['gender'] ?>" ></br></br>
            <input type="text" class="form-signup" name="address" placeholder="<?php echo "Address: "; echo $_SESSION['address'] ?>"></br></br>
            <input type="text" class="form-signup" name="email" placeholder="<?php echo "Email: "; echo $_SESSION['email'] ?>"></br></br>
            <input type="text" class="form-signup" name="phone" placeholder="<?php echo "Phone number: "; echo $_SESSION['phone'] ?>"></br></br>
            <input type="text" class="form-signup" name="ename" placeholder="<?php echo "Emergency Contact Name: "; echo $_SESSION['e_name'] ?>"></br></br>
            <input type="text" class="form-signup" name="ephone" placeholder="<?php echo "Emergency Contact Phone: "; echo $_SESSION['e_phone'] ?>"></br></br>

            <button class="loginbtn" type="submit" name="update_information">submit
              <!-- If the update information button is pushed -->
              <?php if (isset($_POST['update_information'])) {
                // Clean the input
                $new_name_first = trim($_POST['name_first']);
                $new_name_last = trim($_POST['name_last']);
                $new_DOB = trim($_POST['DOB']);
                $new_gender = trim($_POST['gender']);
                $new_address = trim($_POST['address']);
                $new_email = trim($_POST['email']);
                $new_phone = trim($_POST['phone']);
                $new_ename = trim($_POST['ename']);
                $new_ephone = trim($_POST['ephone']);

                // Check if any values are empty
                if($new_name_first == NULL)
                  $new_name_first = $_SESSION['name_first'];

                if($new_name_last == NULL)
                  $new_name_last = $_SESSION['name_last'];

                if($new_DOB == NULL)
                  $new_DOB = $_SESSION['DOB'];

                if($new_gender == NULL)
                  $new_gender = $_SESSION['gender'];

                if($new_address == NULL)
                  $new_address = $_SESSION['address'];

                if($new_email == NULL)
                  $new_email = $_SESSION['email'];

                if($new_phone == NULL)
                  $new_phone = $_SESSION['phone'];

                if($new_ename == NULL)
                  $new_ename = $_SESSION['e_name'];

                if($new_ephone == NULL)
                  $new_ephone = $_SESSION['e_phone'];
                   
              
                // Run the update information query
                $update_info_doctor->bind_param("sssssssssi", $new_name_first, $new_name_last, $new_DOB, $new_gender, $new_address,
                                                      $new_email, $new_phone, $new_ename, $new_ephone, $_SESSION['PID']);
                $rtval = $update_info_doctor->execute();
                $update_info_doctor->close();

              }
              ?>

            </button>
          </form>
        </section>
    <div class="container">
        <button type="button" onclick="document.getElementById('update-info').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </div>
  </form>
</div>

<!--modal called to display make appointment form-->
<div id="make-appointment" class="modal">
  
  <form class="modal-content animate" method="post">
  <div class="imgcontainer">
    <span onclick="document.getElementById('make-appointment').style.display='none'" class="close" title="Close Modal">&times;</span>
    <div class="center">
      <h3>Make an Appointment</h3>
    </div>
  </div>

  <div class="container">
  <section class="make_appointment" id="make_appointment">
    <form class="form-signup" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                  ?>" method="post">
      <div class="center">
      <input type="date" class="form-signup" name="appointment_date" required>
      <span style="display:inline-block; width: 30px;"></span>
      <input type="time" class="form-signup" name="appointment_time" placeholder="Patient ID" required>
      </div>
      <div class="center">
      <p>Ex: 03/11/2020
      <span style="display:inline-block; width: 30px;"></span>
        Ex: 09:15 AM</p>
      </div></br></br>
      <input type="text" class="form-signup" name="name_first" placeholder="<?php echo $_SESSION['name_first']?>" disabled="disabled" required></br></br>
      <input type="text" class="form-signup" name="name_last" placeholder="<?php echo $_SESSION['name_last']?>" disabled="disabled" required></br></br> 
      <textarea class="reason" rows="2" cols="80" style="resize:none" wrap="soft" maxlength="255" name="reason" placeholder="Reason for Visit" required></textarea></br></br>

      <button class="loginbtn" type="submit" name="create">submit
      <!-- If the submit button is pushed, we need to process the data. If successfull we need to redirect to the patient portal -->
        <?php if (isset($_POST['create'])) {
          // Process the form information
          $date = $_POST['appointment_date'];
          $time = $_POST['appointment_time'];
          $reason = trim($_POST['reason']);
          $pid_appt = $_SESSION['PID'];

          if($conn->query("INSERT INTO Appointments (PID, Date, Time, Reason) VALUES ('$pid_appt', '$date', '$time', '$reason')")){

          }
          else{
            echo "Appointment already exists, please choose a different time";
          }

        }?>
      </button>
    </form>
  </section>
    <div class="container">
        <button type="button" onclick="document.getElementById('make-appointment').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </div>
  </form>
</div>

<!--modal for patients to view records-->
<div id="view-records" class="modal">

  <form class="modal-content animate" method="post" style="max-width:95%">
    <div class="imgcontainer">
      <span onclick="document.getElementById('view-records').style.display='none'" class="close" title="Close Modal">&times;
      
      </span>
      <div class="center">
        <h3>Patient Records</h3>
      </div>
    </div>

    <!-- Lets create a patient records section -->
    <div class="container">
        <?php if ($records_btn) {

          // declare some storage variables
          $treament_category_name = null;
          $provid_name = null;
          $provid_address = null;
          $provid = null;
          $notetime = null;
          $diagnosisnotes = null;
          $drrecommendations = null;
          $recordtime = null;
          $tcatid = null;
          $patientpayment = null;

          // Grab the information needed.
          $patient_records->bind_param("i", $_SESSION['PID']);
          $patient_records->execute();
          $patient_records->store_result();
          $patient_records->bind_result($recordtime, $tcatid, $patientpayment);

          $patient_notes->bind_param("i", $_SESSION['PID']);
          $patient_notes->execute();
          $patient_notes->store_result();
          $patient_notes->bind_result($provid, $notetime, $diagnosisnotes, $drrecommendations);

          
          /***** BEGIN: PRINTING RECORDS TABLE *****/
          // Did we get any results
          if ($patient_records->num_rows()>0) {

            # Create the records table
            echo "
            <center>
            <table name=\"patientrecords_table\">
            <tr>
              <th> Record Time </th>
              <th> Treatment Category</th>
              <th> Patient Payment </th>
            </tr>
            </center>";

            // Get the Query Results
            while ($patient_records->fetch()) {
              $treament_category->bind_param("i", $tcatid);
              $treament_category->execute();
              $treament_category->store_result();
              $treament_category->bind_result($treament_category_name);


              if ($treament_category->num_rows > 0) {
                // if we get here all is well
                // Get the Query Results
                while ($treament_category->fetch());
                
              }
              else
              {
                echo "Error: Couldn't find Treatment Category Name!";
              }

              # Print each table row
              echo "<tr>
            <td>$recordtime</td>
            <td>$treament_category_name</td>
            <td>$patientpayment</td>
            </tr>";
            }
            # Close the records table and query
            echo "</table>";
            $patient_records->close();
            $treament_category->close();
          }
          /***** END: PRINTING RECORDS TABLE *****/


          /***** BEGIN: PRINTING Patient Notes TABLE *****/
            if ($patient_notes->num_rows > 0) {
              // if we get here all is well
              # Create the notestable
            echo "
            <br>
            <table name=\"patientnotes_table\">
            <tr>
              <th> Provider Name </th>
              <th> Provider Address </th>
              <th  width=100px> Note Time </th>
              <th> Diagnosis Notes </th>
              <th> Dr. Recommendations </th>
            </tr>";


              while ($patient_notes->fetch()) {

                $healthprovider_name->bind_param("i", $provid);
                $healthprovider_name->execute();
                $healthprovider_name->store_result();
                $healthprovider_name->bind_result($provid_name, $provid_address);
  
                if ($healthprovider_name->num_rows > 0) {
                  // If we get here all is good
                  // Get the Query Results
                  while($healthprovider_name->fetch());
                }
                else
                {
                  echo "Error: Couldn't find Health Provider name or address!";
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

              # Close the patient notes table
              echo "</table>";
              $patient_notes->close();
              $healthprovider_name->close();
            }
            /***** END PRINTING Patient Notes TABLE *****/

            else
            {
              echo "Error: Couldn't find any Patient Notes!";
            }
        
        } else {
          $records_btn = false;
        }
        ?>
    </div>
  </form>
</div>

<!--modal for doctor to make a note -->
<div id="make-note" class="modal">

  <form class="modal-content animate" method="post" style="max-width:95%">
    <div class="imgcontainer">
      <span onclick="document.getElementById('make-note').style.display='none'" class="close" title="Close Modal">&times;
      
      </span>
      <div class="center">
        <h3>Make Note & Record </h3>
      </div>
    </div>
    <div class="container"
    <form class="form-signup" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                        ?>" method="post">
            <input type="text" class="form-signup" name="pid" placeholder="<?php echo "PID: " . $_SESSION['PID']  ?>" disabled="disabled"></br></br>
            <input type="text" class="form-signup" name="name_first" placeholder="<?php echo "First Name: " . $_SESSION['name_first'] ?>" disabled="disabled"></br></br>
            <input type="text" class="form-signup" name="name_last" placeholder="<?php echo "Last Name: " . $_SESSION['name_last'] ?>" disabled="disabled"></br></br>
            <input type="text" class="form-signup" name="DOB" placeholder="<?php echo "DOB: " . $_SESSION['DOB'] ?>" disabled="disabled"></br></br>
            <textarea class="reason" rows="2" cols="80" style="resize:none" wrap="soft" maxlength="255" name="drrecommendations" placeholder="Enter Dr. Recommendations" required></textarea></br></br>
            <textarea class="reason" rows="2" cols="80" style="resize:none" wrap="soft" maxlength="255" name="diagnosisnotes" placeholder="Enter Diagnosis Notes" required></textarea></br></br>
            <p> Was the Patient Treated? (Checked=Yes, Unchecked=No): 
            <input type="checkbox" name="checkbox" value=1 /> </p>
            <p> Select a Treatment Category: </p>
            <select class="form-signup" name="treatmentcatid">
            <option value="DEFAULT"> </option>
            <!-- Print out the drop down menu -->
            <?php 
            $treatment_category_name = null;
            $treatment_category_id = null;
            $get_treatment_category_names->execute();
            $get_treatment_category_names->store_result();
            $get_treatment_category_names->bind_result($treatment_category_id, $treatment_category_name);

            if($get_treatment_category_names->num_rows()>0)
            {
              while($get_treatment_category_names->fetch())
              {
                echo "<option value=$treatment_category_id>" . $treatment_category_name . "</option>";
              }
            }
            $get_treatment_category_names->close();
            ?>
            </select>

            <p> Select a Health Provider: </p>
            <select class="form-signup" name="healthprovider">
            <option value="DEFAULT"> </option>
            <!-- Print out the drop down menu -->
            <?php 
            $health_provider_name = null;
            $get_health_provider_names->execute();
            $get_health_provider_names->store_result();
            $get_health_provider_names->bind_result($health_provider_name);

            if($get_health_provider_names->num_rows()>0)
            {
              while($get_health_provider_names->fetch())
              {
                echo "<option value=\"$health_provider_name\">" . $health_provider_name . "</option>";
              }
            }
            $get_health_provider_names->close();
            ?>
            </select>
            
            <button class="loginbtn" type="submit" name="create_notes">submit
            </button>
          </form>

          <?php 
            if(isset($_POST["create_notes"]) && !isset($_POST["treatmentcatid"]) && !isset($_POST["healthprovider"]))
              $err_msg = "Error: No Treatment Category or Health Provider was selected!";

            elseif(isset($_POST["create_notes"]) && !isset($_POST["treatmentcatid"]) && isset($_POST["healthprovider"]))
              $err_msg = "Error: No Treatment Category or Health Provider was selected!";

            elseif(isset($_POST["create_notes"]) && isset($_POST["treatmentcatid"]) && !isset($_POST["healthprovider"]))
              $err_msg = "Error: No Treatment Category or Health Provider was selected!";

            elseif(isset($_POST["create_notes"]) && isset($_POST["treatmentcatid"]) && isset($_POST["healthprovider"]))
            {
              
              if(($_POST["treatmentcatid"] == "DEFAULT") || ($_POST["healthprovider"] == "DEFAULT"))
                $err_msg = "Error: No Treatment Category or Health Provider was selected!";
              
                else{
                  $treatmentcatid = $_POST["treatmentcatid"];
                  $healthprovider = $_POST["healthprovider"];
                  $drrecommendations = trim($_POST["drrecommendations"]);
                  $diagnosisnotes = trim($_POST["diagnosisnotes"]);
                  $treated = null;
                  $pid = $_SESSION["PID"];

                  if(!isset($_POST["checkbox"]))
                    $treated = 0;
                  else
                    $treated = 1;

                  
                  # Now we insert into notes & records
                  $insert_into_patientnotes->bind_param("isssi", $pid, $healthprovider, $diagnosisnotes, $drrecommendations, $treated);
                  $rtal = $insert_into_patientnotes->execute();
                  
                  $err_msg = $treatmentcatid;

                  $err_msg = "THis is a test: $treatment_categoryid";
                  $insert_into_patientrecords->bind_param("iiiiii", $pid, $treatmentcatid, rand(100,10000),rand(100,10000),rand(100,10000),rand(100,10000));
                  $insert_into_patientrecords->execute();

                  #if($rtal)
                  #  $err_msg = "Submission Success!";
                  #else
                  #  $err_msg = "Submission Failure!";
                  
                  $insert_into_patientnotes->close();
                  $get_treament_categoryid->close();
                  $insert_into_patientrecords->close();

                }
              

              
            }
          ?>
  
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
  <?php echo $err_msg; $conn->close(); ?>
</body>

</html>