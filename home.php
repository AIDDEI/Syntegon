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

//Query for a quick overview of all reservations of the user
$reservation_query = mysqli_query($db, "SELECT date, start_time, end_time FROM reservations WHERE user_id='$id' AND date >= CURRENT_DATE ORDER BY date ASC");
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Home</title>

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
                    //Setting the variables in a while loop, so that all reservations of the user appear in the overview, regardless of the amount
                    while($row = mysqli_fetch_assoc($reservation_query)){
                    ?>
                    <tr>
                        <td><?php echo strftime('%A', strtotime(htmlentities($row['date']))); ?></td>
                        <td><?php echo date('d-m-Y', strtotime(htmlentities($row['date']))); ?></td>
                        <td><?php echo date('H:i', strtotime(htmlentities($row['start_time']))) . " - " . date('H:i', strtotime(htmlentities($row['end_time']))); ?></td>
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

        <footer>
            <hr>
            <img src="images/syntegon_header_logo.png" alt="Syntegon logo klein">
            <a class="footerRight" href="logout.php">Uitloggen</a>
        </footer>
    </body>

</html>
