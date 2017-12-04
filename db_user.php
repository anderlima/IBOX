<?php
require_once("db_conn.php");

function getUser($db, $email) {
	#   $passMd5 = md5($password);
    	$sth = $db->prepare("select * from users where email= :email");
    	$sth->bindValue(':email', $email);
	    $sth->execute();
  	  $result = $sth->fetch(PDO::FETCH_ASSOC);

      return $result;
}

function AlterUser($db, $email, $group, $bucket){
    $sth = $db->prepare("UPDATE users SET groups= :group, bucket= :bucket WHERE email= :email");

      $sth->bindValue(':group', $group);
      $sth->bindValue(':bucket', $bucket);
      $sth->bindValue(':email', $email);

      return $sth->execute();
}

function CountVisits($db){
$now = date("Y-m-d H:i:s", time());
try {
$sql = "Insert into counter (date) values (:now);";
  $stm = $db->prepare($sql);
  $stm->bindValue(':now', $now);
  return $stm->execute();
  } catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function getUserDefaultTeamId($db, $email){
    $sth = $db->prepare("select teams_id from profiles where email=:email and isdefault=1");
    $sth->bindValue(':email', $email);
    $sth->execute();
    $result = $sth->fetch();
	return $result['teams_id'];
}

function getMyProfile($db, $team_id, $user){
    $stm = $db->prepare("SELECT * FROM profiles WHERE email=:user AND teams_id=:team_id");
    $stm->bindValue(':user', $user);
    $stm->bindValue(':team_id', $team_id);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getMyTeams($db, $member){
    $rows = array();    
    $sth = $db->prepare("select team.name as name, prof.teams_id as id from teams as team JOIN profiles as prof ON prof.teams_id=team.id where prof.email='".$member."'");
    $sth->execute();

 while($result = $sth->fetch(PDO::FETCH_ASSOC)) {
	array_push($rows, $result);
	}
	return $rows;
}

function AddTeam($db, $name, $description, $category, $user){
    $now = date("Y/m/d H:i:s", time());
    $sql = "INSERT INTO teams (name, description, category, owner, date) VALUES (:name, :description, :category, :owner, :date); INSERT INTO profiles (email, teams_id, level, isdefault) VALUES (:owner, (select max(id) from teams), 'admin', 1);";
    try{
	$stm = $db->prepare($sql);
	$stm->bindValue(':name', $name);
    $stm->bindValue(':description', $description);
    $stm->bindValue(':category', $category);
    $stm->bindValue(':owner', $user);
    $stm->bindValue(':date', $now);  
     
	return $stm->execute();
    } catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function CheckRepeatedTeam($db, $name){
    $stm = $db->prepare("SELECT * from teams WHERE name='".$name."'");
    $stm->execute();
    return $stm->fetch(PDO::FETCH_ASSOC);
}

function getProfiles($db, $teams_id){
    $rows = array();    
    $sth = $db->prepare("select * from profiles where teams_id=:teams_id");
    $sth->bindValue(':teams_id', $teams_id);
    $sth->execute();

 while($result = $sth->fetch(PDO::FETCH_ASSOC)) {
	array_push($rows, $result);
	}
	return $rows;
}

function getTeamId($db){
	$stm = $db->prepare("select max(id) from teams");
	$stm->execute();
	$result = $stm->fetch(PDO::FETCH_NUM);
	$ciid = $result[0];
	return $ciid;
}

function checkRepeatedProfile($db, $teamid, $email){
    $stm = $db->prepare("SELECT * from profiles WHERE email='".$email."' AND teams_id='".$teamid."'");
    $stm->execute();
    return $stm->fetch(PDO::FETCH_ASSOC);
}

function AddProfile($db, $teamid, $email, $level){
    $now = date("Y/m/d H:i:s", time());
    $sql = "INSERT INTO profiles (email, teams_id, level, isdefault) VALUES (:email, :teams_id, :level, :default)";
    try{
	$stm = $db->prepare($sql);
	$stm->bindValue(':email', $email);
    $stm->bindValue(':teams_id', $teamid);
    $stm->bindValue(':level', $level);
    $stm->bindValue(':default', 1);
     
	return $stm->execute();
    } catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function AlterProfile($db, $profileid, $level){
    $sql = "UPDATE profiles set level=:level WHERE id=:id";
    try{
	$stm = $db->prepare($sql);
	$stm->bindValue(':id', $profileid);
    $stm->bindValue(':level', $level);
     
	return $stm->execute();
    } catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function RemoveProfile($db, $profileid){
    $sql = "DELETE from profiles WHERE id=:id";
    try{
	$stm = $db->prepare($sql);
	$stm->bindValue(':id', $profileid);

	return $stm->execute();
    } catch(PDOException $e)
  {
   $_SESSION["danger"] =  "Error " . $e->getMessage();
  }
}

function getTeam($db, $id){
	$stm = $db->prepare("SELECT * FROM teams WHERE id = :id");
	$stm->bindValue(':id', $id);
	$stm->execute();

	$result = $stm->fetch(PDO::FETCH_ASSOC);

	return $result;
}
