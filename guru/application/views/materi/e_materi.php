
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'> Daftar Materi Pembelajaran</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>

      <div class='box-body'>
        <a id="btn_tambah2" type="button" class="btn btn-default mb-5" href="materi">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        <div id="form_materi" class="row">
          <div class="col-md-12">
            <?php foreach ($e_materi as $data) { ?>
            <form id="formtugas">
              <div class="modal-body">
                <input type="hidden" class="form-control" name="id_mapel" value="<?= $data->materi2_id ?>">
                <div class="form-group">
                  <label>Nama Mapel</label><br>
                  <?= $data->materi2_mapel ?>
                </div>
                <div class="form-group">
                  <label>Judul Materi</label>
                  <input type="text" class="form-control" name="judul_materi" aria-describedby="helpId" placeholder="Judul Materi" required value="<?= $data->materi2_judul ?>" >
                </div>
                <div class="form-group">
                  <textarea id="summernote" name='isimateri'><?= $data->materi2_isi ?></textarea>
                </div>
                <div class="form-group" style="padding-top:10px;" >
                  <div class="row">
                    <div class="col-md-6">
                     <label>Link Yotube Yang Ingin Di Bagikan</label>
                     <input type="text" class="form-control" name="youtube" aria-describedby="helpId" placeholder="ulr_yotube" value="<?= $data->url_youtube ?>">
                   </div>
                   <div class="col-md-6">
                     <label>Link Yotube ID</label><br>
                     <input type="text" class="form-control" name="idyoutube" placeholder="Yotube ID" value="<?= $data->url_embed ?>">
                   </div>
                 </div>
               </div>
               <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label>Link Google Drive Yang Ingin Di Bagikan</label><br>
                    <input type="text" class="form-control" name="gdrive" aria-describedby="helpId" placeholder="Url Google Drive" value="<?= $data->url_gdrive ?>">
                  </div>
                </div>
              </div>
              <div class='form-group'>
                <div class='row'>
                  <div class='col-md-12'>
                    <label>Pilih Kelas</label><br>
                    <div class="row">
                      <div class="col-md-12">
                        <select name='k_kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                          <option value='semua'>Semua</option>
                          <?php foreach ($v_kelas as $value) : ?>
                            <?php if (in_array($value->id_kelas, unserialize($data->kelas))){ ?>
                              <option value="<?= $value->id_kelas ?>" selected><?= $value->nama ?></option>
                            <?php }else{ ?>
                            <option value="<?= $value->id_kelas ?>"><?= $value->nama ?></option>
                            <?php }?>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                  <label for="file">File Pendukung</label>
                  <input type="file" class="form-control-file" name="file_materi" placeholder="" aria-describedby="fileHelpId"><br>
                  Format file ( doc/docx/xls/xlsx/pdf )<br>
                  Format gambar ( jpg/png )<br>
                  </div>
                  <div class="col-md-6">
                   <label for="file">File Pendukung</label><br>
                   <?php if(empty($data->materi2_file)){ echo"<b>Kosong, Tidak ada File</b>"; }else{ echo $data->materi2_file; } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <a href="materi" type="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
          <?php } ?>
        </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- /.row -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#formtugas').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url('admin/up_materi') ?>',
          enctype: 'multipart/form-data',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
            if (data == 'add') {
              toastr.success("Materi berhasil Update");
              setTimeout(function(){
               window.location.reload(1);
              }, 1000);
            }
            else if(data == 'no_add'){
              toastr.error("Materi gagal Update");
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
  });
</script>