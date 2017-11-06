<?php 
require_once("header.php");
require_once("user_logic.php");

checkUser();

if(isset($_POST['ciid'])){
$_SESSION['ciid'] = $_POST['ciid'];
$ci = getInfoReg($db, $_POST['ciid'], 'cis');
?>
<div class="col-md-10">
          <div class="content-box-large">
          	<div class="container">
          	 <div class="form-group col-xs-8">
						<form action="reject_ci.php" method="post">
						<div class="form-group">
                      		<label>Justification:</label>
                      		<input type="hidden" name="ciid" value="<?=$ci['id']?>">
                     		<textarea required maxlength="500" name="justification" class="form-control" placeholder="Justification for rejection" rows="3"><?=$ci['justification']?></textarea>
                   		</div>
						<button class="btn btn-danger" name='submit' type="submit">Reject</button>
						</form>
			 </div>
		   	</div>
		   </div>
</div>

<?php
}
require_once("foot.php");
?>