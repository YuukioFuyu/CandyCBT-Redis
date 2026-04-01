<?php
if(empty($_GET['tahun'])){
  $akti1 = 'class="active"';
  $akti2 = 'in active';
}
else{
  $akti3 = 'class="active"';
  $akti4 = 'in active';
}
$token_bot = fetch($koneksi, "bot_telegram");
?>

<div class='row'>
  <div class="col-md-12"> 
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit"></i>Absen Kehadiran</h3>
      </div>
      <div class='box-body'>
      <ul class="nav nav-tabs">
        <li <?= $akti1 ?>><a data-toggle="tab" href="#home"><i class="fa fa-plus"></i> Menu Absen Kehadiran</a></li>
        <li <?= $akti3 ?>><a data-toggle="tab" href="#menu1"><i class="fa fa-check"></i> Lihat Absensi Kehadiran</a></li>
      </ul>
      <div class="tab-content">
        <div id="home" class="tab-pane fade <?= $akti2 ?>">
          <?php 
             $jamsekolah2 = $dbb->getJamSekolah();
             $jam_masuk = strtotime($jamsekolah2['jamIn']); 
             $jam_pulang = strtotime($jamsekolah2['jamOut']); 
             $jamsekarang = strtotime(date("H:i:s"));
             $jam_malam = strtotime(date("00:59:00"));

             // AND $jamsekarang <> $jam_masuk

             if($jamsekarang >= $jam_masuk ){
              
             ?>
            <div class="row">
              <div class="col-md-12"> 
              <div class="form-group">
                  <label for="email">Tanggal Absen Hari Ini</label>
                  <input data-idkelas="<?= $kelasdb['idkls']?>" data-idsiswa="<?= $siswa['id_siswa']?>" id="tgl" type="text" readonly="readonly" value="<?php  echo date("d-m-Y") ?>" class="form-control" id="tgl">
                </div>
                <button id="absen" class="btn btn-primary"><i class="fa fa-check"></i> Klik Untuk Absen Kehadiran</button>
              </div>
            </div>
           <br>
           <?php if($setting['izi_foto_absen']==1){ ?>
           <div class="row">
              <div class="col-md-12"> 
                <div class="alert alert-info">
                  Pastikan Sudah Klik Absen Kehadiran Terlebih Dahulu, Baru Upload Foto Kehadiran<strong>Infromasi </strong> Foto Menggunakan Seragam Sekolah Seperti Biasanya
                </div>
               <form id='formjawaban'>    
                  <div class="form-group">
                    <label for="">Upload Foto Absensi <br>(Pastikan Fotonya dengan Hp Landscape atau Harizontal atau Miring)</label><br>
                    <input type="file" class="form-control-file" name="file" aria-describedby="fileHelpId">
                    <small id="fileHelpId" class="form-text text-muted">Klik Pilih File Untuk Upload Foto</small>
                  </div>
                   <!-- <button class="btn btn-info"><i class="fa fa-upload"></i> Klik Untuk Upload Foto Absen</button> -->
               <button class="btn btn-info"><i class="fa fa-upload"></i> Klik Untuk Upload Foto Absen</button>
                </form>
              </div>
            </div>
            <hr>
           
            <!-- ------------------------------------------------------------------------- -->
         <?php } }
         
         else{ ?>
          <div class="row" style="padding-top: 10px;">
            <div class="col-md-12">
              <div class="alert alert-info">
                  Upss Belum Waktunya Absen <br>
                  
                </div>
            </div>
          </div>
         <?php }?>
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
            <div class="col-md-2" style="padding-bottom: 3px">
              <button id="cari_absen" class="btn btn-info"> Cari Data Absen</button>
            </div>

          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="tableabsen">
              <thead>
                  <tr>
                    <th>NO</th>
                    <?php if($setting['izi_foto_absen']==1){ ?><th>FOTO</th><?php } ?>
                    <th>NAMA SISWA</th>
                    <th>KELAS</th>
                    <th>TANGGAL</th>
                    <th>JAM MASUK</th>
                    <th>JAM PULANG</th>
                    <th>STATUS ABSEN</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $absen = $dbb->getAbsenDetail();
                  $no=1;
                  foreach ($absen as $abs ) { ?>
                  <tr>
                    <td><?= $no++;?></td>
                    <?php if($setting['izi_foto_absen']==1){ ?>
                      <td><a href="<?= $homeurl.'/'.$abs['absUrlFoto'] ?>" target="_blank"><img width="50" src="<?= $homeurl.'/'.$abs['absUrlFoto'] ?>" class="img-thumbnail img-responsive" alt="Foto Tidak Ada"></a></td>
                     <?php } ?>
                    <td><?= $abs['namasiswa'] ?></td>
                    <td><?= $abs['nama'] ?></td>
                    <td><?= date('d-m-Y',strtotime($abs['absTgl'])) ?></td>
                    <td><?= JamNull($abs['absJamIn']) ?></td>
                    <td><?= JamNull($abs['absJamOut']) ?></td>
                    <td><?= $abs['absStatus'] ?></td>
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
    var siswa = "<?= $_SESSION['id_siswa'] ?>";
    location.replace("?tahun="+tahun+"&bulan="+bulan+"&siswa="+siswa);
  });
  $(document).on('click', '#absen', function() {
    var tgl = $('#tgl').val();
    var siswa = $('#tgl').data('idsiswa');
    var kelas = $('#tgl').data('idkelas');
    $.ajax({
      type: 'POST',
      url: '../_absen.php',
      data: 'tgl='+tgl+'&idsiswa='+siswa+'&idkls='+kelas,
      success: function(response) {
        console.log(response);
        if(response ==1){
            toastr.success('Absensi Berhasil Hari Ini <br>'+tgl);
            <?php 
        if($token_bot['botActive']==1){
        $cekSend = $dbb->CekAktifSend();
          if($cekSend['botSendAbsenSekolah']==1){
            $pesan='---Absen Kehadiran Sekolah---';
            $date = date("d-m-Y");
            $jam = date("H:i:s");
            $status = 'Hadir';
            $message="<b><i>".$pesan."</i></b>\\n";
            $message.="<b>".$_SESSION['nama_sekolah']."</b>\\n";
            $message.="Nama : <b>".$_SESSION['full_nama']."</b>\\n";
            $message.="Kelas : <b>".$_SESSION['id_kelas']."</b>\\n";
            $message.="Status : <b>".$status."</b>\\n";
            $message.="Tgl : ".$date."\\n";
            $message.="Jam : ".$jam."\\n";
            $message.="<b>Domain : ".$_SERVER['SERVER_NAME']."</b>\\n";
            $message.="<b>LisensiDB : ".$setting['lisensiId']."</b>\\n";
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
                "chat_id": "<?= $token_bot['botChatId']; ?>",
                "text": "<?= $message ?>",
                "parse_mode":"HTML",
              })
            }
        
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
        beforeSend: function() {
        $("#pesanku").text("Sedang Di Proses !!!");
        $('.loader').show();
        },
        success: function(data) {
          console.log(data);
          if (data == 1) {
            //$('.loader').hide();
            toastr.success("Berhasil Upload Foto Absen Kehadiran");
            setTimeout(function () { location.reload(1); }, 2000);
          } 
          else if(data == 0){
            $('.loader').hide();
            toastr.warning("Klik Absen Kehadiran Terlebih Dahulu");
          }
          else if(data == 99){
            $('.loader').hide();
            toastr.error("Pastikan File Bertipe Gambar");
          }
          else {
            $('.loader').hide();
            toastr.error("Gagal Upload Foto Absen Kehadiran");
          }
           }
      });
      return false;
    });

</script>
