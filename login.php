<?php
require_once("db_user.php");
require_once("user_logic.php");
require_once("LDAPw3.php");

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
				                logUser($_POST['email'], $_SESSION["name"]);
                        if($user['level'] == 'admin') {
                                $level = "admin";
                            }elseif($user['level'] == 'moderator'){
                                $level = "moderator";
                            }else{
                                $level = "user";
                            }
                              setPrivilege($level);
				              echo "<br>".$_SESSION["name"]."<br>";
			      CountVisits($db);
                              header("Location: index.php");
                            } else {
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
