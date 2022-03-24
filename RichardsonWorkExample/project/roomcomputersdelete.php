<?php
  // CONNECT TO DATABASE
  include 'dbconnect.php';
   
  // CHECK IF "POST" METHOD USED
  if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // READ THE SELECTED DATA FROM THE TABLE
    $query = 'SELECT * FROM roomcomputers
              WHERE roomcomputerid='.$_GET['roomcomputerid'];
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
      } 
      catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }
     
  // DELETE IS CONFIRMED WITH "POST" METHOD
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // DELETE THE CONFIRMED DATA FROM THE DATABASE
    $query = 'DELETE FROM roomcomputers
              WHERE roomcomputerid='.$_POST['roomcomputerid'];
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        // REDIRECT TO LISTING PAGE
        header('Location: roomcomputerslistrecords.php');
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }
     
  // ADD HEADER AND TITLE
  $title = 'Delete Room Computer';
  include 'header.php';

  // DISPLAYS IF ERROR OCCURS, ELSE DISPLAY DATA AND FORM
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } 
  else {
?>

<p style="font-size:20px">Delete data from the table <b>roomcomputers.</b></p><br>
<p style="color:red; font-weight: bold"><strong>NOTE: Deleting this data may impact tables that reference this using foreign keys.</strong></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="roomcomputersdelete" method="post">
  <input type="hidden" name="roomcomputerid" id="roomcomputerid" value="<?php echo $result[0]['roomcomputerid']; ?>" /><br>
  <b>Room ID:</b> <?php echo $result[0]['roomid']; ?><br>
  <b>Building ID:</b> <?php echo $result[0]['buildingid']; ?><br>
  <b>Computer ID:</b> <?php echo $result[0]['computerid']; ?><br>
  <b>Count:</b> <?php echo $result[0]['count']; ?><br>
  <input type="submit" class="button" value="Delete">
</form>
<?php
  }

  // CLOSE DATABASE CONNECTION & INSERT FOOTER
  include 'dbclose.php';
  include 'footer.php';
?>