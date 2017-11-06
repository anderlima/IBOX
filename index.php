<?php 
require_once("db_ci.php");
require_once("header.php");
require_once("user_logic.php");

checkUser();
unset($_SESSION['ci']);
unset($_SESSION['title']);
unset($_SESSION['shortdesc']);
unset($_SESSION['estimated']);
unset($_SESSION['ciid']);


if(isset($_POST['search'])){
$cis = searchCIs($db, $_POST['search']);
}else{
	$cis = getNewCis($db);
}

?>
		  		<div class="col-md-10">
		  			<div class="row">

<?php 

if(isset($_GET['i'])){
switch ($_GET['i']) {
    case 1:
        $cis = getFilterRes($db, 'review', '%', '%');
        break;
    case 2:
        $cis = getFilterRes($db, 'draft', '%', Whois());
        break;
    case 3:
        $cis = getFilterRes($db, 'published', '%', Whois());
        break;
    case 4:
        $cis = getFilterRes($db, 'rejected', '%', Whois());
        break;
    case 5:
        $cis = getFilterRes($db, '%', 'ITM-Infrastructure', '%');
        break;
    case 6:
        $cis = getFilterRes($db, '%', 'ITM-OS', '%');
        break;
    case 7:
        $cis = getFilterRes($db, '%', 'ITM-DB', '%');
        break;
    case 8:
        $cis = getFilterRes($db, '%', 'ITM-APP', '%');
        break;
    case 9:
        $cis = getFilterRes($db, '%', 'Netcool', '%');
        break;
    case 10:
        $cis = getFilterRes($db, '%', 'Bluecare', '%');
        break;
    default:
        $cis = $cis;
}
}

if(count($cis) == 0){
    $_SESSION['danger'] = "Your search or view has returned 0 CIs!";
    showAlert("danger");
}

					foreach($cis as $ci) :
?>
<style type="text/css">
button {
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
    color: #3385ff;
}
</style>
	  				  <div class="col-md-6">
		  				<form action="viewci.php" method="post">
		  				<input type="hidden" name="ciid" value="<?=$ci['id']?>">
		  					<div class="content-box-header">
			  					<div name="title" class="panel-title"><?=$ci['name']?></div>
								<div class="panel-options">
									<button><i class="glyphicon glyphicon-log-in"></i></button>
								</div>
				  			</div>
				  			<div class="content-box-large box-with-header" style="min-height: 160px;">
					  			<?=htmlspecialchars($ci['short_description'])?>
								<br /><br />
							</div>
						</form>
		  			  </div>
<?php 
					endforeach;
?>
		  			</div>
<?php 
require_once("foot.php");
?>
