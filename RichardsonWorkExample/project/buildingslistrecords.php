<?php

    // Connect to the database
    include('dbconnect.php');
    // Set up title and start HTML
    $title = 'Inventory Buildings';
    include('header.php');

    // Check for error
    if (!empty($errorMessage)) {
        echo "<p class='important'><b>Visit the \"Create Database\" link above or <a href='createdatabase.php' class='link'>click here</a> to create the \"admin\" user and \"inventory\" database so that you can access this table.</b></p>";
    } else {
        // Process database query
        $query = 'SELECT * FROM buildings ORDER BY buildingname ASC';
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
            <h1>Buildings</h1>
            <p style="font-size:20px">Data from table is ordered by Building Name (ascending).</p><br>
            <table>
                <thead>
                    <tr>
                        <th>Building ID</th>
                        <th>Building Number</th>
                        <th>Building Name</th>
                        <th><a href="buildingsadd.php">Add Building</a></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                        foreach($result as $building) {
                            echo '<tr>';
                            echo '  <td>' . $building['buildingid'] . '</td>';
                            echo '  <td>' . $building['buildingno'] . '</td>';
                            echo '  <td>' . $building['buildingname'] . '</td>';
                            echo '<td><a href="buildingsupdate.php?buildingid=' . $building['buildingid'] . '">Update</a> | <a href="buildingsdelete.php?buildingid=' . $building['buildingid'] . '">Delete</a></td>';
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