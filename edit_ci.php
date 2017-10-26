<?php 
require_once("db_ci.php");

if(isset($_SESSION['ciid'])){unset($_SESSION['ciid']);}

$status = isset($_POST['review']) ? 'review' : 'draft';
$ciid = $_SESSION['ciid'] = $_POST['ciid'];
$name = $_SESSION['title'] = $_POST['title'];
$shortdesc = $_SESSION['shortdesc'] = $_POST['shortdesc'];
$ci = $_SESSION['ci'] = $_POST['ci'];
$estimated = $_SESSION['estimated'] = $_POST['estimated'];

if (!empty($_POST['component'])){
if(EditCi($db, $ciid, $name, $shortdesc, $ci, $status, $estimated)){
        if($status == 'review'){
        $msg_id = $ciid ? $_SESSION["success"] = "Your CI #".$ciid. " was successfully submitted for review!" : "";
        }else{
        $msg_id = $ciid ? $_SESSION["success"] = "Your CI #".$ciid. " is saved as draft!" : "";
        }
        RemManytoMany($db, $ciid, 'cis_for_components');
    foreach($_POST['component'] as $check) {
            AddManytoMany($db, $check, $ciid, 'cis_for_components');
    }
    if(!empty($_POST['participant'])) {
        RemUserCreateCis($db, $ciid);
    foreach($_POST['participant'] as $check) {
            AddManytoMany($db, $check, $ciid, 'users_create_cis');
    }
}
    if($status == 'review'){
    $emailmessage = sendEmail($db, $ciid, $name, $status, 'CI');
    $_SESSION["success"] = $_SESSION["success"]." ".$emailmessage;
}
    header('Location: viewci.php');
} else {
    $_SESSION["danger"] = $_SESSION["danger"] ? $_SESSION["danger"] : "CI could not be addded. Please talk to administrator!";
    header('Location: editci.php');
}
} else {
    $_SESSION["danger"] = "Verify component under Tool field and try again!";
    header('Location: editci.php');
}
?>