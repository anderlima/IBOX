<?php 
require_once("headprofile.php");
require_once("user_logic.php");
checkUser();
?>

    	<div class="col-md-10">
          <div class="content-box-large">
                <div class="row">
                    <?php showAlert("success"); ?>
                    <?php showAlert("danger"); ?>
                 <div class="panel-heading col-md-10">
                      <div class="panel-title">Add Team</div>
                 </div>
                </div>
                <div class="panel-body">
                  <form action="add_team.php" method="post" enctype="multipart/form-data" >
                  <fieldset>
                   <div class="row">
                    <div class="form-group col-md-6">
                      <label>Team Name:</label>
                      <input required maxlength="20" name="name" class="form-control" placeholder="Team Name" type="text" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Category:</label>
                        <select class="form-control" name="category">
                            <option value="idea" selected>Ideas</option>
                            <option value="ci">Improvements</option>
                            <option value="both">Both</option>
                        </select>
                    </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-12">
                      <label>Description:</label>
                      <input required maxlength="80" name="description" class="form-control" placeholder="Description" type="text" autocomplete="off">
                    </div>
                    </div>
                    <div class="form-group">
                         <button class="btn btn-warning" type="submit">Submit</button>
                    </div>
                    
                   </fieldset>
                   </form>
                 </div>
         </div>
       </div>


<?php
require_once("foot.php");
?>