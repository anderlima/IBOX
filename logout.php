<?php
require_once("user_logic.php");

logout();
$_SESSION["success"] = "You have successfully log out!";
header("Location: index.php");
die();
