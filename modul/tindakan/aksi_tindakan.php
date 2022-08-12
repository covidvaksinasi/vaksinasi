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
  $module = $_GET['module'];
  $act = $_GET['act'];
  if ($module == 'tindakan' AND $act == 'hapus') {
    mysql_query("DELETE FROM tindakan WHERE kode_tindakan='$_GET[id]'");
    header('location:../../index.php?module=' . $module);
  }
  elseif ($module == 'tindakan' AND $act == 'input') {
    $nama_tindakan = $_POST['nama_tindakan'];
    $det_tindakan = $_POST['det_tindakan'];
    $srn_tindakan = $_POST['srn_tindakan'];
    $fileName = $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../../gambar/penyakit/" . $_FILES['gambar']['name']);
    mysql_query("INSERT INTO tindakan(nama_tindakan,det_tindakan,srn_tindakan) 
	  VALUES('$nama_tindakan','$det_tindakan','$srn_tindakan','$fileName')");
    header('location:../../index.php?module=' . $module);
  }
  elseif ($module == 'tindakan' AND $act == 'update') {
    $nama_tindakan= $_POST['nama_tindakan'];
    $det_tindakan = $_POST['det_tindakan'];
    $srn_tindakan = $_POST['srn_tindakan'];
    $fileName     = $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../../gambar/penyakit/" . $_FILES['gambar']['name']);
    if ($fileName) {
      move_uploaded_file($_FILES['gambar']['tmp_name'], "../../gambar/tindakan/" . $_FILES['gambar']['name']);
      mysql_query("UPDATE tindakan SET
					nama_tindakan   = '$nama_tindakan',
					det_tindakan    = '$det_tindakan',
					srn_tindakan    = '$srn_tindakan',
          gambar          = '$fileName'
      WHERE kode_tindakan = '$_POST[id]'");
    } else {
      mysql_query("UPDATE tindakan SET
					nama_tindakan   = '$nama_tindakan',
					det_tindakan    = '$det_tindakan',
					srn_tindakan    = '$srn_tindakan'
     WHERE kode_tindakan  = '$_POST[id]'");
    }
    header('location:../../index.php?module=' . $module);
  }
  ?>
<?php } ?>