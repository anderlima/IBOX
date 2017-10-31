<?php 
require_once("db_conn.php");
require_once("user_logic.php");
checkUser();

date_default_timezone_set('America/Sao_Paulo');

function AddIdea($db, $title){
$now = date("Y/m/d H:i:s", time());
$user = Whois();

try {
$sql = "Insert into ideas (owner, name, status, release_date, last_update_date) values (:user, :name, 'draft', :release, :last);";
	$stm = $db->prepare($sql);
	$stm->bindValue(':name', $title);
	$stm->bindValue(':release', $now);
	$stm->bindValue(':last', $now);
	$stm->bindValue(':user', $user);
	return $stm->execute();
	} catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function EditIdea($db, $iid, $name, $idea, $team, $status){
$now = date("Y/m/d H:i:s", time());
$user = Whois();

try {
$sql = "update ideas set name=:name, description=:idea, team=:team, status=:status, last_update_date=:last where id=:id";
	$stm = $db->prepare($sql);
	$stm->bindValue(':name', $name);
	$stm->bindValue(':idea', $idea);
	$stm->bindValue(':team', $team);
	$stm->bindValue(':status', $status);
	$stm->bindValue(':last', $now);
	$stm->bindValue(':id', $iid);
	return $stm->execute();
	} catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function getNewIdeas($db){
	$rows = array();
	$stm = $db->prepare("SELECT * FROM ideas Where status='published' ORDER by id DESC");
    $stm->execute();
    while($result = $stm->fetch(PDO::FETCH_ASSOC)) {
	array_push($rows, $result);
	}
	return $rows;
}

function AddManytoMany($db, $compid, $ciid, $table){
	$sql = "insert into ".$table." values (:compid, :ciid)";
	$stm = $db->prepare($sql);
	$stm->bindValue(':compid', $compid);
	$stm->bindValue(':ciid', $ciid);
	return $stm->execute();
}

function RemManytoMany($db, $ciid, $table){
	$sql = "delete from ".$table." where cid_id=:ciid";
	$stm = $db->prepare($sql);
	$stm->bindValue(':ciid', $ciid);
	return $stm->execute();
}

function RemUserCreateCis($db, $ciid){
	$sql = "delete from users_create_cis where cis_id=:ciid";
	$stm = $db->prepare($sql);
	$stm->bindValue(':ciid', $ciid);
	return $stm->execute();
}

function getIdeaId($db){
	$stm = $db->prepare("select max(id) from ideas");
	$stm->execute();
	$result = $stm->fetch(PDO::FETCH_NUM);
	$ciid = $result[0];
	return $ciid;
}

function getInfoAll($db, $table){
	$rows = array();
	$stm = $db->prepare("select * from $table");
	$stm->execute();
	while($result = $stm->fetch(PDO::FETCH_ASSOC)) {
		array_push($rows, $result);
	}
	return $rows;
}

function getInfoReg($db, $id, $table){
	$stm = $db->prepare("SELECT * FROM $table WHERE id = :id");
	$stm->bindValue(':id', $id);
	$stm->execute();

	$result = $stm->fetch(PDO::FETCH_ASSOC);

	return $result;
}

function getAttachments($db, $iid){
	$rows = array();
	$stm = $db->prepare("SELECT id, name FROM upload where iid = $iid");
    $stm->execute();
    while($result = $stm->fetch(PDO::FETCH_ASSOC)) {
	array_push($rows, $result);
	}
	return $rows;
}

function getFileParam($db, $id){
	$stm = $db->prepare("SELECT name, type, size, content FROM upload WHERE id = '$id'");
     $stm->execute();
     $result = $stm->fetch(PDO::FETCH_ASSOC);
     return $result;
}

function addFile($db, $ciid, $fileName, $fileSize, $fileType, $content){
	$user = Whois();
	try {
	$stm = $db->prepare("INSERT INTO upload (name, ciid, iid, user, size, type, content ) VALUES ('$fileName', 0, '$ciid', '$user', '$fileSize', '$fileType', '$content')");
    $stm->execute();
    } catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function getTools($db){
	$rows = array();
	$stm = $db->prepare("SELECT DISTINCT tool FROM components");
	$stm->execute();
	while($result = $stm->fetch(PDO::FETCH_ASSOC)) {
		array_push($rows, $result);
	}
	return $rows;
}


function getComponents($db, $tool){
	$rows = array();
	$stm = $db->prepare("SELECT * FROM components WHERE tool=:tool");
	$stm->bindValue(':tool', $tool);
	$stm->execute();
	while($result = $stm->fetch(PDO::FETCH_ASSOC)) {
		array_push($rows, $result);
	}
	return $rows;
}

function getComponentsIds($db, $ciid){
	$rows = array();
	$stm = $db->prepare("SELECT components_id FROM cis_for_components WHERE cid_id=:ciid");
	$stm->bindValue(':ciid', $ciid);
	$stm->execute();
	while($result = $stm->fetch(PDO::FETCH_ASSOC)) {
		array_push($rows, $result);
	}
	return $rows;
}

function getThisTool($db, $ciid){
	$stm = $db->prepare("SELECT tool FROM components WHERE id =(SELECT components_id FROM cis_for_components WHERE cid_id=:ciid LIMIT 1)");
	$stm->bindValue(':ciid', $ciid);
	$stm->execute();
	return $stm->fetch(PDO::FETCH_ASSOC);
}

function searchIdeas($db, $search){
	$rows = array();
	#$searchlike = $search.'%';
	try{
	$stm = $db->prepare("SELECT id, name, description FROM ideas WHERE MATCH (owner, name, description) AGAINST (:search) and status='published'");
	$stm->bindValue(':search', $search);
	#$stm->bindValue(':searchlike', $searchlike);
	$stm->execute();
	while($result = $stm->fetch(PDO::FETCH_ASSOC)) {
		array_push($rows, $result);
	}
	return $rows;

	} catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function getCIusers($db, $ciid){
	$rows = array();
	try{
	$stm = $db->prepare("SELECT users_email FROM users_create_cis WHERE cis_id=".$ciid."");
	$stm->bindValue(':search', $search);
	$stm->execute();
	while($result = $stm->fetch(PDO::FETCH_ASSOC)) {
		array_push($rows, $result);
	}
	return $rows;

	} catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function getFilterRes($db, $status, $user){
	$rows = array();
	#$user = Whois();
	$stm = $db->prepare("SELECT id, name, description FROM ideas WHERE status like :status and owner like :user");
	$stm->bindValue(':status', $status);
	$stm->bindValue(':user', $user);
	$stm->execute();
	while($result = $stm->fetch(PDO::FETCH_ASSOC)) {
		array_push($rows, $result);
	}
	return $rows;
}


function setPublished($db, $iid){
$now = date("Y/m/d H:i:s", time());
$user = Whois();

try {
$sql = "update ideas set status='published', last_update_date=:last, approver=:user where id=:id";
	$stm = $db->prepare($sql);
	$stm->bindValue(':last', $now);
	$stm->bindValue(':user', $user);
	$stm->bindValue(':id', $iid);
	return $stm->execute();
	} catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}


function setRejected($db, $iid, $justification){
$now = date("Y/m/d H:i:s", time());
$user = Whois();

try {
$sql = "update ideas set status='rejected', last_update_date=:last, approver=:user, justification=:justification where id=:id";
	$stm = $db->prepare($sql);
	$stm->bindValue(':last', $now);
	$stm->bindValue(':user', $user);
	$stm->bindValue(':justification', $justification);
	$stm->bindValue(':id', $iid);
	return $stm->execute();
	} catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function sendEmail($id, $name, $status, $type){
$username='03c38cc1-4d8f-492f-9621-6d57632b1d90';
$password='c930a783-7b9c-4b3f-9caf-b97f294fb9b2';
$URL='https://bluemail.w3ibm.mybluemix.net/rest/v2/emails';
$email = Whois();

if($status == 'published'){
	$postData = '{
	"contact": "NotReplyIbox@br.ibm.com",
	"recipients": [
		{"recipient": '.json_encode($email).'}
	],
	"bcc": [
		{"recipient": "alimao@br.ibm.com"}
	],
	"subject": "[IBOX] Your '.$type.' #'.$id.' was successfully '.$status.'        ",
	"message": "Hello,<br>Your '.$type.' entitled as <b>'.$name.'</b> was successfully approved by '.Whois().' and <b>'.$status.'</b> <br> Please visit <a href=\"https://ibox.w3ibm.mybluemix.net\">IBOX</a> and check on My '.$type.'s section. <br><br> Best Regards, <br> IBOX 2.0"
 }';

}elseif($status == 'review'){
	$postData = '{
	"contact": "NotReplyIbox@br.ibm.com",
	"recipients": [
		{"recipient": '.json_encode($email).'}
	],
	"bcc": [
		{"recipient": "alimao@br.ibm.com"}
	],
	"subject": "[IBOX] Your '.$type.' #'.$id.' was successfully sent for '.$status.'        ",
	"message": "Hello,<br>Your '.$type.' entitled as <b>'.$name.'</b> was successfully sent for <b>'.$status.'</b> by '.Whois().' <br> Await for moderator approval then visit <a href=\"https://ibox.w3ibm.mybluemix.net\">IBOX</a> and check on My '.$type.'s section. <br><br> Best Regards, <br> IBOX 2.0"
 }';
}else{
	$postData = '{
	"contact": "NotReplyIbox@br.ibm.com",
	"recipients": [
		{"recipient": '.json_encode($email).'}
	],
	"bcc": [
		{"recipient": "alimao@br.ibm.com"}
	],
	"subject": "[IBOX] Your '.$type.' #'.$id.' was '.$status.'        ",
	"message": "Hello,<br>Your '.$type.' entitled as <b>'.$name.'</b> was <b>'.$status.'</b> by '.Whois().'<br> See justification on <a href=\"https://ibox.w3ibm.mybluemix.net\">IBOX</a> checking on My '.$type.'s section. <br><br> Best Regards, <br> IBOX 2.0"
 }';
}

$ch = curl_init('https://bluemail.w3ibm.mybluemix.net/rest/v2/emails');
curl_setopt_array($ch, array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => array(
        "Authorization: Basic " . base64_encode($username . ":" . $password),
        'Content-Type: application/json'
    ),
    CURLOPT_URL => $URL,
    CURLOPT_POSTFIELDS => $postData
));

$response = curl_exec($ch);

if($response === FALSE){
   return die(curl_error($ch));
}
$responseData = json_decode($response, TRUE);

return "An email was successfully sent!";
}


?>