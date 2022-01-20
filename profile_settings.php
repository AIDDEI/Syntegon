<?php
/** @var mysqli $db */
include_once("main_head.php");

//Get the users id
$id = $_SESSION['loggedInUser']['id'];

//Check if the user has an id
if(isset($id)){
    //Getting all necessary user info
    $query = mysqli_query($db, "SELECT * FROM users WHERE id='$id'");
    while($row = mysqli_fetch_assoc($query)){
        $name = $row['name'];
        $lastname = $row['lastname'];
        $email = $row['email'];
        $phone = $row['phone'];
    }
} else {
    $errors['db'] = "Er is een fout opgetreden...";
}

//Check if 'update' has been posted
if(isset($_POST['update'])){
    //Set all variables to the user input
    $name_update = mysqli_escape_string($db, $_POST['name']);
    $lastname_update = mysqli_escape_string($db, $_POST['lastname']);
    $email_update = mysqli_escape_string($db, $_POST['email']);
    $phone_update = mysqli_escape_string($db, $_POST['phone']);

    //Check for errors, like empty fields
    require_once("update_profile_validation.php");

    //Check if the array errors is empty
    if(empty($errors)){
        //Updating the user info
        $update_query = "UPDATE users SET name='$name_update', lastname='$lastname_update', email='$email_update', phone='$phone_update' WHERE id='$id'";
        $result = mysqli_query($db, $update_query);
        //Check if the user info has been updated
        if($result){
            //Go to the update success page
            header('Location: update_success.php');
            exit;
        } else{
            $errors['db'] = "Er is een fout opgetreden...";
        }
    }
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Gegevens Bewerken</title>
    </head>

    <body>
        <form action="" method="post">
            <div>
                <label for="name">Voornaam</label>
                <input id="name" type="text" name="name" value="<?php
                                                                //Check if the variable is empty
                                                                if(isset($name_update)){
                                                                    //Echo the new user input
                                                                    echo htmlentities($name_update);
                                                                } else{
                                                                    //Echo data from database
                                                                    echo htmlentities($name);
                                                                } ?>">
                <span class="errors"><?php echo $errors['name'] ?? ''; ?></span>
            </div>
            <div>
                <label for="lastname">Achternaam</label>
                <input id="lastname" type="text" name="lastname" value="<?php if(isset($lastname_update)){ echo htmlentities($lastname_update); } else{ echo htmlentities($lastname); } ?>">
                <span class="errors"><?php echo $errors['lastname'] ?? ''; ?></span>
            </div>
            <div>
                <label for="email">E-mail</label>
                <input id="email" type="text" name="email" value="<?php if(isset($email_update)){ echo htmlentities($email_update); } else{ echo htmlentities($email); } ?>">
                <span class="errors"><?php echo $errors['email'] ?? ''; ?></span>
            </div>
            <div>
                <label for="phone">Telefoonnummer</label>
                <input id="phone" type="number" name="phone" value="<?php if(isset($phone_update)){ echo htmlentities($phone_update); } else{ echo "0" . htmlentities($phone); } ?>">
                <span class="errors"><?php echo $errors['phone'] ?? ''; ?></span>
            </div>
            <div>
                <input type="submit" name="update" value="Bewerken">
            </div>
        </form>
        <br><br>
        <a href="profile.php">Terug</a>

        <?php include_once("main_footer.php"); ?>
    </body>

</html>
