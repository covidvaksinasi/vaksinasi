<title>Tindakan</title>

<?php

session_start();
if (!(isset($_SESSION['username']) && isset($_SESSION['password']))) {
  header('location:index.php');
  exit();
} else {
  ?>
  <script type="text/javascript">
    function Blank_TextField_Validator()
    {
      if (text_form.nama_tindakan.value == "")
      {
        alert("Masukkan nama tindakan!");
        text_form.nama_tindakan.focus();
        return (false);
      }
      return (true);
    }
    function Blank_TextField_Validator_Cari()
    {
      if (text_form.keyword.value == "")
      {
        alert("Masukkan keyword!");
        text_form.keyword.focus();
        return (false);
      }
      return (true);
    }
  </script>
  <?php

  include "config/fungsi_alert.php";
  $aksi = "modul/tindakan/aksi_tindakan.php";
  switch ($_GET['act']) {

    default:
      $offset = $_GET['offset'];
  
      $limit = 15;
      if (empty($offset)) {
        $offset = 0;
      }
      $tampil = mysql_query("SELECT * FROM tindakan ORDER BY kode_tindakan");
      echo "<form method=POST action='?module=tindakan' name=text_form onsubmit='return Blank_TextField_Validator_Cari()'>
          <br><br><table class='table table-bordered'>
		  <tr><td><input class='btn bg-red margin' type=button name=tambah value='Tambah Tindakan' onclick=\"window.location.href='tindakan/tambahtindakan';\"><input type=text name='keyword' style='margin-left: 10px;' placeholder='Ketik dan tekan cari...' class='form-control' value='$_POST[keyword]' /> <input class='btn bg-red margin' type=submit value='   Cari   ' name=Go></td> </tr>
          </table></form>";
      $baris = mysql_num_rows($tampil);
      if ($_POST['Go']) {
        $numrows = mysql_num_rows(mysql_query("SELECT * FROM tindakan where nama_tindakan like '%$_POST[keyword]%'"));
        if ($numrows > 0) {
          echo "<div class='alert alert-success alert-dismissible'>
                <h4> Sukses!</h4>
                Tindakan ditemukan.
              </div>";
          $i = 1;
          echo" <table class='table table-bordered' style='overflow-x=auto' cellpadding='0' cellspacing='0'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Tindakan</th>
			        <th>Detail Tindakan</th>
			        <th>Saran Tindakan</th>
              <th>Gambar</th>
              <th>Aksi</th>
            </tr>
          </thead>
		  <tbody>";
          $hasil = mysql_query("SELECT * FROM tindakan where nama_tindakan like '%$_POST[keyword]%'");
          $no = 1;
          $counter = 1;
          while ($r = mysql_fetch_array($hasil)) {
            if ($counter % 2 == 0)
              $warna = "dark";
            else
              $warna = "light";
            echo "<tr class='" . $warna . "'>
			 <td align=center>$no</td>
			 <td>$r[nama_tindakan]</td>
			 <td>$r[det_tindakan]</td>
			 <td>$r[srn_tindakan]</td>
       <td>$r[gambar]</td>
			 <td align=center><a type='button' class='btn btn-block btn-success' href=tindakan/edittindakan/$r[kode_tindakan]><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Ubah </a> &nbsp;
	          <a type='button' class='btn btn-block btn-danger' href=\"JavaScript: confirmIt('Anda yakin akan menghapusnya ?','$aksi?module=tindakan&act=hapus&id=$r[kode_tindakan]','','','','u','n','Self','Self')\" onMouseOver=\"self.status=''; return true\" onMouseOut=\"self.status=''; return true\"> <i class='fa fa-trash-o' aria-hidden='true'></i> Hapus</a>
             </td></tr>";
            $no++;
            $counter++;
          }
          echo "</tbody></table>";
        }
        else {
          echo "<div class='alert alert-danger alert-dismissible'>
                <h4>Gagal!</h4>
                Maaf, Tindakan tidak ditemukan.
              </div>";
        }
      } else {

        if ($baris > 0) {
          echo" <table class='table table-bordered' style='overflow-x=auto' cellpadding='0' cellspacing='0'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Tindakan</th>
			  <th>Detail Tindakan</th>
			  <th>Saran Tindakan</th>
        <th>Gambar</th>
        <th>Aksi</th>
        </tr>
        </thead>
		  <tbody>
		  ";
          $hasil = mysql_query("SELECT * FROM tindakan ORDER BY kode_tindakan limit $offset,$limit");
          $no = 1;
          $no = 1 + $offset;
          $counter = 1;
          while ($r = mysql_fetch_array($hasil)) {
            if ($counter % 2 == 0)
              $warna = "dark";
            else
              $warna = "light";
            echo "<tr class='" . $warna . "'>
			 <td align=center>$no</td>
			 <td>$r[nama_tindakan]</td>
			 <td>$r[det_tindakan]</td>
			 <td>$r[srn_tindakan]</td>
       <td>$r[gambar]</td>
			 <td align=center>
			 <a type='button' class='btn btn-block btn-success' href=tindakan/edittindakan/$r[kode_tindakan]><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Ubah </a> &nbsp;
	          <a type='button' class='btn btn-block btn-danger' href=\"JavaScript: confirmIt('Anda yakin akan menghapusnya ?','$aksi?module=tindakan&act=hapus&id=$r[kode_tindakan]','','','','u','n','Self','Self')\" onMouseOver=\"self.status=''; return true\" onMouseOut=\"self.status=''; return true\">
			  <i class='fa fa-trash-o' aria-hidden='true'></i> Hapus</a>
             </td></tr>";
            $no++;
            $counter++;
          }
          echo "</tbody></table>";
          echo "<div class=paging>";

          if ($offset != 0) {
            $prevoffset = $offset - 10;
            echo "<span class=prevnext> <a href=index.php?module=tindakan&offset=$prevoffset>Back</a></span>";
          } else {
            echo "<span class=disabled>Back</span>"; //cetak halaman tanpa link
          }
          $halaman = intval($baris / $limit); //Pembulatan

          if ($baris % $limit) {
            $halaman++;
          }
          for ($i = 1; $i <= $halaman; $i++) {
            $newoffset = $limit * ($i - 1);
            if ($offset != $newoffset) {
              echo "<a href=index.php?module=tindakan&offset=$newoffset>$i</a>";
              //cetak halaman
            } else {
              echo "<span class=current>" . $i . "</span>"; //cetak halaman tanpa link
            }
          }

          //cek halaman akhir
          if (!(($offset / $limit) + 1 == $halaman) && $halaman != 1) {

            //jika bukan halaman terakhir maka berikan next
            $newoffset = $offset + $limit;
            echo "<span class=prevnext><a href=index.php?module=tindakan&offset=$newoffset>Next</a>";
          } else {
            echo "<span class=disabled>Next</span>"; //cetak halaman tanpa link
          }

          echo "</div>";
        } else {
          echo "<br><b>Data Kosong !</b>";
        }
      }
      break;

    case "tambahtindakan":
      echo "<form name=text_form method=POST action='$aksi?module=tindakan&act=input' onsubmit='return Blank_TextField_Validator()' enctype='multipart/form-data'>
      <br><br><table class='table table-bordered'>
		  <tr><td width=120>Nama Tindakan</td><td><input autocomplete='off' type=text placeholder='Masukkan tindakan baru...' class='form-control' name='nama_tindakan' size=30></td></tr>
		  <tr><td width=120>Detail Tindakan</td><td> <textarea rows='4' cols='50' class='form-control' name='det_tindakan'type=text placeholder='Masukkan detail tindakan baru...'></textarea></td></tr>
		  <tr><td width=120>Saran Tindakan</td><td><textarea rows='4' cols='50' class='form-control' name='srn_tindakan'type=text placeholder='Masukkan saran tindakan baru...'></textarea></td></tr>	  
      <tr><td width=120>Gambar Post</td><td>Upload Gambar (Ukuran Maks = 1 MB) : <input type='file' class='form-control' name='gambar' required /></td></tr>		  
      <tr><td></td><td><input class='btn btn-success' type=submit name=submit value='Simpan' >
		  <input class='btn btn-danger' type=button name=batal value='Batal' onclick=\"window.location.href='?module=tindakan';\"></td></tr>
      </table></form>";
      break;

    case "edittindakan":
      $edit = mysql_query("SELECT * FROM tindakan WHERE kode_tindakan='$_GET[id]'");
      $r = mysql_fetch_array($edit);
    
      echo "<form name=text_form method=POST action='$aksi?module=tindakan&act=update' onsubmit='return Blank_TextField_Validator()' enctype='multipart/form-data'>
          <input type=hidden name=id value='$r[kode_tindakan]'>
          <br><br><table class='table table-bordered'>
		  <tr><td width=120>Nama Tindakan</td><td><input autocomplete='off' type=text class='form-control' name='nama_tindakan' size=30 value=\"$r[nama_tindakan]\"></td></tr>
		  <tr><td width=120>Detail Tindakan</td><td><textarea rows='4' cols='50' type=text class='form-control' name='det_tindakan'>$r[det_tindakan]</textarea></td></tr>
		  <tr><td width=120>Saran Tindakan</td><td><textarea rows='4' cols='50' type=text class='form-control' name='srn_tindakan'>$r[srn_tindakan]</textarea></td></tr>   
      <tr><td width=120>Gambar Post</td><td>Upload Gambar (Ukuran Maks = 1 MB) : <input type='file' class='form-control' name='gambar' required /></td></tr>		  
      <tr><td></td><td><input class='btn btn-success' type=submit name=submit value='Simpan' >
		  <input class='btn btn-danger' type=button name=batal value='Batal' onclick=\"window.location.href='?module=tindakan';\"></td></tr>
          </table></form>";
      break;
  }
  ?>
<?php } ?>

  <script>
    function readURL(input) 
    {
      if (input.files && input.files[0]) 
      {
        var reader = new FileReader();
        reader.onload = function (e) 
        {
          $('#preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#upload").change(function () {
      readURL(this);
    });

    


  </script>
