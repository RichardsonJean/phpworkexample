<?php

    // Connect to the database
    include('dbconnect.php');
    // Set up title and start HTML
    $title = 'Inventory Report';
    include('headerreport.php');
?>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" name="report" method="POST">
    <br>
    <p>Please enter your building id in the input field below!</p><br>
        *Building ID:<br>
         <input type="text" name="buildingid" id="buildingid" required><br><br> 
        <input type="submit" class="button" value="Submit"><br><br>
    </form>
<?php
   

    // Check for error
    if(isset($_POST['buildingid'])) {
        if (!empty($errorMessage)) {
            echo "<p class='important'><b>Visit the \"Create Database\" link above or <a href='createdatabase.php' class='link'>click here</a> to create the \"admin\" user and \"inventory\" database so that you can access the database's records.</b></p>";
        } else {
            // Process database query
            $query = 'SELECT b.buildingid, buildingno, buildingname, r.roomid, roomnumber, capacity, vendorname, model, memorysize, storagesize, count
                FROM buildings b, rooms r, roomcomputers rc, computers c, vendors v
                WHERE b.buildingid= r.buildingid AND r.buildingid=rc.buildingid AND r.roomid=rc.roomid AND rc.computerid=c.computerid
                    AND c.vendorid=v.vendorid
                    AND b.buildingid ='.$_POST['buildingid'];
            
           
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
                <h1>Report</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Building ID</th>
                            <th>Building Number</th>
                            <th>Building Name</th>
                            <th>Room ID</th>
                            <th>Room Number</th>
                            <th>Capacity</th>
                            <th>Vendor Name</th>
                            <th>Model</th>
                            <th>Memory Size</th>
                            <th>Storage Size</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                    
                            foreach($result as $report) {
                                echo '<tr>';
                                echo '  <td>' . $report['buildingid'] . '</td>';
                                echo '  <td>' . $report['buildingno'] . '</td>';
                                echo '  <td>' . $report['buildingname'] . '</td>';
                                echo '  <td>' . $report['roomid'] . '</td>';
                                echo '  <td>' . $report['roomnumber'] . '</td>';
                                echo '  <td>' . $report['capacity'] . '</td>';
                                echo '  <td>' . $report['vendorname'] . '</td>';
                                echo '  <td>' . $report['model'] . '</td>';
                                echo '  <td>' . $report['memorysize'] . '</td>';
                                echo '  <td>' . $report['storagesize'] . '</td>';
                                echo '  <td>' . $report['count'] . '</td>';
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
       
    }
    

    // Close database
    
    include('dbclose.php');
    include('footer.php');

?>