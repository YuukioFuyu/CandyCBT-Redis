<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'>Edit Tugas Pembelajaran</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <a id="btn_tambah2" type="button" class="btn btn-default mb-5" href="tugas">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        <div id="form_materi" class="row">
          <div class="col-md-12">
            <?php foreach ($e_tugas as $data) { ?>
            <form id="formtugas">
              <div class="modal-body">
                <div class="form-group">
                  <input type="hidden" class="form-control" name="id_aksi" value="2">
                  <input type="hidden" class="form-control" name="id_tugas" value="<?= $data->id_tugas ?>">
                  <input type="text" class="form-control" name="mapel" aria-describedby="helpId" placeholder="Mata Pelajaran" required value="<?= $data->mapel ?>">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="judul" aria-describedby="helpId" placeholder="Judul Tugas" required value="<?= $data->judul ?>">
                </div>
                <div class="form-group">
                  <textarea id="summernote" name='isitugas' ><?= $data->tugas ?></textarea>
                </div>
                <div class='form-group'>
                  <div class='row'>
                    <div class='col-md-4'>
                        <label>Pilih Kelas</label><br>
                       <select name='k_kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                          <option value='semua'>Semua</option>
                          <?php foreach ($v_kelas as $value) : ?>
                            <?php if (in_array($value->id_kelas, unserialize($data->kelas))){ ?>
                              <option value="<?= $value->id_kelas ?>" selected><?= $value->nama ?></option>
                            <?php } else{ ?>
                            <option value="<?= $value->id_kelas ?>"><?= $value->nama ?></option>
                            <?php }?>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    <div class='col-md-3'>
                      <label>Tanggal Mulai</label>
                      <input type='text' value="<?= $data->tgl_mulai ?>" name='tgl_mulai' class='tgl form-control' autocomplete='off' required='true' />
                    </div>
                    <div class='col-md-3'>
                      <label>Tanggal Selesai</label>
                      <input value="<?= $data->tgl_selesai ?>" type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' />
                    </div>
                    <div class='col-md-2'>
                      <label>Status Tugas</label>
                      <select class="form-control select2" name="status">
                        <option value="1" <?php if($data->status ==1){ echo"selected";} ?> >Aktif</option>
                        <option value="0" <?php if($data->status ==0){ echo"selected";} ?>>Tiak Aktif</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                  <div class="col-md-6">
                    <label for="file">File Pendukung</label>
                    <input type="file" class="form-control-file" name="file_tugas" placeholder="" aria-describedby="fileHelpId"><br>
                    Format file ( doc/docx/xls/xlsx/pdf )<br>
                    Format gambar ( jpg/png )<br>
                  </div>
                  <div class="col-md-6">
                   <label for="file">File Pendukung</label><br>
                   <?php if(empty($data->file)){ echo"<b>Kosong, Tidak ada File</b>"; }else{ echo $data->file; } ?>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <a href="tugas" class="btn btn-secondary" >Close</a>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
            </form>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#formtugas').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
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
            console.log(data);
            if (data == 'add') {
              toastr.success("Tugas berhasil Update");
              setTimeout(function(){
               window.location.reload(1);
              }, 1000);
            }
            else if(data == 'no_add'){
              toastr.error("Tugas gagal Update");
            } 
            else if(data == 0){
              toastr.error("Gagal Upload File");
            }
            else {
              toastr.error("Erro Printah");
            }
          }
        });
        return false;
      });
</script>