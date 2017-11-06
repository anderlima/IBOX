<?php 
require_once("headidea.php");
require_once("user_logic.php");

checkUser();

if(isset($_POST['iid'])){
$_SESSION['iid'] = $_POST['iid'];
$idea = getInfoReg($db, $_POST['iid'], 'ideas');
?>
<div class="col-md-10">
          <div class="content-box-large">
          	<div class="container">
          	 <div class="form-group col-xs-8">
						<form action="reject_idea.php" method="post">
						<div class="form-group">
                      		<label>Justification:</label>
                      		<input type="hidden" name="iid" value="<?=$idea['id']?>">
                     		<textarea required maxlength="500" name="justification" class="form-control" placeholder="Justification for rejection" rows="3"><?=$idea['justification']?></textarea>
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
