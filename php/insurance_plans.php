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
$name_first = $_SESSION['name_first'];
$name_last = $_SESSION['name_last'];

# Grab the insurace plans the user may be enrolled in. And declare vars for the info
$planid = null;
$companyid = null;

$get_enrolled_query->bind_param("i", $pid);
$get_enrolled_query->execute();
$get_enrolled_query->store_result();
$get_enrolled_query->bind_result($planid, $companyid);
?>
<!--end of php section-->

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
  <title>Insurance Plans Portal </title>
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
      <?php if (isset($_POST['home'])) {
        header('Location: ../index.php');
      }
      ?>
    </button>
  </form>
  <!--Refresh Page Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                  ?>" method="post">
    <button class="w3-bar-item w3-button" name="patient_portal" type="submit">Patient Portal
      <!-- If the logout button is pushed -->
      <?php if (isset($_POST['patient_portal'])) {
        header('Location: patient_portal.php');
      }
      ?>
    </button>
  </form>
  <!--Insurance Plans Page Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                  ?>" method="post">
    <button class="w3-bar-item w3-button" name="insurance_plans" type="submit">Insurance Plans
      <!-- If the logout button is pushed -->
      <?php if (isset($_POST['insurance_plans'])) {
        header('Location: insurance_plans.php');
      }
      ?>
    </button>
  </form>
  <!--Logout Button-->
  <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                  ?>" method="post">
    <button class="w3-bar-item w3-button logoutbtn" name="logout" type="submit" style="float: right;">Logout
      <!-- If the logout button is pushed -->
      <?php if (isset($_POST['logout'])) {
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

      <h2>Insurance Plans Portal: <?php echo " Welcome - <B>$name_first $name_last</B>" ?></h2>

      <section name="insuranceplans" class="center">
        <?php
        // Did we get any results
        if ($get_enrolled_query->num_rows() > 0) {
          // Get the Query Results
          if ($get_enrolled_query->fetch()) {
            // Get the information
            $get_planid_info_by_id_query->bind_param("i", $planid);
            $get_planid_info_by_id_query->execute();
            $get_planid_info_by_id_query->store_result();
            $get_planid_info_by_id_query->bind_result($annualprem, $annualdeductible, $annualcoveragelimit, $lifetimecoverage, $network);

            $get_insprov_info_by_id_query->bind_param("i", $companyid);
            $get_insprov_info_by_id_query->execute();
            $get_insprov_info_by_id_query->store_result();
            $get_insprov_info_by_id_query->bind_result($company, $planid, $category, $address, $email, $phone);
           

            // Declare storage variables
            $annualprem = null;
            $annualdeductible = null;
            $annualcoveragelimit = null;
            $lifetimecoverage = null;
            $network = null;
            $company = null;
            $planid = null;
            $category = null;
            $address = null;
            $email = null;
            $phone = null;

            // Print out results if there are any!

            if ($get_insprov_info_by_id_query->num_rows() > 0) {
              # Create the Ins Provider Table
              echo "
              <center>
              <table name=\"insprovider_table\" class=\"center\" style=\"width=95%;\" border=\"3\" cellpadding=\"1\">
              <tr>
                <th> CompanyID </th>
                <th> Company Name</th>
                <th> PlanID </th>
                <th> Category </th>
                <th> Address </th>
                <th> Phone </th>
                <th> Email </th>
              </tr>
              </center>";

              while ($get_insprov_info_by_id_query->fetch()) {
                # Print each table row
                echo "<tr>
                  <td>$companyid</td>
                  <td>$company</td>
                  <td>$planid</td>
                  <td>$category</td>
                  <td>$address</td>
                  <td>$phone</td>
                  <td>$email</td>
                  </tr>";
              }

              // Close the Ins Provider Table and the query
              echo "</table>";
              $get_insprov_info_by_id_query->close();
            }

            if ($get_planid_info_by_id_query->num_rows() > 0) {
              # Create the Ins Plans Table
              echo "
              <center>
              <table name=\"insplans_table\" class=\"center\" style=\"width=95%;\" border=\"3\" cellpadding=\"1\">
              <tr>
                <th> Annual Prem. </th>
                <th> Annual Deduct. </th>
                <th> Annual Coverage Limit </th>
                <th> Lifetime Coverage </th>
                <th> Netowkr </th>
              </tr>
              </center>";

              while ($get_planid_info_by_id_query->fetch()) {
                # Print each table row
                echo "<tr>
                  <td>$annualprem</td>
                  <td>$annualdeductible</td>
                  <td>$annualcoveragelimit</td>
                  <td>$lifetimecoverage</td>
                  <td>$network</td>
                  </tr>";
              }
              // Close the Ins Provider Table and the query
              echo "</table>";
              $get_planid_info_by_id_query->close();
            }
          }
        }
        else {
          echo "<B> You are not enrolled! Select a state to begin! 
          Then select an Insurance Provider Plan for more information!
          <B>";
          echo "
          <div class=\"container\">
        <section class=\"insurance_plans\" id=\"insurance_plans\">
        <form action=\"\" method=\"post\">
          <div class=\"center\">
            <p> State </p>
            <select name=\"State\">
              <option value=\"DEFAULT\"> State Abbr.</option>
              <option value=\"AL\"> Alabama - AL </option>
              <option value=\"AK\"> Alaska - AK </option>
              <option value=\"AZ\"> Arizona - AZ </option>
              <option value=\"AR\"> Arkansas - AR </option>
              <option value=\"CA\"> California - CA </option>
              <option value=\"Co\"> Colorado - CO </option>
              <option value=\"CT\"> Connecticut - CT </option>
              <option value=\"DE\"> Delaware - DE </option>
              <option value=\"FL\"> Florida - FL </option>
              <option value=\"GA\"> Georgia - GA </option>
              <option value=\"HI\"> Hawaii - HI </option>
              <option value=\"ID\"> Idaho - ID </option>
              <option value=\"IL\"> Illinois - IL </option>
              <option value=\"IN\"> Indiana - IN </option>
              <option value=\"IA\"> Iowa - IA </option>
              <option value=\"KS\"> Kansas - KS </option>
              <option value=\"KY\"> Kentucky - KY </option>
              <option value=\"LA\"> Louisiana - LA </option>
              <option value=\"ME\"> Maine - ME </option>
              <option value=\"MD\"> Maryland - MD </option>
              <option value=\"MA\"> Massachusetts - MA </option>
              <option value=\"MI\"> Michigan - MI </option>
              <option value=\"MN\"> Minnesota - MN </option>
              <option value=\"MS\"> Mississippi - MS </option>
              <option value=\"MO\"> Missouri - MO </option>
              <option value=\"MT\"> Montana - MT </option>
              <option value=\"NE\"> Nebraska - NE </option>
              <option value=\"NV\"> Nevada - NV </option>
              <option value=\"NH\"> New Hampshire - NH </option>
              <option value=\"NJ\"> New Jersey - NJ </option>
              <option value=\"NM\"> New Mexico - NM </option>
              <option value=\"NY\"> New York - NY </option>
              <option value=\"NC\"> North Carolina - NC </option>
              <option value=\"ND\"> North Dakota - ND </option>
              <option value=\"OH\"> Ohio - OH </option>
              <option value=\"OK\"> Oklahoma - OK </option>
              <option value=\"OR\"> Oregon - OR </option>
              <option value=\"PA\"> Pennsylvania - PA </option>
              <option value=\"RI\"> Rhode Island - RI </option>
              <option value=\"SC\"> South Carolina - SC </option>
              <option value=\"SD\"> South Dakota - SD </option>
              <option value=\"TN\"> Tennessee - TN </option>
              <option value=\"TX\"> Texas - TX </option>
              <option value=\"UT\"> Utah - UT </option>
              <option value=\"VT\"> Vermont - VT </option>
              <option value=\"VA\"> Virginia - VA </option>
              <option value=\"WA\"> Washington - WA </option>
              <option value=\"WV\"> West Virginia - WV </option>
              <option value=\"WI\"> Wisconsin - WI </option>
              <option value=\"WY\"> Wyoming - WY </option>
            </select>
            <input class=\"w3-bar-item w3-button logoutbtn\" type=\"submit\" name=\"button\" value=\"Submit\"/>

            </div>
          <div class=\"center\">
        </form>      
          ";

          // Get the drop down data
          if (isset($_POST['State']))
            //  Check To make sure it's not the DEFAULT
            if ($_POST['State'] == "DEFAULT")
              echo "Please select a state!  Try again!";
            else {
              //  We take the state and query for it in the Insurance Provider table
              $state = $_POST['State'];
              $state_string = "%, $state%";
              $search_for_insprov_by_state_query->bind_param("s", $state_string);
              $search_for_insprov_by_state_query->execute();

              # Decalre the variables to store the results in
              $companyid = null;
              $company = null;
              $planid = null;
              $category = null;
              $address = null;
              $email = null;
              $phone = null;

              if ($search_for_insprov_by_state_query->bind_result(
                $companyid,
                $company,
                $planid,
                $category,
                $address,
                $email,
                $phone
              )) {

                # Create the Ins Provider Table
                echo "
                <center>
                <table name=\"insplans_table\" class=\"center\" style=\"width=95%;\" border=\"3\" cellpadding=\"1\">
                <tr>
                  <th> CheckBox </th>
                  <th> CompanyID </th>
                  <th> Company Name</th>
                  <th> PlanID </th>
                  <th> Category </th>
                  <th> Address </th>
                  <th> Phone </th>
                  <th> Email </th>
                </tr>
                </center>";

                // get the resuts
                $check_box_id = 0;
                while ($search_for_insprov_by_state_query->fetch()) {
                  # Print each table row
                  echo "<tr>
                  <td><input type=\"checkbox\" id=\"$check_box_id\" /></td>
                  <td>$companyid</td>
                  <td>$company</td>
                  <td>$planid</td>
                  <td>$category</td>
                  <td>$address</td>
                  <td>$phone</td>
                  <td>$email</td>
                  </tr>";
                  // increment the id
                  $check_box_id++;
                }

                // Close the Ins Provider Table and the query
                echo "</table>";
                $search_for_insprov_by_state_query->close();
              }
            }
        }
        // Close the query we are done with it
        $get_enrolled_query->close();
        ?>
      </section>

    </div>
  </div>

  <?php $conn->close(); ?>
</body>

</html>