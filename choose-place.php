<?php
/** @var mysqli $db */
include_once("main_head.php");

//Get the session variables
$department = $_SESSION['reservation']['department'];
$date = $_SESSION['reservation']['date'];
$startTime = $_SESSION['reservation']['startTime'];
$endTime = $_SESSION['reservation']['endTime'];

//Set the variable empty at the start
$occupied_places = '';

//Query for the check of available places
//This query takes all occupied places from the table 'reservations' where the date is the same date the user wants to book for
$place_check = $db->query("SELECT * FROM reservations WHERE date='$date' AND department_id='$department'");
while($check_row = mysqli_fetch_assoc($place_check)) {
    $occupied = $check_row['place_id'];
    if($occupied > 0){
        //These are all the occupied places in form of part of a query
        $occupied_places.= "AND NOT places.id=" . $occupied . " ";
    }
}

//Check if submit has been posted
if(isset($_POST['submit'])){
    //set the variable to user input
    $place_post = mysqli_escape_string($db, $_POST['place']);
    //Get the users id
    $user_id = $_SESSION['loggedInUser']['id'];

    //Set the errors array empty
    $errors = [];
    //Check if the value of the place is invalid
    if($place_post == "invalid"){
        $errors['place_post'] = "Kies een plaats";
    }

    //Check if the array errors is empty
    if(empty($errors)){
        //Query to insert the data into the database
        $create_query = "INSERT INTO reservations (id, date, start_time, end_time, user_id, department_id, place_id)
                     VALUES ('', '$date', '$startTime', '$endTime', '$user_id', '$department', '$place_post')";
        $result = mysqli_query($db, $create_query) or die('Error: '.mysqli_error($db). ' with query ' . $create_query);
        //Check if the data is added to the database
        if($result){
            //Set the session empty
            unset($_SESSION['reservation']);
            //Go to the confirmation page
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
                    //These variables are parts of the full query
                    $sql_select = "SELECT department_place.department_id, places.id, places.name ";
                    $sql_from = "FROM department_place ";
                    $sql_inner_join = "INNER JOIN places ON department_place.place_id=places.id ";
                    $sql_where = "WHERE department_place.department_id='$department' ";
                    $sql_order = "ORDER BY places.name ASC";
                    //All the parts put together
                    $full_query = $sql_select . $sql_from . $sql_inner_join . $sql_where . $occupied_places . $sql_order;

                    //Getting all the available places and echo them as an option
                    //Value of the option has to be the place id
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
        //Get the correct map, to choose a place
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