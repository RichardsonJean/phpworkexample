<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <title>Richardson Project</title>
    <style>
        table {
          table-layout: fixed;
          width: 100%;
        }
        tr > * + * {
	        padding-left: 0;
        }
    </style>
</head>
<body>
<header>
<!-- Content to be displayed in header -->  
<h1>Richardson Project</h1>
</header>
<nav id="main_nav">
    <ul>
      <li><a href="index.php">Index</a></li>
      <li><a href="createdatabase.php">Create Database</a></li>
      <li><a href="report.php">Report</a></li>
      <li><a href="buildingslistrecords.php">Buildings Table</a></li>
      <li><a href="roomslistrecords.php">Rooms Table</a></li>
      <li><a href="roomcomputerslistrecords.php">Room Computers Table</a></li>
      <li><a href="computerslistrecords.php">Computers Table</a></li>
      <li><a href="vendorslistrecords.php">Vendors Table</a></li>
    </ul>
    <div class="myclear"></div>
  </nav>
<main>
<h1><?php echo $title; ?></h1>