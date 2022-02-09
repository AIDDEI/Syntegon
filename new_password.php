<?php
/** @var mysqli $db */
include_once("main_head.php");

//Get the users id
$id = $_SESSION['loggedInUser']['id'];

//Check if 'update' has been posted
if(isset($_POST['update'])){
    //Query to get the users info
    $query = mysqli_query($db, "SELECT * FROM users WHERE id='$id'");
    $user = mysqli_fetch_array($query);

    //Set variables to user input
    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword1'];
    $newPassword2 = $_POST['newPassword2'];

    //Check for errors, like empty fields
    require_once("new_password_validation.php");

    //Check if the array errors is empty
    if(empty($errors)){
        //Check if the entered old password is the same as the password inside the database
        if(password_verify($oldPassword, $user['password'])){
            //Check if the new passwords are the same
            if($newPassword1 == $newPassword2){
                //Hash the new password
                $hash = password_hash($newPassword1, PASSWORD_DEFAULT);
                //Query to update the password in the database
                $update_query = mysqli_query($db, "UPDATE users SET password='$hash' WHERE id='$id'");

                //Check if the data has been added to the database
                if($update_query){
                    header('Location: update_success.php');
                    exit;
                } else{
                    $errors['db'] = "Er is een fout opgetreden...";
                }
            } else{
                $errors['samePassword'] = "Voer twee keer hetzelfde, nieuwe wachtwoord in...";
            }
        } else{
            $errors['wrongPassword'] = "De combinatie van email en wachtwoord is bij ons niet bekend";
        }
    }
    //Close the connection to the database
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Wachtwoord Wijzigen</title>

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

        <h1>Wachtwoord wijzigen</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="password">Oud wachtwoord</label>
                <input id="password" type="password" name="oldPassword">
                <span class="errors"><?php echo $errors['oldPassword'] ?? ''; ?></span>
            </div>
            <div>
                <label for="newPassword1">Nieuw wachtwoord</label>
                <input id="newPassword1" type="password" name="newPassword1">
                <span class="errors"><?php echo $errors['newPassword1'] ?? ''; ?></span>
            </div>
            <div>
                <label for="newPassword2">Nieuw wachtwoord nog een keer</label>
                <input id="newPassword2" type="password" name="newPassword2">
                <span class="errors"><?php echo $errors['newPassword2'] ?? ''; ?></span>
            </div>
            <?php if (isset($errors['samePassword'])) { ?>
                <div><span class="errors"><?php echo $errors['samePassword']; ?></span></div>
            <?php } ?>
            <?php if (isset($errors['wrongPassword'])) { ?>
                <div><span class="errors"><?php echo $errors['wrongPassword']; ?></span></div>
            <?php } ?>
            <?php if (isset($errors['db'])) { ?>
                <div><span class="errors"><?php echo $errors['db']; ?></span></div>
            <?php } ?>
            <div>
                <input type="submit" name="update" value="Wachtwoord wijzigen"/>
            </div>
        </form>
        <br><br>
        <a href="profile.php">Terug naar 'Mijn Profiel'</a>

        <footer>
            <hr>
            <img src="images/syntegon_header_logo.png" alt="Syntegon logo klein">
            <a class="footerRight" href="logout.php">Uitloggen</a>
        </footer>
    </body>

</html>
