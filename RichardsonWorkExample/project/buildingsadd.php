<?php
    // Connect
    include('dbconnect.php');

    // Check if POST method used then insert
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Insert record
        $number = $_POST['buildingno'];
        $name = $_POST['buildingname'];
        $query = "INSERT INTO buildings
                     (buildingno, buildingname)
                  VALUES
                     ('$number', '$name')";
        $insert_count = $db->exec($query);
        if ($insert_count < 1) {
            $errorMessage = 'Error inserting movie';
        } else {
            header('Location: buildingslistrecords.php');
        }
    }
    $title = 'Inventory (Building Add)';
    include('header.php');

    if (!empty($errorMessage)) {
        display_db_error($errorMessage);
    } else {
?>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="buildingsadd" method="POST">
            *Number:<br>
            <input type="text" name="buildingno" id="buildingno" required><br>
            *Name:<br>
            <input type="text" name="buildingname" id="buildingname" required ><br><br> 
            <input type="submit" class="button" value="Add Building"><br><br>
        </form>
<?php
    }

    // Close
    include('dbclose.php');
    include('footer.php');

?>