<?php
  // Connect to Inventory database
  include 'dbconnect.php';
 
  // Get method used when selecting Building to update
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Read the selected Building from the database
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

  // Update is confirmed with POST method
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update the confirmed building changes to the database
    $query ='UPDATE buildings
        SET buildingno=\'' . $_POST['buildingno'] . '\', ' .
          'buildingname=\'' . $_POST['buildingname'] . '\' ' .
          'WHERE buildingid=' . $_POST['buildingid'];
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        // Redirect to building listing page
        header('Location: buildingslistrecords.php');
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }

  // Set up title and start the HTML code for the page
  $title = 'Inventory (Buildings Update)';
  include 'header.php'; // Contains HTML for header
 
  // Display if error occured, else list the categories
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } else {
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="buildingsupdate" method="POST">
  <input type="hidden" name="buildingid" id="buildingid" value="<?php echo $result[0]['buildingid']; ?>" /><br/><br/><br/>
  Building ID:<br/>
  <strong><?php echo $result[0]['buildingid']; ?></strong><br/>
  *Building Number:<br/>
  <input type="text" name="buildingno" id="buildingno" value="<?php echo $result[0]['buildingno']; ?>" /><br/><br/><br/>
  *Building Name:<br/>
  <input type="text" name="buildingname" id="buildingname" value="<?php echo $result[0]['buildingname']; ?>"/><br><br>
  <input type="submit" class="button" value="Update Building"><br><br>
</form>
<?php
  }
   // Close the database connections
   include 'dbclose.php';
 
   // End the HTML code for the page
   include 'footer.php'; // Contains HTML for footer
 ?>