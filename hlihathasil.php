  <?php
  $nilaiu = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_siswa='$id_siswa' and id_ujian='$ac'"));
  if(empty($nilaiu)){
    $nilai = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM nilai_pindah WHERE id_siswa='$id_siswa' and id_ujian='$ac'"));
  }
  else{
    $nilai = $nilaiu;
  }
  if ($nilai['hasil'] == 1) :
    $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$nilai[id_mapel]'"));
    $namamapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mata_pelajaran WHERE kode_mapel='$mapel[nama]'"));
    $total= number_format($nilai['skor']+$nilai['nilai_esai'], 2, '.', '');
    ?>
    <!-- mryes data hasil ujai siswa -->
    <style type="text/css">
    @media print
    {    
        .no-print
        {
            display: none !important;
        }
    }
  </style>
    <div class='row'>
      <div class='col-md-12'>
        <div class='box box-solid'>
          <div class='box-header with-border'>
            <h3 class='box-title'><i class="fas fa-file-signature"></i> Data Hasil Ujian</h3>
            <div class='box-tools pull-right btn-group'>
            <button class='btn btn-sm btn-info' onclick="printDiv('myprint')"><i class='fa fa-print'></i> Print</button>
            </div>
          </div><!-- /.box-header -->
          <div class='box-body' id="myprint">
            <table class='table table-bordered table-striped'>
              <tr>
                <th width='150'>No Induk</th>
                <td width='10'>:</td>
                <td><?= $siswa['nis'] ?></td>
                <td style="text-align:center; font-weight: bold;">Nilai PG</td>
                <td style="text-align:center; font-weight: bold;">Total Nilai</td>
              </tr>
              <tr>
                <!-- rowspan='3'  -->
                <th>Nama</th>
                <td width='10'>:</td>
                <td><?= $siswa['nama'] ?></td>
                <td style='color: #f39c12; font-size:30px; text-align:center;'><?=  number_format($nilai['skor'], 0, '.', '');?></td>
                
                <td rowspan='4' style='padding-top: 50px; font-size:30px; text-align:center; '>
                  <b 
                  <?php 
                  if($total < 75){ echo" style='font-size:50px'class='text-bold badge bg-red'"; }
                  else{  echo"style='font-size:50px' class='text-bold badge bg-green' "; } ?>><?=  $total ?></b>
                </td>
              </tr>
              <tr>
                <th>Kelas</th>
                <td width='10'>:</td>
                <td><?= $siswa['id_kelas'] ?></td>
                <td style="text-align:center; font-weight: bold; ">Nilai ESSAI</td>
                
              </tr>
              <tr>
                <th>Mata Pelajaran</th>
                <td width='10'>:</td>
                <td><?= $mapel['nama'] ?></td>
                <td  style='color: #f39c12; font-size:30px; text-align:center;'><?=   number_format($nilai['nilai_esai'], 0, '.', ''); ?></td>
                
              </tr>
            </table>
            <br>
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Detail Jawaban</a></li>
                <li class="no-print"><a href="#tab_2" data-toggle="tab" aria-expanded="true">Peringkat</a></li>

              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <div class='table-responsive'>
                    <table id='example1' class='table table-bordered table-striped'>
                      <thead>
                        <tr>
                          <th width='5px'>#</th>
                          <th>Soal PG</th>
                          <th style='text-align:center'>Jawaban</th>
                          <th style='text-align:center'>Hasil</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $jawaban = unserialize($nilai['jawaban']); ?>
                        <?php foreach ($jawaban as $key => $value) : 
                           
                          ?>
                          <?php
                          $no++;
                          $soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_soal='$key'"));
                          if ($value == $soal['jawaban']) :
                            $status = "<span class='text-green'><i class='fa fa-check'></i></span>";
                          else :
                            $status = "<span class='text-red'><i class='fa fa-times'></i></span>";
                          endif;
                          ?>
                          <tr>
                            <td><?= $no ?></td>
                            <!-- <td><?= $soal['soal'] ?></td> -->
                            <td>
                              <?php 
                              if ($soal['file'] == '') {
                                echo'';
                              } else {
                                echo "<img src='$homeurl/files/$soal[file]' class='img-responsive' style='max-width:120px;'/><p>";
                              }
                              ?>
                              <?= $soal['soal']?>
                              <?php 
                              if ($soal['file1'] == '') {
                                echo'';
                              } else {
                               echo"<img src='$homeurl/files/$soal[file1]' class='img-responsive' style='max-width:120px;'/><p>";
                              }

                              ?>  
                              </td>
                            <td style='text-align:center'><?= $value ?></td>
                            <td style='text-align:center'><?= $status ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="tab_2">
                  <table class='table-responsive'>
                    <table id='example1' class='table table-striped'>
                      <thead>
                        <tr>
                          <th style='text-align:center' width='5px'>Peringkat</th>
                          <th>Nama Siswa</th>
                          <th style='text-align:center'>Hasil</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $nilaix = mysqli_query($koneksi, "SELECT * FROM nilai WHERE  id_ujian='$ac' order by cast(skor as decimal) DESC "); ?>
                        <?php $no = 0; ?>
                        <?php while ($peringkat = mysqli_fetch_array($nilaix)) : ?>
                          <?php
                          $no++;
                          $siswa = mysqli_fetch_array(mysqli_query($koneksi, "select * from siswa where id_siswa='$peringkat[id_siswa]'"));
                          if ($peringkat['id_siswa'] == $id_siswa) {
                            $style = "style='background:yellow;font-size:20px;'";
                          } else {
                            $style = "";
                          }
                          ?>
                          <tr <?= $style ?>>
                            <td style='text-align:center'><?= $no ?></td>
                            <td><?= $siswa['nama'] ?></td>
                            <td style='text-align:center'><?= $peringkat['skor'] ?></td>
                          </tr>
                        <?php endwhile; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php else : ?>
        <div class='row'>
          <div class='col-md-12'>
            <div class='box box-solid'>
              <div class='box-header with-border'>
                <h3 class='box-title'><i class="fas fa-file-signature    "></i> Data Hasil Ujian</h3>
              </div>
              <div class='box-body'>
                <div class='alert alert-success alert-dismissible'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                  <i class='icon fa fa-info'></i>
                  maaf untuk hasil nilai belum dapat dilihat, akan diproses terlebih dahulu,,
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endif ?>
<script type="text/javascript">
  
function printDiv(id){
        var printContents = document.getElementById(id).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
}

</script>