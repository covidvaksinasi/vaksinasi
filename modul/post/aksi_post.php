<?php

session_start();
include "../../config/koneksi.php";

$module = $_GET['module'];
$act = $_GET['act'];


if ($module == 'post' AND $act == 'hapus') {
    mysql_query("DELETE FROM keterangan WHERE kode_keterangan='$_GET[id]'");
    header('location:../../index.php?module=' . $module);
}


elseif ($module == 'post' AND $act == 'input') {
    $nama_keterangan = $_POST['nama_keterangan'];
    $det_keterangan  = $_POST['det_keterangan'];
    $fileName        = $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../../gambar/" . $_FILES['gambar']['name']);
    mysql_query("INSERT INTO keterangan(
			      nama_keterangan,det_keterangan,gambar) 
	                       VALUES(
				'$nama_keterangan','$det_keterangan','$fileName')");

    header("location:../../index.php?module=" . $module);
}

elseif ($module == 'post' AND $act == 'update') {
    $nama_keterangan   = $_POST['nama_keterangan'];
    $det_keterangan    = $_POST['det_keterangan'];
    $fileName          = $_FILES['gambar']['name'];
    if ($fileName){
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../../gambar/" . $_FILES['gambar']['name']);

    mysql_query("UPDATE keterangan SET
					nama_keterangan   = '$nama_keterangan',
					det_keterangan    = '$det_keterangan',
					gambar            = '$fileName'
               WHERE kode_keterangan  = '$_POST[id]'");
    } else {
        mysql_query("UPDATE keterangan SET
					nama_keterangan   = '$nama_keterangan',
					det_keterangan    = '$det_keterangan',
               WHERE kode_keterangan  = '$_POST[id]'");
    }
    header('location:../../index.php?module=' . $module);
}
?>