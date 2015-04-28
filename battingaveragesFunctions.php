<?php

function showTable($mysqli, $usertable) {
    echo '<div class="col-md-12">
			<form action="battingaverages.php" method="POST">
			<table class="table table-condensed" 
			style="border: 1px solid #dddddd; border-radius: 5px; 
			box-shadow: 2px 2px 10px;">
			<tr><td colspan="11" style="text-align: center; border-radius: 5px; 
			color: white; background-color:#333333;">
			<h2 style="color: white;">Batting Averages</h2>
			</td></tr><tr style="font-weight:800; font-size:20px;">
			<td>ID</td><td>First Name</td><td>Last Name</td>
			<td>position</td><td>year</td><td></td><td></td></tr>';

    // get count of records in mysql table
    $countresult = $mysqli->query("SELECT COUNT(*) FROM $usertable");
    $countfetch = $countresult->fetch_row();
    $countvalue = $countfetch[0];
    $countresult->close();
    // if records > 0 in mysql table, then populate html table, 
    // else display "no records" message
    if ($countvalue > 0) {
        populateTable($mysqli, $usertable); // populate html table, from mysql table
    } else {
        echo '<br><p>No records in database table</p><br>';
    }

    // display html buttons 
	echo '</table>';
	echo '<input type="hidden" id="hid" name="hid" value="">
            <input type="hidden" id="uid" name="uid" value="">
            <input type="submit" name="InsertAnAverage" value="Add an Entry" 
            class="btn btn-primary"">
			<input type="submit" name="BackToButtons" value="Back To Welcome" 
            class="btn btn-primary"">
            </form></div>';
    // below: JavaScript functions at end of html body section
    // "hid" is id of item to be deleted
    // "uid" is id of item to be updated.
    // see also: populateTable function
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

// populate html table, from data in mysql table
function populateTable($mysqli, $usertable) {
    if ($result = $mysqli->query("SELECT id, first_name, last_name, position, year FROM $usertable")) {
            //. "CONCAT_WS(' ',persons.first_name, persons.last_name) AS person, date_created, "
            //. "search_field FROM Averages LEFT JOIN persons ON Averages.persons_id=persons.id")) {

        while ($row = $result->fetch_row()) {
            echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' .
            $row[2] . '</td><td>' . $row[3] . '</td><td>' . $row[4] .
            '</td><td>' . $row[5] . '</td><td>' . $row[6]; /* . '</td><td>' .
            $row[7] . '</td><td>' . $row[8] . '</td><td>' . $row[9];*/

            //if ($_SESSION["id"] == $row[6]) {
                echo '<input type="hidden" id="uid" name="uid" value="' . $row[0] . '">
                    </td><td><input name="DeleteAnAverage" type="submit" 
                        class="btn btn-danger" value="Delete" onclick="setHid(' . $row[0] . ')" />';
                echo '<input style="margin-left: 10px;" type="submit" 
                        name="UpdateAnAverage" class="btn btn-primary" value="Update" 
                        onclick="setHid(' . $row[0] . ')" />';
            //}
        }
    }
    $result->close();
}

function ShowSprintersUpdateForm($mysqli, $Table) {
    $index = $_POST['hid'];  // "uid" is id of db record to be updated 

    if ($result = $mysqli->query("SELECT id, first_name, last_name, position, year FROM $Table WHERE id = $index")) {
		while($row = $result->fetch_row()) {
            echo '<div class="col-md-4">
        <form name="basic" method="POST" action="battingaverages.php" 
        onSubmit="return validate();"> 
        <table class="table table-condensed" style="border: 1px solid #dddddd; 
        border-radius: 5px; box-shadow: 2px 2px 10px;">
        <tr><td colspan="2" style="text-align: center; border-radius: 5px; 
        color: white; background-color:#333333;"> <h2>Update A Sprinter</h2></td></tr>';

            echo
        '<tr><td>First Name: </td><td><input type="edit" name="first_name" value="' . $row[1] . '" size="30"></td></tr>
	<tr><td>Last Name: </td><td><input type="edit" name="last_name" value="' . $row[2] . '" size="30"></td></tr>
	<tr><td>position: </td><td><input type="edit" name="position" value="' . $row[3] . '" size="20"></td></tr>
	<tr><td>year: </td><td><input type="edit" name="year" value="' . $row[4] . '" size="20"></td></tr>';
            echo '
        </td></tr>
        <tr><td><input type="submit" name="AverageExecuteUpdate" class="btn btn-primary" value="Update Entry"></td> 
	</table> <input type="hidden" name="uid" value="' . $row[0] . '"> </form>
        <form action="battingaverages.php"> <input type="submit" name="BackToAverages" value="Back to Averages" class="btn btn-primary""> </form> <br> </div>';
		}
	 $result->close();
    }
}


/* ------------------------------------------------------------------------------------------------------------------- */

//ADD ENTRY IS NOT DONE YET!
function showAverageInsertForm() {
    echo '<div class="col-md-4">
        <form name="basic" method="POST" action="battingaverages.php"
        onSubmit="return validate();">
        <table class="table table-condensed" style="border: 1px solid #dddddd;
        border-radius: 5px; box-shadow: 2px 2px 10px;">
        <tr><td colspan="2" style="text-align: center; border-radius: 5px;
        color: white; background-color:#333333;"> <h2>Insert New Sprinter</h2></td></tr>';

    echo '<tr><td>First Name: </td><td><input type="edit" name="first_name" value=""
		size="30"></td></tr>
		<tr><td>Last Name: </td><td><input type="edit" name="last_name"
		value="" size="30"></td></tr>
		<tr><td>position: </td><td><input type="edit" name="position" value=""
		size="20"></td></tr>
		<tr><td>year: </td><td><input type="edit" name="year" value=""
		size="20"></td></tr>';

    echo '<tr><td><input type="submit" name="AverageExecuteInsert"
        class="btn btn-success" value="Add Entry"></td>
        <td style="text-align: right;"> </table><a href="battingaverages.php"
        class="btn btn-primary">Display Database</a></form></div>';
}

/* ------------------------------------------------------------------------------------------------------------------- */

function updateRecord($mysqli, $usertable) {
    $stmt = $mysqli->stmt_init();
    if ($stmt = $mysqli->prepare("UPDATE  $usertable SET  first_name =  '" . $_POST['first_name'] .
                                 "', last_name =  '" . $_POST['last_name'] .
                                 "', position =  '" . $_POST['position'] .
                                 "', year =  '" . $_POST['year'] .
                                 "' WHERE  $usertable.id = " . $_POST['uid'])) {
        $stmt->execute();
        $stmt->close();
    }
}

function deleteRecord($mysqli, $usertable) {
    $index = $_POST['hid'];  // "hid" is id of db record to be deleted

    $stmt = $mysqli->stmt_init();
    if ($stmt = $mysqli->prepare("DELETE FROM $usertable WHERE $usertable.id='$index'")) {
        $stmt->bind_param('i', $index);
        $stmt->execute();
        $stmt->close();
    }
}

function insertRecord($mysqli, $usertable) {
    $stmt = $mysqli->stmt_init();
	
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$position = $_POST['position'];
	$year = $_POST['year'];
	
    if ($stmt = $mysqli->prepare("INSERT INTO $usertable VALUES "
            . "(NULL, '" . $_POST['first_name'] . "', '" . $_POST['last_name'] . "', '" . $_POST['position'] . "', '" .
            $_POST['year'] . "');")) {
			
        $stmt->execute();
        $stmt->close();
    }
}
?>
