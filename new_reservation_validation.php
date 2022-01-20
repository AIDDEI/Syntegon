<?php
$errors = [];

if($department_post == "invalid"){
    $errors['department'] = "Kies een afdeling";
}

if($date == ""){
    $errors['date'] = "Kies een datum";
}

if($startTime < '06:59:00'){
    $errors['startTime'] = "U kunt niet eerder dan 07:00 reserveren";
}
if($startTime > '13:00:00'){
    $errors['startTime'] = "U kunt niet later beginnen dan 13:00";
}
if($startTime == ""){
    $errors['startTime'] = "Kies een starttijd";
}

if($endTime < '15:00:00'){
    $errors['endTime'] = "U kunt niet eerder dan 15:00 stoppen";
}
if($endTime > '19:00:00'){
    $errors['endTime'] = "U kunt niet later stoppen dan 19:00";
}
if($endTime == ""){
    $errors['endTime'] = "Kies een eindtijd";
}