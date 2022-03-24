<?php
    // Connect
    include('dbconnect.php');

    // Check if POST method used then insert
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Insert record
        $name = $_POST['vendorname'];
        $contact = $_POST['contact'];
        $tel = $_POST['phone'];
        $query = "INSERT INTO vendors
                     (vendorname, contact, phone)
                  VALUES
                     ('$name', '$contact', '$tel')";
        $insert_count = $db->exec($query);
        if ($insert_count < 1) {
            $errorMessage = 'Error inserting movie';
        } else {
            header('Location: vendorslistrecords.php');
        }
    }
    $title = 'Inventory (Vendor Add)';
    include('header.php');

    if (!empty($errorMessage)) {
        display_db_error($errorMessage);
    } else {
?>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="vendorsadd" method="POST">
            *Name:<br>
            <input type="text" name="vendorname" id="vendorname" required><br>
            *Contact:<br>
            <input type="text" name="contact" id="contact" required><br><br>
            *Phone:<br>
            <input type="tel" name="phone" id="phone" required><br><br> 
            <input type="submit" class="button" value="Add Vendor"><br><br>
        </form>
<?php
    }

    // Close
    include('dbclose.php');
    include('footer.php');

?>