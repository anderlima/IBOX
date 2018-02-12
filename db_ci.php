<?php 
require_once("db_conn.php");
require_once("user_logic.php");
checkUser();

date_default_timezone_set('America/Sao_Paulo');

function AddCi($db, $title){
$now = date("Y/m/d H:i:s", time());
$user = Whois();

try {
$sql = "Insert into cis (name, status, release_date, last_update_date, last_update_by) values (:name, 'draft', :release, :last, :user); insert into users_create_cis values (:user, (select max(id) from cis)); insert into cis_for_components values (3, (select max(id) from cis));";
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

function EditCi($db, $ciid, $title, $shortdesc, $ci, $status, $estimated){
$now = date("Y/m/d H:i:s", time());
$user = Whois();
try {
$sql = "update cis set name=:name, short_description=:shortdesc, description=:ci, status=:status, last_update_date=:last, last_update_by=:user, estimated_time=:estimated where id=:id";
	$stm = $db->prepare($sql);
	$stm->bindValue(':name', $title);
	$stm->bindValue(':shortdesc', $shortdesc);
	$stm->bindValue(':ci', $ci);
	$stm->bindValue(':status', $status);
	$stm->bindValue(':last', $now);
	$stm->bindValue(':id', $ciid);
	$stm->bindValue(':user', $user);
	$stm->bindValue(':estimated', $estimated);
	return $stm->execute();
	} catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function getNewCis($db){
	$rows = array();
	$stm = $db->prepare("SELECT * FROM cis WHERE name is not null and description is not null and short_description is not null and estimated_time is not null and status='published' ORDER by id DESC LIMIT 8");
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


function getCiId($db){
	$stm = $db->prepare("select max(id) from cis");
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

function getAttachments($db, $ciid){
	$rows = array();
	$stm = $db->prepare("SELECT id, name FROM upload where ciid = $ciid");
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
	$stm = $db->prepare("INSERT INTO upload (name, ciid, iid, user, size, type, content ) VALUES ('$fileName', '$ciid', 0, '$user', '$fileSize', '$fileType', '$content')");
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

function searchCIs($db, $search){
	$rows = array();
	
    if(strpos($search, '@') !== false){
    $stm = $db->prepare("SELECT ci.id, ci.name, ci.short_description FROM cis as ci join users_create_cis as uci on ci.id=uci.cis_id where uci.users_email=:search");  
    }else{
	$stm = $db->prepare("SELECT id, name, short_description FROM cis WHERE MATCH (name, short_description, description) AGAINST (:search) and status='published'");
    }
	$stm->bindValue(':search', $search);
	#$stm->bindValue(':searchlike', $searchlike);
    try{
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

function getFilterRes($db, $status, $tool, $user){
    $rows = array();
    $complement = $status == '%' && $user == '%' ? " AND ci.status='published'" : "";
    $complement2 = $status == 'draft' ? "(user.users_email like :user or ci.last_update_by like :user)" : "user.users_email like :user";
    try{
    $stm = $db->prepare("SELECT DISTINCT ci.id, ci.name, ci.short_description FROM cis as ci
        JOIN users_create_cis as user ON user.cis_id=ci.id
        JOIN cis_for_components as cfc ON cfc.cid_id=ci.id
        JOIN components as comp ON comp.id = cfc.components_id
        WHERE ci.status like :status and ".$complement2." and comp.tool like :tool ".$complement."");
    $stm->bindValue(':status', $status);
    $stm->bindValue(':tool', $tool);
    $stm->bindValue(':user', $user);
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


function setPublished($db, $ciid){
$now = date("Y/m/d H:i:s", time());
$user = Whois();

try {
$sql = "update cis set status='published', last_update_date=:last, last_update_by=:user where id=:id";
    $stm = $db->prepare($sql);
    $stm->bindValue(':last', $now);
    $stm->bindValue(':user', $user);
    $stm->bindValue(':id', $ciid);
    return $stm->execute();
    } catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function setRejected($db, $ciid, $justification){
$now = date("Y/m/d H:i:s", time());
$user = Whois();

try {
$sql = "update cis set status='rejected', last_update_date=:last, last_update_by=:user, justification=:justification where id=:id";
	$stm = $db->prepare($sql);
	$stm->bindValue(':last', $now);
	$stm->bindValue(':user', $user);
	$stm->bindValue(':justification', $justification);
	$stm->bindValue(':id', $ciid);
	return $stm->execute();
	} catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function sendEmail($db, $id, $name, $status, $type){
$teamid = WhosTeam();
$username='03c38cc1-4d8f-492f-9621-6d57632b1d90';
$password='c930a783-7b9c-4b3f-9caf-b97f294fb9b2';
$URL='https://bluemail.w3ibm.mybluemix.net/rest/v2/emails';
$email = array();
$email[] = "default@us.ibm.com";
$email[] = "default@us.ibm.com";
$email[] = "default@us.ibm.com";
$email[] = "default@us.ibm.com";
$email[] = "default@us.ibm.com";
$email[] = "default@us.ibm.com";
$i = 0;

$stm = $db->prepare("SELECT users_email from users_create_cis where cis_id=:id");
    $stm->bindValue(':id', $id);
    $stm->execute();
    while($result = $stm->fetch(PDO::FETCH_ASSOC)) {
    	$email[$i] = $result['users_email'];
    	$i++;
    }
    
$stm = $db->prepare("SELECT email from profiles where teams_id=:id and level='moderator'");
    $stm->bindValue(':id', $teamid);
    $stm->execute();
    while($result = $stm->fetch(PDO::FETCH_ASSOC)) {
    	$email[$i] = $result['email'];
    	$i++;
    }

if($status == 'published'){
	$postData = '{
	"contact": "NotReplyIbox@br.ibm.com",
	"recipients": [
	{"recipient": '.json_encode($email[0]).'},
        {"recipient": '.json_encode($email[1]).'},
        {"recipient": '.json_encode($email[2]).'},
        {"recipient": '.json_encode($email[3]).'},
        {"recipient": '.json_encode($email[4]).'},
        {"recipient": '.json_encode($email[5]).'}
	],
	"bcc": [
		{"recipient": "alimao@br.ibm.com"},
		{"recipient": "dfpf@br.ibm.com"}
	],
	"subject": "[IBOX] Your '.$type.' #'.$id.' was successfully '.$status.'        ",
	"message": "Hello,<br>Your '.$type.' entitled as <b>'.$name.'</b> was successfully approved by '.Whois().' and <b>'.$status.'</b> <br> Please visit <a href=\"https://ibox.w3ibm.mybluemix.net\">IBOX</a> and check on My '.$type.'s section. <br><br> Best Regards, <br> IBOX 2.0"
 }';

}if($status == 'review'){
	$postData = '{
	"contact": "NotReplyIbox@br.ibm.com",
	"recipients": [
	{"recipient": '.json_encode($email[0]).'},
        {"recipient": '.json_encode($email[1]).'},
        {"recipient": '.json_encode($email[2]).'},
        {"recipient": '.json_encode($email[3]).'},
        {"recipient": '.json_encode($email[4]).'},
        {"recipient": '.json_encode($email[5]).'}
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
	{"recipient": '.json_encode($email[0]).'},
        {"recipient": '.json_encode($email[1]).'},
        {"recipient": '.json_encode($email[2]).'},
        {"recipient": '.json_encode($email[3]).'},
        {"recipient": '.json_encode($email[4]).'},
        {"recipient": '.json_encode($email[5]).'}
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

function getAllTablesInfo($db, $ciid){
$rows = array();
$stm = $db->prepare("SELECT userc.users_email as userc, users.team as team, team.description as description FROM cis as ci
        JOIN users_create_cis as userc ON userc.cis_id=ci.id
        JOIN cis_for_components as cfc ON cfc.cid_id=ci.id
        JOIN components as comp ON comp.id = cfc.components_id
        JOIN teams as team ON comp.teams_id = team.id
        JOIN users as users ON users.email=userc.users_email 
        WHERE ci.id=:id");
$stm->bindValue(':id', $ciid);
$stm->execute();
$result = $stm->fetch(PDO::FETCH_ASSOC);
return $result;
}

function getTopColaborators($db){  
  $rows = array();
  $sth = $db->prepare("select uc.users_email as label, count(uc.cis_id) as value from users_create_cis as uc
  join cis as cis on cis.id=uc.cis_id where cis.status='published' group by uc.users_email order by count(uc.cis_id) desc");
  $sth->execute();

     while($result = $sth->fetch(PDO::FETCH_ASSOC)) {
	array_push($rows, $result);
	}
	return $rows;
}

function removeAttach($db, $id){
    
    $sql = "delete from upload where id=:id";
    try{
	$stm = $db->prepare($sql);
	$stm->bindValue(':id', $id);
	return $stm->execute();
    } catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function InsertImplementedCis($db, $ciid, $user, $customer_code, $saving, $comment){
$now = date("Y/m/d H:i:s", time());  
    $sql = "INSERT INTO implemented_cis VALUES (:customer_code, :user, :ciid, :saving, :date, :comment)";
    try{
	$stm = $db->prepare($sql);
	$stm->bindValue(':ciid', $ciid);
    $stm->bindValue(':user', $user);
    $stm->bindValue(':customer_code', $customer_code);
    $stm->bindValue(':saving', $saving);
    $stm->bindValue(':comment', $comment);  
    $stm->bindValue(':date', $now);
     
	return $stm->execute();
    } catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function getImplementedCis($db, $ciid){
  $rows = array();    
  $sth = $db->prepare("select distinct * from implemented_cis where cis_id=".$ciid);
  $sth->execute();

 while($result = $sth->fetch(PDO::FETCH_ASSOC)) {
	array_push($rows, $result);
	}
	return $rows;

}

function RepeatedImplementedCIs($db, $ciid, $customer_code){
 
    $stm = $db->prepare("SELECT * FROM implemented_cis WHERE cis_id=:ciid AND customers_code=:customer_code");
    $stm->bindValue(':ciid', $ciid);
    $stm->bindValue(':customer_code', $customer_code);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getVisitorsCount($db){
    $stm = $db->prepare("select UNIX_TIMESTAMP(date) * 1000 as date, count(*) as number from counter group by day(date) order by date");
    $stm->execute();
    return $stm->fetchAll(PDO::FETCH_NUM);
}

function getAllVisitors($db){
    $stm = $db->prepare("SELECT count(*) as number FROM counter");
    $stm->execute();
    return $stm->fetch(PDO::FETCH_ASSOC);
}

function getProfileUsers($db, $teams_id){
    $rows = array();    
    $sth = $db->prepare("select * from profiles where teams_id=:teams_id");
    $sth->bindValue(':teams_id', $teams_id);
    $sth->execute();

 while($result = $sth->fetch(PDO::FETCH_ASSOC)) {
	array_push($rows, $result);
	}
	return $rows;
}
