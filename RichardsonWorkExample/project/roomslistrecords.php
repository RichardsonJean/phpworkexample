<?php

    // CONNECT TO DATABASE & ADD HEADER AND TITLE
    $title = 'Rooms table data';
    include('header.php');
    include('dbconnect.php');

    // CHECK FOR ERROR
    if (!empty($errorMessage)) {
        echo "<p class='important'><b>Visit the \"Create Database\" link above or <a href='createdatabase.php' class='link'>click here</a> to create the \"admin\" user and \"inventory\" database so that you can access this table.</b></p>";
    } 
    else {
        // PROCESS DATABASE QUERY
        $query = 'SELECT * FROM rooms ORDER BY capacity ASC';
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

        <p style="font-size:20px">Data from table is ordered by Room Capacity (ascending).</p><br>
        <table>
            <thead>
                <tr>
                    <th>Room ID</th>
                    <th>Building ID</th>
                    <th>Room Number</th>
                    <th>Capacity</th>
                    <th><a href="roomsadd.php">Add Room</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($result as $room) {
                        echo '<tr>';
                        echo '  <td>' . $room['roomid'] . '</td>';
                        echo '  <td>' . $room['buildingid'] . '</td>';
                        echo '  <td>' . $room['roomnumber'] . '</td>';
                        echo '  <td>' . $room['capacity'] . '</td>';
                        echo '<td><a href="roomsupdate.php?roomid=' . $room['roomid'] . '">Update</a> | <a href="roomsdelete.php?roomid=' . $room['roomid'] . '">Delete</a></td>';
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