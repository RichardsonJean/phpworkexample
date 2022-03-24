<?php
  // CONNECT TO DATABASE
  include 'dbconnect.php';
 
  // GET METHOD USED
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    // READ THE SELECTED DATA FROM THE TABLE
    $query = 'SELECT * FROM rooms
              WHERE roomid='.$_GET['roomid'];
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
    $query = "UPDATE rooms
              SET buildingid=\"" . $_POST["buildingid"] . "\", " .
              "roomnumber=\"" . $_POST["roomnumber"] . "\", " .
              "capacity=\"" . $_POST["capacity"] . "\" " .
              "WHERE roomid=" . $_POST["roomid"];
    if (empty($errorMessage)) {
      try {
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        // REDIRECT TO LISTING PAGE
        header('Location: roomslistrecords.php');
      } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
      }
    }
  }

  // ADD HEADER AND TITLE
  $title = 'Update Room';
  include 'header.php';
 
  // DISPLAYS IF ERROR OCCURS, ELSE DISPLAY FORM
  if (!empty($errorMessage)) {
    display_db_error($errorMessage);
  } 
  else {
?>

<p style="font-size:20px">Update data in the table <b>rooms.</b></p><br>
<p style="color: red; font-weight: bold"> Building ID input should already exist in the database.</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="roomsupdate" method="POST">
  <input type="hidden" name="roomid" id="roomid" value="<?php echo $result[0]['roomid']; ?>" /><br>
  <b>Room ID:</b> <?php echo $result[0]['roomid']; ?><br/><br>
  <b>*Building ID:</b><br>
  <input type="text" name="buildingid" id="buildingid" required value="<?php echo $result[0]['buildingid']; ?>"> <br>
  <b>*Room Number:</b><br>
  <input type="text" name="roomnumber" id="roomnumber" required value="<?php echo $result[0]['roomnumber']; ?>"> <br>
  <b>*Capacity</b><br>
  <input type="number" name="capacity" id="capacity" required value="<?php echo $result[0]['capacity']; ?>"> <br>
  <input type="submit" class="button" value="Update">
</form>
<?php
  }

   // CLOSE DATABASE CONNECTION & INSERT FOOTER
   include 'dbclose.php';
   include 'footer.php';
 ?>