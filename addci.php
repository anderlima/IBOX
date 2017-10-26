<?php 
require_once("db_ci.php");
require_once("db_user.php");
require_once("header.php");
require_once("user_logic.php");

checkUser();

if(!$_SESSION['registered']){
echo '<p class="alert-info text-center"><b>Only registered users can create CIs. Please talk to administrator!</b></p>';
}else{
?>
		  <div class="col-md-10">
              <div class="content-box-large">
                      <div class="container">
          <?php showAlert("success"); ?>
          <?php showAlert("danger"); ?>
          </div>
                 <div class="row">
                 <div class="panel-heading col-md-10">
                      <div class="panel-title">CI Composer</div>
                 </div>
                </div>
                  <div class="panel-body">
                  <form action="add_ci.php" method="post">
                  <fieldset>
                    <div class="form-group">
                    <button class="btn btn-primary" type="submit">
                      <i class="fa fa-save"></i>
                      Add New CI
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
}
require_once("footer.php");
?>
