<?php
/** @var mysqli $db */
require_once("config.php");

//Set all post-back variables empty at the start
$name = $lastname = $email = $phone = "";

//Check if submit has been posted
if (isset($_POST['submit'])){
    //Set all necessary variables to user input
    //Prevent SQL injections with mysqli_escape_string
    $name = mysqli_escape_string($db, $_POST['name']);
    $lastname = mysqli_escape_string($db, $_POST['lastname']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $phone = mysqli_escape_string($db, $_POST['phone']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    //Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    //Check for errors, like empty fields
    require_once("new_account_validation.php");

    //Check if there are no errors
    if(empty($errors)){
        //Query to add the data into the database
        $sql = "INSERT INTO users (id, name, lastname, email, phone, password)
            VALUES ('', '$name', '$lastname', '$email', '$phone', '$hashed')";

        //Check if the user has entered the same password twice
        if($password == $password2){
            //Check whether the data has been added to the database
            if(mysqli_query($db, $sql)) {
                $success = "*Account succesvol toegevoegd";
            } else {
                $error = "Er is een fout opgetreden waardoor het account niet is toegevoegd...";
            }
        } else {
            $errors['samePassword'] = "Voer twee keer hetzelfde wachtwoord in";
        }
    }
    //Close the database
    mysqli_close($db);
}

?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Syntegon | Schiedam | Account maken</title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="images/syntegon_header_logo.png">
    </head>

    <body class="caribbeanGreenBackGround">
        <span class="errors"><?php echo $success ?? ''; ?></span>
        <span class="errors"><?php $error ?? ''; ?></span>
        <div>
            <h3>Maak een account aan</h3>
            <form action="" method="post" class="divAccount">
                <div>
                    <label for="name"><b>Voornaam</b></label>
                    <span class="errors"><?php echo $errors['name'] ?? ''; ?></span>
                    <br>
                    <input class="inputAccount" id="name" type="text" placeholder="Voer hier uw voornaam in" name="name" value="<?php echo htmlentities($name); ?>">
                </div>
                <div>
                    <label for="lastname"><b>Achternaam</b></label>
                    <span class="errors"><?php echo $errors['lastname'] ?? ''; ?></span>
                    <br>
                    <input class="inputAccount" id="lastname" type="text" placeholder="Voer hier uw achternaam in" name="lastname" value="<?php echo htmlentities($lastname); ?>">
                </div>
                <div>
                    <label for="email"><b>E-mailadres</b></label>
                    <span class="errors"><?php echo $errors['email'] ?? ''; ?></span>
                    <br>
                    <input class="inputAccount" id="email" type="text" placeholder="Voer hier uw e-mailadres in" name="email" value="<?php echo htmlentities($email); ?>">
                </div>
                <div>
                    <label for="phone"><b>Telefoonnummer</b></label>
                    <span class="errors"><?php echo $errors['phone'] ?? ''; ?></span>
                    <br>
                    <input class="inputAccount" id="phone" type="number" placeholder="Voer hier uw telefoonnummer in" name="phone" value="<?php echo htmlentities($phone); ?>">
                </div>
                <div>
                    <label for="password"><b>Wachtwoord</b></label>
                    <span class="errors"><?php echo $errors['password'] ?? ''; ?></span>
                    <br>
                    <input class="inputAccount" id="password" type="password" placeholder="Voer hier uw wachtwoord in" name="password">
                </div>
                <div>
                    <label for="password2"><b>Hetzelfde wachtwoord</b></label>
                    <span class="errors"><?php echo $errors['password2'] ?? ''; ?></span>
                    <br>
                    <input class="inputAccount" id="password2" type="password" placeholder="Voer hier uw wachtwoord nog een keer in" name="password2">
                </div>
                <div>
                    <button class="buttonAccount" name="submit" type="submit">Account maken</button>
                    <?php if (isset($errors['samePassword'])) { ?>
                        <div><span class="errors"><?php echo $errors['samePassword']; ?></span></div>
                    <?php } ?>
                </div>
            </form>
        </div>
        <footer class="bottom">
            <a href="index.php">Terug</a>
        </footer>
        </body>

</html>
