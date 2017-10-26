<?php 
require_once("db_ci.php");
require_once("header.php");
require_once("user_logic.php");

checkUser();

if(isset($_POST['search'])){
$cis = searchCIs($db, $_POST['search']);
}else{
	$cis = getNewCis($db);
}

?>
		  		<div class="col-md-10">
	  <?php showAlert("success"); ?>
          <?php showAlert("danger"); ?>
		  			<div class="row">

<?php 

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
				  			<?php 
				  			if (strlen($idea['description']) > 445) {
				  				$content = substr(htmlspecialchars(strip_tags($ci['short_description'])), 0, 445)."...";
				  			}else{
				  				$content = htmlspecialchars(strip_tags($ci['short_description']));
				  			}
				  			?>
				  			<div class="content-box-large box-with-header">
					  			<?=htmlspecialchars($content)?>
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
