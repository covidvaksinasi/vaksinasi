<title>Riwayat Diagnosis</title>
<center><h2 class='text text-primary'>Riwayat Diagnosis</h2></center>
<hr>
<?php
include "config/fungsi_alert.php";
$aksi = "modul/riwayat/aksi_hasil.php";
switch ($_GET['act']) {
default:
        $offset = $_GET['offset'];
        $limit = 15;
        if (empty($offset)) {
            $offset = 0;
        }
        $sqlgjl = mysql_query("SELECT * FROM gejala order by kode_gejala+0");
        while ($rgjl = mysql_fetch_array($sqlgjl)) {
            $argjl[$rgjl['kode_gejala']] = $rgjl['nama_gejala'];
        }
        $sqlpkt = mysql_query("SELECT * FROM tindakan order by kode_tindakan+0");
        while ($rpkt = mysql_fetch_array($sqlpkt)) {
            $arpkt[$rpkt['kode_tindakan']] = $rpkt['nama_tindakan'];
            $ardpkt[$rpkt['kode_tindakan']] = $rpkt['det_tindakan'];
            $arspkt[$rpkt['kode_tindakan']] = $rpkt['srn_tindakan'];
        }
        $tampil = mysql_query("SELECT * FROM hasil ORDER BY id_hasil");
        $baris = mysql_num_rows($tampil);
        if ($baris > 0) {
          echo"<div class='row'><div class='col-md-12'><table class='table table-bordered table-striped riwayat' style='overflow-x=auto' cellpadding='0' cellspacing='0'>
          <thead>
              <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Tindakan</th>
              <th nowrap>Nilai CF</th>
              <th width='21%' class='text-center'>Aksi</th>
              </tr>
          </thead>
		    <tbody>
		  ";
        $hasil = mysql_query("SELECT * FROM hasil ORDER BY id_hasil limit $offset,$limit");
        $no = 1;
        $no = 1 + $offset;
        $counter = 1;
        while ($r = mysql_fetch_array($hasil)) {
        if ($r['kode_tindakan']>0){
          if ($counter % 2 == 0)
            $warna = "light";
          else
            $warna = "light";
            echo "<tr class='" . $warna . "'>
			      <td align=center>$no</td>
			      <td>$r[tanggal]</td>
			      <td>" . $arpkt[$r['kode_tindakan']] . "</td>
			      <td>" . $r['hasil_nilai'] . "</span></td>
			      <td align=center>
			      <a type='button' class='btn btn-danger btn-xs' target='_blank' href=riwayat-detail/$r[id_hasil]> Detail </a> &nbsp;
	          </td></tr>";
            $no++;
            $counter++;
            }
            }
            echo "</tbody></table></div>";
            ?>
        
            <?php
            echo "</div><div class='col-md-12'><div class='row'><div class=paging>";
            if ($offset != 0) {
                $prevoffset = $offset - $limit;
                echo "<span class=prevnext> <a href=index.php?module=riwayat&offset=$prevoffset>Back</a></span>";
            } 
            else {
                echo "<span class=disabled>Back</span>"; 
            }
            $halaman = intval($baris / $limit); 
            if ($baris % $limit) {
                $halaman++;
            }
            for ($i = 1; $i <= $halaman; $i++) {
                $newoffset = $limit * ($i - 1);
                if ($offset != $newoffset) {
                    echo "<a href=index.php?module=riwayat&offset=$newoffset>$i</a>";
                } else {
                    echo "<span class=current>" . $i . "</span>"; 
                }
            }
            if (!(($offset / $limit) + 1 == $halaman) && $halaman != 1) {
                $newoffset = $offset + $limit;
                echo "<span class=prevnext><a href=index.php?module=riwayat&offset=$newoffset>Next</a>";
            } else {
                echo "<span class=disabled>Next</span>";
            }

            echo "</div></div></div>";
        } else {
            echo "<br><b>Data Kosong !</b>";
        }
}
?>

</script>




