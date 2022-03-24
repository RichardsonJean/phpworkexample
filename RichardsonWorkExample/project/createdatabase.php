<?php
    $title = 'Create Inventory Database';
    $database = 'inventory';
    include('header.php');


    $dsn = 'mysql:host=localhost';
    $username = 'root';
    $password = '';
    $user = 'admin';
    $pass = 'Pa11word';

    try {
        $db = new PDO($dsn,$username,$password);

        $db->exec("CREATE DATABASE IF NOT EXISTS `$database`;
        CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
        GRANT ALL ON *.* TO '$user'@'localhost';
        FLUSH PRIVILEGES;");


        echo '<p>New user <b>' . $user . '</b> has been created and granted full access.</p>';
        echo '<p>Database <b>' . $database . '</b> has been created.</p>';

        $db = NULL;
        $db = new PDO($dsn,$user,$pass);
      
        $qry = 'USE ' . $database;
        $created = $db->exec($qry);

        // CREATE BUILDINGS TABLE
        $qry = 'CREATE TABLE IF NOT EXISTS buildings (buildingid INT primary key auto_increment, buildingno INT not null, buildingname VARCHAR(50) not null)';
        $created = $db->exec($qry);
        echo '<p>Table <b>buildings</b> has been created.</p>';

        // CREATE ROOMS TABLE
        $qry = 'CREATE TABLE IF NOT EXISTS rooms (roomid INT primary key auto_increment, buildingid INT, roomnumber INT not null, capacity INT not null, FOREIGN KEY (buildingid) REFERENCES buildings (buildingid) ON DELETE SET NULL)';
        $created = $db->exec($qry);
        echo '<p>Table <b>rooms</b> has been created.</p>';

        // CREATE VENDORS TABLE
        $qry = 'CREATE TABLE IF NOT EXISTS vendors (vendorid INT primary key auto_increment, vendorname VARCHAR(30) not null, contact VARCHAR(50) not null, phone VARCHAR(20) not null)';
        $created = $db->exec($qry);
        echo '<p>Table <b>vendors</b> has been created.</p>';

        // CREATE COMPUTERS TABLE
        $qry = 'CREATE TABLE IF NOT EXISTS computers (computerid INT primary key auto_increment, vendorid INT, model VARCHAR(50) not null, memorysize VARCHAR(20) not null, storagesize VARCHAR(20) not null, FOREIGN KEY (vendorid) REFERENCES vendors (vendorid) ON DELETE SET NULL)';
        $created = $db->exec($qry);
        echo '<p>Table <b>computers</b> has been created.</p>';

        // CREATE ROOMCOMPUTERS TABLE
        $qry = 'CREATE TABLE IF NOT EXISTS roomcomputers (roomcomputerid INT primary key auto_increment, roomid INT, buildingid INT, computerid INT, count INT not null, FOREIGN KEY (roomid) REFERENCES rooms (roomid) ON DELETE SET NULL, FOREIGN KEY (buildingid) REFERENCES buildings (buildingid) ON DELETE SET NULL, FOREIGN KEY (computerid) REFERENCES computers (computerid) ON DELETE SET NULL)';
        $created = $db->exec($qry);
        echo '<p>Table <b>roomcomputers</b> has been created.</p>';


        // AUTO INSERT DATA INTO BUILDINGS TABLE
        $query = "INSERT IGNORE INTO buildings
                    (buildingid, buildingno, buildingname)
                  VALUES
                    ('1', '1', 'Central Campus'),
                    ('2', '2', 'North Campus')";
        $insert_count = $db->exec($query); 

        // AUTO INSERT DATA INTO ROOMS TABLE
        $query = "INSERT IGNORE INTO rooms
                    (roomid, buildingid, roomnumber, capacity)
                  VALUES
                    ('1', '1', '101', '35'),
                    ('2', '1', '103', '40'),
                    ('3', '2', '1001', '42')";
        $insert_count = $db->exec($query); 

        // AUTO INSERT DATA INTO VENDORS TABLE
        $query = "INSERT IGNORE INTO vendors
                    (vendorid, vendorname, contact, phone)
                  VALUES
                    ('1', 'Apex Computer Supply Co.', 'Office', '954-111-1111')";
        $insert_count = $db->exec($query); 

        // AUTO INSERT DATA INTO COMPUTERS TABLE
        $query = "INSERT IGNORE INTO computers
                    (computerid, vendorid, model, memorysize, storagesize)
                  VALUES
                    ('1', '1', 'MGPL3LL/A', '8 GB', '512 GB'),
                    ('2', '1', 'F0EK007HUS', '12 GB', '256 GB')";
        $insert_count = $db->exec($query); 

        // AUTO INSERT DATA INTO ROOMCOMPUTERS TABLE
        $query = "INSERT IGNORE INTO roomcomputers
                    (roomcomputerid, roomid, buildingid, computerid, count)
                  VALUES
                    ('1', '1', '1', '1', '36'),
                    ('2', '2', '1', '2', '41')";
        $insert_count = $db->exec($query); 


         echo '<p>Data added to tables.</p><br>';
         echo '<p>You can now access the tables for the <b>inventory</b> database.';

    } 
    catch (PDOException $exception) {
        echo 'Error: ' . $exception->getCode() . ' | ' . $exception->getMessage();
    }

    // Close database
    $db = NULL;

    include('footer.php');
?>