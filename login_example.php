<?php
	require_once('LDAPw3.php');
?>
<form id="loginPage" method="post" action="index.php" enctype="application/x-www-form-urlencoded">
	<br>
	<label for="IntranetID">Intranet ID: <span class="ibm-required">*</span></label>
	<span><input id="IntranetID" type="text" name="username" value="" size="30" /></span>
	<br>
	<label for="Password">Password:<span class="ibm-required">*</span></label>
	<span><input id="Password" type="password" name="password" value="" size="30" /></span>
	<div class="ibm-columns">
	<div class="ibm-col-6-1"><p><input type="submit" name="ibm-submit" value="Log In" class="ibm-btn-pri" /></p></div>
	</div>
</form>
<?php
if ($_POST['username']){
//	$_POST['username'] = lower(strip($_POST['username']));
//	$_POST['password'] = strip($_POST['password']);
	echo $_POST['username']." TRYING TO LOGIN<BR>";

	if (empty($_POST['username']) || empty($_POST['password'])) {
		echo "error<br>";
	} elseif ($ds = @ldap_connect('ldaps://bluepages.ibm.com')) {

		@ldap_bind($ds);
		// Search LDAP server
		$data = @ldap_search($ds, 'ou=bluepages,o=ibm.com', '(&(uid=*)(c=*)(mail='.$_POST['username'].'))');
		$info = @ldap_get_entries($ds, $data);

		echo "$data<br>";
		echo "$info<br>";

		if($info['count']){
			$employee = ldap_result_format($info[0]);
			// AQUI CHECA SE PASSWORD ESTÁ CORRETO
			if (@ldap_bind($ds, $employee['dn'], $_POST['password'])) {
				echo "PWD OK! <BR>";
				
#----Standard Connect----
#$link = mysqli_connect("us-cdbr-sl-dfw-01.cleardb.net", "b5a633a3f56c99", "8c58a8b8", "ibmx_a4bc7dcebd0f758");
#
#if (!$link) {
#    echo "Error: Unable to connect to MySQL." . PHP_EOL;
#   echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
#   echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
#    exit;
#}

#echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
#echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

#mysqli_close($link);
#End connect

#---PDO Connect----
$db = new PDO('mysql:host=us-cdbr-sl-dfw-01.cleardb.net;dbname=ibmx_a4bc7dcebd0f758;charset=utf8mb4', 'b5a633a3f56c99', '8c58a8b8');

foreach($db->query('SELECT * FROM users') as $row) {
    echo '<br>'.$row['email'];
}
header("Location: testeditor.php");
#phpinfo();
				}	
			} else
				echo "PWD NAO PASSOU <BR>";
		}
	@ldap_close($ds);
	} else {
		echo "NAO PASSOU 2 <BR>";
	}
?>



