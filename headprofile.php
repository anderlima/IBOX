<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once("show_alert.php");
require_once("db_user.php");
require_once("user_logic.php");

$myteams = getMyTeams($db, Whois());
?>

<!DOCTYPE html>
<html>
  <head>
    <title>IBOX</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery UI -->
    <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- TypeAhead -->
<link rel="stylesheet" href="http://ciolab.ibm.com/misc/typeahead/builds/facestypeahead-0.4.4.min.css"/>
<script src="https://code.jquery.com/jquery.js"></script>
<script src="http://ciolab.ibm.com/misc/typeahead/builds/facestypeahead-0.4.4.min.js"></script>
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="header">
    	     <div class="container">
	        <div class="row">
	           <div class="col-md-10">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index.php">IBOX</a></h1>
	              </div>
	           </div>
	           <div class="col-md-2">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
	                      <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img style="float: top;" src="http://images.tap.ibm.com:10002/image/<?=getUid()?>.jpg?s=28"> <b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
	                          <li><a href="profile.php">Profile</a></li>
	                          <li><a href="logout.php">Logout</a></li>
	                        </ul>
	                      </li>
	                    </ul>
	                  </nav>
	              </div>
	           </div>
	        </div>
          </div>
	</div>
          <div class="page-content">
    	<div class="row">
		  <div class="col-md-2">
		  	<div class="sidebar content-box" style="display: block;">
                <ul class="nav">
                    <li><a href="addteam.php"><i class="glyphicon glyphicon-pencil"></i>Create Team</a></li>
                   <li class="submenu">
                          <a <?=$i2?><?=$i3?><?=$i4?> href="#">
                            <i class="glyphicon glyphicon-user"></i> My Teams 
                            <span class="caret pull-right"></span>
                          </a> 
                    <ul>  
                    <?php foreach($myteams as $myteam):?>
                    <form action="profile.php" method="post">
                    <input type="hidden" name="teamid" value="<?=$myteam['id']?>">
                    <li><a href="javascript:formSubmit(<?=$myteam['id']?>)"><i class="glyphicon glyphicon-th-list"></i> <?=$myteam['name']?></a></li>
                    </form>
                    <?php endforeach;?>
                    </ul> 
                    </li>
                </ul>
             </div>
             </div>
<script>
    function formSubmit(teamid){
        document.forms[0].teamid.value = teamid;
        document.forms[0].submit();
    }
</script>
