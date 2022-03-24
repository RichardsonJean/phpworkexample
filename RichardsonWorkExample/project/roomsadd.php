<?php
    // CONNECT TO DATABASE
    include('dbconnect.php');

    // CHECK IF "POST" METHOD USED
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // INSERT DATA FROM FORM
        $buildingid = $_POST['buildingid'];
        $roomnumber = $_POST['roomnumber'];
        $capacity = $_POST['capacity'];
        $query = "INSERT INTO rooms
                     (buildingid, roomnumber, capacity)
                  VALUES
                     (\"$buildingid\",\"$roomnumber\",\"$capacity\")"; // ALLOWS APOSTROPHE IN DATA ENTRY
        $insert_count = $db->exec($query);
        if ($insert_count < 1) {
            $errorMessage = 'Error inserting into table.';
        } else {
            header('Location: roomslistrecords.php');
        }
    }

    // ADD HEADER AND TITLE
    $title = 'Add Room';
    include('header.php');

    // DISPLAYS IF ERROR OCCURS, ELSE DISPLAY FORM
    if (!empty($errorMessage)) {
        display_db_error($errorMessage);
    } else {
?>

<p style="font-size: 20px">Add data to the table <b>rooms.</b></p><br>
<p style="color: red; font-weight: bold"> Building ID input should already exist in the database.</p><br>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="roomsadd" method="POST">
            <b>*Building ID:</b><br>
            <input type="text" name="buildingid" id="buildingid" required> <br>
            <b>*Room Number:</b><br>
            <input type="text" name="roomnumber" id="roomnumber" required> <br>
            <b>*Capacity</b><br>
            <input type="number" name="capacity" id="capacity" required> <br>
            <input type="submit" class="button" value="Add">
        </form>
<?php
    }

    // CLOSE DATABASE CONNECTION & INSERT FOOTER
    include('dbclose.php');
    include('footer.php');

?>