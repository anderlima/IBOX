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
    <!-- Morris -->
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
                    $result = count(getFilterRes($db, 'rejected', '%', Whois()));
                    $rejected = $result > 0 ? '<span class="step">'.$result.'</span>' : '';

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
                    $i0 = $_GET['i'] == 'newest' ? $i0 = 'style="color: black;"' : $i0 = '';
                    $ichart = $_GET['i'] == 'chart' ? $ichart = 'style="color: black;"' : $ichart = '';
                    $i1 = $_GET['i'] == 1 ? $i1 = 'style="color: black;"' : $i1 = '';
                    $i2 = $_GET['i'] == 2 ? $i2 = 'style="color: black;"' : $i2 = '';
                    $i3 = $_GET['i'] == 3 ? $i3 = 'style="color: black;"' : $i3 = '';
                    $i4 = $_GET['i'] == 4 ? $i4 = 'style="color: black;"' : $i4 = '';
                    $i5 = $_GET['i'] == 5 ? $i5 = 'style="color: black;"' : $i5 = '';
                    $i6 = $_GET['i'] == 6 ? $i6 = 'style="color: black;"' : $i6 = '';
                    $i7 = $_GET['i'] == 7 ? $i7 = 'style="color: black;"' : $i7 = '';
                    $i8 = $_GET['i'] == 8 ? $i8 = 'style="color: black;"' : $i8 = '';
                    $i9 = $_GET['i'] == 9 ? $i9 = 'style="color: black;"' : $i9 = '';
                    $i10 = $_GET['i'] == 10 ? $i10 = 'style="color: black;"' : $i10 = '';
                    ?>

                    <li><a href="addci.php"><i class="glyphicon glyphicon-pencil"></i>Create CI</a></li>
                    <li><a <?=$i0?> href="index.php?i=newest"><i class="glyphicon glyphicon-list"></i>Newest CIs </a></li>
                    <li><a <?=$i1?> href="index.php?i=1"><i class="glyphicon glyphicon-floppy-saved"></i>To be Reviewed <?=$tbreviewed?> </a></li>
                    <li><a <?=$ichart?> href="chartsci.php?i=chart"><i class="glyphicon glyphicon-stats"></i> Statistics </a></li>
                    <li class="submenu">
                          <a <?=$i2?><?=$i3?><?=$i4?> href="#">
                            <i class="glyphicon glyphicon-user"></i> My CIs 
                            <span class="caret pull-right"></span>
                          </a>
                          <ul>
                            <li><a <?=$i2?> href="index.php?i=2">Draft <?=$draft?> </a></li>
                            <li><a <?=$i3?> href="index.php?i=3">Published <?=$published?></a></li>
                            <li><a <?=$i4?> href="index.php?i=4">Rejected <?=$rejected?></a></li>
                          </ul>
                    </li>
                    <li class="submenu">
                         <a <?=$i5?><?=$i6?><?=$i7?><?=$i8?><?=$i9?><?=$i10?> href="#">
                            <i class="glyphicon glyphicon-filter"></i> Monitoring 
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a <?=$i5?> href="index.php?i=5">ITM Infra <?=$itminf?></a></li>
                            <li><a <?=$i6?> href="index.php?i=6">ITM OS Agents <?=$itmos?></a></li>
                            <li><a <?=$i7?> href="index.php?i=7">ITM DB Agents <?=$itmdb?></a></li>
                            <li><a <?=$i8?> href="index.php?i=8">ITM APP Agents <?=$itmapp?></a></li>
                            <li><a <?=$i9?> href="index.php?i=9">Netcool <?=$netcool?></a></li>
                            <li><a <?=$i10?> href="index.php?i=10">Bluecare <?=$bluecare?></a></li>
                        </ul>
                    </li>
                </ul>
             </div>
             </div>
