<?php
session_start();

unset($_SESSION['Input_username']);
header("Location: login_page.html");

?>