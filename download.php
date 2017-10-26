<?php
require_once("db_ci.php");
if(isset($_GET['id'])){
$id = $_GET['id'];

$result = getFileParam($db, $id);

header("Content-length: ".$result['size']."");
header("Content-type: ".$result['type']."");
header("Content-Disposition: attachment; filename=".$result['name']."");
echo $result['content'];

}else{
	echo "Wrong address! Please check with Administrator!";
}

?>