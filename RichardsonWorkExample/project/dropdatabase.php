<?php
$title='Drop Inventory Database';
include('header.php');
include('dbconnect.php');
$dsn = 'mysql:host=localhost';
    $username = 'root';
    $password = '';
    $user = 'admin';
    $pass = 'Pa11word';
try {
    $db = new PDO($dsn,$username,$password);
    $qry = 'USE inventory';
    $created = $db->exec($qry);
    echo '<p>Database inventory used!!!</p>';

    $qry = 'DROP DATABASE IF EXISTS inventory';
      
    $created = $db->exec($qry);
    echo '<p>Database inventory has been deleted!!!</p>'.'<br>';
   
   
        

} catch (PDOException $exception) {
    echo 'Error: ' . $exception->getCode() . ' | ' . $exception->getMessage();
}


// Close database
$db = NULL;

include('footer.php');
?>
