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
$isemployee = $_SESSION['isemployee'];
$pid = $_SESSION['pid'];


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
  <h1><b>My Health Patient Portal</b></h1>
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
          list($first_name, $last_name, $DOB) = explode(",",$inp_string,3);
          // Query the PatientInfo database for the information
          $first_last_dob_query->bind_param("sss",$first_name,$last_name,$DOB);
          $first_last_dob_query->execute();
          $flb_results = $first_last_dob_query->get_result();

          // Did we get any results
          if($flb_results->num_rows >0)
          {
            // Get the Query Results
            while ($row = $flb_results->fetch_assoc()) {
              echo '<section name="patientinfo" class="center">
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
                  <td>'.$row["PID"].'</td>
                  <td>'.$row["name_first"].'</td>
                  <td>'.$row["name_last"].'</td>
                  <td>'.$row["DOB"].'</td>
                  <td>'.$row["Gender"].'</td>
                  <td>'.$row["address"].'</td>
                  <td>'.$row["email"].'</td>
                  <td>'.$row["phone"].'</td>
                  <td>'.$row["Emergency_name"].'</td>
                  <td>'.$row["Emergency_phone"].'</td>
                </tr>
                </tbody>
              </table>
            </section>';
            } 
          }

        }
        
      break;
      case "search_by_PID": 
        //$inp_string = $_POST["searchbar-txt"];
        if($inp_string == NULL){
          echo("<ul>" . "Enter Patient ID" . "</ul>\n");
        }
        // Query the PatientInfo database for the information
        $patient_id_query->bind_param("s",$inp_string);
        $patient_id_query->execute();
        $pid_results = $patient_id_query->get_result();

        if($pid_results->num_rows >0)
          {
            // Get the Query Results
            while ($row = $pid_results->fetch_assoc()) {
              echo '<section name="patientinfo" class="center">
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
                  <td>'.$row["PID"].'</td>
                  <td>'.$row["name_first"].'</td>
                  <td>'.$row["name_last"].'</td>
                  <td>'.$row["DOB"].'</td>
                  <td>'.$row["Gender"].'</td>
                  <td>'.$row["address"].'</td>
                  <td>'.$row["email"].'</td>
                  <td>'.$row["phone"].'</td>
                  <td>'.$row["Emergency_name"].'</td>
                  <td>'.$row["Emergency_phone"].'</td>
                </tr>
                </tbody>
              </table>
            </section>';

            } 
          }


        
      break;

      case "search_by_FLE":
        if($inp_string == NULL){
          echo("<ul>" . "Enter Firstname, Lastname and Email" . "</ul>\n");
        }
        else{           
          list($first_name, $last_name, $email_ad) = explode(",",$inp_string,3);
          // Query the PatientInfo database for the information
          $first_last_email_query->bind_param("sss",$first_name,$last_name,$email_ad);
          $first_last_email_query->execute();
          $fle_results = $first_last_email_query->get_result();
  
          // Did we get any results
          if($fle_results->num_rows >0)
          {
            // Get the Query Results
            while ($row = $fle_results->fetch_assoc()) {
              echo '<section name="patientinfo" class="center">
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
                  <td>'.$row["PID"].'</td>
                  <td>'.$row["name_first"].'</td>
                  <td>'.$row["name_last"].'</td>
                  <td>'.$row["DOB"].'</td>
                  <td>'.$row["Gender"].'</td>
                  <td>'.$row["address"].'</td>
                  <td>'.$row["email"].'</td>
                  <td>'.$row["phone"].'</td>
                  <td>'.$row["Emergency_name"].'</td>
                  <td>'.$row["Emergency_phone"].'</td>
                </tr>
                </tbody>
              </table>
            </section>';
            } 
          }
  
        }
         
        
      break;

    }
  }
}



?>



  <?php $conn->close(); ?>
</body>

</html>