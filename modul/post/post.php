<title>Keterangan</title>
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
      if (text_form.nama_keterangan.value == "")
      {
        alert("Masukkan nama keterangan !");
        text_form.nama_keterangan.focus();
        return (false);
      }
      return (true);
    }
    function Blank_TextField_Validator_Cari()
    {
      if (text_form.keyword.value == "")
      {
        alert("Masukkan keyword pencarian !");
        text_form.keyword.focus();
        return (false);
      }
      return (true);
    }
</script>
<?php
include "config/fungsi_alert.php";
$aksi = "modul/post/aksi_post.php";
switch ($_GET['act']) {
    // Tampil post
    default:
        $offset = $_GET['offset'];
      
        $limit = 15;
        if (empty($offset)) {
            $offset = 0;
        }
        $tampil = mysql_query("SELECT * FROM keterangan ORDER BY kode_keterangan");
       
        echo "<form method=POST action='?module=post' name=text_form onsubmit='return Blank_TextField_Validator_Cari()'>
          <br><br><table class='table table-bordered'>
		  <tr><td><input class='btn bg-red margin' type=button name=tambah value='Tambah Keterangan' onclick=\"window.location.href='post/tambahpost';\"><input type=text name='keyword' style='margin-left: 10px;' placeholder='Ketik dan tekan cari...' class='form-control' value='$_POST[keyword]' /> <input class='btn bg-red margin' type=submit value='   Cari   ' name=Go></td> </tr>
          </table></form>";
        $baris = mysql_num_rows($tampil);
     
        if ($_POST['Go']) {
            $numrows = mysql_num_rows(mysql_query("SELECT * FROM keterangan where nama_keterangan like '%$_POST[keyword]%'"));
            if ($numrows > 0) {
                echo "<div class='alert alert-success alert-dismissible'>
                <h4><i class='icon fa fa-check'></i> Sukses!</h4>
                Keterangan yang anda cari di temukan.
              </div>";
                $i = 1;
                echo" <table class='table table-bordered' style='overflow-x=auto' cellpadding='0' cellspacing='0'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Vaksin</th>
			        <th>Detail Vaksin</th>
              <th>Aksi</th>
            </tr>
          </thead>
		  <tbody>";
                $hasil = mysql_query("SELECT * FROM keterangan where nama_keterangan like '%$_POST[keyword]%'");
                $no = 1;
                $counter = 1;
                while ($r = mysql_fetch_array($hasil)) {
                    if ($counter % 2 == 0)
                        $warna = "dark";
                    else
                        $warna = "light";
                    echo "<tr class='" . $warna . "'>
			 <td align=center>$no</td>
			 <td>$r[nama_keterangan]</td>
			 <td>$r[det_keterangan]</td>
			 <td align=center><a type='button' class='btn btn-success margin' href=post/editpost/$r[kode_keterangan]><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Ubah </a> &nbsp;
	          <a type='button' class='btn btn-danger margin' href=\"JavaScript: confirmIt('Hapus Keterangan?','$aksi?module=post&act=hapus&id=$r[kode_keterangan]','','','','u','n','Self','Self')\" onMouseOver=\"self.status=''; return true\" onMouseOut=\"self.status=''; return true\"> <i class='fa fa-trash-o' aria-hidden='true'></i> Hapus</a>
             </td></tr>";
                    $no++;
                    $counter++;
                }
                echo "</tbody></table>";
            }
            else {
                echo "<div class='alert alert-danger alert-dismissible'>
                <h4><i class='icon fa fa-ban'></i> Gagal!</h4>
                Keterangan tidak ditemukan.
              </div>";
            }
        } else {

            if ($baris > 0) {
                echo" <table class='table table-bordered' style='overflow-x=auto' cellpadding='0' cellspacing='0'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Vaksin</th>
			        <th>Detail Vaksin</th>
              <th>Aksi</th>
            </tr>
          </thead>
		  <tbody>
		  ";
                $hasil = mysql_query("SELECT * FROM keterangan ORDER BY kode_keterangan limit $offset,$limit");
                $no = 1;
                $no = 1 + $offset;
                $counter = 1;
                while ($r = mysql_fetch_array($hasil)) {
                    if ($counter % 2 == 0)
                        $warna = "dark";
					if (strlen($r['det_keterangan']) > 150)
					{
						$maxLength = 140;
						$r['det_keterangan'] = substr($r['det_keterangan'], 0, $maxLength);
						}
          else
            $warna = "light";
            echo "<tr class='" . $warna . "'>
			 <td align=center>$no</td>
			 <td>$r[nama_keterangan]</td>
			 <td>$r[det_keterangan]</td>
			 <td align=center>
			 <a type='button' class='btn btn-success margin' href=post/editpost/$r[kode_keterangan]><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Ubah </a> &nbsp;
	          <a type='button' class='btn btn-danger margin' href=\"JavaScript: confirmIt('Hapus ?','$aksi?module=post&act=hapus&id=$r[kode_keterangan]','','','','u','n','Self','Self')\" onMouseOver=\"self.status=''; return true\" onMouseOut=\"self.status=''; return true\">
			      <i class='fa fa-trash-o' aria-hidden='true'></i> Hapus</a>
            </td></tr>";
                    $no++;
                    $counter++;
                }
                echo "</tbody></table>";
                echo "<div class=paging>";

                if ($offset != 0) {
                    $prevoffset = $offset - 10;
                    echo "<span class=prevnext> <a href=index.php?module=post&offset=$prevoffset>Back</a></span>";
                } else {
                    echo "<span class=disabled>Back</span>";
                }
                
                $halaman = intval($baris / $limit); 

                if ($baris % $limit) {
                    $halaman++;
                }
                for ($i = 1; $i <= $halaman; $i++) {
                    $newoffset = $limit * ($i - 1);
                    if ($offset != $newoffset) {
                        echo "<a href=index.php?module=post&offset=$newoffset>$i</a>";
                        //cetak halaman
                    } else {
                        echo "<span class=current>" . $i . "</span>"; 
                    }
                }

             
                if (!(($offset / $limit) + 1 == $halaman) && $halaman != 1) {

                 
                    $newoffset = $offset + $limit;
                    echo "<span class=prevnext><a href=index.php?module=post&offset=$newoffset>Next</a>";
                } else {
                    echo "<span class=disabled>Next</span>";
                }

                echo "</div>";
            } else {
                echo "<br><b>Data Kosong !</b>";
            }
        }
        break;

    case "tambahpost":
        echo "<form name=text_form method=POST action='$aksi?module=post&act=input' onsubmit='return Blank_TextField_Validator()' enctype='multipart/form-data'>
          <br><br><table class='table table-bordered'>
		      <tr><td width=120>Nama Vaksin</td><td><input autocomplete='off' type=text placeholder='Masukkan Keterangan baru...' class='form-control' name='nama_keterangan' size=30></td></tr>
		      <tr><td width=120>Detail Vaksin</td><td> <textarea id='editor1' rows='4' cols='50' class='form-control' name='det_keterangan'type=text placeholder='Masukkan detail keterangan...'></textarea></td></tr>
		      <tr><td width=120>Gambar</td><td>Upload Gambar (Ukuran Maks = 1 MB) : <input type='file' class='form-control' name='gambar' required /></td></tr>
		      <tr><td></td><td><input class='btn btn-success' type=submit name=submit value='Simpan' >
		      <input class='btn btn-danger' type=button name=batal value='Batal' onclick=\"window.location.href='?module=post';\"></td></tr>
          </table></form>";
        break;

    case "editpost":
        $edit = mysql_query("SELECT * FROM keterangan WHERE kode_keterangan='$_GET[id]'");
        $r = mysql_fetch_array($edit);
        if ($r['gambar']) {
            $gambar = 'gambar/' . $r['gambar'];
        } else {
            $gambar = 'gambar/noimage.png';
        }

        echo "<form name=text_form method=POST action='$aksi?module=post&act=update' onsubmit='return Blank_TextField_Validator()' enctype='multipart/form-data'>
          <input type=hidden name=id value='$r[kode_keterangan]'>
          <br><br><table class='table table-bordered'>
		      <tr><td width=120>Nama Vaksin</td><td><input autocomplete='off' type=text class='form-control' name='nama_keterangan' size=30 value=\"$r[nama_keterangan]\"></td></tr>
		      <tr><td width=120>Detail Vaksin</td><td><textarea id='editor1' rows='4' cols='50' type=text class='form-control' name='det_keterangan'>$r[det_keterangan]</textarea></td></tr>
          <tr><td width=120>Gambar </td><td>Upload Gambar (Ukuran Maks = 1 MB) : <input id='upload' type='file' class='form-control' name='gambar' required /></td></tr>
          <tr><td></td><td><img id='preview' src='$gambar' width=200></td></tr>
          <tr><td></td><td><input class='btn btn-success' type=submit name=submit value='Simpan' >
		      <input class='btn btn-danger' type=button name=batal value='Batal' onclick=\"window.location.href='?module=post';\"></td></tr>
          </table></form>";
      break;
}
?>
<?php } ?>
<script>
    function readURL(input) {

      if (input.files &&
              input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#upload").change(function () {
      readURL(this);
    });

    $(function () {
      CKEDITOR.replace('editor1');
      CKEDITOR.replace('editor2');
      CKEDITOR.replace('editor1a');
      CKEDITOR.replace('editor2a');
    })


</script>
