<?php
require_once("LDAPw3.php");

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

function setTeamName($name){
    $_SESSION['tname'] = $name;
}

function teamName(){
    return $_SESSION['tname'];
}

function setUid($uid){
    $_SESSION['uid'] = $uid;
}

function getUid(){
    return $_SESSION['uid'];
}

function ldapUid($email){
    $ds = @ldap_connect('ldaps://bluepages.ibm.com');
    @ldap_bind($ds); 
    $data = @ldap_search($ds, 'ou=bluepages,o=ibm.com', '(&(uid=*)(c=*)(mail='.$email.'))');
    $info = @ldap_get_entries($ds, $data);
    $employee = ldap_result_format($info[0]);
    return $employee['uid'];
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


