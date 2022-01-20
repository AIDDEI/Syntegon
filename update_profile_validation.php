<?php
$errors = [];

if(strlen($name_update) > 50){
    $errors['name'] = "Uw voornaam kan op onze website niet langer zijn dan 50 tekens";
}
if($name_update == ""){
    $errors['name'] = "Vul uw voornaam in";
}

if(strlen($lastname_update) > 50){
    $errors['lastname'] = "Uw achternaam kan op onze website niet langer zijn dan 50 tekens";
}
if($lastname_update == ""){
    $errors['lastname'] = "Vul uw achternaam in";
}

if(strlen($lastname_update) > 255){
    $errors['lastname'] = "Uw e-mailadres kan op onze website niet langer zijn dan 255 tekens";
}
if($email_update == ""){
    $errors['email'] = "Vul uw e-mailadres in";
}

if(strlen($phone_update) < 10){
    $errors['phone'] = "Uw telefoonnummer kan niet kleiner zijn dan 10 tekens";
}
if(strlen($phone_update) > 15){
    $errors['phone'] = "Uw telefoonnummer kan niet groter zijn dan 15 tekens";
}
if($phone_update == ""){
    $errors['phone'] = "Vul uw telefoonnummer in";
}