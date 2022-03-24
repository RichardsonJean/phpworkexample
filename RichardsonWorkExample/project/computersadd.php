<?php
    // CONNECT TO DATABASE
    include('dbconnect.php');

    // CHECK IF "POST" METHOD USED
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // INSERT DATA FROM FORM
        $vendorid = $_POST['vendorid'];
        $model = $_POST['model'];
        $memorysize = $_POST['memorysize'];
        $storagesize = $_POST['storagesize'];
        $query = "INSERT INTO computers
                     (vendorid, model, memorysize, storagesize)
                  VALUES
                     (\"$vendorid\",\"$model\",\"$memorysize\",\"$storagesize\")"; // ALLOWS APOSTROPHE IN DATA ENTRY
        $insert_count = $db->exec($query);
        if ($insert_count < 1) {
            $errorMessage = 'Error inserting into table.';
        } else {
            header('Location: computerslistrecords.php');
        }
    }

    // ADD HEADER AND TITLE
    $title = 'Add Computer';
    include('header.php');

    // DISPLAYS IF ERROR OCCURS, ELSE DISPLAY FORM
    if (!empty($errorMessage)) {
        display_db_error($errorMessage);
    } else {
?>

<p style="font-size: 20px">Add data to the table <b>computers.</b></p><br>
<p style="color: red; font-weight: bold">Vendor ID input should already exist in the database.</p><br>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="computersadd" method="POST">
            <b>*Vendor ID:</b><br>
            <input type="text" name="vendorid" id="vendorid" required> <br>
            <b>*Model:</b><br>
            <input type="text" name="model" id="model" required> <br>
            <b>*Memory Size</b><br>
            <input type="text" name="memorysize" id="memorysize" required> <br>
            <b>*Storage Size</b><br>
            <input type="text" name="storagesize" id="storagesize" required> <br>
            <input type="submit" class="button" value="Add">
        </form>
<?php
    }

    // CLOSE DATABASE CONNECTION & INSERT FOOTER
    include('dbclose.php');
    include('footer.php');

?>