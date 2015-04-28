 <?php

session_start();
include "displayWelcome.php";
include "battingaveragesFunctions.php";
include "Functions.php";

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
    $GoTobattingaverages = 2; // after user clicked InsertAAverage button on list 
    $GoToteam = 3; // after user clicked UpdateAbattingaverages button on list 

    $_SESSION['battingaveragesID'] = $_POST['uid'];
    $userlocation = $_SESSION['location'];

    $userSelection = $firstCall; // assumes first call unless button was clicked
    if (isset($_POST['GoTobattingaverages']))
        $userSelection = $GoTobattingaverages;
    if (isset($_POST['GoToteam']))
        $userSelection = $GoToteam;

    switch ($userSelection):
        case $firstCall:
            displayHTMLHead();
            showButtons($mysqli);
            break;
        case $GoTobattingaverages:
            displayHTMLHead();
			header("Location: battingaverages.php");
            break;
        case $GoToteam :
            displayHTMLHead();
            header("Location: team.php");
            break;
    endswitch;
} // ---------- end if ---------- end main processing ----------
?>
