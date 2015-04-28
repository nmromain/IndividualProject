<?php

session_start();
include "teamFunctions.php";
include "Functions.php";
include "displayWelcome.php";

$hostname = "localhost";
$username = "CIS355nmromain";
$password = "Compuware1993";
$dbname = "CIS355nmromain";
$usertable = "team";

$mysqli = new mysqli($hostname, $username, $password, $dbname);
checkConnect($mysqli); // program dies if no connection
// ---------- if successful connection...
if ($mysqli) {
    // ---------- c. create table, if necessary -------------------------------
    //createTable($mysqli); 
    // ---------- d. initialize userSelection and $_POST variables ------------
    $userSelection = 0;
    $firstCall = 1; // first time program is called
    $InsertAteam = 2; // after user clicked InsertAteam button on list 
    $UpdateAteam = 3; // after user clicked UpdateAteam button on list 
    $DeleteAteam = 4; // after user clicked DeleteAteam button on list 
    $teamExecuteInsert = 5; // after user clicked insertSubmit button on form
    $teamExecuteUpdate = 6; // after user clicked updateSubmit button on form
	$BackToteam = 7; // after user clicks to go back to the database
	$BackToButtons = 8; // after user clicks on button to go to welcome page

    $_SESSION['teamID'] = $_POST['uid'];
    $userlocation = $_SESSION['location'];

    $userSelection = $firstCall; // assumes first call unless button was clicked
    if (isset($_POST['InsertAteam']))
        $userSelection = $InsertAteam;
    if (isset($_POST['UpdateAteam']))
        $userSelection = $UpdateAteam;
    if (isset($_POST['DeleteAteam']))
        $userSelection = $DeleteAteam;
    if (isset($_POST['teamExecuteInsert']))
        $userSelection = $teamExecuteInsert;
    if (isset($_POST['teamExecuteUpdate']))
        $userSelection = $teamExecuteUpdate;
	if (isset($_POST['BackToteam']))
        $userSelection = $BackToteam;
	if (isset($_POST['BackToButtons']))
		$userSelection = $BackToButtons;

    switch ($userSelection):
        case $firstCall:
            displayHTMLHead();
            showTable($mysqli, $usertable);
            break;
        case $InsertAteam:
            displayHTMLHead();
            showteamInsertForm($mysqli);
            break;
        case $UpdateAteam :
            $_SESSION['teamID'] = $_POST['uid'];
            echo $_SESSION['teamID'];
            displayHTMLHead();
            ShowteamUpdateForm($mysqli, $usertable);
            break;
        case $DeleteAteam:
            $_SESSION['teamID'] = $_POST['hid'];
            echo $_SESSION['teamID'];
            displayHTMLHead();
            deleteRecord($mysqli, $usertable);   // delete is immediate (no confirmation)
			header("Location: team.php");
            break;
        case $teamExecuteInsert:
            insertRecord($mysqli, $usertable);
			header("Location: team.php");
            break;
        case $teamExecuteUpdate:
            updateRecord($mysqli, $usertable);
			header("Location: team.php");
            break;
		case $BackToteam:
			header("Location: team.php");
			break;
		case $BackToButtons:
			header("Location: welcome.php");
			break;
    endswitch;
} // ---------- end if ---------- end main processing ----------
?>
