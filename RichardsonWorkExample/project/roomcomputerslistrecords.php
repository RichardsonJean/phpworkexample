<?php

    // CONNECT TO DATABASE & ADD HEADER AND TITLE
    $title = 'Room Computers table data';
    include('header.php');
    include('dbconnect.php');

    // CHECK FOR ERROR
    if (!empty($errorMessage)) {
        echo "<p class='important'><b>Visit the \"Create Database\" link above or <a href='createdatabase.php' class='link'>click here</a> to create the \"admin\" user and \"inventory\" database so that you can access this table.</b></p>";
    } 
    else {
        // PROCESS DATABASE QUERY
        $query = 'SELECT * FROM roomcomputers ORDER BY buildingid ASC';
        try {
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();
            
        } 
        catch (PDOException $exception) {
            $errorMessage = $exception->getMessage();
            
        }

        if (!empty($errorMessage)) {
            display_db_error($errorMessage);
        } 
        else {
?>

        <p style="font-size:20px">Data from table is ordered by Building ID (ascending).</p><br>
        <table>
            <thead>
                <tr>
                    <th>Room ID</th>
                    <th>Building ID</th>
                    <th>Computer ID</th>
                    <th>Count</th>
                    <th><a href="roomcomputersadd.php">Add Room Computer</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($result as $roomcomputer) {
                        echo '<tr>';
                        echo '  <td>' . $roomcomputer['roomid'] . '</td>';
                        echo '  <td>' . $roomcomputer['buildingid'] . '</td>';
                        echo '  <td>' . $roomcomputer['computerid'] . '</td>';
                        echo '  <td>' . $roomcomputer['count'] . '</td>';
                        echo '<td><a href="roomcomputersupdate.php?roomcomputerid=' . $roomcomputer['roomcomputerid'] . '">Update</a> | <a href="roomcomputersdelete.php?roomcomputerid=' . $roomcomputer['roomcomputerid'] . '">Delete</a></td>';
                        echo '</tr>';
                    }
                ?>
        </tbody>
        </table>
<?php
    if (count($result) <= 0) {
        echo '<p>There are no records in this table.</p>';
    }
        }
    }

    // CLOSE DATABASE CONNECTION & INSERT FOOTER
    include('dbclose.php');
    include('footer.php');

?>