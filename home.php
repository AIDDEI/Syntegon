<?php
/** @var mysqli $db */
include_once("main_head.php");

//Get the correct id and e-mail of the user
$id = mysqli_escape_string($db, $_SESSION['loggedInUser']['id']);
$email = mysqli_escape_string($db, $_SESSION['loggedInUser']['email']);

//Different greeting based on the time
$currentTime = date('H');
if($currentTime >= 00 && $currentTime < 06){
    $greeting = "Goedenacht ";
} elseif ($currentTime >= 06 && $currentTime < 12){
    $greeting = "Goedemorgen ";
} elseif ($currentTime >= 12 && $currentTime < 17){
    $greeting = "Goedemiddag ";
} elseif ($currentTime >= 17){
    $greeting = "Goedenavond ";
}

//Fetching all necessary data of the user
$user_query = mysqli_query($db, "SELECT name, lastname FROM users WHERE id='$id' AND email='$email'");
$user = mysqli_fetch_assoc($user_query);

//Set the language of the date to Dutch
setlocale(LC_TIME, 'NL_nl');
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Home</title>
    </head>

    <body>
        <h1><?php echo  htmlentities($greeting) . htmlentities($user['name']) . " " . htmlentities($user['lastname']); ?></h1>
        <div class="screenHalfLeft">
            <h2><a href="reservations.php">Uw Reserveringen</a></h2>
            <div class="block">
                <table>
                    <thead>
                    <tr>
                        <th>Dag</th>
                        <th>Datum</th>
                        <th>Tijd</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //Query for a quick overview of all reservations of the user
                    $reservation_query = mysqli_query($db, "SELECT date, start_time, end_time FROM reservations WHERE user_id='$id' AND date >= CURRENT_DATE ORDER BY date ASC");
                    //Setting the variables in a while loop, so that all reservations of the user appear in the overview, regardless of the amount
                    while($row = mysqli_fetch_assoc($reservation_query)){
                        $reservation_date = $row['date'];
                        $reservation_start_time = $row['start_time'];
                        $reservation_end_time = $row['end_time'];

                        $date_converted = date('d-m-Y', strtotime($reservation_date));
                        $date_written = strftime('%A', strtotime($reservation_date));
                        $time_converted = date('H:i', strtotime($reservation_start_time)) . " - " . date('H:i', strtotime($reservation_end_time));
                    ?>
                    <tr>
                        <td><?php echo htmlentities($date_written); ?></td>
                        <td><?php echo htmlentities($date_converted); ?></td>
                        <td><?php echo htmlentities($time_converted); ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="screenHalfRight">
            <h2><a href="how-to-reserve.php">Nieuwe reservering</a></h2>
            <h2><a href="profile.php">Naar 'Mijn Profiel'</a></h2>
        </div>
        <?php include_once("main_footer.php"); ?>
    </body>

</html>
