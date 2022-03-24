<?php
  // Connect to Inventory database
  include 'dbconnect.php';
 
  // Get method used when selecting Vendors to update
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Read the selected Vendors from the database
    $query = 'SELECT * FROM vendors
              WHERE vendorid='.$_GET['vendorid'];
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }

  // Update is confirmed with POST method
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update the confirmed vendor changes to the database
    $query ='UPDATE vendors
        SET vendorname=\'' . $_POST['vendorname'] . '\', ' .
          'contact=\'' . $_POST['contact'] . '\', ' .
          'phone=\'' . $_POST['phone'] . '\' ' .
          'WHERE vendorid=' . $_POST['vendorid'];
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        // Redirect to vendor listing page
        header('Location: vendorslistrecords.php');
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }

  // Set up title and start the HTML code for the page
  $title = 'Inventory (Vendor Update)';
  include 'header.php'; // Contains HTML for header
 
  // Display if error occured, else list the categories
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } else {
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="vendorsupdate" method="POST">
  <input type="hidden" name="vendorid" id="vendorid" value="<?php echo $result[0]['vendorid']; ?>" /><br/><br/><br/>
  Vendor ID:<br/>
  <strong><?php echo $result[0]['vendorid']; ?></strong><br/>
  *Vendor Name:<br/>
  <input type="text" name="vendorname" id="vendorname" value="<?php echo $result[0]['vendorname']; ?>" /><br/><br/><br/>
  *Contact:<br/>
  <input type="text" name="contact" id="contact" value="<?php echo $result[0]['contact']; ?>"/><br><br>
  *Phone:<br/>
  <input type="tel" name="phone" id="phone" value="<?php echo $result[0]['phone']; ?>"/><br><br>
  <input type="submit" class="button" value="Update Vendor"><br><br>
</form>
<?php
  }
   // Close the database connections
   include 'dbclose.php';
 
   // End the HTML code for the page
   include 'footer.php'; // Contains HTML for footer
 ?>