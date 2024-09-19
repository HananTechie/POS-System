<?php

require("config/functions.php");
session_start(); // Start the session

// Call the logout function
logoutSession();

if (isset($_SESSION["loggedIn"])) {
    redirect("login.php", "Logged Out Successfully");
} else {
    redirect("login.php", "You are not logged in.");
}
?>
