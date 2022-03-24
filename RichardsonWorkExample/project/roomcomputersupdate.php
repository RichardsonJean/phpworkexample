<?php
  // CONNECT TO DATABASE
  include 'dbconnect.php';
 
  // GET METHOD USED
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
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }

  // UPDATE IS CONFIRMED WITH "POST" METHOD
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // UPDATE THE CONFIRMED CHANGES TO THE DATABASE; ALLOWS APOSTROPHE IN DATA ENTRY
    $query = "UPDATE roomcomputers
              SET roomid=\"" . $_POST["roomid"] . "\", " .
              "buildingid=\"" . $_POST["buildingid"] . "\", " .
              "computerid=\"" . $_POST["computerid"] . "\", " .
              "count=\"" . $_POST["count"] . "\" " .
              "WHERE roomcomputerid=" . $_POST["roomcomputerid"];
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
  $title = 'Update Room Computer';
  include 'header.php';
 
  // DISPLAYS IF ERROR OCCURS, ELSE DISPLAY FORM
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } 
  else {
?>

<p style="font-size: 20px">Update data in the table <b>roomcomputers.</b></p><br>
<p style="color: red; font-weight: bold">Room ID, Building ID & Computer ID input MUST exist in the database. Building ID input MUST correspond with the selected Room ID. <a href="roomslistrecords.php">Click here</a> to browse which Building IDs correspond with Room IDs. <a href=computerslistrecords.php>Click here</a> to browse Computer IDs in the database.</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="roomcomputersupdate" method="POST">
  <input type="hidden" name="roomcomputerid" id="roomcomputerid" value="<?php echo $result[0]['roomcomputerid']; ?>" /><br>
  <b>*Room ID:</b><br>
  <input type="text" name="roomid" id="roomid" required value="<?php echo $result[0]['roomid']; ?>"> <br>
  <b>*Building ID:</b><br>
  <input type="text" name="buildingid" id="buildingid" required value="<?php echo $result[0]['buildingid']; ?>"> <br>
  <b>*Computer ID:</b><br>
  <input type="text" name="computerid" id="computerid" required value="<?php echo $result[0]['computerid']; ?>"> <br>
  <b>*Count</b><br>
  <input type="number" name="count" id="count" required value="<?php echo $result[0]['count']; ?>"> <br>
  <input type="submit" class="button" value="Update">
</form>
<?php
  }

   // CLOSE DATABASE CONNECTION & INSERT FOOTER
   include 'dbclose.php';
   include 'footer.php';
 ?>