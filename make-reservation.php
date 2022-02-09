<?php
/** @var mysqli $db */
//Include the main <head> and also navigation bar
//In the file main_head.php the connection with the database is also made and the check if the user is logged in or not
include_once("main_head.php");

//Find all departments
$find_departments = $db->query("SELECT * FROM departments ORDER BY name ASC");

//Set the post-back variables empty at the start
$department_post = $date = $startTime = $endTime = "";

//Check if submit has been posted
if(isset($_POST['submit'])){
    //Set the variables to the user input
    $department_post = mysqli_escape_string($db, $_POST['department']);
    $date = mysqli_escape_string($db, $_POST['date']);
    $startTime = mysqli_escape_string($db, $_POST['startTime']);
    $endTime = mysqli_escape_string($db, $_POST['endTime']);

    //Check for errors, like empty fields
    require_once("new_reservation_validation.php");

    //Check if the array errors is empty
    if(empty($errors)){
        //Start the session
        session_start();
        //Insert the variables into the session
        $_SESSION['reservation'] = [
            'department' => $department_post,
            'date' => $date,
            'startTime' => $startTime,
            'endTime' => $endTime
        ];
        //Go to the place-chooser page
        header('Location: choose-place.php');
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Nieuwe Reservering Maken</title>

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

        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="department">Afdeling</label>
                <select id="department" name="department">
                    <option value="invalid">--Selecteer een afdeling--</option>
                    <?php
                    //Find all departments and echo these as options
                    //Value of the option has to be the id of the department
                    while($row = mysqli_fetch_assoc($find_departments)){
                        ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo htmlentities($row['name']); ?></option>
                    <?php } ?>
                </select>
                <span class="errors"><?php echo $errors['department'] ?? ''; ?></span>
            </div>
            <br>
            <div>
                <label for="date">Datum</label>
                <input id="date" type="date" name="date" value="<?php echo htmlentities($date); ?>">
                <span class="errors"><?php echo $errors['date'] ?? ''; ?></span>
            </div>
            <br>
            <div>
                <label for="startTime">Starttijd</label>
                <input id="startTime" type="time" name="startTime" value="<?php echo htmlentities($startTime); ?>">
                <span class="errors"><?php echo $errors['startTime'] ?? ''; ?></span>
            </div>
            <br>
            <div>
                <label for="endTime">Eindtijd</label>
                <input id="endTime" type="time" name="endTime" value="<?php echo htmlentities($endTime); ?>">
                <span class="errors"><?php echo $errors['endTime'] ?? ''; ?></span>
            </div>
            <br>
            <div>
                <button class="button" type="submit" name="submit">Plaats Kiezen</button>
            </div>
        </form>

        <footer>
            <hr>
            <img src="images/syntegon_header_logo.png" alt="Syntegon logo klein">
            <a class="footerRight" href="logout.php">Uitloggen</a>
        </footer>
    </body>

</html>
