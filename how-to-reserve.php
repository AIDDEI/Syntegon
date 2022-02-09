<?php
include_once("main_head.php");
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Hoe werkt het?</title>

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

        <div class="center">
            <h2>Nieuwe reservering maken</h2>
            <div class="divBlock">
                <h3>Hoe werkt het?</h3>
                <p>1. Kies een afdeling, datum en tijdslot</p>
                <p>2. Kies een plaats</p>
                <p>3. Klik op de knop 'maak reservering'</p>
                <p class="paddingBottom">4. Reservering gelukt!</p>
            </div>
            <a class="button" href="make-reservation.php">Nieuwe Reservering</a>
        </div>

        <footer>
            <hr>
            <img src="images/syntegon_header_logo.png" alt="Syntegon logo klein">
            <a class="footerRight" href="logout.php">Uitloggen</a>
        </footer>
    </body>

</html>
