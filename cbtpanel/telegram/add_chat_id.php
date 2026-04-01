<div class='row'>
  <div class='col-md-6'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'> Tambah ID Telegram Guru</h3>
        <div class='box-tools pull-right '>
          <button class='btn btn-sm btn-flat btn-primary' data-toggle='modal' data-backdrop='static' data-target='#infobot'><i class='glyphicon glyphicon-info-sign'></i> <span class='hidden-xs'>Informasi Baca Dulu</span></button>
        </div>
      </div>
      <div class='box-body'>
        <div class="col-md-12">
          <form id="formid" class="form-horizontal">
              <div class="form-group">
                <label class="control-label " >Nama Guru</label><br>
                  <select id="idguru" name="idguru" class="form-control select2" required>
                    <option value="">Pilih Guru</option>
                    <?php $db2 = $db->getGuru(); 
                    foreach ($db2 as $value) { ?>
                      <option value="<?= $value['id_pengawas']; ?>"><?= $value['nama']; ?></option>
                    <?php } ?>
                  </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="pwd">ID Telegram Guru</label>
                  <input type="text" class="form-control" id="chatid" name="chatid" placeholder="ID Telegram Guru">
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class='col-md-6'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'> Data ID Telegram Guru </h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <div class="table-responsive">
          <table class="table table-bordered" id="tbtabel">
            <thead>
              <tr>
                <th>Nama Guru</th>
                <th>Id Telegram Guru </th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $db2 = $db->getTelegramBotGuru(); 
                foreach ($db2 as $gt) { ?>
                <tr>
                  <td><?= $gt['nama']?></td>
                  <td><?= $gt['tlChatId']?></td>
                  <td><button 
                    data-id="<?= $gt['tlId']?>"
                    data-token="<?= $gt['tlChatId']?>"
                    type="button" class="btn btn-info btn-xs tgedit" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></button>
                    <button  data-id="<?= $gt['tlId']?>" class="btn btn-danger btn-xs hapus"><i class="fa fa-trash"></i></button></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if($_SESSION['level']=='admin'){ ?>
<div class="row">
 <div class='col-md-6'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'> Token Bot Telegram</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <div class="row">
          <div class="col-md-12">
            <?php $db2 = $db->getTokenBot(); 
            foreach ($db2 as $value) { ?>
                <div class="form-group">
                  <label >Token Bot Telegram </label>
                  <div >
                    <input type="text" value="<?= $value['botToken'] ?>" class="form-control" id="token_bot" name="token_bot" placeholder="Token Bot Telegram">
                  </div>
                  <span style="font-size: 12px;"><i>Silahkan Masukan Token Bot Telegram, Seteleah Membuat Bot Telegramnya</i></span>
                  <label style="padding-top: 20px;">ID Grub Telegram Absensi Sekolah </label>
                  <div >
                    <input type="text" value="<?= $value['botChatId'] ?>" class="form-control" id="idgrup" name="idgrup" placeholder="Id Grub Telegram Absensi">
                  </div>
                  <span style="font-size: 12px;"><i>Silahkan Masukan ID Grub Telegram Untuk Absensi Sekolah</i></span>
                  <div style="padding-top: 10px;">
                    <button class="btn btn-primary" id="tokenbot"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="row" style="padding-bottom: 10px">
              <div class="col-sm-10">
                <label>Send Absen Mapel Siswa Ke Telegram </label>
                <div>
                 <select data-id="mapel" class="form-control select2 teleaktif">
                   <option <?php selected1($value['botSendAbsenMapel']); ?> value="1">Aktif</option>
                   <option <?php selected0($value['botSendAbsenMapel']); ?> value="0">Tidak Aktif</option>
                 </select>
                </div>
              </div>
            </div>
            <div class="row" style="padding-bottom: 10px">
              <div class="col-sm-10">
                <label>Send Tugas Siswa Ke Telegram</label>
                <div>
                 <select data-id="tugas" class="form-control select2 teleaktif">
                   <option <?php selected1($value['botSendTugas']); ?> value="1">Aktif</option>
                   <option <?php selected0($value['botSendTugas']); ?> value="0">Tidak Aktif</option>
                 </select>
                </div>
              </div>
            </div>
            <div class="row" style="padding-bottom: 10px">
              <div class="col-sm-10">
                <label>Send Absen Sekolah Siswa Ke Telegram</label>
                <div>
                 <select data-id="sekolah" class="form-control select2 teleaktif">
                   <option <?php selected1($value['botSendAbsenSekolah']); ?> value="1">Aktif</option>
                   <option <?php selected0($value['botSendAbsenSekolah']); ?> value="0">Tidak Aktif</option>
                 </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php }?>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Token Chat Id Telegram Grub</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal"> 
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Chat ID </label>
            <div class="col-sm-10">
              <input type="hidden" name="id2" id="id2">
              <input type="text" class="form-control" id="chatid2" name="chatid2" placeholder="Chat ID / Token Grub Telegram">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" id="tgupdate" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div class='modal fade bd-example-modal' id='infobot' style='display: none;' tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog " style="width: 1200px;">
    <div class='modal-content'>
      <div class='modal-header bg-primary'>
        <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
        <h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Infromasi Bot Telegram</h4>
      </div>

      <div class='modal-body'>
        <p>
          <div class="row">
            <div class="col-md-12">
                <legend style="font-weight: bold;">Fungsi Bot Telegram</legend>
                <b>ID Telegram Guru</b> adalah ID telegram Guru yang nanti akan di gunakan untuk mengirim informasi monitor siswa, seperti absensi ke Telegram Guru bersangkutan secara automatis
                <hr>
                <?php if($_SESSION['level']=='admin'){ ?>
                  <b>Token Bot Telegram</b> adalah Token yand di dapat pada saat membuat Bot Telegram di <i>BotFather</i> (Milik Telegram), Token Bot Telegram adalah key atau ID dari bot yang kita buat
                <hr>
                <b>ID Grub Telegram Absensi Sekolah</b> adalah ID Grub Telegram yang di gunakan untuk Kirim Aktifitas atau monitor Absensi Sekolah Siswa
                <?php }?>
            </div>
          </div>

        </p>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#tbtabel').dataTable();
  $('.tgedit').click(function(){
    var id = $(this).data('id');
    var token = $(this).data('token');
    $('#chatid2').val(token);
    $('#id2').val(id);
  });
   $('#tgupdate').click(function(){
    var id2 = $('#id2').val();
    var token2 = $('#chatid2').val();
       $.ajax({
          type: 'POST',
          url: 'c_aksi.php?telegram=updatechatid',
          data:{id:id2,chatid:token2},
          success: function(data) {
            console.log(data);
            if (data == 1) {
              toastr.success("Update Berhasil");
              setTimeout(function () { location.reload(1); }, 1000);
            } 
            else {
              $('.loader').hide();
              toastr.error("Update Gagal");
            }
          }
        });
   });

   $('.teleaktif').change(function(){ //aktif non aktif send telegram
      var id = $(this).data('id');
      var val = $(this).val();
      $.ajax({
            type: 'POST',
            url: 'c_aksi.php?telegram=aktifsend',
            data:{id:id,aksi:val},
            success: function(data) {
              console.log(data);
              if (data == 1) {
                toastr.success("Berhasil Di Ubah");
                setTimeout(function () { location.reload(1); }, 1000);
              } 
              else {
                $('.loader').hide();
                toastr.error("Gagal Di Ubah");
              }
            }
          });
   });

   $('.hapus').click(function(){ //hapus id telegram guru
    var id = $(this).data('id');
    var cek = confirm('Apakah Yakin Akan Menghapus Data Ini ?');
      if(cek){
         $.ajax({
            type: 'POST',
            url: 'c_aksi.php?telegram=hapustelegram',
            data:{id:id},
            success: function(data) {
              console.log(data);
              if (data == 1) {
                toastr.success("Hapus Berhasil");
                setTimeout(function () { location.reload(1); }, 1000);
              } 
              else {
                $('.loader').hide();
                toastr.error("Hapus Gagal");
              }
            }
          });
      }
   });
  $('#formid').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: 'c_aksi.php?telegram=addchatid',
          enctype: 'multipart/form-data',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
            if (data == 1) {
            //$('.loader').hide();
              toastr.success("Berhasil Tambah ID Grub");
              setTimeout(function () { location.reload(1); }, 1000);
            } 
            else if(data == 99){
              $('.loader').hide();
              toastr.warning("ID Grub Anda Sudah Ada");
            }
            else {
              $('.loader').hide();
              toastr.error("Gagal ID Grub");
            }
            
           
          }

        });
        return false;
  });
  
  $('#tokenbot').click(function(){
    var token = $('#token_bot').val();
    var idgrup = $('#idgrup').val();

    $.ajax({
          type: 'POST',
          url: 'c_aksi.php?telegram=addbottelegram',
          data:{id_grub:idgrup,bot_token:token},
          success: function(data) {
            console.log(data);
            if (data == 1) {
            //$('.loader').hide();
              toastr.success("Token Berhasil");
              setTimeout(function () { location.reload(1); }, 1000);
            } 
            else {
              $('.loader').hide();
              toastr.error("Gagal Token");
            }


          }
    });
    return false;
  });
</script>