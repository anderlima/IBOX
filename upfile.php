<?php 
#require_once("db_ci.php");
#$_SESSION['ciname'] = $_POST['title'];
#$_SESSION['shdescription'] = $_POST['shortdesc'];
#$_SESSION['cidescription'] = $_POST['ci']; 

#echo $_SESSION['ciname'] ."<br>";
#echo $_SESSION['shdescription'] ."<br>";
#echo $_SESSION['cidescription'] ."<br>";

#echo $_POST['title'] ."<br>";
#echo $_POST['shortdesc'] ."<br>";
#echo $_POST['ci'] ."<br>";

if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0) {
$fileName = $_FILES['userfile']['name'];
$tmpName  = $_FILES['userfile']['tmp_name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];

#echo $fileType;

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

if(!get_magic_quotes_gpc())
{
    $fileName = addslashes($fileName);
}
$ciid = $ciid ? $ciid : $iid;
addFile($db, $ciid, $fileName, $fileSize, $fileType, $content);
#header('Location: editci.php#position');
}
?>