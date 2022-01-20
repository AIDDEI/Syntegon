<?php

session_start();

//If a user isn't logged in, they can't get to certain pages; this code makes sure of it
if(!isset($_SESSION['loggedInUser'])){
    header('Location: index.php');
}
