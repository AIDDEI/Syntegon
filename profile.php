<?php
/** @var mysqli $db */
include_once("main_head.php");

//Get the 'loggedInUser' session data
$id = mysqli_escape_string($db, $_SESSION['loggedInUser']['id']);
$email = mysqli_escape_string($db, $_SESSION['loggedInUser']['email']);

//Getting all necessary user info
$profile_query = mysqli_query($db, "SELECT name, lastname, phone FROM users WHERE id='$id' AND email='$email'");
$user = mysqli_fetch_assoc($profile_query);
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Mijn Profiel</title>

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

        <div class="screenHalfLeft">
            <h2>Mijn gegevens</h2>
            <div class="block2">
                <h3><?php echo htmlentities($user['name']) . " " . htmlentities($user['lastname']); ?></h3>
                <p>
                    <?php echo htmlentities($email); ?>
                    <br>
                    <?php echo "0" . htmlentities($user['phone']); ?>
                </p>
                <br>
                <p><a href="profile_settings.php">Gegevens wijzigen</a></p>
                <p><a href="new_password.php">Wachtwoord wijzigen</a></p>
            </div>
        </div>
        <div class="screenHalfRight">
            <h2>Mijn reserveringen</h2>
            <div class="block">
                <p><a href="reservations.php">- Bekijk reserveringen</a></p>
                <p><a href="how-to-reserve.php">- Maak een nieuwe reservering</a></p>
            </div>
        </div>

        <footer>
            <hr>
            <img src="images/syntegon_header_logo.png" alt="Syntegon logo klein">
            <a class="footerRight" href="logout.php">Uitloggen</a>
        </footer>
    </body>

</html>
