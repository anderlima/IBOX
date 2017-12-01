<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once("show_alert.php");
require_once("db_idea.php");
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
    <!-- HighCharts -->
<?php if(isset($_GET['i']) && $_GET['i'] == 'chart') { ?>
      <script src="https://code.jquery.com/jquery.js"></script>
      <script src="https://code.highcharts.com/stock/highstock.js"></script>
      <script src="https://code.highcharts.com/highcharts.js"></script>
      <script src="https://code.highcharts.com/modules/series-label.js"></script>
<?php  } ?>
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
	              <div class="logo navbar">
	                 <h1><a href="#">IBOX</a></h1>
	              </div>
	           </div>
            <div class="col-md-4">
                <div class="navbar navbar-inverse" role="banner">
                    <nav class="navbar-collapse bs-navbar-collapse" role="navigation">
                      <ul class="nav navbar-nav">
                        <li>
                          <a href="index.php">IMPROVEMENTS</a>
                        </li>
                        <li class="active">
                          <a href="#">IDEA LOG</a>
                        </li>
                      </ul>
                    </nav>
                </div>
             </div>
               <div class="col-md-5">
                <div class="row">
                 <div class="col-lg-12">
                  <form action="listidea.php" method="post">
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
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img style="float: top;" src="http://images.tap.ibm.com:10002/image/<?=Whois()?>.jpg?s=28"> <b class="caret"></b></a>
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
                    <?php
                    $result = count(getFilterRes($db, 'review', '%'));
                    $tbreviewed = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, 'draft', Whois()));
                    $draft = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, 'published', Whois()));
                    $published = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, 'rejected', Whois()));
                    $rejected = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, 'published', '%'));
                    $allideas = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    $result = count(getFilterRes($db, 'rejected', '%'));
                    $allrejected = $result > 0 ? '<span class="step">'.$result.'</span>' : '';
                    
                    $inew = $_GET['i'] == 'newest' ? $inew = 'style="color: black;"' : $inew = '';
                    $ichart = $_GET['i'] == 'chart' ? $ichart = 'style="color: black;"' : $ichart = '';
                    $iadd = $_GET['i'] == 'add' ? $iadd = 'style="color: black;"' : $iadd = '';
                    $i1 = $_GET['i'] == 1 ? $i1 = 'style="color: black;"' : $i1 = '';
                    $i2 = $_GET['i'] == 2 ? $i2 = 'style="color: black;"' : $i2 = '';
                    $i3 = $_GET['i'] == 3 ? $i3 = 'style="color: black;"' : $i3 = '';
                    $i4 = $_GET['i'] == 4 ? $i4 = 'style="color: black;"' : $i4 = '';
                    $i5 = $_GET['i'] == 5 ? $i5 = 'style="color: black;"' : $i5 = '';
                    $i6 = $_GET['i'] == 6 ? $i6 = 'style="color: black;"' : $i6 = '';
                    ?>
                    <li><a <?=$iadd?> href="addidea.php?i=add"><i class="glyphicon glyphicon-pencil"></i>Create Idea</a></li>
                    <li><a <?=$inew?> href="listidea.php?i=newest"><i class="glyphicon glyphicon-list"></i>Newest Ideas</a></li>
                    <li><a <?=$i1?> href="listidea.php?i=1"><i class="glyphicon glyphicon-floppy-saved"></i>To be Reviewed<?=$tbreviewed?></a></li>
                    <li><a <?=$ichart?> href="chartsidea.php?i=chart"><i class="glyphicon glyphicon-stats"></i> Statistics (TBA)</a></li>
                    <li class="submenu">
                          <a <?=$i2?><?=$i3?><?=$i4?> href="#">
                            <i class="glyphicon glyphicon-user"></i> My Ideas
                            <span class="caret pull-right"></span>
                          </a>
                          <ul>
                            <li><a <?=$i2?> href="listidea.php?i=2">Draft <?=$draft?></a></li>
                            <li><a <?=$i3?> href="listidea.php?i=3">Published <?=$published?></a></li>
                            <li><a <?=$i4?> href="listidea.php?i=4">Rejected <?=$rejected?></a></li>
                          </ul>
                    </li>
                    <li class="submenu">
                         <a <?=$i5?><?=$i6?> href="#">
                            <i class="glyphicon glyphicon-filter"></i> Filters
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a <?=$i5?> href="listidea.php?i=5">All Ideas</a></li>
                            <li><a <?=$i6?> href="listidea.php?i=6">All Rejected</a></li>
                        </ul>
                    </li>
                </ul>
             </div>
             </div>

