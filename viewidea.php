<?php 
require_once("db_idea.php");
require_once("headidea.php");
require_once("user_logic.php");

checkUser();

if(isset($_POST['iid']) || (isset($_SESSION['iid'])) || (isset($_GET['iid']))){
$iid = $_GET['iid'] ? $_GET['iid'] : "";
$iid = $_SESSION['iid'] ? $_SESSION['iid'] : $iid;
$iid = $_POST['iid'] ? $_POST['iid'] : $iid;
if(isset($_SESSION['iid'])){unset($_SESSION['iid']);}

    if(!is_numeric($iid) || !getInfoReg($db, $iid, "ideas")){
    echo '<p align="center" style="width: 99.9%; text-align: center" class="alert-warning"><b>Url Not Found!</b></p>';
    die();
}
    
$idea = getInfoReg($db, $iid, "ideas");
$team_id = WhosTeam();
$team = getTeamName($db, $team_id);
    
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
						if((getLevel() == 'admin' || getLevel() == 'moderator') && $idea['status'] == 'review'){
						?>
						<form class="col-xs-3" action="publish_idea.php" method="post">
						<input type="hidden" name="iid" value="<?=$idea['id']?>">
						<button title="Approve Idea" style="color: #5CB85C;"><i class="glyphicon glyphicon-ok"></i></button>
						</form>
						<?php
						}
						?>
						<?php
						if((getLevel() == 'admin' || getLevel() == 'moderator') && $idea['status'] == 'review'){
						?>
						<form class="col-xs-3" action="rejectidea.php" method="post">
						<input type="hidden" name="iid" value="<?=$idea['id']?>">
						<button title="Reject Idea" style="color: #d9534f;"><i class="glyphicon glyphicon-remove"></i></button>
						</form>
						<?php
						}
						?>
						<?php
						if($idea['owner'] == Whois() && $idea['status'] == 'draft'){
						?>
						<form class="col-xs-3" action="editidea.php" method="post">
						<input type="hidden" name="iid" value="<?=$idea['id']?>">
						<button title="Edit Idea"><i class="glyphicon glyphicon-edit"></i></button>
						</form>
						<?php
						}
						?>
						</div>
						</div>
		  			</div>
		  			<div class="content-box-large box-with-header">
                        <div class="col-md-12">
                            <div class="col-md-6 well">
                                <p><b>Owner:</b> <?=$idea['owner']?>_<?=$team?> <img style="float: right;" src="http://images.tap.ibm.com:10002/image/alimao@br.ibm.com.jpg?s=45"> </p>
                                <p><b>Status:</b> <?=$idea['status']?></p><br>
                            </div>
                            <div class="col-md-6 well">
                                <p><b>Approver:</b> <?=$idea['approver']?></p>
                                <p><b>URL: </b>https://ibox.w3ibm.mybluemix.net/viewidea.php?iid=<?=$idea['id']?></p><br>
                            </div>
                        </div>
                        <h4>Idea</h4>
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
}else{
    echo '<p align="center" style="width: 99.9%; text-align: center" class="alert-warning"><b>Url Not Found!</b></p>';
}
require_once("foot.php");
?>
