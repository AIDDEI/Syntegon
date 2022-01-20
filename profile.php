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
    </head>

    <body>
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
    <?php include_once("main_footer.php"); ?>
    </body>

</html>
