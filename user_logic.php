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
}

function setPrivilege($level) {
	$_SESSION["level"] = $level;
}

function getLevel(){
    return $_SESSION["level"];
}

function logout() {
	session_destroy();
	session_start();
}

function setUserProfile($team_id) {
    $_SESSION['team'] = $team_id;
}

function WhosTeam() {
    return $_SESSION['team'];
}

function setTeamCategory($category){
    $_SESSION['category'] = $category;
}

function teamCateg(){
    return $_SESSION['category'];
}

function checkTeamIdea(){
    if(teamCateg() == 'ci'){
    header("Location: index.php");
}
    if(teamCateg() == null){
    header("Location: profile.php");
    die();
} else {
    return null;
    }
}

function checkTeamCI(){
    if(teamCateg() == 'idea'){
    header("Location: listidea.php");
}
    if(teamCateg() == null){
    header("Location: profile.php");
    die();
} else {
    return null;
    }
}


