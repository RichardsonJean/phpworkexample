<?php
    $database = 'inventory';
    $dsn = 'mysql:host=localhost;dbname=' . $database;
    $user = 'admin';
    $pass = 'Pa11word';
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $errorMessage = '';
        $db = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $exception) {
        $errorMessage = $exception->getMessage();
    }

    function display_db_error($errorMessage) {
        echo '<h2>Error</h2>';
        echo "<p>$errorMessage</p>";
    }
?>