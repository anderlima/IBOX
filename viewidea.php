<?php 
require_once("db_idea.php");
require_once("headidea.php");
require_once("user_logic.php");

checkUser();

if(isset($_POST['iid']) || (isset($_SESSION['iid']))){
$iid = $_SESSION['iid'] ? $_SESSION['iid'] : "";
$iid = $_POST['iid'] ? $_POST['iid'] : $iid;
if(isset($_SESSION['iid'])){unset($_SESSION['iid']);}

$idea = getInfoReg($db, $iid, "ideas");
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
<div class="col-md-10">
		  <?php showAlert("success"); ?>
          <?php showAlert("danger"); ?>
		  	<div class="row">
		  		<div class="col-md-12 panel-warning">
		  			<div class="content-box-header panel-heading">
	  					<div class="panel-title "><?=$idea['name']?></div>
						<div class="panel-options">
						<div class="row">
						<?php
						if($_SESSION['level'] == 'admin' && $idea['status'] == 'review'){
						?>
						<form class="col-xs-3" action="publish_idea.php" method="post">
						<input type="hidden" name="iid" value="<?=$idea['id']?>">
						<button style="color: #5CB85C;"><i class="glyphicon glyphicon-ok"></i></button>
						</form>
						<?php
						}
						?>
						<?php
						if($_SESSION['level'] == 'admin' && $idea['status'] == 'review'){
						?>
						<form class="col-xs-3" action="rejectidea.php" method="post">
						<input type="hidden" name="iid" value="<?=$idea['id']?>">
						<button style="color: #d9534f;"><i class="glyphicon glyphicon-remove"></i></button>
						</form>
						<?php
						}
						?>
						<?php
						if($idea['owner'] == Whois() && $idea['status'] == 'draft'){
						?>
						<form class="col-xs-3" action="editidea.php" method="post">
						<input type="hidden" name="iid" value="<?=$idea['id']?>">
						<button><i class="glyphicon glyphicon-edit"></i></button>
						</form>
						<?php
						}
						?>
						</div>
						</div>
		  			</div>
		  			<div class="content-box-large box-with-header">
		  				<p align="right"><b>Team:</b> <?=$idea['team']?></p>
		  				<p align="right"><b>Created by:</b> <?=$idea['owner']?></p></br>
			  			<?=$idea['description']?>
						<br/><br/>
					</div>
						<?php
						if($idea['status'] == 'rejected'){
						?>
						<div class="content-box-large box-with-header"><label>Justification: </label>
			  			<?=$idea['justification']?>
						<br /><br />
					 </div>
					    <?php } ?>
		  		</div>
		  	</div>
		  </div>


<?php 
}
require_once("foot.php");
?>