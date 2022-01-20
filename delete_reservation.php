<?php
/** @var mysqli $db */
include_once("main_head.php");

$id = $_GET['id'];
$user_id = $_SESSION['loggedInUser']['id'];

setlocale(LC_TIME, 'NL_nl');

$query_reservation = "SELECT reservations.id, reservations.date, reservations.start_time, reservations.end_time, places.name 
        FROM reservations
        INNER JOIN places ON reservations.place_id = places.id 
        WHERE reservations.id ='$id' 
        AND reservations.user_id = '$user_id'";
$get_reservation = mysqli_query($db, $query_reservation);
$reservation = mysqli_fetch_assoc($get_reservation);

$query_department_name = "SELECT departments.name FROM reservations INNER JOIN departments 
                        ON reservations.department_id = departments.id WHERE reservations.id='$id' AND user_id='$user_id'";
$get_department_name = mysqli_query($db, $query_department_name);
$department = mysqli_fetch_assoc($get_department_name);

$date = date('d-m-Y', strtotime($reservation['date']));
$date_written = strftime('%A %d %B %Y', strtotime($reservation['date']));
$time = "van " . date('H:i', strtotime($reservation['start_time'])) . " tot " . date('H:i', strtotime($reservation['end_time']));

if (isset($_POST['submit'])) {
    $query_delete = "DELETE FROM reservations WHERE id='$id' AND user_id='$user_id'";
    $result = mysqli_query($db, $query_delete) or die ('Error: ' . $query_delete);

    if($result === TRUE){
        header('Location: reservations.php');
    } else{
        header('Location: delete_fail.php');
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Reservering <?php echo htmlentities($date); ?> annuleren?</title>
    </head>

    <body>
        <h2>Weet u zeker dat u uw reservering op <?php echo htmlentities($date); ?> wilt annuleren?</h2>
        <div class="block2">
            <p><?php echo "Datum: " . htmlentities($date_written); ?></p>
            <p><?php echo "Tijd: " . htmlentities($time) ?></p>
            <p><?php echo "Afdeling: " . htmlentities($department['name']); ?></p>
            <p><?php echo "Plaats: " . htmlentities($reservation['name']); ?></p>
            <br>
            <form action="" method="post">
                <input class="button" type="submit" name="submit" value="Ja (reservering annuleren)">
            </form>
            <br><br>
            <a href="reservations.php">Nee, breng mij terug</a>
        </div>
        <?php include_once("main_footer.php"); ?>
    </body>

</html>
