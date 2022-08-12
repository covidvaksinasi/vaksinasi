<title>Tentang Vaksin</title>
<center><h2 class='text text-primary'>Jenis-jenis Vaksin</h2></center>
<hr>
<div class="row">

  <?php
  $hasil = mysql_query("SELECT * FROM keterangan ORDER BY kode_keterangan");
  while ($r = mysql_fetch_array($hasil)) {
      ?>

      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" data-aos="fade-right">
        <div class="card text-center">
          <img class="card-img-top img-bordered-sm" src="<?php echo 'gambar/' . $r['gambar']; ?>" alt="" width="100%" height="200">
          <div class="card-block">
            <h4 class="card-title"><h3 class="bg-keterangan"><?php echo $r['nama_keterangan']; ?></h3>
              <a class="btn bg-maroon btn-flat margin" href="#" data-toggle="modal" data-target="#modal<?php echo $r['kode_keterangan']; ?>"><i class="fa fa-puzzle-piece" aria-hidden="true"></i> Detail</a>
          </div>
        </div>
        <hr>
      </div>
      <div class="modal fade" id="modal<?php echo $r['kode_keterangan'];?>" role="dialog">
        <div class="modal-dialog">

          <div class="modal-content">
            <div class="modal-header detail-ket">
              <button type="button" class="close" data-dismiss="modal" style="opacity: .99;color: #fff;">&times;</button>
              <h4 class="modal-title text text-ket"><i class="fa fa-puzzle-piece" aria-hidden="true"></i> Detail  <?php echo $r['nama_post']; ?></h4>
            </div>
            <div class="modal-body" style="text-align: justify;text-justify: inter-word;">
              <p><?php echo $r['det_keterangan']; ?></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
      
  <?php } ?>



</div>
