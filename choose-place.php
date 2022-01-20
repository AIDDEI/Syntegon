<?php
/** @var mysqli $db */
include_once("main_head.php");

$department = $_SESSION['reservation']['department'];
$date = $_SESSION['reservation']['date'];
$startTime = $_SESSION['reservation']['startTime'];
$endTime = $_SESSION['reservation']['endTime'];

$occupied_places = '';

$place_check = $db->query("SELECT * FROM reservations WHERE date='$date' AND department_id='$department'");
while($check_row = mysqli_fetch_assoc($place_check)) {
    $occupied = $check_row['place_id'];
    if($occupied > 0){
        $occupied_places.= "AND NOT places.id=" . $occupied . " ";
    }
}

if(isset($_POST['submit'])){
    $place_post = mysqli_escape_string($db, $_POST['place']);
    $user_id = $_SESSION['loggedInUser']['id'];

    $errors = [];
    if($place_post == "invalid"){
        $errors['place_post'] = "Kies een plaats";
    }

    if(empty($errors)){
        $create_query = "INSERT INTO reservations (id, date, start_time, end_time, user_id, department_id, place_id)
                     VALUES ('', '$date', '$startTime', '$endTime', '$user_id', '$department', '$place_post')";
        $result = mysqli_query($db, $create_query) or die('Error: '.mysqli_error($db). ' with query ' . $create_query);
        if($result){
            unset($_SESSION['reservation']);
            header('Location: confirmation.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <title>Nieuwe Reservering Maken</title>
    </head>

    <body>
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="place">Plaats</label>
                <select id="place" name="place">
                    <option value="invalid">--Selecteer een plaats--</option>
                    <?php
                    $sql_select = "SELECT department_place.department_id, places.id, places.name ";
                    $sql_from = "FROM department_place ";
                    $sql_inner_join = "INNER JOIN places ON department_place.place_id=places.id ";
                    $sql_where = "WHERE department_place.department_id='$department' ";
                    $sql_order = "ORDER BY places.name ASC";
                    $full_query = $sql_select . $sql_from . $sql_inner_join . $sql_where . $occupied_places . $sql_order;
                    $find_places = $db->query($full_query);
                    while($row = mysqli_fetch_assoc($find_places)){
                        $place = $row['name'];
                        $place_id = $row['id'];
                        ?>
                    <option value="<?php echo $place_id; ?>"><?php echo htmlentities($place); ?></option>
                    <?php } ?>
                </select>
                <span class="errors"><?php echo $errors['place_post'] ?? ''; ?></span>
            </div>
            <br>
            <div>
                <button type="submit" name="submit">Reservering Maken</button>
            </div>
        </form>

        <?php
        $get_img = $db->query("SELECT * FROM departments WHERE id='$department'");
        if($get_img){
            $department_array = mysqli_fetch_assoc($get_img);
        ?>
        <img class="map" src="<?php echo $department_array['img']; ?>" alt="plattegrond">
        <?php } else{
            echo "Er is helaas geen plattegrond van deze afdeling beschikbaar...";
        } ?>

        <?php include_once("main_footer.php"); ?>
    </body>

</html>