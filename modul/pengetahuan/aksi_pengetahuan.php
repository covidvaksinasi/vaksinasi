<?php

session_start();
if (!(isset($_SESSION['username']) && isset($_SESSION['password']))) {
    header('location:index.php');
    exit();
} else {
?>
<?php
session_start();
include "../../config/koneksi.php";

$module=$_GET['module'];
$act=$_GET['act'];
if ($module=='pengetahuan' AND $act=='hapus'){
  mysql_query("DELETE FROM basis_pengetahuan WHERE kode_pengetahuan='$_GET[id]'");
  header('location:../../index.php?module='.$module);
}
elseif ($module=='pengetahuan' AND $act=='input'){
$kode_tindakan=$_POST['kode_tindakan'];
$kode_gejala=$_POST['kode_gejala'];
$mb=$_POST['mb'];
$md=$_POST['md'];
mysql_query("INSERT INTO basis_pengetahuan(kode_tindakan,kode_gejala,mb,md) 
VALUES('$kode_tindakan','$kode_gejala','$mb','$md')");
header('location:../../index.php?module='.$module);
}
elseif ($module=='pengetahuan' AND $act=='update'){
$kode_tindakan=$_POST['kode_tindakan'];
$kode_gejala=$_POST['kode_gejala'];
$mb=$_POST['mb'];
$md=$_POST['md'];
mysql_query("UPDATE basis_pengetahuan SET
					kode_tindakan   = '$kode_tindakan',
					kode_gejala   = '$kode_gejala',
					mb   = '$mb',
					md   = '$md'
          WHERE kode_pengetahuan       = '$_POST[id]'");
header('location:../../index.php?module='.$module);
}
?>
<?php } ?>