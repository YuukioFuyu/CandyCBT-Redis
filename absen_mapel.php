<?php
if(empty($_GET['tahun'])){
  $akti1 = 'class="active"';
  $akti2 = 'in active';
}
else{
  $akti3 = 'class="active"';
  $akti4 = 'in active';
}
$cekSend = $dbb->CekAktifSend();
$token_bot = fetch($koneksi, "bot_telegram");
?>

<div class='row'>
  <div class="col-md-12"> 
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit"></i>Absen Mapel</h3>
      </div>
      <div class='box-body'>
      <ul class="nav nav-tabs">
        <li <?= $akti1 ?>><a data-toggle="tab" href="#home"><i class="fa fa-plus"></i> Menu Absen Kehadiran</a></li>
        <li <?= $akti3 ?>><a data-toggle="tab" href="#menu1"><i class="fa fa-check"></i> Lihat Absensi Kehadiran</a></li>
      </ul>
      <div class="tab-content">
        <div id="home" class="tab-pane fade <?= $akti2 ?>">
          
            <div class="row">
              <div class="col-md-12"> 
              <div class="form-group">
                  <label for="email">Tanggal Absen Hari Ini</label>
                  <input   id="tgl" type="text" readonly="readonly" value="<?php  echo date("d-m-Y") ?>" class="form-control " id="tgl">
                </div>
                
              </div>
            </div>
          <div class="row">
            <div class="col-md-12">
              <!-- <h2>Bordered Table</h2> -->       
                <h2>Daftar Mapel Hari Ini <button style="margin-left: 2px;" onclick="location.reload();" class='btn btn-flat btn-primary'><i class="fa fa-spinner fa-spin "></i> Refres Jadwal</button> </h2> 
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Absen</th>
                      <th>Nama Mapel</th>
                      <th>Guru</th>
                      <th>Hari</th>
                      <th>Jam Mulai</th>
                      <th>Jam Akhir</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $daftar_hari = array(
                     'Sunday' => 'Minggu',
                     'Monday' => 'Senin',
                     'Tuesday' => 'Selasa',
                     'Wednesday' => 'Rabu',
                     'Thursday' => 'Kamis',
                     'Friday' => 'Jumat',
                     'Saturday' => 'Sabtu'
                    );
                    $jamsekarang = strtotime(date("H:i"));
                    $hari = date("d-m-Y");
                    $namahari = date('l', strtotime($hari));
                    $mapel = $dbb->getAbsenMapel($idkelas,$namahari);
                   
                    foreach ($mapel as $vl) { 
                      $idbtn = $vl['amId'];
                      $idmapel=$vl['idmapel'];
                      $tokenbot=$vl['tlChatId'];
                      ?>
                      <tr>
                        <td>
                          <?php 
                            $jamin= strtotime($vl['amJamMulai']);
                            $jamout = strtotime($vl['amJamAkhir']);
                            if($jamsekarang >=$jamin AND  $jamsekarang <=$jamout){
                              echo'<button 
                              data-nama_mapel="'.$vl['amNamaMapel'].'"
                              data-tokenbot="'.$tokenbot.'" data-idkelas="'.$kelasdb['idkls'].'" data-idsiswa="'.$siswa['id_siswa'].'" data-mapel="'.$idmapel.'" data-id="'.$idbtn.'" class="btn btn-primary absenmapel"><i class="fa fa-check"></i> Klik Absen</button>';
                            }
                            else if($jamsekarang <= $jamin AND  $jamsekarang <= $jamout){
                              echo'<button disabled  class="btn btn-danger"><i class="fa fa-times"></i> Belum Terbuka </button>';
                            }
                            else{
                              echo'<button disabled class="btn btn-warning">Sudah Berakhir </button>';
                            }
                          ?>
                        </td>
                      
                        <td><?= $vl['amNamaMapel']; ?></td>
                        <td><?= $vl['nama']; ?></td>
                        <td><?= $daftar_hari[$vl['amHari']]; ?></td>
                        <td><?= $vl['amJamMulai']; ?></td>
                        <td><?= $vl['amJamAkhir']; ?></td>
                        </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div id="menu1" class="tab-pane fade <?= $akti4 ?>" >
          <br>
          <div class="row" style="padding-bottom: 10px ">
            <div class="col-md-2" style="padding-bottom: 3px">
              <select id="tahun" class="form-control select2 ">
                <?php $kelas = $dbb->getTahun(); ?>
                  <option value=""> Pilih Tahun</option>
                  <?php foreach ($kelas as $value) : ?>
                    <option <?= selectAktif($value['tahun'],$_GET['tahun']) ?> value="<?= $value['tahun'] ?>"><?= $value['tahun'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2" style="padding-bottom: 3px">
              <select id="bulan" class="form-control select2 ">
                  <option value=""> Pilih Bulan</option>
                  <?php for ($i=1; $i <=12 ; $i++) { ?>
                    <option <?= selectAktif($i,$_GET['bulan']) ?> value="<?= $i ?>"><?= bulanIndo($i) ?></option>
                    <?php } ?>
              </select>
            </div>
            <div class="col-md-3" style="padding-bottom: 3px">
              <select id="mapel" class="form-control select2 ">
                  <option value=""> Pilih Mapel</option>
                  <?php foreach ($dbb->getAbsenMapel($idkelas) as $vl) { ?>
                    <option <?= selectAktif( $vl['amId'],$_GET['mapel']) ?> value="<?= $vl['amId']?>"><?= $vl['nama_mapel']?></option>
                    <?php } ?>
              </select>
            </div>
            <div class="col-md-2" style="padding-bottom: 3px">
              <button id="cari_absen" class="btn btn-info"> Cari Data Absen</button>
            </div>

          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="tableabsen">
              <thead>
                  <tr>
                    <th>NO</th>
                    <th>NAMA SISWA</th>
                    <th>KELAS</th>
                    <th>TANGGAL</th>
                    <th>JAM ABSEN</th>
                    <th>STATUS ABSEN</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no=1;
                  foreach ($dbb->getAbsenMapel_by_siswa() as $vl) { ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $vl['nama']?></td>
                      <td><?= $vl['id_kelas']?></td>
                      <td><?= $vl['amaTgl']?></td>
                      <td><?= $vl['amaJamIn']?></td>
                      <td><?= $vl['amaStatus']?></td>
                    </tr>
                  <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
       
      </div>
     
</div>
</div>
<script type="text/javascript">
  var tabel = $('#tableabsen').dataTable();
$(document).on('click', '#cari_absen', function() {
    var tahun = $('#tahun').val();
    var bulan = $('#bulan').val();
    var mapel = $('#mapel').val();
    var siswa = "<?= $_SESSION['id_siswa'] ?>";
    location.replace("?tahun="+tahun+"&bulan="+bulan+"&mapel="+mapel+"&siswa="+siswa);
  });
  $(document).on('click', '.absenmapel', function() {
    var idam = $(this).data('id'); //id anggota mapel
    var idmapel = $(this).data('mapel');
    var idkelas = $(this).data('idkelas');
    var idsiswa = $(this).data('idsiswa');
    var tokenbot = $(this).data('tokenbot');
    var nama_mapel = $(this).data('nama_mapel');
    
    var tgl = $('#tgl').val();
    
   
    $.ajax({
      type: 'POST',
      url: '../_absen _mapel.php',
      data: 'idam='+idam+'&idmapel='+idmapel+'&idkelas='+idkelas+'&idsiswa='+idsiswa+'&tgl='+tgl+'&tokenbot='+tokenbot+'&nama_mapel='+nama_mapel,
      success: function(response) {
        console.log(response);
        if(response ==1){
            toastr.success('Absensi Berhasil Hari Ini <br>'+tgl);
            <?php 
        if($token_bot['botActive']==1){
          if($cekSend['botSendAbsenMapel']==1){
            $pesan='---Absen Mapel Kehadiran---';
            $date = date("d-m-Y");
            $jam = date("H:i:s");
            ?>
            var settings = {
              "async": true,
              "crossDomain": true,
              "url": "https://api.telegram.org/bot<?php echo $_SESSION['token_bot_telegram']; ?>/sendMessage",
              "method": "POST",
              "headers": {
                "Content-Type": "application/json",
                "cache-control": "no-cache"
              },
              "data": JSON.stringify({
                "chat_id": tokenbot,
                "text": "<b><?=$pesan?></b>\n <b><?=$_SESSION['nama_sekolah']?></b>\nMapel : <b>"+nama_mapel +"</b>\nNama : <b><?= $_SESSION['full_nama'] ?></b>\nKelas : <b><?= $_SESSION['id_kelas'] ?></b>\nTgl : <b><?= $date ?></b>\nJam : <b><?= $jam ?></b>",
                "parse_mode":"HTML",
              })
            }
        
            // $.ajax(settings).done(function (response) {
            //   console.log(response);
            // });
            $.ajax(settings).done();
        <?php  } } ?>
        }
        else if(response ==0){
          toastr.error('Upss Gagal Absen');
        }
        else{
          toastr.warning('Anda Sudah Absen Hari Ini <br> '+tgl);
        }
        
      }
    });
    
    
  });
  $('#formjawaban').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var homeurl = '<?= $homeurl ?>';

      $.ajax({
        type: 'POST',
        url: homeurl + '/_absen_foto.php',
        enctype: 'multipart/form-data',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);
          if (data == 1) {
            toastr.success("Berhasil Upload Foto Absen Kehadiran");
            setTimeout(function () { location.reload(1); }, 2000);
          } 
          else if(data == 0){
            toastr.warning("Klik Absen Kehadiran Terlebih Dahulu");
          }
          else if(data == 99){
            toastr.error("Pastikan File Bertipe Gambar");
          }
          else {
            toastr.error("Gagal Upload Foto Absen Kehadiran");
          }
        }
      });
      return false;
    });

</script>
