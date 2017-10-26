<?php
require_once("db_ci.php");

$_SESSION['ciid'] = $_POST['ciid'];

$ci = getInfoReg($db, $_POST['ciid'], 'cis');
if($ci['status'] == 'published'){
    $_SESSION["danger"] = "This CI is already published";
    header('Location: viewci.php');
}else{
if(setPublished($db, $_POST['ciid'])){
    $_SESSION["success"] = "This CI was successfully set to Published!";
    $emailmessage = sendEmail($db, $ci['id'], $ci['name'], 'published', 'CI');
    $_SESSION["success"] = $_SESSION["success"]." ".$emailmessage;
    header('Location: viewci.php');
}else{
    $_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "CI could not be published. Please talk to administrator!";
    header('Location: viewci.php');
}
}

 ?>