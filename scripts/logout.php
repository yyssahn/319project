<?php
session_start();

unset($_SESSION['Input_username']);
header("Location: Login page.html");

?>