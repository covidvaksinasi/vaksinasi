<title>Gejala</title>
<?php

session_start();
if (!(isset($_SESSION['username']) && isset($_SESSION['password']))) {
    header('location:index.php');
    exit();
} else {
    ?>
<script type="text/javascript">
function Blank_TextField_Validator(){
	if (text_form.nama_gejala.value == "")
	{
	alert("Masukkan nama gejala!");
	text_form.nama_gejala.focus();
	return (false);
	}
	return (true);
}
function Blank_TextField_Validator_Cari(){
	if (text_form.keyword.value == "")
	{
	alert("Masukkan keyword!");
	text_form.keyword.focus();
	return (false);
	}
return (true);
}

-->
</script>
<?php
include "config/fungsi_alert.php";
$aksi="modul/gejala/aksi_gejala.php";
switch($_GET['act']){
	// Tampil gejala
  default:
  $offset=$_GET['offset'];
	//jumlah data yang ditampilkan perpage
	$limit = 20;
	if (empty ($offset)) {
		$offset = 0;
	}
  $tampil=mysql_query("SELECT * FROM gejala ORDER BY kode_gejala");
	echo "<form method=POST action='?module=gejala' name=text_form onsubmit='return Blank_TextField_Validator_Cari()'>
          <br><br><table class='table table-bordered'>
		  <tr><td><input class='btn bg-red margin' type=button name=tambah value='Tambah Gejala' onclick=\"window.location.href='gejala/tambahgejala';\"><input type=text name='keyword' style='margin-left: 10px;' placeholder='Ketik dan tekan cari...' class='form-control' value='$_POST[keyword]' /> <input class='btn bg-red margin' type=submit value='   Cari   ' name=Go></td> </tr>
          </table></form>";
		  $baris=mysql_num_rows($tampil);
		  
	if ($_POST['Go']){
			$numrows = mysql_num_rows(mysql_query("SELECT * FROM gejala where nama_gejala like '%$_POST[keyword]%'"));
			if ($numrows > 0){
				echo "<div class='alert alert-success alert-dismissible'>
                <h4><i class='icon fa fa-check'></i> Sukses!</h4>
                Gejala yang anda cari di temukan.
              </div>";
				$i = 1;
	echo" <table class='table table-bordered' style='overflow-x=auto' cellpadding='0' cellspacing='0'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Gejala</th>
			  <th>Kategori</th>
              <th width='21%'>Aksi</th>
            </tr>
          </thead>
		  <tbody>"; 
	$hasil = mysql_query("SELECT * FROM gejala where nama_gejala like '%$_POST[keyword]%'");
	$no = 1;
	$counter = 1;
    while ($r=mysql_fetch_array($hasil)){
	if ($counter % 2 == 0) $warna = "dark";
	else $warna = "light";
       echo "<tr class='".$warna."'>
			 <td align=center>$no</td>
			 <td>$r[nama_gejala]</td>
			 <td>$r[kategori]</td>
			 <td align=center><a type='button' class='btn btn-success margin' href=gejala/editgejala/$r[kode_gejala]><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Ubah </a> &nbsp;
	          <a type='button' class='btn btn-danger margin' href=\"JavaScript: confirmIt('Anda yakin akan menghapusnya ?','$aksi?module=gejala&act=hapus&id=$r[kode_gejala]','','','','u','n','Self','Self')\" onMouseOver=\"self.status=''; return true\" onMouseOut=\"self.status=''; return true\"><i class='fa fa-trash-o' aria-hidden='true'></i> Hapus</a>
             </td></tr>";
      $no++;
	  $counter++;
    }
    echo "</tbody></table>";
			}
			else{
				echo "<div class='alert alert-danger alert-dismissible'>
                <h4><i class='icon fa fa-ban'></i> Gagal!</h4>
                Maaf, Gejala tidak ditemukan.
              </div>";
			}
		}else{
	
	if($baris>0){
	echo" <table class='table table-bordered' style='overflow-x=auto' cellpadding='0' cellspacing='0'>
          <thead>
            <tr>
              <th >No</th>
              <th>Nama Gejala</th>
			  <th>Kategori</th>
			  <th>Kode Depedensi</th>
              <th width='21%'>Aksi</th>
            </tr>
          </thead>
		  <tbody>
		  "; 
	$hasil = mysql_query("SELECT * FROM gejala ORDER BY kode_gejala limit $offset,$limit");
	$no = 1;
	$no = 1 + $offset;
	$counter = 1;
    while ($r=mysql_fetch_array($hasil)){
	if ($counter % 2 == 0){ $warna = "dark";}
	else{ $warna = "light";}
       echo "<tr class='".$warna."'>
			 <td align=center>G$no</td>
			 <td>$r[nama_gejala]</td>
			 <td>$r[kategori]</td>";
			 if (!empty($r['kode_depedensi'])) {
				echo "<td>G$r[kode_depedensi]</td>";
			 }else{
				echo "<td>-</td>";
			 }

		echo "
			 <td align=center>
			 <a type='button' class='btn btn-success margin' href=gejala/editgejala/$r[kode_gejala]><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Ubah </a> &nbsp;
	         <a type='button' class='btn btn-danger margin' href=\"JavaScript: confirmIt('Anda yakin akan menghapusnya ?','$aksi?module=gejala&act=hapus&id=$r[kode_gejala]','','','','u','n','Self','Self')\" onMouseOver=\"self.status=''; return true\" onMouseOut=\"self.status=''; return true\"><i class='fa fa-trash-o' aria-hidden='true'></i> Hapus</a>
             </td></tr>";
      $no++;
	  $counter++;
    }
    echo "</tbody></table>";
	echo "<div class=paging>";

	if ($offset!=0) {
		$prevoffset = $offset-10;
		echo "<span class=prevnext> <a href=index.php?module=gejala&offset=$prevoffset>Back</a></span>";
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
			echo "<a href=index.php?module=gejala&offset=$newoffset>$i</a>";
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
		echo "<span class=prevnext><a href=index.php?module=gejala&offset=$newoffset>Next</a>";
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
  
  case "tambahgejala":
    echo "<form name=text_form method=POST action='$aksi?module=gejala&act=input' onsubmit='return Blank_TextField_Validator()'>
          <br><br><table class='table table-bordered'>
		  	<tr>
				<td width=120>Nama Gejala</td>
				<td>
					<input type=text autocomplete='off' placeholder='Masukkan gejala baru...' class='form-control' name='nama_gejala' size=30>
				</td>
			</tr>
			<tr>
				<td width=120>Kategori </td>
				<td>
					<select name='kategori' id='kategori'>
						<option value='none' selected disabled hidden>--Pilih Kategori--</option>
						<option value='Anak-anak'>Anak-anak</option>
						<option value='Pria Dewasa'>Pria Dewasa</option>
						<option value='Wanita Dewasa'>Wanita Dewasa</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width=120>Kode Depedensi</td>
				<td>
				<select class='form-control' name='kode_depedensi' id='kode_depedensi'>
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
				</td>
			</tr>
		  	<tr>
				<td></td>
				<td><input class='btn btn-success' type=submit name=submit value='Simpan' >
		  		<input class='btn btn-danger' type=button name=batal value='Batal' onclick=\"window.location.href='?module=gejala';\"></td></tr>
          </table></form>";
     break;
    
  case "editgejala":
    $edit=mysql_query("SELECT * FROM gejala WHERE kode_gejala='$_GET[id]'");
    $r=mysql_fetch_array($edit);
	
    echo "<form name=text_form method=POST action='$aksi?module=gejala&act=update' onsubmit='return Blank_TextField_Validator()'>
          <input type=hidden name=id value='$r[kode_gejala]'>
          <br><br><table class='table table-bordered'>
		  <tr><td width=120>Nama Gejala</td><td><input autocomplete='off' type=text class='form-control' name='nama_gejala' size=30 value=\"$r[nama_gejala]\"></td></tr>
		  <tr>
		  <td width=120>Kategori </td>
		  <td>
			  <select name='kategori' id='kategori'>
				  <option value='none' selected disabled hidden>--Pilih Kategori--</option>
				<option value='$r[kategori]' selected hidden >$r[kategori]</option>
				  <option value='Anak-anak'>Anak-anak</option>
				  <option value='Pria Dewasa'>Pria Dewasa</option>
				  <option value='Wanita Dewasa'>Wanita Dewasa</option>
			  </select>
		  </td>
	  	  </tr>
			<tr>
			<td width=120>Kode Depedensi</td>
			<td>
			<select class='form-control' name='kode_depedensi' id='kode_depedensi'>
			<option value=''>- Pilih Gejala -</option>
			";
				$edit2=mysql_query("SELECT * FROM gejala WHERE kode_gejala='$r[kode_depedensi]'");
				$selected=mysql_fetch_array($edit2);
				if(!empty($selected['kode_depedensi'])){
					echo "<option value='$selected[kode_gejala]' selected hidden >$selected[kode_gejala] | $selected[nama_gejala]</option>";
				}

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
			</td>
		</tr> 
		  <tr><td></td><td><input class='btn btn-success' type=submit name=submit value='Simpan' >
		  <input class='btn btn-danger' type=button value='Batal' onclick=\"window.location.href='?module=gejala';\"></td></tr>
          </table></form>";
    break;  
}
?>
<?php } ?>
