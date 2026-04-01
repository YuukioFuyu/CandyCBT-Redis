
<div class='row'>
  <div class='col-md-12'>
    <div id="info">
    <?php $this->load->view('thema/pesan_data.php'); ?>
    </div>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'>Daftar Tugas Pembelajaran</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <div class="form-group">
          <a id="btn_tambah" type="button" class="btn btn-primary mb-5" style="">
            <i class="fas fa-plus-circle "></i> Buat Tugas
          </a>
          <a id="btn_tambah2" type="button" class="btn btn-default mb-5" style="display: none;" >
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
        <div id="form_materi" class="row" style="display: none;">
          <div class="col-md-12">
            <form id="formtugas">
              <div class="modal-body">
                <div class="form-group">
                  <input type="hidden" class="form-control" name="id_aksi" value="1">
                  <input type="text" class="form-control" name="mapel" aria-describedby="helpId" placeholder="Mata Pelajaran" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="judul" aria-describedby="helpId" placeholder="Judul Tugas" required>
                </div>
                <div class="form-group">
                  <!-- <textarea name='isitugas' class='editor1' rows='10' cols='80' style='width:100%;'></textarea> -->
                  <textarea id="summernote" name='isitugas' ></textarea>
                </div>
                <div class='form-group'>
                  <div class='row'>
                    <div class='col-md-4'>
                        <label>Pilih Kelas</label><br>
                        <?php $this->load->view($kelas_kelompok);?>
                      </div>
                    <div class='col-md-3'>
                      <label>Tanggal Mulai</label>
                      <input type='text' name='tgl_mulai' class='tgl form-control' autocomplete='off' required='true' />
                    </div>
                    <div class='col-md-3'>
                      <label>Tanggal Selesai</label>
                      <input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' />
                    </div>
                    <div class='col-md-2'>
                      <label>Status Tugas</label>
                      <select class="form-control select2" name="status">
                        <option value="1">Aktif</option>
                        <option value="0">Tiak Aktif</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="file">File Pendukung</label>
                  <input type="file" class="form-control-file" name="file_tugas" placeholder="" aria-describedby="fileHelpId"><br>
                  Format file ( doc/docx/xls/xlsx/pdf )<br>
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
        <div  class='table-responsive' style="">
          <table id='tabletugas' class='table table-bordered table-hover'>
            <thead class="title_bar_table">
              <tr>
                <th width='5px'>#</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <th>Judul Tugas</th>
                <th>Tgl Mulai</th>
                <th>Tgl Selesai</th>
                <th>Kelas</th>
                <th>File</th>
                <th>Status</th>
                <th width='200px'>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($v_tugas as $value) { ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $value->mapel; ?></td>
                  <td><?= $value->nama; ?></td>
                  <td><?= $value->judul; ?></td>
                  <td><?= $value->tgl_mulai; ?></td>
                  <td><?= $value->tgl_selesai; ?></td>
                  <td align="center">
                    <?php $kelas=unserialize($value->kelas); 
                     foreach ($kelas as $kelas) {
                       echo $kelas . " | ";
                     }
                    ?>
                  </td>
                  <td>
                    <?php if(!empty($value->file)){ ?>
                      <a class="btn btn-info" target="_blank" href="<?php echo base_url().'tugas/'.$this->session->userdata('id_pengawas').'/'.$value->file  ?>"><i class="fas fa-download"></i></a>
                  <?php }?>
                  </td>
                  <td>
                    <?php if($value->status){
                      echo"<span class='label label-success'>AKTIF</span>";
                    }
                    else{
                      echo"<span class='label label-danger'>TIDAK AKTIF</span>";
                    } ?>
                      
                  </td>
                  <td>
                    <a href='v_nilai_tugas?pg=<?= encrypt_url('lihat') ?>&aksi=<?= encrypt_url($value->id_tugas) ?>' class='btn btn-sm btn-success '><i class='fas fa-eye'></i> Lihat</a>
                    <a href="e_tugas?pg=<?= encrypt_url('edit') ?>&aksi=<?= encrypt_url($value->id_tugas) ?>" type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                    <a onclick="return confirm('Apakah Kamu Yakin Akan Menghapus Tugas Ini ?');" href="h_tugas/<?= encrypt_url($value->id_tugas) ?>" class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>
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
  $(document).ready(function(){
    $('#tabletugas').DataTable({
      "lengthMenu": [[50, -1], [50, "All"]]
     });
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
    $('#table_materi').DataTable({
        pageLength: 25,
      });
    $('#summernote').summernote({
        codeviewFilter: false,
        codeviewIframeFilter: true,
        focus,
      });
  
    <?php //simpan materi ?>
    $('#formtugas').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var pesan ="Tugas";
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url('admin/t_tugas') ?>',
          enctype: 'multipart/form-data',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            //console.log(data);
            if (data == 'add') {
              toastr.success(pesan+" Berhasil Disimpan");
              setTimeout(function(){
               window.location.reload(1);
              }, 1000);
            } 
            else if(data == 0){
              toastr.error("Gagal Upload File");
            }
            else {
              toastr.error(pesan+" Gagal Dibuat");
            }
          }
        });
        return false;
      });


  } );
</script>

