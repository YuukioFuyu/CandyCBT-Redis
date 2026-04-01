
<div class='row'>
  <div class='col-md-12'>
    <div id="info">
    <?php $this->load->view('thema/pesan_data.php'); ?>
    </div>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'>Daftar Absen Mapel</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <div class="form-group">
          <a id="btn_tambah" type="button" class="btn btn-primary mb-5" style="">
            <i class="fas fa-plus-circle "></i> Buat Absensi Mapel
          </a>
          <a id="btn_tambah2" type="button" class="btn btn-default mb-5" style="display: none;" >
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
        <div id="form_materi" class="row" style="display: none;">
          <div class="col-md-12">
            <form id="formtugas">
              <div class="modal-body">
                <div class='form-group'>
                    <div class="form-group">
                    <label>Pilih Level Kelas</label>
                    <div class="row">
                      <div class="col-md-3">
                        <select class="form-control select2 level" id="level" name="level">
                          <option value=""> Pilih Kelas</option>
                          <?php foreach ($v_level as $value) : ?>
                            <option value="<?= $value->kode_level ?>"><?= $value->kode_level ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                  <label>Pilih Mata Pelajaran</label><br>
                    <select id="idmapel" name="mapel" class="form-control select2" style="width: 300px" required>
                    </select>
                  </div>
                  <div class='form-group'>
                    <label>Pilih Kelas</label><br>
                    <div class="form-group">
                       <select id="idkelas" name="idkelas" class="form-control select2" style="width: 300px" required>
                    </select>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label>Hari Jadwal Mapel</label>
                    <div class="form-group">
                      <select id="hari" name="hari" class="form-control select2" style="width: 300px" required>
                        <option>Pilih Nama Hari</option>
                        <option value="Monday">Senin</option>
                        <option value="Tuesday">Selasa</option>
                        <option value="Wednesday">Rabu</option>
                        <option value="Thursday">Kamis</option>
                        <option value="Friday">Jumat</option>
                        <option value="Saturday">Sabtu</option>
                        <option value="Sunday">Minggu</option>
                      </select>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label>Jam Mulai</label>
                       <input type='text' name='jamin' style="width: 300px" class='timer form-control' autocomplete='off' required='true' />
                  </div>
                  <div class='form-group'>
                    <label>Jam Akhir</label>
                       <input type='text' name='jamout' style="width: 300px" class='timer form-control' autocomplete='off' required='true' />
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
        <div  class='table-responsive' id='tabletugas2' style="">
          <table id='tabletugas' class='table table-bordered table-hover'>
            <thead class="title_bar_table">
              <tr>
                <th width='5px'>#</th>
                <th >Mata Pelajaran</th>
                <th >Kelas</th>
                <th style="text-align: center;">Hari</th>
                <th style="text-align: center;">Jam Mulai</th>
                <th style="text-align: center;">Jam Akhri</th>
                <th width='200px' style="text-align: center;">Aksi</th>
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
                $no=1; foreach ($absen_mapel as $vl) { ?>
               <tr>
                 <td align="center"><?= $no++;?></td>
                 <td><?= $vl->nama_mapel ?></td>
                 <td><?= $vl->id_kelas ?></td>
                 <td align="center"><?= $daftar_hari[$vl->amHari] ?></td>
                 <td align="center"><?= $vl->amJamMulai ?></td>
                 <td align="center"><?= $vl->amJamAkhir ?></td>
                 <td>
                  <button 
                  data-hari="<?= $vl->amHari ?>"
                  data-jamin="<?= $vl->amJamMulai ?>"
                  data-jamout="<?= $vl->amJamAkhir ?>"
                  data-toggle="modal" data-target="#myModal" data-id='<?= $vl->amId ?>' class="btn btn-info editabsmapel"><i class="fa fa-edit"></i></button>
                  <button data-id='<?= $vl->amId ?>' class="btn btn-danger hapusabsmapel"><i class="fa fa-trash"></i></button>
                </td>
               </tr>
             <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Absen Mapel</h4>
      </div>
      <div class="modal-body">
        <form id="formtugas2">
          
            <div class='form-group'>
              <input id="id" type='hidden' name='id' class='form-control' required='true' />
              <label>Jam Mulai</label>
              <input id="jamin2" type='text' name='jamin2' style="width: 300px" class='timer form-control' autocomplete='off' required='true' />
          </div>
          <div class='form-group'>
            <label>Jam Akhir</label>
            <input id="jamout2" type='text' name='jamout2' style="width: 300px" class='timer form-control' autocomplete='off' required='true' />
          </div>
          <div class="form-group">
            <select id="hari2" name="hari2" class="form-control select2" style="width: 300px" required>
              <option>Pilih Nama Hari</option>
              <option value="Monday">Senin</option>
              <option value="Tuesday">Selasa</option>
              <option value="Wednesday">Rabu</option>
              <option value="Thursday">Kamis</option>
              <option value="Friday">Jumat</option>
              <option value="Saturday">Sabtu</option>
              <option value="Sunday">Minggu</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          
        </form>
      </div>
    </div>  
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('.editabsmapel').click(function() {
      var id = $(this).data('id');
      var jamin = $(this).data('jamin');
      var jamout = $(this).data('jamout');
      var hari = $(this).data('hari');
      $('#id').val(id);
      $('#jamin2').val(jamin);
      $('#jamout2').val(jamout);
      $('#hari2').val(hari).change();
    });
    $('.hapusabsmapel').click(function() {
      var id = $(this).data('id');
      if (confirm("Yakin Akan Di Hapus Ini Absen Mapel ? Semau Absens Siswa dengan Mapel Ini Akan Terhapus Juga")) {
      $.ajax({
          type: 'POST',
          url: '<?php echo base_url('absen/delet_absen_mapel') ?>',
          data: {id:id},
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Hapus Absen Mapel');
              setTimeout(function () { location.reload(1); }, 2000);
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
      }
    });

    $('#tabletugas').DataTable({
      "lengthMenu": [[50, -1], [50, "All"]]
     });
    $(document).on('click', '#btn_tambah', function() {
      $('#form_materi').slideDown(1000);
      $('#form_materi').removeAttr("style");
      $("#tabletugas2").css("display","none");
      $("#btn_tambah").css("display","none");
      $('#btn_tambah2').removeAttr("style");
    });
   $(document).on('click', '#btn_tambah2', function() {
      $('#form_materi').css("display","none");
      $("#tabletugas2").removeAttr("style");
      $("#btn_tambah2").css("display","none");
      $('#btn_tambah').removeAttr("style");
    });
    $('#table_materi').DataTable({
        pageLength: 25,
      });
     $('.level').change(function() {
        var idlevel = $(this).val();
        $("#idmapel").empty();
        $("#idkelas").empty();
        $.ajax({
          url: "<?php echo base_url('admin/json_mapel'); ?>",
          data:{id:idlevel},
          type: 'post',
          dataType: "json",
          success: function(data){
            var dataMapel = [];
            $.each(data, function(index, objek){
             var option = '<option value="'+objek.idmapel+'">'+objek.nama_mapel+'</option>';
             dataMapel.push(option);
           });
            $('#idmapel').append('<option value="">Pilih Mapel</option>'+dataMapel);
          }
        });
        $.ajax({
          url: "<?php echo base_url('admin/json_kelas'); ?>",
          data:{id:idlevel},
          type: 'post',
          dataType: "json",
          success: function(data){
            var dataMapel = [];
            $.each(data, function(index, objek){
             var option = '<option value="'+objek.idkls+'">'+objek.nama+'</option>';
             dataMapel.push(option);
           });
            $('#idkelas').append('<option value="">Pilih Kelas</option>'+dataMapel);
          }
        });
      });
    <?php //simpan materi ?>
    $('#formtugas').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var pesan ="absensi_mapel";
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url('absen/insert_absen_mapel') ?>',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Tambah Absen Mapel');
              setTimeout(function () { location.reload(1); }, 2000);
            }
            else if(respon==99){
              toastr.warning('Absen Mapel Dengna Kelas ini Sudah ada');
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
        return false;
      });

    $('#formtugas2').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var pesan ="absensi_mapel";
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url('absen/update_absen_mapel') ?>',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Update Absen Mapel');
              setTimeout(function () { location.reload(1); }, 2000);
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
        return false;
    });


  } );
</script>


