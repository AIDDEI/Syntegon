<?php
session_start();

if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

/** @var mysqli $db */
require_once("config.php");

if (isset($_POST['submit'])) {
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = mysqli_escape_string($db, $_POST['password']);

    $errors = [];
    if($email == '') {
        $errors['email'] = 'Voer uw e-mailadres in';
    }
    if($password == '') {
        $errors['password'] = 'Voer uw wachtwoord in';
    }

    if(empty($errors))
    {
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $login = true;

                $_SESSION['loggedInUser'] = [
                    'email' => $user['email'],
                    'id' => $user['id']
                ];
                header('location: home.php');
            } else {
                $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend';
            }
        } else {
            $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="nl">

    <head>

        <title>Syntegon | Schiedam | Aanmelden</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="images/syntegon_header_logo.png">

    </head>

    <body class="caribbeanGreenBackGround">
        <img class="imgLogin" src="images/syntegon_logo_alternate.png" alt="Syntegon logo volledig">
        <h3>Schiedam</h3>
        <?php
            if($login) {
                header("Location: home.php");
            } else {
        ?>
        <form action="" method="post">
            <div class="divLogin">
                <label for="email">E-mailadres</label>
                <br>
                <span class="errors"><?= $errors['email'] ?? '' ?></span>
                <input id="email" type="text" placeholder="Voer hier uw e-mailadres in" class="inputLogin" name="email" value="<?php if(isset($email)){ echo htmlentities($email); } else{ echo ""; } ?>">
            </div>
            <div class="divLogin">
                <label for="password">Wachtwoord</label>
                <br>
                <span class="errors"><?= $errors['password'] ?? '' ?></span>
                <input id="password" type="password" placeholder="Voer hier uw wachtwoord in" class="inputLogin" name="password">
            </div>
            <div class="divLogin">
                <div class="center">
                    <input class="buttonLogin" type="submit" name="submit" value="Aanmelden">
                    <br>
                    <span class="errors"><?= $errors['loginFailed'] ?? '' ?></span>
                </div>
            </div>
        </form>
        <?php } ?>
        <img class="imgLoginSmall" src="images/syntegon_header_alternate.jpg" alt="Syntegon logo verkleind">
        <footer>
            <a href="account.php">Maak een account aan!</a>
        </footer>
    </body>

</html>
