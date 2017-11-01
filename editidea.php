<?php 
require_once("db_idea.php");
require_once("headidea.php");
require_once("user_logic.php");

checkUser();

if(isset($_POST['iid']) || (isset($_SESSION['iid']))){
$iid = $_SESSION['iid'] ? $_SESSION['iid'] : "";
$iid = $_POST['iid'] ? $_POST['iid'] : $iid;


$idea = getInfoReg($db, $iid, 'ideas');
$teams = getInfoAll($db, 'teams');

$ideaname = isset($_POST['title']) ? $_POST['title'] : $idea['name'];
$ideaname = isset($_SESSION['title']) ? $_SESSION['title'] : $ideaname; unset($_SESSION['title']);
$ideateam = isset($_POST['team']) ? $_POST['team'] : $idea['team'];
$ideateam = isset($_SESSION['team']) ? $_SESSION['team'] : $estimated; unset($_SESSION['team']);
$ideadescription = isset($_POST['idea']) ? $_POST['idea'] : $idea['description'];
$ideadescription = isset($_SESSION['idea']) ? $_SESSION['idea'] : $ideadescription; unset($_SESSION['idea']);

?>
		  <div class="col-md-10">
          <div class="content-box-large">
          <div class="container">
          </div>
                 <div class="row">
                 <?php showAlert("success"); ?>
                 <?php showAlert("danger"); ?>
                 <div class="panel-heading col-md-10">
                      <div class="panel-title">Idea Header</div>
                 </div>
                </div>
                  <div class="panel-body">
                  <form id="junction" action="edit_idea.php" method="post" enctype="multipart/form-data" >
                  <input id="ideaID" type="hidden" name="iid" value="<?=$iid?>">
                  <fieldset>
                  <div class="form-group">
                    <button class="btn btn-primary" name="draft" type="submit">
                      <i class="fa fa-save"></i>
                      Save As Draft
                    </button>
                     <button class="btn btn-success" name="review" type="submit">
                      <i class="fa fa-save"></i>
                      Submit for Review
                    </button>
                   </div>

                    <div class="form-group">
                      <label>Title:</label>
                      <input required maxlength="50" name="title" class="form-control" placeholder="Title" type="text" value="<?=$ideaname?>">
                    </div>
                    <div class="form-group row">
                      <div class=" col-xs-4"><label>Team:</label>
                      <select name="team" class="form-control">
                      <?php foreach($teams as $team) :
                      	$thisIstheTeam = $ideateam == $team['name'];
                        $selectteam = $thisIstheTeam ? "selected='selected'" : "";
                      ?>
                        <option value="<?=$team['name']?>" <?=$selectteam?>><?=$team['name']?></option>
                      <?php endforeach; ?>
                      </select>
                      </div>
                    </div>
        			<div class="content-box-large">
          				<div class="panel-heading">
         				 	<div class="panel-title">Idea</div>
         				<div class="panel-options">
            				<a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
            				<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
         				</div>
        				</div>
          				<div class="panel-body">
            				<textarea name="idea" id="ckeditor_full"><?=$ideadescription?></textarea>
          				</div>
        			</div>
        			<!-- </form> -->

        <div class="content-box-large">
          <div class="panel-heading">
          <div class="panel-title">Attachments</div>

          <div class="panel-options">
            <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
            <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
          </div>
        </div>
          <div class="panel-body">
          		<!-- <form method="post" id="position" action="editci.php" enctype="multipart/form-data"> -->
					<table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
						<tr>
						<td width="246">
							<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
							<input name="userfile" type="file" id="userfile">
						</td>
						<td width="80"><input name="upload" type="submit" class="box" onclick="changeForm()" id="upload" value=" Upload "></td>
						</tr>
					</table>
				</form> </br></br>
				<div class="row">
            <?php
            	include_once('upfile.php');
				$rows = getAttachments($db, $iid);
				 foreach ($rows as $row) {
					?>
					<div class="col-md-4"> </br>
					<label>
					<a href="download.php?id=<?=$row['id']?>"><?=$row['name']?></a> 
                        <a href="remattach.php?id=<?=$row['id']?>&iid=<?=$iid?>&name=<?=$row['name']?>" onclick="return confirm('This will remove <?=$row['name']?> permanently. Are you Sure?')"><span style="float: right; color: #d9534f;"><i class="glyphicon glyphicon-remove"></i></span></a>
                        <?php echo '<input type="text" class="form-control" value="download.php?id='.$row['id'].'">'?>
					</label>
                    </div>
				<?php
					}
				?>
				</div>
				<div id="position"></div>
          </div>
        </div>

	  </div>
    </div>
  </div>

<script type="text/javascript">
function changeForm(){
	document.getElementById("junction").action = "editidea.php#position";
	document.getElementById("junction").submit();
}
</script>

<?php 
}
require_once("footer.php");
?>
