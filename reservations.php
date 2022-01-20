<?php
/** @var mysqli $db */
include_once("main_head.php");

$id = $_SESSION['loggedInUser']['id'];
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Uw Reserveringen</title>
    </head>

    <body>
        <h1>Uw Reserveringen</h1>
        <table>
            <thead>
            <tr>
                <th>Datum</th>
                <th>Afdeling</th>
                <th>Tijd</th>
                <th>Details</th>
                <th>Annuleren</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $findReservations = mysqli_query($db, "SELECT reservations.id, reservations.date, reservations.start_time, 
                                                        reservations.end_time, departments.name FROM reservations 
                                                        INNER JOIN departments ON reservations.department_id = departments.id 
                                                        WHERE user_id = '$id' AND reservations.date >= CURRENT_DATE
                                                        ORDER BY reservations.date ASC");
            while($row = mysqli_fetch_assoc($findReservations)){
                $reservation_id = $row['id'];
                $date = $row['date'];
                $new_date = date('d-m-Y', strtotime($date));
                $department = $row['name'];
                $startTime = $row['start_time'];
                $new_startTime = date('H:i', strtotime($startTime));
                $endTime = $row['end_time'];
                $new_endTime = date('H:i', strtotime($endTime));
            ?>
            <tr>
                <td><?php echo htmlentities($new_date); ?></td>
                <td><?php echo htmlentities($department) ?></td>
                <td><?php echo htmlentities($new_startTime) . " - " . htmlentities($new_endTime); ?></td>
                <td><a href="reservation.php?id=<?php echo $reservation_id; ?>">Bekijk</a></td>
                <td><a href="delete_reservation.php?id=<?php echo $reservation_id; ?>">Annuleer</a></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>

        <?php include_once("main_footer.php"); ?>
    </body>

</html>
