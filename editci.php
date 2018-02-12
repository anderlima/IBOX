<?php 
require_once("db_ci.php");
require_once("header.php");
require_once("user_logic.php");

checkUser();

if(isset($_POST['ciid']) || (isset($_SESSION['ciid']))){
$ciid = $_SESSION['ciid'] ? $_SESSION['ciid'] : "";
$ciid = $_POST['ciid'] ? $_POST['ciid'] : $ciid;

$ci = getInfoReg($db, $ciid, 'cis');
$thistool = getThisTool($db, $ciid);
$tools = getTools($db);
$users = getProfileUsers($db, WhosTeam());
$theseusers = getCIusers($db, $ciid);
$struser = "";
foreach ($theseusers as $thisuser) {
  $struser = $struser.", ".$thisuser['users_email'];
}

$cidescription = isset($_POST['ci']) ? $_POST['ci'] : $ci['description'];
$cidescription = isset($_SESSION['ci']) ? $_SESSION['ci'] : $cidescription; unset($_SESSION['ci']);
$ciname = isset($_POST['title']) ? $_POST['title'] : $ci['name'];
$ciname = isset($_SESSION['title']) ? $_SESSION['title'] : $ciname; unset($_SESSION['title']);
$shdescription = isset($_POST['shortdesc']) ? $_POST['shortdesc'] : $ci['short_description'];
$shdescription = isset($_SESSION['shortdesc']) ? $_SESSION['shortdesc'] : $shdescription; unset($_SESSION['shortdesc']);
$estimated = isset($_POST['estimated']) ? $_POST['estimated'] : $ci['estimated_time'];
$estimated = isset($_SESSION['estimated']) ? $_SESSION['estimated'] : $estimated; unset($_SESSION['estimated']);
?>
		  <div class="col-md-10">
          <div class="content-box-large">
          <div class="container">
          </div>
                 <div class="row">
          <?php showAlert("success"); ?>
          <?php showAlert("danger"); ?>
                 <div class="panel-heading col-md-10">
                      <div class="panel-title">CI Header</div>
                 </div>
                </div>
                  <div class="panel-body">
                  <form id="junction" action="edit_ci.php" method="post" enctype="multipart/form-data" >
                  <input id="ciID" type="hidden" name="ciid" value="<?=$ciid?>">
                  <fieldset>
                    <div class="form-group">
                    <button class="btn btn-primary" name="draft" type="submit">
                      <i class="fa fa-save"></i>
                      Save as Draft
                    </button>
                    <button class="btn btn-success" name="review" type="submit">
                      <i class="fa fa-save"></i>
                      Submit for Review
                    </button>
                    </div>

                    <div class="form-group">
                      <label>Title:</label>
                      <input required maxlength="50" name="title" class="form-control" placeholder="Title" type="text" value="<?=$ciname?>">
                    </div>
                    <div class="form-group row">
                      <div class=" col-xs-2"><label>Estimated Implementation Time:</label>
                      <input required name="estimated" class="form-control" placeholder="Min" type="number" min="10" max="43800" step="10" value="<?=$estimated?>">
                      </div>
                      <div class=" col-xs-4"><label>Add owner/s if not you:</label>
                      <select name="participant[]" class="form-control" size="3" multiple="multiple" tabindex="1">
                      <?php foreach($users as $user) :
                        $thisIstheUser = strpos($struser, $user['email']) !== false;
                        $selectuser = $thisIstheUser ? "selected='selected'" : "";
                      ?>
                        <option value="<?=$user['email']?>" <?=$selectuser?>><?=$user['email']?></option>
                      <?php endforeach; ?>
                      </select>
                      </div>
                    </div>
                      <label for="setTool">Tools: </label>
						          <select required class="form-control" id="setTool">
						          <option value="">Please select</option>
						          <?php
                      	 foreach($tools as $tool) :
                          $thisIstheTool = $thistool['tool'] == $tool['tool'];
                          $selecttool = $thisIstheTool ? "selected='selected'" : "";
						          ?>

  						        <option value="<?=$tool['tool']?>" <?=$selecttool?>><?=$tool['tool']?></option>
  						        <?php  endforeach; ?>
						          </select>
                    <div id ="results" class="row"></div>
                    </br></br>
                    <div class="form-group">
                      <label>Summary:</label>
                      <textarea required maxlength="420" name="shortdesc" class="form-control" placeholder="Short Description" rows="3"><?=$shdescription?></textarea>
                    </div>
                   </fieldset>
                   </div>

        			<div class="content-box-large">
          				<div class="panel-heading">
         				 	<div class="panel-title">CI Content</div>
         				<div class="panel-options">
            				<a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
            				<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
         				</div>
        				</div>
          				<div class="panel-body">
            				<textarea name="ci" id="ckeditor_full"><?=$cidescription?></textarea>
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
				$rows = getAttachments($db, $ciid);
					foreach ($rows as $row) {
					?>
					<div class="col-md-4"> </br>
					<label>
					<a href="download.php?id=<?=$row['id']?>"><?=$row['name']?></a> 
                        <a href="remattach.php?id=<?=$row['id']?>&ciid=<?=$ciid?>&name=<?=$row['name']?>" onclick="return confirm('This will remove <?=$row['name']?> permanently. Are you Sure?')"><span style="float: right; color: #d9534f;"><i class="glyphicon glyphicon-remove"></i></span></a>
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
	document.getElementById("junction").action = "editci.php#position";
	document.getElementById("junction").submit();
}
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>
      $("#setTool").on("click", function(){
        var ciid = $("#ciID").val();
        var selected = $(this).val();
        makeAjaxRequest(selected, ciid);
        });

      function makeAjaxRequest(opts, ciid){
  $.ajax({
    type: "POST",
    data: { opts: opts , ciid: ciid},
    url: "ajax_comp_edit.php",
    success: function(res) {
     $("#results").html(res);
    }
  });
}
</script>

<?php 
}
require_once("footer.php");
?>
