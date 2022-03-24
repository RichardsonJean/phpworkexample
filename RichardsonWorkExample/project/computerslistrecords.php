<?php

    // Connect to the database
    include('dbconnect.php');
    // Set up title and start HTML
    $title = 'Inventory Computers';
    include('header.php');

    // Check for error
    if (!empty($errorMessage)) {
        echo "<p class='important'><b>Visit the \"Create Database\" link above or <a href='createdatabase.php' class='link'>click here</a> to create the \"admin\" user and \"inventory\" database so that you can access this table.</b></p>";
    } else {
        // Process database query
        $query = 'SELECT * FROM computers ORDER BY computerid';
        try {
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();
        } catch (PDOException $exception) {
            $errorMessage = $exception->getMessage();
        }

        if (!empty($errorMessage)) {
            display_db_error($errorMessage);
        } else {
?>       
            <h1>Computers</h1>
            <p style="font-size:20px">Data from table is ordered by Computer ID (ascending).</p><br>
            <table>
                <thead>
                    <tr>
                        <th>Computer ID</th>
                        <th>Vendor ID</th>
                        <th>Model</th>
                        <th> Memory Size</th>
                        <th>Storage Size</th>
                        <th><a href="computersadd.php">Add Computer</a></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                        foreach($result as $computer) {
                            echo '<tr>';
                            echo '  <td>' . $computer['computerid'] . '</td>';
                            echo '  <td>' . $computer['vendorid'] . '</td>';
                            echo '  <td>' . $computer['model'] . '</td>';
                            echo '  <td>' . $computer['memorysize'] . '</td>';
                            echo '  <td>' . $computer['storagesize'] . '</td>';
                            echo '<td><a href="computersupdate.php?computerid=' . $computer['computerid'] . '">Update</a> | <a href="computersdelete.php?computerid=' . $computer['computerid'] . '">Delete</a></td>';
                            echo '</tr>';
                        }
                    ?>
                    
                </tbody>
            </table>
        <br><br>
<?php
    if (count($result) <= 0) {
        echo 'No records found!!!';
    }
        }
    }

    // Close database
    include('dbclose.php');
    include('footer.php');

?>