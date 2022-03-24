<?php
  // Connect to Inventory database
  include 'dbconnect.php';
   
  // Get method used when selecting Inventory to delete
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Read the selected Inventory from the database
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
     
  // Delete is confirmed with POST method
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Delete the confirmed Vendor from the database
    $query = 'DELETE FROM vendors
              WHERE vendorid='. $_POST['vendorid'];
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        // Redirect to Vendor listing page
        header('Location: vendorslistrecords.php');
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }
     
  // Set up title and start the HTML code for the page
  $title = 'Inventory (Vendor Delete)';
  include 'header.php'; // Contains HTML for header

  // Display if error occured, else list the categories
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } else {
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="vendorsdelete" method="post">
  <input type="hidden" name="vendorid" id="vendorid" value="<?php echo $result[0]['vendorid']; ?>" /><br/>
   ID: <strong><?php echo $result[0]['vendorid']; ?></strong><br/><br/>
  Name: <strong><?php echo $result[0]['vendorname']; ?></strong><br/><br/>
  Contact: <strong><?php echo $result[0]['contact']; ?></strong><br><br>
  Phone: <strong><?php echo $result[0]['phone']; ?></strong><br><br>
  <input type="submit" class="button" value="Delete Vendor"><br><br>
</form>
<?php
  }

  // Close the database connections
  include 'dbclose.php';
 
  // End the HTML code for the page
  include 'footer.php'; // Contains HTML for footer
?>