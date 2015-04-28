<?php

session_start();
include "battingaveragesFunctions.php";
include "Functions.php";
include "displayWelcome.php";

$hostname = "localhost";
$username = "CIS355nmromain";
$password = "Compuware1993";
$dbname = "CIS355nmromain";
$usertable = "battingaverages";

$mysqli = new mysqli($hostname, $username, $password, $dbname);
checkConnect($mysqli); // program dies if no connection
// ---------- if successful connection...
if ($mysqli) {
    // ---------- c. create table, if necessary -------------------------------
    //createTable($mysqli); 
    // ---------- d. initialize userSelection and $_POST variables ------------
    $userSelection = 0;
    $firstCall = 1; // first time program is called
    $InsertAnAverage = 2; // after user clicked InsertAnAverage button on list 
    $UpdateAnAverage = 3; // after user clicked UpdateAnAverage button on list 
    $DeleteAnAverage = 4; // after user clicked DeleteAnAverage button on list 
    $AverageExecuteInsert = 5; // after user clicked insertSubmit button on form
    $AverageExecuteUpdate = 6; // after user clicked updateSubmit button on form
	$BackToAverages = 7;
	$BackToButtons = 8;

    $_SESSION['AverageID'] = $_POST['uid'];
    $userlocation = $_SESSION['location'];

    $userSelection = $firstCall; // assumes first call unless button was clicked
    if (isset($_POST['InsertAnAverage']))
        $userSelection = $InsertAnAverage;
    if (isset($_POST['UpdateAnAverage']))
        $userSelection = $UpdateAnAverage;
    if (isset($_POST['DeleteAnAverage']))
        $userSelection = $DeleteAnAverage;
    if (isset($_POST['AverageExecuteInsert']))
        $userSelection = $AverageExecuteInsert;
    if (isset($_POST['AverageExecuteUpdate']))
        $userSelection = $AverageExecuteUpdate;
	if (isset($_POST['BackToAverages']))
        $userSelection = $BackToAverages;
	if (isset($_POST['BackToButtons']))
		$userSelection = $BackToButtons;

    switch ($userSelection):
        case $firstCall:
            displayHTMLHead();
            showTable($mysqli, $usertable);
            break;
        case $InsertAnAverage:
            displayHTMLHead();
            showAverageInsertForm($mysqli);
            break;
        case $UpdateAnAverage :
            $_SESSION['AverageID'] = $_POST['uid'];
            echo $_SESSION['AverageID'];
            displayHTMLHead();
            ShowSprintersUpdateForm($mysqli, $usertable);
            break;
        case $DeleteAnAverage:
            $_SESSION['AverageID'] = $_POST['hid'];
            echo $_SESSION['AverageID'];
            displayHTMLHead();
            deleteRecord($mysqli, $usertable);   // delete is immediate (no confirmation)
			header("Location: battingaverages.php");
            break;
        case $AverageExecuteInsert:
            insertRecord($mysqli, $usertable);
			header("Location: battingaverages.php");
            break;
        case $AverageExecuteUpdate:
            updateRecord($mysqli, $usertable);
			header("Location: battingaverages.php");
            break;
		case $BackToAverages:
			header("Location: battingaverages.php");
			break;
		case $BackToButtons:
			header("Location: welcome.php");
			break;
    endswitch;
} // ---------- end if ---------- end main processing ----------
?>
