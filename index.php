<?php
error_reporting(0);
ob_start();
session_start();
include "config/koneksi.php";
include "config/fungsi_alert.php";
?>
<!DOCTYPE html>
<html><head>

    <base href="http://localhost/vaksinasi/">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <link rel="icon" href="corona.png">
    <link href="css/font-awesome-4.2.0/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/owl-carousel/owl.carousel.css" rel="stylesheet"  media="all">
    <link href="css/owl-carousel/owl.theme.css" rel="stylesheet"  media="all">
    <link href="css/magnific-popup.css" type="text/css" rel="stylesheet" media="all">
    <link href="css/font.css" rel="stylesheet" type="text/css"  media="all">
    <link href="css/fontello.css" rel="stylesheet" type="text/css"  media="all">
    <link href="css/main.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="css/paging.css" type="text/css" media="screen">
    <link rel="stylesheet" href="aset/bootstrap.css">
    <link rel="stylesheet" href="aset/AdminLTE.css">
  	<link rel="stylesheet" href="aset/cinta.css">
    <link rel="stylesheet" href="aset/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="aset/skins/_all-skins.min.css">
    <link rel="stylesheet" href="aset/custom.css">
    <link rel="stylesheet" href="aset/icheck/green.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="aset/jQuery-2.js"></script>
    <script src="aset/bootstrap.js"></script>
    <script src="aset/icheck/icheck.js"></script>
    <script src="aset/ckeditor/ckeditor.js"></script>
    <script src="aset/Flot/jquery.flot.js"></script>
    <script src="aset/Flot/jquery.flot.resize.js"></script>
    <script src="aset/Flot/jquery.flot.pie.js"></script>
    <script src="aset/Flot/jquery.flot.categories.js"></script> 
    <script src="aset/app.js"></script>
  </head>
  <body id="pakar" class="hold-transition skin-red-light sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <a href="./" class="logo">
          <span class="logo-lg"><b>Vaksinasi</b></span>
        </a>
       
        <nav class="navbar navbar-fixed-top" role="navigation">
        
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php
                if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
                    ?>
                  <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="gambar/admin/android-contact.png" class="user-image" alt="User Image"> <?php echo ucfirst($_SESSION['username']); ?>
                      <span class="hidden-xs"><?php echo $user; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- User image -->
                      <li class="user-header">
                        <img src="gambar/admin/android-contact.png" class="img-circle" alt="User Image">
                        <p>
                         Login sebagai <?php echo ucfirst($_SESSION['username']); ?>
                        </p>
                      </li>
                      
                      <!-- Menu Footer-->
                      <li class="user-footer"> 
                        <div class="pull-right">
                          <a class="btn btn-default btn-flat" href="JavaScript: confirmIt('Logout? ?','logout.php','','','','u','n','Self','Self')" onMouseOver="self.status = ''; return true" onMouseOut="self.status = ''; return true"><i class="fa fa-sign-out"></i> <span>LogOut</span></a>
                        </div>
                      </li>
                    </ul>
                  </li>
              <?php 
            } 
              else 
              { 
                ?> <li><a <?php if ($module == "bantuan") echo 'class="active"'; ?> 
                id="bantu" href="bantuan" data-toggle="tooltip" data-placement="bottom" data-delay='{"show":"300", "hide":"500"}' 
                title="Petunjuk penggunaan">
                <span>Bantuan</span></a></li>
				        <li class="dropdown messages-menu">
                    <a <?php if ($module == "formlogin") echo 'class="active"'; ?> href="formlogin"> <span>Login</span></a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </nav>
      </header>
    
      <aside class="main-sidebar">

        <section class="sidebar">
          <ul class="sidebar-menu">
            <li class="header">Menu</li>
            <?php include "menu.php"; ?>
        </section>
    
      </aside>
      <div class="content-wrapper" style="min-height: 310px;">

        <section class="content-header">
        </section>
        <section class="content">
          <div class="box">
            <div class="box-body">
                <?php include "content.php"; ?>		
            </div>
          </div>
        </section>
      </div>

<footer class="main-footer">
</script>
      <center><strong><div class="cinta">©2022 - Unika De La Salle </div></strong></center>
      </footer>
      <div class="control-sidebar-bg" style="position: fixed; height: auto;"></div>
    </div><!-- ./wrapper -->
  </body></html>
<?php            ob_end_flush();
?>