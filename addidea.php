<?php 
require_once("db_idea.php");
require_once("headidea.php");

?>
		  <div class="col-md-10">
              <div class="content-box-large">
                      <div class="container">
          <?php showAlert("success"); ?>
          <?php showAlert("danger"); ?>
          </div>
                 <div class="row">
                 <div class="panel-heading col-md-10">
                      <div class="panel-title">New Idea</div>
                 </div>
                </div>
                  <div class="panel-body">
                  <form action="add_idea.php" method="post">
                  <fieldset>
                    <div class="form-group">
                    <button class="btn btn-primary" type="submit">
                      <i class="fa fa-save"></i>
                      Add New Idea
                    </button>
                    </div>
                    <div class="form-group">
                      <label>Title</label>
                      <input name="title" required maxlength="50" class="form-control" placeholder="Title" type="text">
                    </div>
                   </fieldset>
                </div>
                </div>
            		</div>
<?php 
require_once("footer.php");
?>