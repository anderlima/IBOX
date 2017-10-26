<?php
#-----------------------------------------------------------------
#Error Dumps
error_reporting(E_ALL ^ E_NOTICE);
ini_set( "display_errors", 0);

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'index.php';
#-----------------------------------------------------------------
require_once "ldapw3.php";
#include "db-connect.php";

$userid = $_POST['userid'];
$ldappass = $_POST['ldappass'];

$ldap_result = W3_ldap_authenticate($userid, $ldappass);
$ldap_result = array(0);

if ($ldap_result[0] == 0) {
            if ($ds = @ldap_connect('bluepages.ibm.com')) {
                echo "success connection <br>";
                @ldap_bind($ds);
                $data = @ldap_search($ds, 'ou=bluepages,o=ibm.com', '(&(uid=*)(c=*)(mail='.$userid.'))');
                $info = @ldap_get_entries($ds, $data);
                if($info['count']){
                        $employee = ldap_result_format($info[0]);
                        if (@ldap_bind($ds, $employee['dn'], $ldappass)) {
						session_start();
                                                $_SESSION["notesid"] = $employee['notesid'];
						$_SESSION['iduser'] = $userid;
						$_SESSION['nomeuser'] = $nome;
              					$arr = explode('/', $_SESSION["notesid"], 2);
						$arr = explode('=', $arr[0], 2);
						$arr = $arr[1];	
						$_SESSION['uname'] = $arr;
						echo $_SESSION['uname']."<br>";
						#$hasuser = CheckExistUser($db, $userid);
						#if ($hasuser == null){
						#$sth = $db->prepare("INSERT INTO users (uemail, uname) Values (:email, :name)");
						#$sth->bindValue(':email', $_SESSION['iduser']);
						#$sth->bindValue(':name', $_SESSION['uname']);
						#$sth->execute();
						#}
						echo "<script>location.href='index.php';</script>";
					   }
					
					}
                @ldap_close($ds);
        		} 
       
	} else {
      	$AD = md5($ldap_result[0]);
       	echo "<script>location.href='login_page.php';</script>"; #?authorization_check=". $AD);); exit;
       	exit;
	}

#function CheckExistUser($db, $email){
	#$sth = $db->prepare("SELECT * FROM users where uemail = :email");
		#$sth->bindValue(':email', $email);

		#$sth->execute();
  		#$result = $sth->fetch(PDO::FETCH_ASSOC);

#return $result;
#}
?>
