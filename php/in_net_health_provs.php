<?php
/* This is the insurance_plans.php file.
* All Patient insurance information will be accessed
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

# Declare globals
global $err_msg;
?>
<!--end of php section-->

<!------------- HTML ------------->
<!DOCTYPE html>
<html>

<head>
    <title>Insurance Plans Portal </title>
    <link href="../css/welcome.css" rel="stylesheet">
    <link href="../css/blue_theme.css" rel="stylesheet">
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
    <!-- In-Network Health Providers Page Button-->
    <form class="form-options" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
                                                    ?>" method="post">
        <button class="w3-bar-item w3-button" name="in-net-health-prov" type="submit">In-Network Health Providers
            <!-- If the logout button is pushed -->
            <?php if (isset($_POST['in-net-health-prov'])) {
                header('Location: in_net_health_provs.php');
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

            <h2>In-Network Health Providers: <?php echo " Welcome - <B>$name_first $name_last</B>" ?></h2>

            <div class="container">
                <?php

                # Let's find out if this user has insurance
                $pid_planid = null;
                $pid_companyid = null;
                $health_provider_id = null;
                $health_provider_name = null;
                $health_provider_address =
                    $get_enrolled_query->bind_param("i", $pid);
                $get_enrolled_query->execute();
                $get_enrolled_query->store_result();
                $get_enrolled_query->bind_result($pid_planid, $pid_companyid);

                if ($get_enrolled_query->num_rows() > 0) {
                    while ($get_enrolled_query->fetch());
                    // go grab the in-network health providers list
                    $get_in_net_health_prov_by_planid->bind_param("i", $pid_planid);
                    $get_in_net_health_prov_by_planid->execute();
                    $get_in_net_health_prov_by_planid->store_result();
                    $get_in_net_health_prov_by_planid->bind_result($health_provider_id);

                    if ($get_in_net_health_prov_by_planid->num_rows() > 0) {
                        # Create the In-Network Health Provider Table
                        echo "
                <center>
                <table name=\"in_net_health_prov_table\" class=\"center\" style=\"width=95%;\" border=\"3\" cellpadding=\"1\">
                <tr>
                <th> Name </th>
                <th> Address</th>
                </tr>
                </center>";

                        while ($get_in_net_health_prov_by_planid->fetch()) {
                            // For each Provider ID fetch the info
                            $get_health_prov_info->bind_param("i", $health_provider_id);
                            $get_health_prov_info->execute();
                            $get_health_prov_info->store_result();
                            $get_health_prov_info->bind_result($health_provider_name, $health_provider_address);

                            if ($get_health_prov_info->num_rows() > 0) {
                                while ($get_health_prov_info->fetch()) {
                                    // Add table rows
                                    # Print each table row
                                    echo "<tr>
                                <td>$health_provider_name </td>
                                <td>$health_provider_address </td>
                            </tr>";
                                }
                            }
                        }
                    }

                    # Close the  In-Network Health Provider Table and queries
                    echo "</table>";
                    $get_enrolled_query->close();
                    $get_in_net_health_prov_by_planid->close();
                    $get_health_prov_info->close();
                } else
                    $err_msg = "You are not enrolled into an insurance plan!\n Please vist the Insurance Plans page to shop for plans!";
                ?>

            </div>
        </div>
    </div>

    <?php
    echo $err_msg;
    $conn->close(); ?>
</body>

</html>