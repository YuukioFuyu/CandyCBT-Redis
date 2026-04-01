<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
if($_GET['pg']=='materi_pb' and $_GET['aksi']==''){ ?>
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'> Daftar Materi Pembelajaran</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <!-- Button trigger modal -->
        <div class="form-group">
          <a id="btn_tambah" type="button" class="btn btn-primary mb-5" style="" >
            <i class="fas fa-plus-circle "></i> Tambah Materi
          </a>
          <a id="btn_tambah2" type="button" class="btn btn-default mb-5" style="display: none;" >
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
          <button class="btn btn-success" data-toggle="modal" data-target="#myModal" ><i class="fa fa-info"></i> Panduan Youtube dan Goole Drive</button>
          <!-- Modal -->
          <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Cara Membagikan Link Materi</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <b><h3>Link Youtube Yang Ingin Di Bagikan</h3></b><br>
                      1. Buka Yotube yang ingin di bagikan<br> 
                      2. Copy URL nya atau alamat yotubenya<br>
                      Contoh URLnya &nbsp;<i style="color: blue;"><a href="https://www.youtube.com/channel/UCkyRvjQoOXKtnfobSmiFjQw" target="_blank">https://www.youtube.com/channel/UCkyRvjQoOXKtnfobSmiFjQw</a></i>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <b><h3>Link Google Drive Yang Ingin Di Bagikan</h3></b><br>
                      1. Buka Google Drive<br>
                      2. Kemudian Pilih (File atau Folder juga bisa) yang ingin di bagikan<br> 
                      3. Klik icon titik 3 atau untuk ke menu bagikan <br>
                      4. Kemudian Pilih bagikan (nanti akan tampul url atau alamat)<br>
                      5. Copy URL atau alamatnya di sini (kolom materi tambah link google drive ) <br>
                      Contoh URLnya &nbsp;<i style="color: blue;"><a href="https://drive.google.com/drive/folders/1vko1d3gSdpbXScU4VHRBPBE0U8dMT_3o?usp=sharing" target="_blank">https://drive.google.com/drive/folders/1vko1d3gSdpbXScU4VHRBPBE0U8dMT_3o?usp=sharing</a></i>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <b><h3>Link Yotube ID</h3></b><br>
                      1. Buka Yotube yang ingin di bagikan<br> 
                      2. Copy URL nya atau alamat yotubenya<br>
                      Contoh URLnya &nbsp;<i style="color: blue;">
                        <br>1. <a>https://www.youtube.com/watch?v=<b style="color: red;">UljftxURIfY</b></a> &nbsp;atau
                        <br>2. <a>www.youtube.com/watch?v=<b style="color: red;">UljftxURIfY</b></a><br></i>
                        Nah dari link di atas yang kita ambil atau yang kita copy <br>
                        adalah yang <b style="color: red;">warna merah</b>
                      
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div id="form_materi" class="row" style="display: none;">
          <div class="col-md-12">
            <form id="formtugas">
                <div class="modal-body">
                  <div class="form-group">
                    <select id="idlevel" name="idlevel" class="form-control select2" style="width: 200px" required>
                      <option>Pilih Level Kelas</option>
                      <?php $db2 = $db->v_level(); 
                      foreach ($db2 as $value) { ?>
                        <option value="<?= $value['kode_level']; ?>"><?= $value['kode_level']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <select id="idmapel" name="mapel" class="form-control select2" style="width: 300px">
                    </select>
                  </div>
                  <input type="hidden" class="form-control" name="id_mapel" value="<?= $id_mapel ?>">
                  <div class="form-group">
                    <input type="text" class="form-control" name="judul_materi" aria-describedby="helpId" placeholder="Judul Materi" required>
                  </div>
                  <div class="form-group">
                    <textarea id="summernote" name='isimateri'></textarea>
                  </div>
                  <div class="form-group" style="padding-top:10px;" >
                    <div class="row">
                      <div class="col-md-6">
                         <label>Link Yotube Yang Ingin Di Bagikan</label>
                      <input type="text" class="form-control" name="youtube" aria-describedby="helpId" placeholder="ulr_yotube">
                      </div>
                      <div class="col-md-6">
                         <label>Link Yotube ID</label><br>
                        <input type="text" class="form-control" name="idyoutube" placeholder="Yotube ID">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                      <label>Link Google Drive Yang Ingin Di Bagikan</label><br>
                        <input type="text" class="form-control" name="gdrive" aria-describedby="helpId" placeholder="Url Google Drive">
                      </div>
                    </div>
                  </div>
                  <div class='form-group'>
                    <div class='row'>
                      <div class='col-md-4'>
                        <label>Pilih Kelas</label><br>
                        <select id="kelas1" name='kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                        </select>
                      </div>
                      <div class='col-md-3'>
                          <label>Tanggal Materi Rilis/Tampilkan </label>
                          <input required type='text' name='tgl_rilis' class='tgl form-control' autocomplete='off' required='true' />
                      </div>
                      <div class="col-md-5">
                        <label>Nama Guru</label><br>
                        <select name='idguru' class='form-control select2' style='width:100%' required='true'>
                          <?php foreach ($db->getGuru() as $guru) { ?>
                            <option value="<?= $guru['id_pengawas']; ?>"> <?= $guru['nama']?></option>
                          <?php } ?>
                        </select>
                       </div>
                    </div>
                  </div>

                  <div class="form-group" >
                    <label for="file">File Pendukung</label>
                    <input type="file" class="form-control-file" name="file_materi" placeholder="" aria-describedby="fileHelpId"><br>
                    Format file ( doc/docx/xls/xlsx/ppt/pptx/pdf )<br>
                    Format gambar ( jpg/png )<br>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
          </div>
        </div>
       
        <div id='tabletugas' class='table-responsive' style="">
           <div class="row" style="padding-bottom: 10px;">
          <div class="col-md-2">
            <select name='kelas' id="pilihkelas" class='form-control select2' style='width:100%' >
              <option value='null'>Pilih Kelas</option>
              <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
              <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                <option <?= selectAktif($kelas['id_kelas'],$_GET['kelas']) ?> value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
              <?php endwhile ?>
            </select>
          </div>
          <div class="col-md-2">
            <select name='guru' id="pilihguru" class='form-control select2' style='width:100%' >
              <option value='null'>Pilih Guru</option>
              <?php 
              if ($pengawas['level'] == 'guru') { 
                $lev = mysqli_query($koneksi, "SELECT * FROM pengawas where id_pengawas='$_SESSION[id_pengawas]'"); 
              }
              else{
                $lev = mysqli_query($koneksi, "SELECT * FROM pengawas where level='guru'"); 
              }
              
              ?>
              <?php while ($data = mysqli_fetch_array($lev)) : ?>
                <option <?= selectAktif($data['id_pengawas'],$_GET['guru']) ?> value="<?= $data['id_pengawas'] ?>"><?= $data['nama'] ?></option>"
              <?php endwhile ?>
            </select>
          </div>
         
          <div class="col-md-2">
          <a id="carimateri" type="button" class="btn btn-primary mb-5" style="" >
            <i class="fa fa-search"></i> Cari Materi
          </a>
          </div>
        </div>
          <table id="table_materi" class='table table-bordered table-striped  table-hover'>
            <thead>
              <tr>
                <th width='5px'>#</th>
                <th >Aksi</th>
                <th width='200px'>Mata Pelajaran</th>
                <th >Guru</th>
                <th width='500px'>Judul Materi</th>
                <th>Kelas</th>
                <th>File</th>
                <th>Link Google Drive</th>
                <th>Video</th>
                <th>Video Embed</th>
                <th width='50px'>Tgl Terbit</th>
               
              </tr>
            </thead>
            <tbody>
              <?php
              if(empty($_GET['guru'])){

              }
              else{
                $kelas = $_GET['kelas'];
              if ($pengawas['level'] == 'guru') {
                $tugasQ = mysqli_query($koneksi, "SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel  INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas where id_guru='$_SESSION[id_pengawas]' ORDER BY materi2_tgl ");
              } else {
                $tugasQ = mysqli_query($koneksi, "SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel  INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas where id_guru='$_GET[guru]' ORDER BY materi2_tgl");
              }
              foreach ($tugasQ as $value) {
                $datakelas = unserialize($value['kelas']);
                if (in_array($kelas, $datakelas)){
                  $data2[] = $value;
                } 
              }
              //while ($tugas = mysqli_fetch_array($data3)){
              ?>
              <?php foreach ($data2 as $tugas) {  ?>
                <?php
                $no++
                ?>
                <tr>
                  <td><?= $no ?></td>
                  <td style="text-align:center">
                    <div class=''>
                      <a title="Jumlah Viwer Materi" href='<?= $homeurl ?>/<?= $crew ?>/?pg=materi_pb&aksi=viewer&id=<?= $tugas['materi2_id'] ?>' class='btn btn-sm btn-success '><i class='fas fa-heartbeat'></i> </a>
                      <a title="Edit Materi" href="<?= $homeurl ?>/<?= $crew ?>/?pg=materi_pb&aksi=edit&id=<?= $tugas['materi2_id'] ?>" type="button" class="btn btn-primary btn-sm" >
                        <i class="fas fa-edit    "></i>
                      </a>
                      <button title="Hapus Materi" data-id='<?= $tugas['materi2_id'] ?>' class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    </div>
                  </td>
                  <td>
                    <?= $tugas['nama_mapel'] ?>
                  </td>
                  <td>
                    <?= $tugas['nama'] ?>
                  </td>
                  <td>
                    <?= $tugas['materi2_judul'] ?>
                  </td>

                  <td style="text-align:center">
                    <?php $kelas = unserialize($tugas['kelas']);
                    foreach ($kelas as $kelas) {
                      echo $kelas . " | ";
                    }
                    ?>
                  </td>
                  <td>
                    <?php if ($tugas['materi2_file'] <> '') { ?>
                      <a href="<?= $homeurl?>/<?= $linkguru ?>/berkas2/<?= $tugas['id_guru'] ?>/<?= $tugas['materi2_file'] ?>" target="_blank">Lihat</a> || 
                      <a href="<?= $homeurl?>/<?= $linkguru ?>/berkas2/<?= $tugas['id_guru'] ?>/<?= $tugas['materi2_file'] ?>" download >Download</a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($tugas['url_gdrive'] != '') { ?>
                    <a href="<?= $tugas['url_gdrive'] ?>" target="_blank"> Link Goole Drive</a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($tugas['url_youtube'] != '') { ?>
                    <a href="<?= $tugas['url_youtube'] ?>" target="_blank"> Link Yotube</a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($tugas['url_embed'] != '') { ?>
                    <a href="https://www.youtube.com/watch?v=<?= $tugas['url_embed'] ?>" target="_blank">Tersedia</a>
                    <?php } ?>
                  </td>
                  <td>
                    <?= 
                    $tugas['materi2_tgl_rilis'] ?>
                  </td>
                  
                </tr>
                <?php } ?>
              </tbody>
              <?php } ?>
            </table>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
<?php
}
//edit Materi -----------------------------------------------------------------------
elseif($_GET['pg']=='materi_pb' and $_GET['aksi']=='edit'){ ?>
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
       <!--  <a href="<?= $homeurl ?>/<?= $crew ?>/?pg=materi_pb" type="button" class="btn btn-default" ><i class="fas fa-arrow-left"></i> Kembali</a> -->
       <button onclick="window.history.back();" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali </button>&nbsp;&nbsp;
        <h3 class='box-title'> Edit Materi Pembelajaran</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <div id="<?= $tugas['materi2_id'] ?>" class="row">
      <div class="col-md-12">
        <?php if(empty($_GET['id'])){ $id=null; }else{ $id=$_GET['id']; } 
        $db2 = $db->edit_materi2($id);
        foreach ($db2 as $tugas) {
        ?>
        <form id="formedittugas">
          <div class="modal-body">
            <input type="hidden" value="<?= $tugas['materi2_id'] ?>" name='id'>
            <div class="form-group">
              <label>Nama Mapel</label><br>
              <?= $tugas['nama_mapel'] ?>
            </div>
            <div class="form-group">
              <label>Judul Materi</label>
              <input type="text" class="form-control" name="judul_materi" aria-describedby="helpId" placeholder="Judul Tugas" value="<?= $tugas['materi2_judul'] ?>" required>
            </div>
            <div class="form-group">
              <label>Isi Materi</label>
              <textarea id="summernote_edit" name='isimateri'><?= $tugas['materi2_isi'] ?></textarea>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                 <label>Link Yotube Yang Ingin Di Bagikan</label>
                  <input type="text" class="form-control" name="youtube" placeholder="ulr_yotube" value="<?= $tugas['url_youtube'] ?>">
               </div>
               <div class="col-md-3">
                <label>Link Yotube ID</label><br>
                <input type="text" class="form-control" name="idyoutube" placeholder="Yotube ID" value="<?= $tugas['url_embed'] ?>">
                </div>
                 <div class="col-md-3">
                  <label>Nama Guru</label><br>
                  <select name='idguru' class='form-control select2' style='width:100%' required='true'>
                    <?php foreach ($db->getGuru() as $guru) { ?>
                      <option value="<?= $guru['id_pengawas']; ?>" <?php selectAktif($tugas['id_guru'],$guru['id_pengawas']) ?>> <?= $guru['nama']?></option>
                    <?php } ?>
                  </select>
                 </div>
            </div>
           </div>
           <div class="form-group">
            <div class="row">
              <div class="col-md-9">
               <label>Link Google Drive Yang Ingin Di Bagikan</label><br>
               <input type="text" class="form-control" name="gdrive" placeholder="Url Google Drive" value="<?= $tugas['url_gdrive'] ?>">
             </div>
             <div class='col-md-3'>
              <label>Tanggal Materi Rilis/Tampilkan </label>
              <input type='text' name='tgl_rilis' class='tgl form-control' autocomplete='off' required='true' value="<?= $tugas['materi2_tgl_rilis'] ?>" />
            </div>
            </div>
            </div>
            <div class='form-group'>
              <div class='row'>
                <div class='col-md-4'>
                  <label>Pilih Kelas</label><br>
                  <select name='kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                    <option value='semua'>Semua</option>
                    <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas where id_level='$tugas[kode_level]'"); ?>
                    <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                      <?php if (in_array($kelas['id_kelas'], unserialize($tugas['kelas']))) : ?>
                        <option value="<?= $kelas['id_kelas'] ?>" selected><?= $kelas['id_kelas'] ?></option>"
                        <?php else : ?>
                          <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
                        <?php endif; ?>
                      <?php endwhile ?>
                    </select>
                  </div> 
                  <div class="col-md-4">
                    <label for="file">File Pendukung</label>
                    <input type="file" class="form-control-file" name="file_materi" id="file_materi" placeholder="" aria-describedby="fileHelpId" value="">
                    Format file ( doc/docx/xls/xlsx/ppt/pdf )<br>
                    Format gambar ( jpg/png )<br>
                  </div>
                  <div class="col-md-4">
                    <label for="file">Nama File Pendukung</label><br>
                    <?php if($tugas['materi2_file'] == ""){ echo "Kosong";}else{  ?>
                      <b><a href="../<?= $linkguru ?>/berkas2/<?= $tugas['id_guru'] ?>/<?= $tugas['materi2_file'] ?>" download ><?= $tugas['materi2_file'] ?></a></b>
                    <?php } ?>
                  </div>

                </div>
              </div>

            </div>
            <div class="modal-footer">
              <a href="<?= $homeurl ?>/<?= $crew ?>/?pg=materi_pb" type="button" class="btn btn-default" data-dismiss="modal">Kembali</a>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
        <script type="text/javascript">
          $('#formedittugas').submit(function(e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
              type: 'POST',
              url: 'materi/edit_materi.php',
              enctype: 'multipart/form-data',
              data: data,
              cache: false,
              contentType: false,
              processData: false,
              beforeSend: function() {
                $("#pesanku").text("Sedang Proses ...!");
                $('.loader').show();
              },
              success: function(data) {
                if (data == "ok") {
                  toastr.success("Materi berhasil dirubah");
                } else {
                  toastr.error(data);
                }
                setTimeout(function() {
                  location.reload();
                }, 1000);

              }
            });
            return false;
          });
        </script>
        <?php } ?>
      </div>
    </div>
      </div>
    </div>
  </div>
</div>
<?php }
//Viwer Materi -----------------------------------------------------------------------
elseif($_GET['aksi']=='viewer'){ 
$idMateri=$_GET['id'];
$jumlah = $db->hitungViewMateri2($idMateri); 
?>
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
       <!--  <a href="<?= $homeurl ?>/<?= $crew ?>/?pg=materi_pb" type="button" class="btn btn-default" ><i class="fas fa-arrow-left"></i> Kembali</a> -->
       <button onclick="window.history.back();" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali </button>&nbsp;&nbsp;
        <h3 class='box-title'> Viwer Materi Pembelajaran</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <div class="row">
          <div class="col-md-4">
            <legend>Total Viewer : <b><?= $jumlah['jumlah'] ?></b></legend>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table id="table_materi" class='table table-bordered table-striped  table-hover'>
              <thead>
                <tr>
                  <th width='5px'>#</th>
                  <th width='5px'>NAMA PESERTA</th>
                  <th width='5px'>JUDUL MATERI</th>
                  <th width='5px'>YANG DI LIHAT</th>
                  <th width='5px'>HARI</th>
                  <th width='5px'>TGL</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; foreach ($db->listViewMateri2($idMateri) as $datas): 
                $datetime = date('d-m-Y H:i:s',strtotime($datas['mtrViewDate']));
                if($datas['mtrViewJenis']==1){ $jenis="<span class='badge bg-blue'>Materi</span>"; }
                else if($datas['mtrViewJenis']==2){ $jenis="<span class='badge bg-green'>Unduhan</span>"; }
                else if($datas['mtrViewJenis']==3){ $jenis="<span class='badge bg-yellow'>Video </span>"; }
                else{ }
                $namahari = date('l', strtotime($datas['mtrViewDate']));
                ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $datas['nama']?></td>
                  <td><?= $datas['materi2_judul']?></td>
                  <td><?= $jenis ?></td>
                  <td><?= HariIndo($namahari) ?></td>
                  <td><?= $datetime ?></td>
                </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php }else{

}
?>
  <script type="text/javascript">
   $(document).on('click', '#btn_tambah', function() {
      $('#form_materi').slideDown(1000);
      $('#form_materi').removeAttr("style")
      $("#tabletugas").css("display","none");
      $("#btn_tambah").css("display","none");
      $('#btn_tambah2').removeAttr("style");
    });
   $(document).on('click', '#btn_tambah2', function() {
      $('#form_materi').css("display","none");
      $("#tabletugas").removeAttr("style");
      $("#btn_tambah2").css("display","none");
      $('#btn_tambah').removeAttr("style");
    });
  
   $(document).ready(function() {
    //Agar Video Summoner editor responsif
        jQuery('.note-video-clip').each(function(){
            var tmp = jQuery(this).wrap('<p/>').parent().html();
            jQuery(this).parent().html('<div class="embed-responsive embed-responsive-16by9">'+tmp+'</div>');
          });
    $('#carimateri').click(function() {
      var idkelas = $('#pilihkelas').val();
      var guru = $('#pilihguru').val();
      location.replace("?pg=materi_pb&kelas="+idkelas+"&guru="+guru);
    });
    //Tampil mapel dan kelas ketika level di pilih
    $('#idlevel').change(function() { 
      var idlevel = $('#idlevel').val();
      $("#idmapel").empty();
       $("#kelas1").empty();
      $.ajax({
        url: "<?php echo "c_aksi.php?materi=cari_mapel"; ?>",
        data:{id:idlevel},
        type: 'post',

        dataType: "json",
        success: function(data){
          var dataMapel = [];
          $.each(data, function(index, objek){
           var option = '<option value="'+objek.kode_mapel+'">'+objek.nama_mapel+'</option>';
           dataMapel.push(option);
         });
          $('#idmapel').append('<option value="">Pilih Mapel</option>'+dataMapel);
        //console.log(data);
        }
      });
      //get kelas json
      $.ajax({
        url: "<?php echo "c_aksi.php?kelas=getkelas"; ?>",
        data:{idlevel:idlevel},
        type: 'post',

        dataType: "json",
        success: function(data){
          var dataMapel = [];
          $.each(data, function(index, objek){
           var option = '<option value="'+objek.id_kelas+'">'+objek.nama+'</option>';
           dataMapel.push(option);
         });
          $('#kelas1').append('<option value="">Pilih Kelas</option>'+dataMapel);
        //console.log(data);
        }
      });
    });

    $('#table_materi').DataTable({
        pageLength: 10,
      });

      $('#summernote').summernote({
        codeviewFilter: false,
        codeviewIframeFilter: true,
        focus,
      });
      $('#summernote_edit').summernote({
        codeviewFilter: false,
        codeviewIframeFilter: true,
        focus,
      });
    });

    $('#formtugas').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: 'materi/tambah_materi.php',
          enctype: 'multipart/form-data',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
            $('#modaltugas').modal('hide');
            if (data ==1) {
              toastr.success("Materi berhasil disimpan");
              setTimeout(function() {
                location.reload();
              }, 1000);
            } else {
              toastr.error("Materi gagal dibuat");
            }
            //toastr.error(data);

           //alert(data);
          }

        });
        return false;
      });
    $('#tabletugas').on('click', '.hapus', function() {
      var id = $(this).data('id');
      console.log(id);
      swal({
        title: 'Apa anda yakin?',
        text: "akan menghapus Materi ini!",

        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: 'materi/hapus_materi2.php',
            method: "POST",
            data: 'id=' + id,
            success: function(data) {
              console.log(data);
              toastr.success('Materi berhasil dihapus');
              setTimeout(function () { location.reload(1); }, 1000);
            }
          });
        }
      })

    });
    // $('#tablejawaban').on('click', '.hapus', function() {
    //   var id = $(this).data('id');
    //   console.log(id);
    //   swal({
    //     title: 'Apa anda yakin?',
    //     text: "akan menghapus nilai ini!",

    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Yes!'
    //   }).then((result) => {
    //     if (result.value) {
    //       $.ajax({
    //         url: 'tugas/hapus_nilai.php',
    //         method: "POST",
    //         data: 'id=' + id,
    //         success: function(data) {
    //           toastr.success('Materi berhasil dihapus');
    //           $("#tablejawaban").load(window.location + " #tablejawaban");
    //         }
    //       });
    //     }
    //   })

    // });
  </script>
  <script>
    tinymce.init({
      selector: '.editor1',
      plugins: [
      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      'insertdatetime media nonbreaking save table contextmenu directionality',
      'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
      ],

      toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link image paste ',
      fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
      paste_data_images: true,

      images_upload_handler: function(blobInfo, success, failure) {
        success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
      },
      image_class_list: [{
        title: 'Responsive',
        value: 'img-responsive'
      }],
      setup: function(editor) {
        editor.on('change', function() {
          tinymce.triggerSave();
        });
      }
    });
  </script>