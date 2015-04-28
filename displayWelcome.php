<?php

session_start();
$hostname = "localhost";
$username = "CIS355nmromain";
$password = "Compuware1993";
$dbname = "CIS355nmromain";
$usertable = "battingaverages";

# ========== FUNCTIONS ========================================================
# ---------- checkConnect -----------------------------------------------------

function checkConnect($mysqli) {
    if ($mysqli->connect_errno) {
        die('Unable to connect to database [' . $mysqli->connect_error . ']');
        exit();
    }
}

function showButtons($mysqli) {
    // display html buttons
		echo '<div class="col-md-12">
			  <form action="welcome.php" method="POST">'; 
		echo '<br><br><br><br>';
        echo '<input type="hidden" id="hid" name="hid" value="">
            <input type="hidden" id="uid" name="uid" value="">
			<table>
            <tr><td><input type="submit"  name="GoTobattingaverages" value="battingaverages" 
            class="btn btn-primary"></td>
			<td><input type="submit" name="GoToteam" value="team"
			class="btn btn-primary""></td></tr></table>
            </form></div>';

        echo "<script>
			function setHid(num)
			{
				document.getElementById('hid').value = num;
		    }
		    function setUid(num)
			{
				document.getElementById('uid').value = num;
		    }
		 </script>";
}
?>

