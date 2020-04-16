<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <?php $plugins = base_url().PLUGINS_FULL; ?>
    <link href="<?php echo base_url()."assets/css/custom.min.css?".VER; ?>" rel="stylesheet" type="text/css" />
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url()."assets/bootstrap/css/bootstrap.min.css?".VER; ?>" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url()."assets/font-awesome/css/font-awesome.min.css?".VER; ?>" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url()."assets/dist/css/AdminLTE.min.css?".VER; ?>" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url()."assets/dist/css/skins/_all-skins.min.css?".VER; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $plugins."datepicker/datepicker3.css?".VER; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $plugins."datepicker/datepicker3.css?".VER; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $plugins."timepicker/bootstrap-timepicker.min.css?".VER; ?>" rel="stylesheet" type="text/css" >
    <link href="<?php echo $plugins."bootstrap-editable/css/bootstrap-editable.css?".VER; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $plugins."datatables/dataTables.bootstrap.css?".VER; ?>" rel="stylesheet" type="text/css" />
    
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url()."assets/js/jQuery-2.1.4.min.js?".VER; ?>"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a id="lnkLogo" href="<?php echo base_url(); ?>dashboard" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>F</b>B</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Feed</b>Backer</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a id="lnkProfileDrop" href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $role_text; ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a id="lnkChangePass" href="<?php echo base_url(); ?>loadChangePass" class="btn btn-default btn-flat">Change Password</a>
                    </div>
                    <div class="pull-right">
                      <a id="lnkLogout" href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
              <a id="lnkDashboard" href="<?php echo base_url(); ?>dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            <?php
            if($role == ROLE_EMPLOYEE)
            {
            ?>
            <li class="treeview">
              <a id="lnkRawListing" href="<?php echo base_url(); ?>rawListing">
                <i class="fa fa-blind"></i><span>Customers</span>
              </a>
            </li>
            <li class="treeview">
              <a id="lnkFollowListing" href="<?php echo base_url(); ?>followListing">
                <i class="fa fa-bell-o"></i><span>Follow Ups</span>
              </a>
            </li>
            <?php
            }
            ?>

            <?php
            if($role == ROLE_ADMIN)
            {
            ?>
            <li class="treeview">
              <a id="lnkImport" href="<?php echo base_url(); ?>import">
                <i class="fa fa-dashboard"></i> <span>Import</span>
              </a>
            </li>
            <li class="treeview">
              <a id="lnkUnassignedCustomers" href="<?php echo base_url(); ?>unassignCustomers">
                <i class="fa fa-users"></i><span>Assign Customers</span>
              </a>
            </li>
            <li class="treeview">
              <a id="lnkRawCustomerListing" href="<?php echo base_url(); ?>rawCustomerListing">
                <i class="fa fa-blind"></i><span>Customers</span>
              </a>
            </li>
            <li class="treeview">
              <a id="lnkFollowCustomerListing" href="<?php echo base_url(); ?>followCustomerListing">
                <i class="fa fa-bell-o"></i><span>Follow Ups</span>
              </a>
            </li>
            <li class="treeview">
              <a id="lnkUserListing" href="<?php echo base_url(); ?>userListing">
                <i class="fa fa-users"></i>
                <span>Admin Users</span>
              </a>
            </li>
            <li class="treeview">
              <a id="lnkReports" href="#">
                <i class="fa fa-files-o"></i>
                <span>Reports</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu menu-open">
                <li><a id="lnkEmployeeReport" href="<?php echo base_url(); ?>employeeReport"><i class="fa fa-circle-o"></i> Employee Report</a></li>
                <li><a id="lnkSummaryReport" href="<?php echo base_url(); ?>summaryReport"><i class="fa fa-circle-o"></i> Summary Report</a></li>
              </ul>
            </li>
            <?php
            }
            ?>
            <?php
            if($role == ROLE_ADMIN)
            {
            ?>
            <li class="treeview">
              <a id="lnkCMS" href="#">
                <i class="fa fa-gear"></i>
                <span>CMS</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu menu-open">
                <li><a id="lnkEmailTemplates" href="<?php echo base_url(); ?>emailTemplates"><i class="fa fa-circle-o"></i> Email Templates</a></li>
                <li><a id="lnkCompanyListing" href="<?php echo base_url(); ?>companyListing"><i class="fa fa-circle-o"></i> Company List</a></li>
                <li><a id="lnkAttachmentListing" href="<?php echo base_url(); ?>attachmentListing"><i class="fa fa-circle-o"></i> Attachments</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a id="lnkCaching" href="<?php echo base_url(); ?>caching">
                <i class="fa fa-refresh"></i>
                <span>Caching</span>
              </a>
            </li>
            <?php
            }
            ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>