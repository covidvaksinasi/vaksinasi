<?php
$module = $_GET['module'];
?>
<li><a <?php if ($module == "") echo 'class="active"'; ?> href="./"> <span>Beranda</span></a><li>
  <div class="container"></div>
  <?php
  if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
      ?>
    <li><a <?php if ($module == "admin") echo 'class="active"'; ?> href="admin"> <span>Admin</span></a><li>
      <div class="container"></div>	
    <li><a <?php if ($module == "riwayat") echo 'class="active"'; ?> href="riwayat"> <span>Riwayat</span></a><li>
      <div class="container"></div>
    <li><a <?php if ($module == "tindakan") echo 'class="active"'; ?> href="tindakan"> <span>Tindakan</span></a><li>
      <div class="container"></div>	
    <li><a <?php if ($module == "gejala") echo 'class="active"'; ?> href="gejala"> <span>Gejala</span></a><li>
      <div class="container"></div>
    <li><a <?php if ($module == "pengetahuan") echo 'class="active"'; ?> href="pengetahuan"> <span>Pengetahuan</span></a><li>
      <div class="container"></div>
    <li><a <?php if ($module == "post") echo 'class="active"'; ?> href="post"> <span>Post Keterangan</span></a><li>
      <div class="container"></div>
    <li><a <?php if ($module == "password") echo 'class="active"'; ?> href="password"> <span>Ubah Password</span></a><li>
      <div class="container"></div>
      <?php
  }else {
      ?>
    <li><a <?php if ($module == "diagnosa") echo 'class="active"'; ?> href="diagnosa"> </i> <span>Diagnosis</span></a><li>
      <div class="container"></div>
    <li><a <?php if ($module == "keterangan") echo 'class="active"'; ?> href="keterangan"> </i> <span>Keterangan</span></a><li>
      <?php
  }
  ?>
<?php if ($module == "tentang") echo 'class="active"'; ?> 