<?php
/** @var mysqli $db */
include_once("main_head.php");

//Get the users id
$id = $_SESSION['loggedInUser']['id'];

//Getting all the reservations of the user
$findReservations = mysqli_query($db, "SELECT reservations.id, reservations.date, reservations.start_time, 
                                            reservations.end_time, departments.name FROM reservations 
                                            INNER JOIN departments ON reservations.department_id = departments.id 
                                            WHERE user_id = '$id' AND reservations.date >= CURRENT_DATE
                                            ORDER BY reservations.date ASC");
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Uw Reserveringen</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="images/syntegon_header_logo.png">
    </head>

    <body>
        <nav class="navbar">
            <a href="home.php"><img class="syntegonNav" src="images/syntegon_logo.png" alt="Syntegon logo volledig"></a>
            <div class="flex">
                <a href="how-to-reserve.php"><img class="reservationNav" src="images/plusteken.png" alt="Nieuwe reservering maken icoon"></a>
                <a href="profile.php" class="smallerWidth"><img class="profileNav" src="images/default_avatar.png"></a>
            </div>
        </nav>
        <hr>

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
            //Setting the variables in a while loop, so that all reservations of the user appear in the overview, regardless of the amount
            while($row = mysqli_fetch_assoc($findReservations)){
            ?>
            <tr>
                <td><?php echo date('d-m-Y', strtotime(htmlentities($row['date']))); ?></td>
                <td><?php echo htmlentities($row['name']) ?></td>
                <td><?php echo date('H:i', strtotime(htmlentities($row['start_time']))) . " - " . date('H:i', strtotime(htmlentities($row['end_time']))); ?></td>
                <td><a href="reservation.php?id=<?php echo $row['id']; ?>">Bekijk</a></td>
                <td><a href="delete_reservation.php?id=<?php echo $row['id']; ?>">Annuleer</a></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>

        <footer>
            <hr>
            <img src="images/syntegon_header_logo.png" alt="Syntegon logo klein">
            <a class="footerRight" href="logout.php">Uitloggen</a>
        </footer>
    </body>

</html>
