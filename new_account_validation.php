<?php
$errors = [];

if(strlen($name) > 50){
    $errors['name'] = "Uw voornaam kan op onze website niet langer zijn dan 50 tekens";
}
if($name == ""){
    $errors['name'] = "Vul uw voornaam in";
}

if(strlen($lastname) > 50){
    $errors['lastname'] = "Uw achternaam kan op onze website niet langer zijn dan 50 tekens";
}
if($lastname == ""){
    $errors['lastname'] = "Vul uw achternaam in";
}

if(strlen($lastname) > 255){
    $errors['lastname'] = "Uw e-mailadres kan op onze website niet langer zijn dan 255 tekens";
}

if($email == ""){
    $errors['email'] = "Vul uw e-mailadres in";
}

if(strlen($phone) < 10){
    $errors['phone'] = "Uw telefoonnummer kan niet kleiner zijn dan 10 tekens";
}
if(strlen($phone) > 15){
    $errors['phone'] = "Uw telefoonnummer kan niet groter zijn dan 15 tekens";
}
if($phone == ""){
    $errors['phone'] = "Vul uw telefoonnummer in";
}

if(strlen($password) < 8){
    $errors['password'] = "Een wachtwoord moet minimaal 8 tekens lang zijn";
}
if(strlen($password) > 255){
    $errors['password'] = "Een wachtwoord kan op onze website niet langer zijn dan 255 tekens";
}
if($password == ""){
    $errors['password'] = "Vul een wachtwoord in";
}

if(strlen($password2) < 8){
    $errors['password2'] = "Een wachtwoord moet minimaal 8 tekens lang zijn";
}
if(strlen($password2) > 255){
    $errors['password2'] = "Een wachtwoord kan op onze website niet langer zijn dan 255 tekens";
}
if($password2 == ""){
    $errors['password2'] = "Vul een wachtwoord in";
}
