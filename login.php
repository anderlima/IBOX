<?php
require_once("db_user.php");
require_once("user_logic.php");
require_once("LDAPw3.php");

$redirect = isset($_POST['location']) ? $_POST['location'] : '';

if ($_POST['email']){
        if (empty($_POST['email']) || empty($_POST['password'])) {
                echo "error empty<br>";
        } elseif ($ds = @ldap_connect('ldaps://bluepages.ibm.com')) {
                echo "success connection";
                @ldap_bind($ds);
                $data = @ldap_search($ds, 'ou=bluepages,o=ibm.com', '(&(uid=*)(c=*)(mail='.$_POST['email'].'))');
                $info = @ldap_get_entries($ds, $data);
                if($info['count']){
                        $employee = ldap_result_format($info[0]);
                        if (@ldap_bind($ds, $employee['dn'], $_POST['password'])) {
                                #$_SESSION["success"] = "User successfully logged in!";
				$user = getUser($db, $employee['mail']);
                                if($user){
                                $_SESSION['registered'] = 'true';
                            }
                                $_SESSION["name"] = $employee['cn'];
			
			      logUser($_POST['email']);

			      CountVisits($db);
			      $team_id = getUserDefaultTeamId($db, $_POST['email']);
                              $team = getTeam($db, $team_id);
                              $myprofile = getMyProfile($db, $team_id, Whois());
                              setPrivilege($myprofile['level']);    
                              setUserProfile($team_id);
                              setTeamCategory($team['category']);

                              if($redirect != ''){
                              header("Location:". $redirect);
                             }else{
                              header("Location: index.php");
                             }

                            }else{
				$_SESSION["danger"] = "Wrong ID or Password";
                                header("Location: login_page.php");
                }
                @ldap_close($ds);
        } else {
                $_SESSION["danger"] = "Wrong ID or Password";
                header("Location: login_page.php");
        }
    }
}
?>
