<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once("show_alert.php");
require_once("db_ci.php");
require_once("user_logic.php");
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
	           <div class="col-md-1">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index.php">IBOX</a></h1>
	              </div>
	           </div>
             <div class="col-md-4">
                <div class="navbar navbar-inverse" role="banner">
                    <nav class="navbar-collapse bs-navbar-collapse" role="navigation">
                      <ul class="nav navbar-nav">
                        <li class="active">
                          <a href="#">IMPROVEMENTS</a>
                        </li>
                         <li>
                          <a href="listidea.php">IDEA LOG</a>
                        </li>
                      </ul>
                    </nav>
                </div>
              </div>
               <div class="col-md-5">
	              <div class="row">
	                <div class="col-lg-12">
                  <form action="index.php" method="post">
	                  <div class="input-group form">
	                       <input name="search" type="text" class="form-control" placeholder="Search...">
	                       <span class="input-group-btn">
	                         <button class="btn btn-primary" type="submit">Search</button>
	                       </span>
	                  </div>
                    </form>
	                </div>
	              </div>
	           </div>
	           <div class="col-md-2">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
	                      <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
	                          <li><a href="#">Profile</a></li>
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
                    <!-- Main menu -->
                    <?php
                    $result = count(getFilterRes($db, 'review', '%', '%'));
                    $tbreviewed = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, 'draft', '%', Whois()));
                    $draft = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, 'published', '%', Whois()));
                    $published = $result > 0 ? '<span class="step">'.$result.'</span>' : '';

                    $result = count(getFilterRes($db, '%', 'ITM-Infrastructure', '%'));
                    $itminf = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, '%', 'ITM-OS', '%'));
                    $itmos = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, '%', 'ITM-DB', '%'));
                    $itmdb = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, '%', 'ITM-App', '%'));
                    $itmapp = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, '%', 'Netcool', '%'));
                    $netcool = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, '%', 'Bluecare', '%'));
                    $bluecare = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    ?>

                    <li><a href="addci.php"><i class="glyphicon glyphicon-pencil"></i>Create CI</a></li>
                    <li><a href="index.php"><i class="glyphicon glyphicon-list"></i>Newest CIs</a></li>
                    <li><a href="index.php?i=1"><i class="glyphicon glyphicon-floppy-saved"></i>To be Reviewed (Admin) <?=$tbreviewed?></a></li>
                    <li><a href="#"><i class="glyphicon glyphicon-stats"></i> Statistics (Charts) TBA</a></li>
                    <li class="submenu">
                          <a href="#">
                            <i class="glyphicon glyphicon-user"></i> My CIs
                            <span class="caret pull-right"></span>
                          </a>
                          <ul>
                            <li><a href="index.php?i=2">Draft <?=$draft?></a></li>
                            <li><a href="index.php?i=3">Published <?=$published?></a></li>
                          </ul>
                    </li>
                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-filter"></i> I-EAU-BR-04
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a href="index.php?i=4">ITM Infratructure <?=$itminf?></a></li>
                            <li><a href="index.php?i=5">ITM OS Agents <?=$itmos?></a></li>
                            <li><a href="index.php?i=6">ITM DB Agents <?=$itmdb?></a></li>
                            <li><a href="index.php?i=7">ITM APP Agents <?=$itmapp?></a></li>
                            <li><a href="index.php?i=8">Netcool <?=$netcool?></a></li>
                            <li><a href="index.php?i=9">Bluecare <?=$bluecare?></a></li>
                        </ul>
                    </li>
                </ul>
             </div>
             </div>

