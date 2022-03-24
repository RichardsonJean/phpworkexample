<?php
  // Connect to Inventory database
  include 'dbconnect.php';
   
  // Get method used when selecting Inventory to delete
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Read the selected Inventory from the database
    $query = 'SELECT * FROM buildings
              WHERE buildingid='.$_GET['buildingid'];
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
    // Delete the confirmed Building from the database
    $query = 'DELETE FROM buildings
              WHERE buildingid='.$_POST['buildingid'];
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        // Redirect to Building listing page
        header('Location: buildingslistrecords.php');
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }
     
  // Set up title and start the HTML code for the page
  $title = 'Inventory (Building Delete)';
  include 'header.php'; // Contains HTML for header

  // Display if error occured, else list the categories
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } else {
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="buildingsdelete" method="post">
  <input type="hidden" name="buildingid" id="buildingid" value="<?php echo $result[0]['buildingid']; ?>" /><br/>
  Building ID: <strong><?php echo $result[0]['buildingid']; ?></strong><br/><br/>
  Building Number: <strong><?php echo $result[0]['buildingno']; ?></strong><br/><br/>
  Building Name: <strong><?php echo $result[0]['buildingname']; ?></strong><br><br>
  <input type="submit" class="button" value="Delete Building"><br><br>
</form>
<?php
  }

  // Close the database connections
  include 'dbclose.php';
 
  // End the HTML code for the page
  include 'footer.php'; // Contains HTML for footer
?>