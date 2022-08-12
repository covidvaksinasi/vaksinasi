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
if ($module=='gejala' AND $act=='hapus'){
  mysql_query("DELETE FROM gejala WHERE kode_gejala='$_GET[id]'");
  header('location:../../index.php?module='.$module);
}
elseif ($module=='gejala' AND $act=='input'){
          $nama_gejala    =$_POST['nama_gejala'];
          $kategori       =$_POST['kategori'];
          $kode_depedensi =$_POST['kode_depedensi'];
mysql_query("INSERT INTO gejala(nama_gejala,kategori,kode_depedensi) 
          VALUES('$nama_gejala','$kategori','$kode_depedensi')");
          header('location:../../index.php?module='.$module);
          }
elseif ($module=='gejala' AND $act=='update'){
          $nama_gejala   =$_POST['nama_gejala'];
          $kategori      =$_POST['kategori'];
          $kode_depedensi=$_POST['kode_depedensi'];
          $id            =$_POST['id'];
$r=mysql_query("SELECT * FROM gejala WHERE kode_gejala='$_POST[id]'");
$chek=mysql_fetch_array($r);
$check_code_depedensi=$chek['kode_depedensi'];
$number=0;
  if(!empty($chek['kode_depedensi'])){
   
    if($kode_depedensi!==$id){

      mysql_query("UPDATE gejala SET
      nama_gejala        = '$nama_gejala',
      kategori           = '$kategori',
      kode_depedensi     = '$kode_depedensi' 
      WHERE kode_gejala  = '$_POST[id]'"); 

      mysql_query("UPDATE gejala SET
      kode_depedensi     = '$_POST[id]'
      WHERE kode_gejala  = '$kode_depedensi'"); 

      mysql_query("UPDATE gejala SET
      kode_depedensi     = '$number'
      WHERE kode_gejala  = '$check_code_depedensi'");
    }
  }
  elseif (empty($chek['kode_depedensi'])) {
    if($kode_depedensi!==$id){
      mysql_query("UPDATE gejala SET
      nama_gejala   = '$nama_gejala',
      kategori      = '$kategori',
      kode_depedensi = '$kode_depedensi'
      WHERE kode_gejala       = '$_POST[id]'"); 

      mysql_query("UPDATE gejala SET
      kode_depedensi = '$_POST[id]'
      WHERE kode_gejala       = '$kode_depedensi'");
    }
  }else{
    mysql_query("UPDATE gejala SET
    nama_gejala   = '$nama_gejala',
    kategori      = '$kategori',
    WHERE kode_gejala       = '$_POST[id]'");
  }
  



  header('location:../../index.php?module='.$module);
} 
?>
<?php } ?>