<?php

session_start();
if (!(isset($_SESSION['username']) && isset($_SESSION['password']))) {
    header('location:index.php');
    exit();
} else {
?>

<?php

include "../../config/koneksi.php";

$module=$_GET['module'];
$act=$_GET['act'];

// hapus admin
if ($module=='admin' AND $act=='hapus'){
  mysql_query("DELETE FROM admin WHERE username='$_GET[id]'");
  header('location:../../index.php?module='.$module);
}

// tambah admin
elseif ($module=='admin' AND $act=='input'){
$username=$_POST['username'];
$nama_lengkap=$_POST['nama_lengkap'];
$pass=md5($_POST['password']);
mysql_query("INSERT INTO admin(
			      username,password,nama_lengkap) 
	                       VALUES(
				'$username','$pass','$nama_lengkap')");
  header('location:../../index.php?module='.$module);
}

// ubah admin
elseif ($module=='admin' AND $act=='update'){
$username=$_POST['username'];
$nama_lengkap=$_POST['nama_lengkap'];
  mysql_query("UPDATE admin SET
					username   = '$username',
					nama_lengkap   = '$nama_lengkap'
                WHERE username       = '$_POST[id]'");
  header('location:../../index.php?module='.$module);
 }
 
?>
<?php } ?>