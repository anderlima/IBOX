<?php 
require_once("db_ci.php");
require_once("header.php");
require_once("user_logic.php");

checkUser();

if(isset($_POST['ciid']) || (isset($_SESSION['ciid']))){
$ciid = $_SESSION['ciid'] ? $_SESSION['ciid'] : "";
$ciid = $_POST['ciid'] ? $_POST['ciid'] : $ciid;
if(isset($_SESSION['ciid'])){unset($_SESSION['ciid']);}

$ci = getInfoReg($db, $ciid, "cis");
$info = getAllTablesInfo($db, $ciid);
$owners = getCIusers($db, $ciid);
$out = "";
foreach($owners as $owner){
    $out .= implode(",", $owner) . "\r\n"; //transform array on string csv
}
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
	  					<div class="panel-title "><?=$ci['name']?></div>
						<div class="panel-options">
						<div class="row">
                        <?php
                        if(($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'moderator') && $ci['status'] == 'review'){
                        ?>
                        <form class="col-xs-3" action="publish.php" method="post">
                        <input type="hidden" name="ciid" value="<?=$ci['id']?>">
                        <button style="color: #5CB85C;"><i class="glyphicon glyphicon-ok"></i></button>
                        </form>
                        <?php
                        }
                        ?>
                        <?php
						if(($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'moderator') && $ci['status'] == 'review'){
						?>
						<form class="col-xs-3" action="rejectci.php" method="post">
						<input type="hidden" name="ciid" value="<?=$ci['id']?>">
						<button style="color: #d9534f;"><i class="glyphicon glyphicon-remove"></i></button>
						</form>
						<?php
						}
						?>
                        <?php
                        if($_SESSION['level'] == 'admin' || ($ci['last_update_by'] == Whois() && $ci['status'] == 'draft') || (strpos($out, Whois()) !== false && $ci['status'] == 'draft' || $ci['status'] == 'rejected')){
                        ?>
                        <form class="col-xs-3" action="editci.php" method="post">
                        <input type="hidden" name="ciid" value="<?=$ci['id']?>">
                        <button><i class="glyphicon glyphicon-edit"></i></button>
                        </form>
                        <?php
                        }
                        ?>
                        </div>
						</div>
		  			</div>
		  			<div class="content-box-large box-with-header">
                       <p align="right"><b>Owner:</b> <?=$info['user']?>_<?=$info['team']?></p>
                       <p align="right"><b>Last updated by:</b> <?=$ci['last_update_by']?></p><br>
			  			<?=$ci['short_description']?>
						<br /><br />
					</div>
		  		</div>
		  	</div>
		  	<div class="content-box-large">
				<?=$ci['description']?>
		  	</div>
                <?php
                if($ci['status'] == 'rejected'){
				?>
    <div class="content-box-large box-with-header"><label>Rejection Justification: </label></br>
			  	<?=$ci['justification']?>
				<br /><br />
				</div>
				<?php } ?>
		  </div>

<?php 
}
require_once("foot.php");
?>
