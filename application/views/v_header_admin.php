<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Antrian PTSP</title>
    <link rel="icon" href="<?php echo base_url() ?>assets/images/favicon.ico" type="image/x-icon"/>
    <link href="<?php echo base_url() ?>assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
    <link href="<?php echo base_url() ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
    <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url() ?>assets/css/animate.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>assets/css/horizontal-menu.css" rel="stylesheet"/>
    <link href="<?php echo base_url() ?>assets/css/app-style.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/js/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/js/sweetalert2.css">
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/sweetalert2.min.js"></script>
</head>

<body>

<!-- start loader -->
<div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner"><div class="loader"></div></div></div></div>
<!-- end loader -->

<!-- Start wrapper-->
<div id="wrapper">

    <!--Start topbar header-->
    <header class="topbar-nav">
        <nav class="navbar navbar-expand">
            <ul class="navbar-nav mr-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void();">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h5 class="logo-text">ANTRIAN PTSP</h5>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-center right-nav-link">
                        <li class="dropdown-item"><a href="<?php echo base_url();?>"><i class="icon-power mr-2"></i> Logout</li></a>
            </ul>
        </nav>
    </header>
    <!--End topbar header-->

    <!-- start horizontal Menu -->
    <?php
    if ($this->session->userdata('kewenangan')=='admin') {

        ?>
        <nav>
            <!-- Menu Toggle btn-->
            <div class="menu-toggle">
                <h3>Menu</h3>
                <button type="button" id="menu-btn">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <ul id="respMenu" class="horizontal-menu">
                <li>
                    <a href="javascript:;">
                        <i class="zmdi zmdi-view-dashboard" aria-hidden="true"></i>
                        <span class="title">Setting</span>
                        <span class="arrow"></span>
                    </a>
                    <!-- Level Two-->
                    <ul>
                        <li><a href="<?php echo base_url('konfig/master_loket'); ?>"><i class="zmdi zmdi-dot-circle-alt"></i>Master Loket dan password</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <?php
    }
    ?>
    <!-- end horizontal Menu -->

    <div class="clearfix"></div>

    <div class="content-wrapper">
        <div class="container-fluid">

            <!--Start Dashboard Content-->