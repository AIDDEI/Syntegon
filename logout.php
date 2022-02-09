<?php

session_start();

//Destroy the session, so that the user isn't logged in anymore
session_destroy();

//Go to the login page
header('Location: index.php');
exit;