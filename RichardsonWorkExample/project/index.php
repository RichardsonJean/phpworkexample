<?php
    $title = "Home Page";
    include('header.php');
?>

<p>You must create the <b>inventory</b> database before you can view its contents. <a href="createdatabase.php"><b>Click here</b></a> or the button below to create the <b>inventory</b> database so that you can browse the database's tables, listed below and in the navigation bar.</p>
<a class="button" href="createdatabase.php">Create Database</a><br><br>

<hr>

<p>View table listings for the <b>inventory</b> database:</p>
<a class="button" href="buildingslistrecords.php">Buildings table</a>
<a class="button" href="roomslistrecords.php">Rooms table</a>
<a class="button" href="roomcomputerslistrecords.php">Room Computers table</a>
<a class="button" href="computerslistrecords.php">Computers table</a>
<a class="button" href="vendorslistrecords.php">Vendors table</a>
  
<br><br><hr>

<p>View a report of the <b>inventory</b> database:</p>
<a class="button" href="report.php">Report page</a>

<br><br><hr>
<p>Drop the <b>inventory</b> database using the button below:</p>
<a class="button" href="dropdatabase.php">Drop Database</a><br><br>

<?php
    include('footer.php')
?>