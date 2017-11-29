<?php 
require_once("db_ci.php");
require_once("header.php");
require_once("user_logic.php");

checkUser();

if(isset($_POST['ciid']) || (isset($_SESSION['ciid'])) || (isset($_GET['ciid']))){
$ciid = $_GET['ciid'] ? $_GET['ciid'] : "";
$ciid = $_SESSION['ciid'] ? $_SESSION['ciid'] : $ciid;
$ciid = $_POST['ciid'] ? $_POST['ciid'] : $ciid;
if(isset($_SESSION['ciid'])){unset($_SESSION['ciid']);}

if(!is_numeric($ciid) || !getInfoReg($db, $ciid, "cis")){
    echo '<p align="center" style="width: 99.9%; text-align: center" class="alert-warning"><b>Url Not Found!</b></p>';
    die();
}

$ci = getInfoReg($db, $ciid, "cis");
$info = getAllTablesInfo($db, $ciid);
$owners = getCIusers($db, $ciid);
$implementedcis = getImplementedCis($db, $ciid);
$csvimp = "";
foreach($implementedcis as $impci) :
    $csvimp = $csvimp.", ".$impci['customers_code'];
endforeach;
$csvimp = $csvimp == "" ? $csvimp = "None" : $csvimp;
    
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
                        <?php
                        if(($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'moderator') && $ci['status'] == 'review'){
                        ?>
                        <form class="col-xs-4" action="publish.php" method="post">
                        <input type="hidden" name="ciid" value="<?=$ci['id']?>">
                        <button title="Publish CI" style="color: #5CB85C;"><i class="glyphicon glyphicon-ok"></i></button>
                        </form>
                        <?php
                        }
                       	if(($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'moderator') && $ci['status'] == 'review'){
						?>
						<form class="col-xs-4" action="rejectci.php" method="post">
						<input type="hidden" name="ciid" value="<?=$ci['id']?>">
						<button title="Reject CI" style="color: #d9534f;"><i class="glyphicon glyphicon-remove"></i></button>
						</form>
						<?php
						}
                        if($_SESSION['level'] == 'admin' || ($ci['last_update_by'] == Whois() && $ci['status'] == 'draft') || (strpos($out, Whois()) !== false && $ci['status'] == 'draft' || $ci['status'] == 'rejected')){
                        ?>
                        <form class="col-xs-4" action="editci.php" method="post">
                        <input type="hidden" name="ciid" value="<?=$ci['id']?>">
                        <button title="Edit CI" ><i class="glyphicon glyphicon-edit"></i></button>
                        </form>
                        <?php
                        }
                        if($ci['status'] == 'published'){
                        ?>
                        <div class="col-xs-4">
                        <input id="idimp" type="hidden" name="ciid" value="<?=$ci['id']?>">
                        <a href="#" id="setImp" title="Implement CI" style="color: #5CB85C;"><i class="glyphicon glyphicon-tags"></i></a>
                        </div>
                        <?php
                        }
                        ?>
					    </div>
		  			</div>
		  			<div class="content-box-large box-with-header">
                        <div id="results1" class="col-md-12"></div>
                        <div class="col-md-12">
                            <div class="col-md-6 well">
                                <p><b>Owner:</b> <?=$info['userc']?>_<?=$info['team']?></p>
                                <p><b>Last updated by:</b> <?=$ci['last_update_by']?></p>
                                <p><b>Status:</b> <?=$ci['status']?></p><br>
                            </div>
                            <div class="col-md-6 well">
                                <p><b>Accounts Implemented:</b> <?=trim($csvimp,',')?></p>
                                <p><b>Category:</b> <?=$info['description']?></p>
                                <p><b>URL: </b>https://ibox.w3ibm.mybluemix.net/viewci.php?ciid=<?=$ci['id']?></p><br>
                            </div>
                        </div>
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


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
    $("#setImp").on("click", function(){
        var ciid = $("#idimp").val();
        var selected = $(this).val();
        makeAjaxImpReq(selected, ciid);
        });
    
function makeAjaxImpReq(opts, ciid){
  $.ajax({
    type: "POST",
    data: { opts: opts , ciid: ciid},
    url: "ajax_implement_ci.php",
    success: function(res) {
     $("#results1").html(res);
    }
  });
}
</script>

<?php 
}else{
    echo '<p align="center" style="width: 99.9%; text-align: center" class="alert-warning"><b>Url Not Found!</b></p>';
}
require_once("foot.php");
?>

