<?php
/** @var mysqli $db */
include_once("main_head.php");

$department_post = $date = $startTime = $endTime = "";

if(isset($_POST['submit'])){
    $department_post = mysqli_escape_string($db, $_POST['department']);
    $date = mysqli_escape_string($db, $_POST['date']);
    $startTime = mysqli_escape_string($db, $_POST['startTime']);
    $endTime = mysqli_escape_string($db, $_POST['endTime']);

    require_once("new_reservation_validation.php");

    if(empty($errors)){
        session_start();
        $_SESSION['reservation'] = [
            'department' => $department_post,
            'date' => $date,
            'startTime' => $startTime,
            'endTime' => $endTime
        ];

        header('Location: choose-place.php');
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
                <label for="department">Afdeling</label>
                <select id="department" name="department">
                    <option value="invalid">--Selecteer een afdeling--</option>
                    <?php
                    $find_departments = $db->query("SELECT * FROM departments ORDER BY name ASC");
                    while($row = mysqli_fetch_assoc($find_departments)){
                        $department = $row['name'];
                        $department_id = $row['id'];
                        ?>
                    <option value="<?php echo $department_id; ?>"><?php echo htmlentities($department); ?></option>
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
        <?php include_once("main_footer.php"); ?>
    </body>

</html>
