<?php
//Set the array empty
$errors = [];

//Errors for the old password
if(strlen($oldPassword) < 8){
    $errors['oldPassword'] = "Uw wachtwoord moet minimaal 8 tekens lang zijn";
}
if(strlen($oldPassword) > 255){
    $errors['oldPassword'] = "Uw wachtwoord kan op onze website niet langer zijn dan 255 tekens";
}
if($oldPassword == ""){
    $errors['oldPassword'] = "Vul uw wachtwoord in";
}

//Errors for the new password
if(strlen($newPassword1) < 8){
    $errors['newPassword1'] = "Een nieuw wachtwoord moet minimaal 8 tekens lang zijn";
}
if(strlen($newPassword1) > 255){
    $errors['newPassword1'] = "Een nieuw wachtwoord kan op onze website niet langer zijn dan 255 tekens";
}
if($newPassword1 == ""){
    $errors['newPassword1'] = "Vul een nieuw wachtwoord in";
}

//Same errors, but for the second input of the new password
if(strlen($newPassword2) < 8){
    $errors['newPassword2'] = "Een nieuw wachtwoord moet minimaal 8 tekens lang zijn";
}
if(strlen($newPassword2) > 255){
    $errors['newPassword2'] = "Een nieuw wachtwoord kan op onze website niet langer zijn dan 255 tekens";
}
if($newPassword2 == ""){
    $errors['newPassword2'] = "Vul een nieuw wachtwoord in";
}