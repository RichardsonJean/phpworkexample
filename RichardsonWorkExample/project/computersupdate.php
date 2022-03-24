<?php
  // CONNECT TO DATABASE
  include 'dbconnect.php';
 
  // GET METHOD USED
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    // READ THE SELECTED DATA FROM THE TABLE
    $query = 'SELECT * FROM computers
              WHERE computerid='.$_GET['computerid'];
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

  // UPDATE IS CONFIRMED WITH "POST" METHOD
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // UPDATE THE CONFIRMED CHANGES TO THE DATABASE; ALLOWS APOSTROPHE IN DATA ENTRY
    $query = "UPDATE computers
              SET vendorid=\"" . $_POST["vendorid"] . "\", " .
              "model=\"" . $_POST["model"] . "\", " .
              "memorysize=\"" . $_POST["memorysize"] . "\", " .
              "storagesize=\"" . $_POST["storagesize"] . "\" " .
              "WHERE computerid=" . $_POST["computerid"];
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        // REDIRECT TO LISTING PAGE
        header('Location: computerslistrecords.php');
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }

  // ADD HEADER AND TITLE
  $title = 'Update Computer';
  include 'header.php';
 
  // DISPLAYS IF ERROR OCCURS, ELSE DISPLAY FORM
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } 
  else {
?>

<p style="font-size:20px">Update data in the table <b>computers.</b></p><br>
<p style="color: red; font-weight: bold">Vendor ID input should already exist in the database.</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="computersupdate" method="POST">
  <input type="hidden" name="computerid" id="computerid" value="<?php echo $result[0]['computerid']; ?>" /><br>
  <b>Computer ID:</b> <?php echo $result[0]['computerid']; ?><br/><br>
  <b>*Vendor ID:</b><br>
  <input type="text" name="vendorid" id="vendorid" required value="<?php echo $result[0]['vendorid']; ?>"> <br>
  <b>*Model:</b><br>
  <input type="text" name="model" id="model" required value="<?php echo $result[0]['model']; ?>"> <br>
  <b>*Memory Size:</b><br>
  <input type="text" name="memorysize" id="memorysize" required value="<?php echo $result[0]['memorysize']; ?>"> <br>
  <b>*Storage Size</b><br>
  <input type="text" name="storagesize" id="storagesize" required value="<?php echo $result[0]['storagesize']; ?>"> <br>
  <input type="submit" class="button" value="Update">
</form>
<?php
  }

   // CLOSE DATABASE CONNECTION & INSERT FOOTER
   include 'dbclose.php';
   include 'footer.php';
 ?>