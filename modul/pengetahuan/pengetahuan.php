<title>Pengetahuan </title>
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
if (text_form.kode_tindakan.value == "")
{
   alert("Pilih tindakan !");
   text_form.kode_tindakan.focus();
   return (false);
}
if (text_form.kode_gejala.value == "")
{
   alert("Pilih gejala !");
   text_form.kode_gejala.focus();
   return (false);
}
if (text_form.mb.value == "")
{
   alert("Isi dulu MB !");
   text_form.mb.focus();
   return (false);
}
if (text_form.md.value == "")
{
   alert("Isi dulu MD !");
   text_form.md.focus();
   return (false);
}
return (true);
}
function Blank_TextField_Validator_Cari()
{
if (text_form.keyword.value == "")
{
   alert("Masukkan Keyword !");
   text_form.keyword.focus();
   return (false);
}
return (true);
}
-->
</script>
<?php
include "config/fungsi_alert.php";
$aksi="modul/pengetahuan/aksi_pengetahuan.php";
switch($_GET['act']){
  default:
  $offset=$_GET['offset'];
	$limit = 15;
	if (empty ($offset)) {
		$offset = 0;
	}
  $tampil=mysql_query("SELECT * FROM basis_pengetahuan ORDER BY kode_pengetahuan");
	echo "<form method=POST action='?module=pengetahuan' name=text_form onsubmit='return Blank_TextField_Validator_Cari()'>
          <br><br><table class='table table-bordered'>
		  <tr><td><input class='btn bg-red margin' type=button name=tambah value='Tambah Basis Pengetahuan' onclick=\"window.location.href='pengetahuan/tambahpengetahuan';\"><input type=text name='keyword' style='margin-left: 10px;' placeholder='Ketik dan tekan cari...' class='form-control' value='$_POST[keyword]' /> <input class='btn bg-red margin' type=submit value='   Cari   ' name=Go></td> </tr>
          </table></form>";
		  	$baris=mysql_num_rows($tampil);
	if ($_POST['Go']){
			$numrows = mysql_num_rows(mysql_query("SELECT * FROM basis_pengetahuan b,tindakan p where b.kode_tindakan=p.kode_tindakan AND p.nama_tindakan like '%$_POST[keyword]%'"));
			if ($numrows > 0){
				echo "<div class='alert alert-success alert-dismissible'>
                <h4> Sukses!</h4>
                Pengetahuan yang anda cari di temukan.
              </div>";
				$i = 1;
	echo" <table class='table table-bordered' style='overflow-x=auto' cellpadding='0' cellspacing='0'>
          <thead>
            <tr>
              <th>No</th>
              <th>Tindakan</th>
              <th>Gejala</th>
              <th>MB</th>
              <th>MD</th>
              <th width='21%'>Aksi</th>
            </tr>
          </thead>
		  <tbody>"; 
	$hasil = mysql_query("SELECT * FROM basis_pengetahuan b,tindakan p where b.kode_tindakan=p.kode_tindakan AND p.nama_tindakan like '%$_POST[keyword]%'");
	$no = 1;
	$counter = 1;
    while ($r=mysql_fetch_array($hasil)){
	if ($counter % 2 == 0) $warna = "dark";
	else $warna = "light";
	$sql = mysql_query("SELECT * FROM gejala where kode_gejala = '$r[kode_gejala]'");

	$rgejala=mysql_fetch_array($sql);
       echo "<tr class='".$warna."'>
			 <td align=center>$no</td>
			 <td>$r[nama_tindakan]</td>
			 <td>$rgejala[nama_gejala]</td>
			 <td align=center>$r[mb]</td>
			 <td align=center>$r[md]</td>
			 <td align=center><a type='button' class='btn btn-success margin' href=pengetahuan/editpengetahuan/$r[kode_pengetahuan]><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Ubah </a> &nbsp;
	          <a type='button' class='btn btn-danger margin' href=\"JavaScript: confirmIt('Anda yakin akan menghapusnya ?','$aksi?module=pengetahuan&act=hapus&id=$r[kode_pengetahuan]','','','','u','n','Self','Self')\" onMouseOver=\"self.status=''; return true\" onMouseOut=\"self.status=''; return true\"><i class='fa fa-trash-o' aria-hidden='true'></i> Hapus</a>
             </td></tr>";
      $no++;
	  $counter++;
    }
    echo "</tbody></table>";
			}
			else{
				echo "<div class='alert alert-danger alert-dismissible'>
                <h4></i> Gagal!</h4>
                Maaf, Pengetahuan tidak ditemukan
              </div>";
			}
		}else{
	
	if($baris>0){
	echo" <table class='table table-bordered' style='overflow-x=auto' cellpadding='0' cellspacing='0'>
          <thead>
            <tr>
              <th>No</th>
              <th>Tindakan</th>
              <th>Gejala</th>
              <th>MB</th>
              <th>MD</th>
              <th width='21%'>Aksi</th>
            </tr>
          </thead>
		  <tbody>
		  "; 
	$hasil = mysql_query("SELECT * FROM basis_pengetahuan ORDER BY kode_pengetahuan limit $offset,$limit");
	$no = 1;
	$no = 1 + $offset;
	$counter = 1;
    while ($r=mysql_fetch_array($hasil)){
	if ($counter % 2 == 0) $warna = "dark";
	else $warna = "light";
	$sql = mysql_query("SELECT * FROM gejala where kode_gejala = '$r[kode_gejala]'");
	$rgejala=mysql_fetch_array($sql);
	$sql2 = mysql_query("SELECT * FROM tindakan where kode_tindakan = '$r[kode_tindakan]'");
	$rtindakan=mysql_fetch_array($sql2);
       echo "<tr class='".$warna."'>
			 <td align=center>$no</td>
			 <td>$rtindakan[nama_tindakan]</td>
			 <td>$rgejala[nama_gejala]</td>
			 <td align=center>$r[mb]</td>
			 <td align=center>$r[md]</td>
			 <td align=center>
			 <a type='button' class='btn btn-success margin' href=pengetahuan/editpengetahuan/$r[kode_pengetahuan]><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Ubah </a> &nbsp;
	          <a type='button' class='btn btn-danger margin' href=\"JavaScript: confirmIt('Anda yakin akan menghapusnya ?','$aksi?module=pengetahuan&act=hapus&id=$r[kode_pengetahuan]','','','','u','n','Self','Self')\" onMouseOver=\"self.status=''; return true\" onMouseOut=\"self.status=''; return true\">
			  <i class='fa fa-trash-o' aria-hidden='true'></i> Hapus</a>
             </td></tr>";
      $no++;
	  $counter++;
    }
    echo "</tbody></table>";
	echo "<div class=paging>";

	if ($offset!=0) {
		$prevoffset = $offset-10;
		echo "<span class=prevnext> <a href=index.php?module=pengetahuan&offset=$prevoffset>Back</a></span>";
	}
	else {
		echo "<span class=disabled>Back</span>";//cetak halaman tanpa link
	}
	//hitung jumlah halaman
	$halaman = intval($baris/$limit);//Pembulatan

	if ($baris%$limit){
		$halaman++;
	}
	for($i=1;$i<=$halaman;$i++){
		$newoffset = $limit * ($i-1);
		if($offset!=$newoffset){
			echo "<a href=index.php?module=pengetahuan&offset=$newoffset>$i</a>";
			//cetak halaman
		}
		else {
			echo "<span class=current>".$i."</span>";//cetak halaman tanpa link
		}
	}

	//cek halaman akhir
	if(!(($offset/$limit)+1==$halaman) && $halaman !=1){

		//jika bukan halaman terakhir maka berikan next
		$newoffset = $offset + $limit;
		echo "<span class=prevnext><a href=index.php?module=pengetahuan&offset=$newoffset>Next</a>";
	}
	else {
		echo "<span class=disabled>Next</span>";//cetak halaman tanpa link
	}
	
	echo "</div>";
	}else{
	echo "<br><b>Data Kosong !</b>";
	}
	}
    break;
  
  case "tambahpengetahuan":
	echo "	<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<b>Contoh:</b><br>
				Jika kepercayaan <b>(MB)</b> anda terhadap gejala Suhu tubuh normal untuk tindakan Layak Vaksin adalah <b>0.8 (Hampir Pasti)</b><br>
				Dan ketidakpercayaan <b>(MD)</b> anda terhadap gejala Suhu tubuh normal untuk tindakan Layak Vaksin <b>0.2 (Hampir Mungkin)</b><br><br>
				<b>Maka:</b> CF(Pakar) = MB – MD (0.8 - 0.2) = <b>0.6</b> <br>
				Dimana nilai kepastian anda terhadap gejala Suhu tubuh normal untuk tindakan Layak Vaksin adalah <b>0.6 (Kemungkinan Besar)</b>
              </div>
          <form name=text_form method=POST action='$aksi?module=pengetahuan&act=input' onsubmit='return Blank_TextField_Validator()'>
          <br><br><table class='table table-bordered'>
		  <tr><td width=150>Tindakan</td><td><select class='form-control' name='kode_tindakan'  id='kode_tindakan'><option value='' disabled>- Pilih Tindakan -</option>";
		$hasil4 = mysql_query("SELECT * FROM tindakan order by nama_tindakan");
		while($r4=mysql_fetch_array($hasil4)){
			echo "<option value='$r4[kode_tindakan]'>$r4[nama_tindakan]</option>";
		}
		echo	"</select>
					</td>
						</tr>
							<tr>
								<td>Gejala</td>
								<td>
									<select class='form-control' name='kode_gejala' id='kode_gejala'>
									<option value=''>- Pilih Gejala -</option>";
		$hasil4 = mysql_query("SELECT * FROM gejala  where kategori='Anak-anak' order by kode_gejala");
		echo "<option value='none'disabled> --Anak-Anak-- </option>";
		while($r4=mysql_fetch_array($hasil4)){
			
			echo "<option value='$r4[kode_gejala]'>$r4[kode_gejala] | $r4[nama_gejala]</option>";
		}
		$wanita_dewasa = mysql_query("SELECT * FROM gejala  where kategori='Wanita Dewasa' order by kode_gejala");
		echo "<option value='none' disabled > -------------- Wanita Dewasa --------------</option>";
		while($wd=mysql_fetch_array($wanita_dewasa)){
			
			echo "<option value='$wd[kode_gejala]'>$wd[kode_gejala] | $wd[nama_gejala]</option>";
		}
		$dewasa_pria = mysql_query("SELECT * FROM gejala  where kategori='Pria Dewasa' order by kode_gejala");
		echo "<option value='none' disabled > -------------- Pria Dewasa --------------</option>";
		while($dp=mysql_fetch_array($dewasa_pria)){
			
			echo "<option value='$dp[kode_gejala]'>$dp[kode_gejala] | $dp[nama_gejala]</option>";
		}
		echo	"</select>
				</td></tr>
		<tr><td>MB</td><td><input autocomplete='off' placeholder='Masukkan MB' type=text class='form-control' name='mb' size=15 ></td></tr>
		<tr><td>MD</td><td><input autocomplete='off' placeholder='Masukkan MD' type=text class='form-control' name='md' size=15 ></td></tr>
		  <tr><td></td><td><input class='btn btn-success' type=submit name=submit value='Simpan' >
		  <input class='btn btn-danger' type=button name=batal value='Batal' onclick=\"window.location.href='?module=pengetahuan';\"></td></tr>
          </table></form>";
     break;
    
  case "editpengetahuan":
    $edit=mysql_query("SELECT * FROM basis_pengetahuan WHERE kode_pengetahuan='$_GET[id]'");
    $r=mysql_fetch_array($edit);
	
    echo "<br>
	<br>
	<form name=text_form method=POST action='$aksi?module=pengetahuan&act=update' onsubmit='return Blank_TextField_Validator()'>
          <input type=hidden name=id value='$r[kode_pengetahuan]'>
          <br><br><table class='table table-bordered'>
		  <tr><td width=120>Tindakan</td><td><select class='form-control' name='kode_tindakan' id='kode_tindakan'>";
		$hasil4 = mysql_query("SELECT * FROM tindakan order by nama_tindakan");
		while($r4=mysql_fetch_array($hasil4)){
			echo "<option value='$r4[kode_tindakan]'"; if($r['kode_tindakan']==$r4['kode_tindakan']) echo "selected";
			echo ">$r4[nama_tindakan]</option>";
		}
		echo	"</select></td></tr>
		<tr><td>Gejala</td><td><select class='form-control' name='kode_gejala' id='kode_gejala'>";
		$hasil4 = mysql_query("SELECT * FROM gejala order by nama_gejala");
		while($r4=mysql_fetch_array($hasil4)){
			echo "<option value='$r4[kode_gejala]'"; if($r['kode_gejala']==$r4['kode_gejala']) echo "selected";
			echo ">$r4[nama_gejala]</option>";
		}
		echo	"</select></td></tr>
		<tr><td>MB</td><td><input autocomplete='off' placeholder='Masukkan MB' type=text class='form-control' name='mb' size=15 value='$r[mb]'></td></tr>
		<tr><td>MD</td><td><input autocomplete='off' placeholder='Masukkan MD' type=text class='form-control' name='md' size=15 value='$r[md]'></td></tr>
          <tr><td></td><td><input class='btn btn-success' type=submit name=submit value='Simpan' >
		  <input class='btn btn-danger' type=button name=batal value='Batal' onclick=\"window.location.href='?module=pengetahuan';\"></td></tr>
          </table></form>";
    break;  
}
?>
<?php } ?>
