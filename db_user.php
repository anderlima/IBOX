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
