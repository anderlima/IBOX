<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once("show_alert.php");
?>

<html>
<head>
	<meta charset="utf-8">
	<title>IBOX</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/complement.css" rel="stylesheet">
	</head>
<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
			<a href="#"><img id ="logo" class="nav" src="pic/ibm_logo.gif"></a>
			</div>
				<ul class="nav navbar-nav">
				<li><a class="navbar-brand" href="#">IBOX</a></li>
				</ul>
			</div>
	</nav>
	<div class="container">
		<div class="main">
	  <?php showAlert("success"); ?>
          <?php showAlert("danger"); ?>

<?php
require_once("user_logic.php");

if(isUserLogged()) {

?>
	<p class="text-success">You are logged as <?= Whois() ?>. <a href="logout.php">Deslogar</a></p>
<?php
} else {
?>
	
	<form action="login.php" method="post">
		<table class="table">
		<tr>
		<td colspan="2"><h3>W3 ID</h3></td>
		</tr>
			<tr>
				
				<td><label style="padding-right:3em;">Email</label><input  class="form-control form-control-medium" type="text" name="email"></td>
			</tr>
			<tr>
				
				<td><label style="padding-right:2.5em;">Senha</label><input  class="form-control form-control-medium" type="password" name="password"></td>
			</tr>
			<tr>
				<td><button class="btn btn-primary">Login</button></td>
			</tr>
		</table>
	</form>
<?php
}
?>
</div>
	</div>
    </div></div>
    </br></br></br></br>
    <div class="navbar navbar-fixed-bottom">
      <footer class="footer">
        <div class="container">
            <div class="copy text-center">
               IBOX  2017 <a href='#'>Wiki Link</a>
            </div>
        </div>
      </footer>
    </div>
    
<script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>

