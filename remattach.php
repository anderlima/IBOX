<?php
require_once('db_ci.php');
require_once('user_logic.php');

checkUser();

if(isset($_GET['ciid'])){
$_SESSION['ciid'] = $_GET['ciid'];
    if(removeAttach($db, $_GET['id'])){
        $_SESSION["success"] = $_GET['name']." successfully removed!";
        header('Location: editci.php');
    }else{
	   $_SESSION["danger"] = $_SESSION["danger"] ? 'Attachment could not be removed.'.$_SESSION["danger"] : "Attachment could not be removed. Please talk to administrator!";
	   header('Location: editci.php');
       }
}

if(isset($_GET['iid'])){
$_SESSION['iid'] = $_GET['iid'];
    if(removeAttach($db, $_GET['id'])){
        $_SESSION["success"] = $_GET['name']." successfully removed!";
        header('Location: editidea.php');
    }else{
	   $_SESSION["danger"] = $_SESSION["danger"] ? 'Attachment could not be removed.'.$_SESSION["danger"] : "Attachment could not be removed. Please talk to administrator!";
	   header('Location: editidea.php');
        }
}
    
    

?>