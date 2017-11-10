<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

function isUserLogged() {
	return isset($_SESSION["user_email"]);
}

function checkUser() {
	if(!isUserLogged()) {
		header("Location: login_page.php?location=" . urlencode($_SERVER['REQUEST_URI']));
		die();
	}
}

function Whois() {
	return $_SESSION["user_email"];
}

function WhosName() {
	return $_SESSION["user_name"];
}

function logUser($email, $name) {
	$_SESSION["user_email"] = $email;
	$_SESSION["user_name"] = $name;
}

function setPrivilege($level) {
	$_SESSION["level"] = $level;
	return $_SESSION["level"];
}

function logout() {
	session_destroy();
	session_start();
}
