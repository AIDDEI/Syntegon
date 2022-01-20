<?php
/** @var mysqli $db */
include_once("main_head.php");

$id = $_SESSION['loggedInUser']['id'];

if(isset($_POST['update'])){
    $query = mysqli_query($db, "SELECT * FROM users WHERE id='$id'");
    $user = mysqli_fetch_array($query);

    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword1'];
    $newPassword2 = $_POST['newPassword2'];

    require_once("new_password_validation.php");

    if(empty($errors)){
        if(password_verify($oldPassword, $user['password'])){
            if($newPassword1 == $newPassword2){
                $hash = password_hash($newPassword1, PASSWORD_DEFAULT);
                $update_query = mysqli_query($db, "UPDATE users SET password='$hash' WHERE id='$id'");
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
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Wachtwoord Wijzigen</title>
    </head>

    <body>
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

        <?php include_once("main_footer.php"); ?>
    </body>

</html>
