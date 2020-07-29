<!doctype html>
<html lang="en">

<head>
    <title>Dashboard | Heaplan - Home Equity Acceleration</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-multiselect.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/chartist/css/chartist-custom.css">
	<!-- DATA TABLE -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

	<!-- MAIN CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/main.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/img/favicon.png">
	<script src="<?php echo base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand logo-wrapper">
				<a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>assets/img/logo.png" alt="Heaplan Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="lnr lnr-user"></i> <span><?php echo $this->session->userdata('username') ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i>
							</a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url() ?>settings"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
								<li><a href="<?php echo base_url() ?>authentication/logout"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="<?php echo base_url() ?>"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
						<li><a href="<?php echo base_url(). "report/reportStep1/".$this->session->userdata("client_id") ?>"><i class="lnr lnr-file-add"></i> <span>Create Report</span></a></li>
						<li><a href="<?php echo base_url(). "report/listReports/".$this->session->userdata("client_id") ?>"><i class="lnr lnr-eye"></i> <span>View Report</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
