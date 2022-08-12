<title>Diagnosis </title>
<script type="text/javascript">
function Blank_TextField_Validator(){
	if (text_form.nama.value == "")
	{
	alert("Masukkan nama!");
	text_form.nama.focus();
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
switch ($_GET['act']) {

  default:
    if ($_POST['submit']) {
      $nama=$_POST['nama'];
      $jenis_kelamin=$_POST['jenis_kelamin'];
      $tanggal_lahir=$_POST['tanggal_lahir'];
      $arcolor = array('#ffffff', '#ffffff', '#ffffff', '#ffffff', '#ffffff', '#ffffff', '#ffffff', '#ffffff', '#ffffff', '#ffffff');
      date_default_timezone_set("Asia/Jakarta");
      $inptanggal = date('Y-m-d H:i:s');

      $arbobot = array('0', '1', '0.8', '0.6','0.2' );
      $argejala = array();
 

      for ($i = 0; $i < count($_POST['kondisi']); $i++) {
        $arkondisi = explode("_", $_POST['kondisi'][$i]);
        if (strlen($_POST['kondisi'][$i]) > 1) {
          $argejala += array($arkondisi[0] => $arkondisi[1]);
        }
      }
      // var_dump( $_POST['kondisi']);
      $sqlkondisi = mysql_query("SELECT * FROM kondisi order by id+0");
      while ($rkondisi = mysql_fetch_array($sqlkondisi)) {
        $arkondisitext[$rkondisi['id']] = $rkondisi['kondisi'];
      }

      $sqlpkt = mysql_query("SELECT * FROM tindakan order by kode_tindakan+0");
      while ($rpkt = mysql_fetch_array($sqlpkt)) {
        $arpkt[$rpkt['kode_tindakan']] = $rpkt['nama_tindakan'];
        $ardpkt[$rpkt['kode_tindakan']] = $rpkt['det_tindakan'];
        $arspkt[$rpkt['kode_tindakan']] = $rpkt['srn_tindakan'];
        $argpkt[$rpkt['kode_tindakan']] = $rpkt['gambar'];
      }

     

      $sqltindakan = mysql_query("SELECT * FROM tindakan order by kode_tindakan");
      $artindakan = array();

      while ($rtindakan = mysql_fetch_array($sqltindakan)) {

        $cftotal_temp = 0;
        $cf = 0;
        $sqlgejala = mysql_query("SELECT * FROM basis_pengetahuan where kode_tindakan=$rtindakan[kode_tindakan]");
        $cflama = 0;
        while ($rgejala = mysql_fetch_array($sqlgejala)) {
          $arkondisi = explode("_", $_POST['kondisi'][0]);
          
          $gejala = $arkondisi[0];
         
            for ($i = 0; $i < count($_POST['kondisi']); $i++) {
              $arkondisi = explode("_", $_POST['kondisi'][$i]);
              
              $gejala = $arkondisi[0];
              if ($rgejala['kode_gejala'] == $gejala) {
                $cf = ($rgejala['mb'] - $rgejala['md']) * $arbobot[$arkondisi[1]];
             
                $arbobot_all[$i]=$arbobot[$arkondisi[1]];
                if (($cf >= 0) && ($cf * $cflama >= 0)) {
                  $cflama = $cflama + ($cf * (1 - $cflama));
               
                 
                }
                if ($cf * $cflama < 0) {
                  $cflama = ($cflama + $cf) / (1 - Math . Min(Math . abs($cflama), Math . abs($cf)));
                
                  
                }
                if (($cf < 0) && ($cf * $cflama >= 0)) {
                  $cflama = $cflama + ($cf * (1 + $cflama));
                 
                
                }
                
              }
            
            }

        }

        if ($cflama > 0) {
          $artindakan += array($rtindakan['kode_tindakan'] => number_format($cflama, 4));
        }
        
      }
      
     
      arsort($artindakan);
      
      $inpgejala = serialize($argejala);
      $inptindakan = serialize($artindakan);
      
      $np1 = 0;
      foreach ($artindakan as $key1 => $value1) {
        $np1++;
        $idpkt1[$np1] = $key1;
        $vlpkt1[$np1] = $value1;
      }






      $sqltindakan2 = mysql_query("SELECT * FROM tindakan order by kode_tindakan");
      $artindakan2 = array();
      $cf_all= array();
      $rgejala_mb=array();
      $rgejala_md= array();
      $arbobot_all=array();
      $combine_all=array();
      $cf_pakar=array();
      $cf_PakarCount=0;
      $count=0;
      while ($rtindakan2 = mysql_fetch_array($sqltindakan2)) {

        $cftotal_temp = 0;
        $cf = 0;
        $sqlgejala = mysql_query("SELECT * FROM basis_pengetahuan where kode_tindakan=$idpkt1[1]");
        $cflama = 0;
        while ($rgejala = mysql_fetch_array($sqlgejala)) {
          $arkondisi = explode("_", $_POST['kondisi'][0]);
          
          $gejala = $arkondisi[0];
          
            for ($i = 0; $i < count($_POST['kondisi']); $i++) {
              $arkondisi = explode("_", $_POST['kondisi'][$i]);
              
              $gejala = $arkondisi[0];
              if ($rgejala['kode_gejala'] == $gejala) {
                $cf = ($rgejala['mb'] - $rgejala['md']) * $arbobot[$arkondisi[1]];
                $cf_all[$i]=$cf;
                $rgejala_mb[$i]=$rgejala['mb'];
                $rgejala_md[$i]=$rgejala['md'];
                $arbobot_all[$i]=$arbobot[$arkondisi[1]];
                if (($cf >= 0) && ($cf * $cflama >= 0)) {
                  $cflama = $cflama + ($cf * (1 - $cflama));
                  $combine_all[$i]=number_format($cflama, 4);
                 
                }
                if ($cf * $cflama < 0) {
                  $cflama = ($cflama + $cf) / (1 - Math . Min(Math . abs($cflama), Math . abs($cf)));
                  $combine_all[$i]=number_format($cflama, 4);
                  
                }
                if (($cf < 0) && ($cf * $cflama >= 0)) {
                  $cflama = $cflama + ($cf * (1 + $cflama));
                  $combine_all[$i]=number_format($cflama, 4);
                
                }
                
              }
            
            }
         
          
          
         
        

        }

        if ($cflama > 0) {
          $artindakan += array($rtindakan['kode_tindakan'] => number_format($cflama, 4));
        
          $cf_pakar[$cf_PakarCount]= number_format($cflama, 4);
          $cf_PakarCount++;
          
         
        }
        
      }

      var_dump($cf_PakarCount);
        ////////////////////////////////////////TAMPILKAN PERHITUNGAN/////////////////////////
      
      echo "<div class='box box-danger box-solid'><div class='box-header with-border'><h3 class='box-title'>Perhitungan</h3></div><div class='box-body'><h4>";
      echo "<hr><table class='table table-bordered'> 
            <th width=8%>No</th>
            <th width=10%>Kode</th>
            <th width=40%>Gejala yang dialami </th>
            <th>CF </th>
            <th>Pilihan</th>
            
            </tr>";
          $ig = 0;
          $cfcount=0;
          foreach ($argejala as $key => $value) {
            $kondisi = $value;
            $ig++;
            $gejala = $key;
            $sql4 = mysql_query("SELECT * FROM gejala where kode_gejala = '$key'");
            $r4 = mysql_fetch_array($sql4);
            echo '<tr><td>' . $ig . '</td>';
            echo '<td>G' . str_pad($r4['kode_gejala'], 3, '0', STR_PAD_LEFT) . '</td>';
            echo '<td><span class="hasil text text-primary">' . $r4['nama_gejala'] . "</span></td>";
            echo '<td>'
                  .'CF Gejala ' .$cfcount+1 .' = ( mb - md) * CF user <br>'
                  .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= '
                  .'('.$rgejala_mb[$cfcount].' - '.$rgejala_md[$cfcount].' ) * '.$arbobot_all[$cfcount].'<br>'
                  .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= '
                  .$cf_all[$cfcount]. 
                  '</td>';
            $cfcount++;
            echo '<td><span class="kondisipilih" style="color:' . $arcolor[$kondisi] . '">' . $arkondisitext[$kondisi] . "</span></td></tr>";
          }

      echo "</table>";

      echo "<br>";
      $combine_count=0;
      $count_cf=0;
      for ($i=0; $i < count($combine_all)-1 ; $i++) { 
        $combine_count++;
        $count_cf++;
        if($i==0){
          
        echo 'CF Combine '. $combine_count.'&nbsp;&nbsp;&nbsp;= CF gejala '. $count_cf .' + CF gejala '. $count_cf+1 .' * (1 – CF gejala '. $count_cf .') <br>'
             .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= '
             .$cf_all[$i].' + '.$cf_all[$i+1].' * ( 1 - '.$cf_all[$i].') <br>'
             .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= '
             . $combine_all[$combine_count]
             .'<br><br> ';
        }else{
          if($combine_all[$i]>0){
            if($i>1){
              echo 'CF Combine '. $combine_count .'&nbsp;&nbsp;&nbsp;= CF combine '. $combine_count-1 .' + CF gejala '. $count_cf+1 .' * (1- CF combine '. $combine_count-1 .') <br>'
              .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= '
              .$combine_all[$i].' + '.$cf_all[$i].' * ( 1 - '.$combine_all[$i-1].') <br>'
              .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= '
              . $combine_all[$i]
              .'<br><br> ';
            }
           
          }
         
        }

      }
      echo 'Presentase keyakinan &nbsp;&nbsp;&nbsp;= '. $vlpkt1[1]. ' * 100%  <br>'
          .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= '
          . $vlpkt1[1] *100  . '%<br>'
         
         ;

      echo "</div></div>";

      ////////////////////////////////////////END PERHITUNGAN/////////////////////////


     
      

      mysql_query("INSERT INTO hasil(
                  tanggal,
                  gejala,
                  tindakan,
                  hasil_id,
                  hasil_nilai,
                  nama,
                  jenis_kelamin,
                  tanggal_lahir
				  ) 
	        VALUES(
                '$inptanggal',
                '$inpgejala',
                '$inptindakan',
                '$idpkt1[1]',
                '$vlpkt1[1]',
                '$nama',
                '$jenis_kelamin',
                '$tanggal_lahir'
				)");
// --------------------- END -------------------------

      echo "<div class='content'>
	<h2 class='text text-primary'>Hasil Diagnosis &nbsp;&nbsp;<button id='print' onClick='window.print();' data-toggle='tooltip' data-placement='right' title='Cetak hasil diagnosa'><i class='fa fa-print'></i> Cetak</button> </h2>
	          <hr><table class='table table-bordered'> 
          <th width=8%>No</th>
          <th width=10%>Kode</th>
          <th>Gejala yang dialami </th>
          <th width=20%>Pilihan</th>
          </tr>";
      $ig = 0;
      foreach ($argejala as $key => $value) {
        $kondisi = $value;
        $ig++;
        $gejala = $key;
        $sql4 = mysql_query("SELECT * FROM gejala where kode_gejala = '$key'");
        $r4 = mysql_fetch_array($sql4);
        echo '<tr><td>' . $ig . '</td>';
        echo '<td>G' . str_pad($r4['kode_gejala'], 3, '0', STR_PAD_LEFT) . '</td>';
        echo '<td><span class="hasil text text-primary">' . $r4['nama_gejala'] . "</span></td>";
        echo '<td><span class="kondisipilih" style="color:' . $arcolor[$kondisi] . '">' . $arkondisitext[$kondisi] . "</span></td></tr>";
      }
      $np = 0;
      foreach ($artindakan as $key => $value) {
        $np++;
        $idpkt[$np] = $key;
        $nmpkt[$np] = $arpkt[$key];
        $vlpkt[$np] = $value;
      }
      if ($argpkt[$idpkt[1]]) {
        $gambar = 'gambar/tindakan/' . $argpkt[$idpkt[1]];
      } else {
        $gambar = 'gambar/noimage.png';
      }
      echo "</table><div class='well well-small'><img class='card-img-top img-bordered-sm' style='float:right; margin-left:15px;' src='" . $gambar . "' height=200><h3>Hasil Diagnosa</h3>";
      echo "<div class='callout callout-default'>Anda : <b><h3 class='text text-success'></b> " . $vlpkt[1]*100 . " %" . $nmpkt[1] . " <br></h3>";
      echo "</div></div><div class='box box-danger box-solid'><div class='box-header with-border'><h3 class='box-title'>Detail</h3></div><div class='box-body'><h4>";
      echo $ardpkt[$idpkt[1]];
      echo "</h4></div></div><div class='box box-danger box-solid'><div class='box-header with-border'><h3 class='box-title'>Saran</h3></div><div class='box-body'><h4>";
      echo $arspkt[$idpkt[1]];
      echo "</h4></div></div><div class='box box-danger box-solid'><div class='box-header with-border'><h3 class='box-title'>Kemungkinan lain</h3></div><div class='box-body'><h4>";
      for ($ipl = 2; $ipl < count($idpkt); $ipl++) {
        echo " <h4><i class='fa fa-caret-square-o-right'></i> " . $nmpkt[$ipl] . "</b> / " . round($vlpkt[$ipl], 2) . " % (" . $vlpkt[$ipl] . ")<br></h4>";
      }
     
      echo "</div></div></div></div>";


    } else {

      echo "<center><h2 class='text text-primary'>Diagnosis Tindakan</h2></center>  <hr>";
      echo "<div class='alert alert-success alert-dismissible'>
                <h4>Keterangan:</h4>
                P &nbsp;&nbsp;&nbsp;&nbsp; = PASTI.<br>
                HP &nbsp; = HAMPIR PASTI.<br>
                KB &nbsp; = KEMUNGKINAN BESAR.<br>
                M &nbsp; &nbsp; = MUNGKIN.<br>
                T  &nbsp;&nbsp; &nbsp; = TIDAK.
              </div>";
      echo "<form name=text_form method=POST  onsubmit='return Blank_TextField_Validator()'>
          <br><br><table class='table table-bordered'>
      <tr>
        <td width=120>Nama</td>
        <td>
          <input type=text name='nama' placeholder='Input Nama' class='form-control'  size=30 value='$_POST[nama]' /> 
        </td>
      </tr>
      <tr>
        <td width=120>Jenis </td>
        <td>
        <select name='jenis_kelamin' id='jenis_kelamin' value='$_POST[jenis_kelamin]' width=30>
          <option value='none' selected disabled hidden>--Pilih Jenis Kelamin--</option>
          ";
            if($_POST['jenis_kelamin']){
              echo" <option value=".$_POST['jenis_kelamin']." selected hidden >".$_POST['jenis_kelamin']." </option>";
            }
      echo"
          <option value='Pria' >Pria</option>
          <option value='Wanita'>Wanita</option>
        </select>
        </td>
      </tr>
      <tr>
        <td width=120>Tanggal Lahir </td>
        <td>
        <input type=date name='tanggal_lahir'  placeholder='Input Nama' class='form-control' value='$_POST[tanggal_lahir]' width=30/> 
        </td>
      </tr>
    
        <tr>
        <td></td>
        <td><input class='btn btn-success' type=submit name=filter value='Simpan' >
        <input class='btn btn-danger' type=submit name=clear value='Bersihkan' >
          </table></form>";
      
        
      
      
      
      ///////////////////////////////// FILTER UMUR ////////////////////////
     

        if ($_POST['filter']){
        
          $birthDate = date("m/d/Y", strtotime($_POST['tanggal_lahir']));   
          $birthDate = explode("/", $birthDate);
          $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));
          $jenis_kelamin= $_POST['jenis_kelamin'];
          echo $jenis_kelamin;
        if ($age<6){
            echo "<div class='alert alert-danger alert-dismissible'>";
            echo "<h4>MAAF</h4>
                  Anda belum bisa menerima vaksinasi!<br>
            </div>";
          }
        elseif ( $age>=6 && $age<=12){  
        
            echo "
        <form name=text_form method=POST action='diagnosa' >
              <input type='hidden' id='nama' name='nama' value='$_POST[nama]'>
              <input type='hidden' id='jenis_kelamin' name='jenis_kelamin' value='$_POST[jenis_kelamin]'>
              <input type='hidden' id='tanggal_lahir' name='tanggal_lahir' value='$_POST[tanggal_lahir]'>
              <table class='table table-bordered table-striped konsultasi'><tbody class='pilihkondisi'>
              <tr><th>No</th><th>Kode</th><th>Gejala</th><th width='30%'>Pilih Kondisi</th></tr>";
          
          $sql3 = mysql_query("SELECT * FROM gejala where kategori='Anak-anak' order by kode_gejala" );
        
          $i = 0;
        while ($r3 = mysql_fetch_array($sql3)) {
          $i++;
          echo "<tr><td class=opsi>$i</td>";
          echo "<td class=opsi>G" . str_pad($r3['kode_gejala'], 3, '0', STR_PAD_LEFT) . "</td>";
          echo "<td class=gejala>$r3[nama_gejala]</td>";
          echo '<td class="opsi">';
          echo '<fieldset id="' . $r3['kode_gejala'] .'" margin="" align="left">  ';
          $s = "select * from kondisi order by id";
          $q = mysql_query($s) or die($s);
          while ($rw = mysql_fetch_array($q)) {
            ?>
            <input type="radio" name="kondisi[]<?php echo $i?>" id="<?php echo $r3['kode_gejala'].'_'.$r3['kode_depedensi'] ?>"  value="<?php echo $r3['kode_gejala'] . '_' . $rw['id']; ?>" >
            <label for="<?php echo 'sl'. $i ?>" ><?php echo $rw['kondisi']; ?></label>
            &nbsp;
            <?php
          }
          echo '</fieldset>';
          echo '</td>';

          ?>
          <script>
         
          document.body.addEventListener('change', function (e) {
           

            let text = e.target.id;  id="1_2"
            const myArray = text.split("_");
            let code= myArray[0];
            let depen=myArray[1];

            let text2=e.target.value
            const myArray2 = text2.split("_");
            let opsi=myArray2[1]
            if (depen!=0){

              if (opsi<5){
              
                document.getElementById(depen).disabled = true;
              }else if(opsi==5){
                
                document.getElementById(depen).disabled = false;
              };
            }
          });
          </script>
         
          <?php
          echo "</tr>";
        }
        echo "
        <input class='float' type=submit data-toggle='tooltip' data-placement='top' title='Klik disini untuk melihat hasil diagnosa' name=submit value='&#xf00e;' style='font-family:Arial, FontAwesome'>
        </tbody></table></form>"; 

          }elseif ($age>=13 && $jenis_kelamin=='Pria') {
            echo "
            <form name=text_form method=POST action='diagnosa' >
                  <input type='hidden' id='nama' name='nama' value='$_POST[nama]'>
                  <input type='hidden' id='jenis_kelamin' name='jenis_kelamin' value='$_POST[jenis_kelamin]'>
                  <input type='hidden' id='tanggal_lahir' name='tanggal_lahir' value='$_POST[tanggal_lahir]'>
                  <table class='table table-bordered table-striped konsultasi'><tbody class='pilihkondisi'>
                  <tr><th>No</th><th>Kode</th><th>Gejala</th><th width='30%'>Pilih Kondisi</th></tr>";
              
              $sql3 = mysql_query("SELECT * FROM gejala where kategori='Pria Dewasa' order by kode_gejala" );
        
              $i = 0;
              while ($r3 = mysql_fetch_array($sql3)) {
                $i++;
                echo "<tr><td class=opsi>$i</td>";
                echo "<td class=opsi>G" . str_pad($r3['kode_gejala'], 3, '0', STR_PAD_LEFT) . "</td>";
                echo "<td class=gejala>$r3[nama_gejala]</td>";
                echo '<td class="opsi">';
                echo '<fieldset id="' . $r3['kode_gejala'] .'" margin="" align="left">  ';
                $s = "select * from kondisi order by id";
                $q = mysql_query($s) or die($s);
                while ($rw = mysql_fetch_array($q)) {
                  ?>
                  <input type="radio" name="kondisi[]<?php echo $i?>" id="<?php echo $r3['kode_gejala'].'_'.$r3['kode_depedensi'] ?>"  value="<?php echo $r3['kode_gejala'] . '_' . $rw['id']; ?>" >
                  <label for="<?php echo 'sl'. $i ?>" ><?php echo $rw['kondisi']; ?></label>
                  &nbsp;
                  <?php
                }
                echo '</fieldset>';
                echo '</td>';
      
                ?>
                <script>
               
                document.body.addEventListener('change', function (e) {
                  
                  let text = e.target.id;
                  const myArray = text.split("_");
                  let code= myArray[0];
                  let depen=myArray[1];
      
                  let text2=e.target.value
                  const myArray2 = text2.split("_");
                  let opsi=myArray2[1]
                  if (depen!=0){
      
                    if (opsi<5){
                    
                      document.getElementById(depen).disabled = true;
                    }else if(opsi==5){
                      
                      document.getElementById(depen).disabled = false;
                    };
                  }
                });
                </script>
               
                <?php
                echo "</tr>";
              }
              echo "
              <input class='float' type=submit data-toggle='tooltip' data-placement='top' title='Klik disini untuk melihat hasil diagnosa' name=submit value='&#xf00e;' style='font-family:Arial, FontAwesome'>
              </tbody></table></form>"; 

                  
          }elseif ($age>=13 && $jenis_kelamin=='Wanita') {
           
            echo "
            <form name=text_form method=POST action='diagnosa' >
            <input type='hidden' id='nama' name='nama' value='$_POST[nama]'>
            <input type='hidden' id='jenis_kelamin' name='jenis_kelamin' value='$_POST[jenis_kelamin]'>
            <input type='hidden' id='tanggal_lahir' name='tanggal_lahir' value='$_POST[tanggal_lahir]'>
            <table class='table table-bordered table-striped konsultasi'><tbody class='pilihkondisi'>
            <tr><th>No</th><th>Kode</th><th>Gejala</th><th width='30%'>Pilih Kondisi</th></tr>";
        
        $sql3 = mysql_query("SELECT * FROM gejala where kategori='Wanita Dewasa' order by kode_gejala" );
       
        $i = 0;
        while ($r3 = mysql_fetch_array($sql3)) {
          $i++;
          echo "<tr><td class=opsi>$i</td>";
          echo "<td class=opsi>G" . str_pad($r3['kode_gejala'], 3, '0', STR_PAD_LEFT) . "</td>";
          echo "<td class=gejala>$r3[nama_gejala]</td>";
          echo '<td class="opsi">';
          echo '<fieldset id="' . $r3['kode_gejala'] .'" margin="" align="left">  ';
          $s = "select * from kondisi order by id";
          $q = mysql_query($s) or die($s);
          while ($rw = mysql_fetch_array($q)) {
            ?>
            <input type="radio" name="kondisi[]<?php echo $i?>" id="<?php echo $r3['kode_gejala'].'_'.$r3['kode_depedensi'] ?>"  value="<?php echo $r3['kode_gejala'] . '_' . $rw['id']; ?>" >
            <label for="<?php echo 'sl'. $i ?>" ><?php echo $rw['kondisi']; ?></label>
            &nbsp;
            <?php
          }
          echo '</fieldset>';
          echo '</td>';

          ?>
          <script>
         
          document.body.addEventListener('change', function (e) {
            
            let text = e.target.id;
            const myArray = text.split("_");
            let code= myArray[0];
            let depen=myArray[1];

            let text2=e.target.value
            const myArray2 = text2.split("_");
            let opsi=myArray2[1]
            if (depen!=0){

              if (opsi<5){
              
                document.getElementById(depen).disabled = true;
              }else if(opsi==5){
                
                document.getElementById(depen).disabled = false;
              };
            }
          });
          </script>
         
          <?php
          echo "</tr>";
        }
        echo "
        <input class='float' type=submit data-toggle='tooltip' data-placement='top' title='Klik disini untuk melihat hasil diagnosa' name=submit value='&#xf00e;' style='font-family:Arial, FontAwesome'>
        </tbody></table></form>"; 

          }elseif ($_POST['clear']) {
          header("refresh: 3;");
          }
        }
    }
    break;
}
?>