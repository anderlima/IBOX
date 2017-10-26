<?php 
require_once("db_idea.php");
require_once("headidea.php");
require_once("user_logic.php");

checkUser();
unset($_SESSION['title']);
unset($_SESSION['team']);
unset($_SESSION['idea']);
unset($_SESSION['iid']);

if(isset($_POST['search'])){
$ideas = searchIdeas($db, $_POST['search']);
}else{
	$ideas = getNewIdeas($db);
}
?>
		  		<div class="col-md-10">
		  			<div class="row">

<?php 
if(isset($_GET['i'])){
switch ($_GET['i']) {
    case 1:
    	$ideas = getFilterRes($db, 'review', '%');
        break;
    case 2:
        $ideas = getFilterRes($db, 'draft', Whois());
        break;
    case 3:
        $ideas = getFilterRes($db, 'published', Whois());
        break;
    case 4:
        $ideas = getFilterRes($db, 'rejected', Whois());
        break;
    case 5:
        $ideas = getFilterRes($db, 'published', '%');
        break;
    case 6:
        $ideas = getFilterRes($db, 'rejected', '%');
        break;
    default:
        $ideas = $ideas;
} 
}

if(count($ideas) == 0){
	$_SESSION['danger'] = "Your search or view has returned 0 Ideas!";
	showAlert("danger");
}
					foreach($ideas as $idea) :
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
	  				  <div class="col-md-6 DivHeight">
		  				<form action="viewidea.php" method="post">
		  				<input type="hidden" name="iid" value="<?=$idea['id']?>">
		  					<div class="content-box-orange">
			  					<div name="title" class="panel-title"><?=$idea['name']?></div>
								<div class="panel-options">
									<button><i class="glyphicon glyphicon-log-in"></i></button>
								</div>
				  			</div>
				  			<div class="content-box-large box-with-header" style="min-height: 160px; text-overflow: ellipsis;">
				  			<?php 
				  			if (strlen($idea['description']) > 445) {
				  				$content = substr(htmlspecialchars(strip_tags($idea['description'])), 0, 445)."...";
				  			}else{
				  				$content = htmlspecialchars(strip_tags($idea['description']));
				  			}
				  			?>
					  			<p style"text-overflow: ellipsis;"><b>Summary: </b><?=$content?></p>
								<br /><br />
							</div>
						</form>
		  			  </div>
<?php 
					endforeach;
?>
		  			</div>
<?php
require_once("foot.php");
?>