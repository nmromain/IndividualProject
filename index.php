<?php

include "displayWelcome.php";
include "Functions.php";

ini_set("session.cookie_domain", "csis.svsu.edu/");

// Start the session
session_start();
// Set an error message
$error = "";
$hostname = "localhost";
$username = "CIS355nmromain";
$password = "Compuware1993";
$dbname = "CIS355nmromain";

$_SESSION['LoggedIn'] = FALSE;

$mysqli = new mysqli($hostname, $username, $password, $dbname);
checkConnect($mysqli);

// If the user pressed the Submit button
if (isset($_POST['loginSubmit'])) {
    $usern = $_POST['username'];
    $passw = $_POST['password'];

    if ($result = $mysqli->query("SELECT email, password, id FROM `users` WHERE email = '$usern' AND password = '$passw'")) {

        $row = $result->fetch_row();

        $ValidPassword = strcmp($passw, $row[1]);
        $ValidUser = strcmp(strtoupper($usern), strtoupper($row[0]));

        if (is_null($row) || $ValidPassword != 0 || $ValidUser != 0) {
            //This means the login had an invalid username/password or the user
            //was not in the system.
            $_SESSION['InvalidLogin'] = 1;
            LoginPage();
        } else {
            SessionVars($row);
            getNameOfPersonLoggedIn($mysqli);
            header("Location: welcome.php");
        }
    }
} else {
    LoginPage();
}

function SessionVars($row) {
    $_SESSION['LoggedIn'] = TRUE;
    $_SESSION['InvalidLogin'] = 0;
    $_SESSION['ValidUsername'] = $row[1];
    $_SESSION['PersonID'] = $row[2];
}

function getNameOfPersonLoggedIn($mysqli) {
$Statement = "SELECT CONCAT_WS(' ',users.first_name, users.last_name) AS user FROM `users` WHERE id =" . $_SESSION['PersonID'];
    $result = $mysqli->query( $Statement);
    $item = $result->fetch_row();
    $_SESSION['UserLoggedIn'] =  $item[0];
    $result->close();
}

?>
