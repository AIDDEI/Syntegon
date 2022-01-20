<?php

session_start();

if(!isset($_SESSION['loggedInUser'])){
    header('Location: index.php');
}
