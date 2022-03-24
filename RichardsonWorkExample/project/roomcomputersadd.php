<?php
    // CONNECT TO DATABASE
    include('dbconnect.php');

    // CHECK IF "POST" METHOD USED
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // INSERT DATA FROM FORM
        $roomid = $_POST['roomid'];
        $buildingid = $_POST['buildingid'];
        $computerid = $_POST['computerid'];
        $count = $_POST['count'];
        $query = "INSERT INTO roomcomputers
                     (roomid, buildingid, computerid, count)
                  VALUES
                     (\"$roomid\",\"$buildingid\",\"$computerid\",\"$count\")"; // ALLOWS APOSTROPHE IN DATA ENTRY
        $insert_count = $db->exec($query);
        if ($insert_count < 1) {
            $errorMessage = 'Error inserting into table.';
        } else {
            header('Location: roomcomputerslistrecords.php');
        }
    }

    // ADD HEADER AND TITLE
    $title = 'Add Room Computer';
    include('header.php');

    // DISPLAYS IF ERROR OCCURS, ELSE DISPLAY FORM
    if (!empty($errorMessage)) {
        display_db_error($errorMessage);
    } else {
?>

<p style="font-size: 20px">Add data to the table <b>roomcomputers.</b></p><br>
<p style="color: red; font-weight: bold">Room ID, Building ID & Computer ID input MUST exist in the database. Building ID input MUST correspond with the selected Room ID. <a href="roomslistrecords.php">Click here</a> to browse which Building IDs correspond with Room IDs. <a href=computerslistrecords.php>Click here</a> to browse Computer IDs in the database.</p><br>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="roomcomputersadd" method="POST">
        <b>*Room ID:</b><br>
        <input type="text" name="roomid" id="roomid" required> <br>
        <b>*Building ID:</b><br>
        <input type="text" name="buildingid" id="buildingid" required> <br>
        <b>*Computer ID:</b><br>
        <input type="text" name="computerid" id="computerid" required> <br>
        <b>*Count</b><br>
        <input type="number" name="count" id="count" required> <br>
        <input type="submit" class="button" value="Add">
    </form>
<?php
    }

    // CLOSE DATABASE CONNECTION & INSERT FOOTER
    include('dbclose.php');
    include('footer.php');

?>