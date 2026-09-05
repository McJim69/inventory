<!DOCTYPE html>
<html>

<head>
	<title>VFW Inventory System</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="shortcut icon" href="img/favicon.png">
	<script src="bower_components/sweetalert/sweetalert.js"></script>
	<script src="dist/js/adminlte.min.js"></script>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="fonts/sanspro.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<link rel="stylesheet" href="plugins/iCheck/all.css">
	<script src="plugins/iCheck/icheck.min.js"></script>
	<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<script src="chartjs/dist/Chart.min.js"></script>
</head>

<script type="text/javascript" src="head.js"></script>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">

      <a href="#" class="logo">	  
        <span class="logo-mini"><img src="img/favicon.png" height="30px"></span>
        <span class="logo-lg"><img src="img/favicon.png" height="35px" float="top">&nbsp;&nbsp;<b>VFW</b> Inventory</span>
      </a>

      <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?php
					$user=$_SESSION['username'];
					if(file_exists("img/".$user.".jpg")){					
					echo"<img src='img/".$user.".jpg' class='user-image' alt='User Image'>";
					}else{
					echo"<img src='img/Jan2.png' class='user-image' alt='User Image'>";
					}
				?>
                <span class="hidden-xs text-title"><?php echo $_SESSION['username']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
				<?php
					if(file_exists("img/".$user.".jpg")){					
						echo"<img src='img/".$user.".jpg' class='img-circle' alt='User Image'>";
						}else{
						echo"<img src='img/Jan2.png' class='img-circle' alt='User Image'>";
					}					
				?>
                  <p class="text-title">
                    <?php echo $_SESSION['username']; ?> - <?php echo $_SESSION['role']; ?>
                    <small class="text-capitalize"><?php echo $_SESSION['fullname']; ?></small>
                  </p>
                </li>
                <li class="user-footer"  style="background:#00c0ef">
                  <div class="pull-left">
                    <a href="profile.php" class="btn btn-default btn-flat">Change Password</a>
                  </div>
                  <div class="pull-right">
                    <a href="misc/logout.php" class="btn btn-default btn-flat"
                    onclick="return confirm('Are you Sure ?')"
                    class="btn btn-danger">Sign Out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <aside class="main-sidebar">

      <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">Menu</li>
          <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Home</span></a></li>
          <li><a href="./category.php"><i class="fa fa-list-alt"></i> <span>Category</span></a></li>
          <li><a href="./unit.php"><i class="fa fa-balance-scale"></i> <span>Unit</span></a></li>
          <li><a href="./items.php"><i class="fa fa-archive"></i> <span>Items</span></a></li>
          <li><a href="./rollout.php"><i class="fa fa-truck"></i> <span>Rollout</span></a></li>
          <li><a href="./repairs.php"><i class="fa fa-wrench"></i> <span>Repairs</span></a></li>
		  <li><a href="./upgrades.php"><i class="fa fa-level-up"></i> <span>Upgrades</span></a></li>
		  <li><a href="./sites.php"><i class="fa fa-signal"></i> <span>Sites</span></a></li>
		  <li><a href="./register.php"><i class="fa fa-users"></i> <span>Users</span></a></li>
		  <li><a href="./backup.php"><i class="fa fa-hdd-o"></i> <span>Backup</span></a></li>
          <li><a href="reports.php"><i class="fa fa-newspaper-o"></i> <span>Reports</span></a></li>
        </ul>
      </section>
    </aside>