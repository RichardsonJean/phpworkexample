<?php

    // Connect to the database
    include('dbconnect.php');
    // Set up title and start HTML
    $title = 'Inventory Vendors';
    include('header.php');

    // Check for error
    if (!empty($errorMessage)) {
        echo "<p class='important'><b>Visit the \"Create Database\" link above or <a href='createdatabase.php' class='link'>click here</a> to create the \"admin\" user and \"inventory\" database so that you can access this table.</b></p>";
    } else {
        // Process database query
        $query = 'SELECT * FROM vendors ORDER BY vendorname DESC';
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
            <h1>Vendors</h1>
            <p style="font-size:20px">Data from table is ordered by Vendor Name (descending).</p><br>
            <table>
                <thead>
                    <tr>
                        <th>Vendor ID</th>
                        <th>Vendor Name</th>
                        <th>Contact</th>
                        <th>Phone</th>
                        <th><a href="vendorsadd.php">Add Vendor</a></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                        foreach($result as $vendor) {
                            echo '<tr>';
                            echo '  <td>' . $vendor['vendorid'] . '</td>';
                            echo '  <td>' . $vendor['vendorname'] . '</td>';
                            echo '  <td>' . $vendor['contact'] . '</td>';
                            echo '  <td>' . $vendor['phone'] . '</td>';
                            echo '<td><a href="vendorsupdate.php?vendorid=' . $vendor['vendorid'] . '">Update</a> | <a href="vendorsdelete.php?vendorid='. $vendor['vendorid'] . '">Delete</a></td>';
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