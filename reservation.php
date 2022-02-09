<?php
/** @var mysqli $db */
include_once("main_head.php");

//Set the language of the date to Dutch
setlocale(LC_TIME, 'NL_nl');

//Get the correct reservation id
$id = $_GET['id'];

//Check if the id is empty
if(isset($_GET['id'])){
    //Get the users id
    $user_id = $_SESSION['loggedInUser']['id'];

    //Getting all necessary data of the reservation
    $query = "SELECT reservations.id, reservations.date, reservations.start_time, reservations.end_time, departments.img,
            places.name FROM reservations INNER JOIN departments ON reservations.department_id = departments.id 
            INNER JOIN places ON reservations.place_id = places.id WHERE reservations.id ='$id' 
            AND reservations.user_id = '$user_id'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query );

    //Check if there is one result
    if(mysqli_num_rows($result) == 1){
        $reservation = mysqli_fetch_assoc($result);
    } else {
        $unknown_reservation = "Deze reservering bestaat niet";
    }

    //Getting the department name
    //Separate query, because the name of the place, is also 'name'; so a conflict arises
    $query_department_name = "SELECT departments.name FROM reservations INNER JOIN departments 
                        ON reservations.department_id = departments.id WHERE reservations.id='$id' AND user_id='$user_id'";
    $get_department_name = mysqli_query($db, $query_department_name);
    $department = mysqli_fetch_assoc($get_department_name);
} else {
    $fail = "Er is iets misgegaan...";
}

//Setting all dates and time in the correct format
$date = date('d-m-Y', strtotime($reservation['date']));
$date_written = strftime('%A %d %B %Y', strtotime($reservation['date']));
$time = "van " . date('H:i', strtotime($reservation['start_time'])) . " tot " . date('H:i', strtotime($reservation['end_time']));
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Reservering <?php echo htmlentities($date); ?></title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="images/syntegon_header_logo.png">
    </head>

    <body>
        <span class="errors"><?php echo $unknown_reservation ?? ''; ?></span>
        <span class="errors"><?php echo $fail ?? ''; ?></span>
        <nav class="navbar">
            <a href="home.php"><img class="syntegonNav" src="images/syntegon_logo.png" alt="Syntegon logo volledig"></a>
            <div class="flex">
                <a href="how-to-reserve.php"><img class="reservationNav" src="images/plusteken.png" alt="Nieuwe reservering maken icoon"></a>
                <a href="profile.php" class="smallerWidth"><img class="profileNav" src="images/default_avatar.png"></a>
            </div>
        </nav>
        <hr>

        <h1><?php echo "Reservering " . htmlentities($date); ?></h1>
        <br>
        <div>
            <div class="block2">
                <p><?php echo "Datum: " . htmlentities($date_written); ?></p>
                <p><?php echo "Tijd: " . htmlentities($time); ?></p>
                <p><?php echo "Afdeling: " . htmlentities($department['name']); ?></p>
                <a class="popupLink" onclick="document.getElementById('popup').style.display='block'"><?php echo "Plaats: " . htmlentities($reservation['name']); ?></a>
                <br><br><br><br>
                <a href="delete_reservation.php?id=<?php echo $id; ?>">Reservering annuleren</a>
            </div>
            <div id="popup" class="modal">
                <div class="modal-content animate">
                    <div class="imgContainer">
                        <span onclick="document.getElementById('popup').style.display='none'" class="close" title="Sluit Afbeelding">&times;</span>
                        <img src="<?php echo $reservation['img']; ?>" alt="Plattegrond" class="avatar">
                    </div>
                </div>
            </div>
            <div>

            </div>
        </div>

        <footer>
            <hr>
            <img src="images/syntegon_header_logo.png" alt="Syntegon logo klein">
            <a class="footerRight" href="logout.php">Uitloggen</a>
        </footer>
    </body>

</html>
