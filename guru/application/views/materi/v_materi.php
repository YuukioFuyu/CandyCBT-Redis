
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
          <a id="btn_tambah" type="button" class="btn btn-primary mb-5" style="margin-bottom: 5px;">
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
                    <?php $this->load->view($level_select);?>
                  </div>
                  <div class="form-group">
                    <select id="idmapel" name="mapel" class="form-control select2" style="width: 300px" required>
                    </select>
                  </div>
                  <!-- <input type="hidden" class="form-control" name="id_mapel" value="<?= $id_mapel ?>"> -->
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
                      <div class='col-md-12'>
                        <label>Pilih Kelas</label><br>
                        <?php $this->load->view($kelas_kelompok);?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="file">File Pendukung</label>
                    <input type="file" class="form-control-file" name="file_materi" placeholder="" aria-describedby="fileHelpId"><br>
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

        <div id='tabletugas' class='table-responsive' style="">
          <table id="table_materi" class='table table-bordered table-hover'>
            <thead class="title_bar_table">
              <tr>
                <th width='5px'>#</th>
                <th width='100px'>Mata Pelajaran</th>
                <th >Guru</th>
                <th width='300px'>Judul Tugas</th>
                <th width='100px'>Kelas</th>
                <th>File</th>
                <th>Link Google Drive</th>
                <th>Video</th>
                <th>Video Embed</th>
                <th width='50px'>Tgl Terbit</th>
                <th ></th>
              </tr>
            </thead>
            <tbody>
             <?php $no=1; foreach ($v_materi as $value) { ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $value->nama_mapel ?></td>
                <td><?= $value->nama ?></td>
                <td><?= $value->materi2_judul ?></td>
                <td align="center">
                  <?php $kelas=unserialize($value->kelas); 
                   foreach ($kelas as $kelas) {
                     echo $kelas . " | ";
                   }
                  ?>
                </td>
                <td align="center">
                <?php if(!empty($value->materi2_file)){ ?>
                  <a class="btn btn-info" target="_blank" href="<?php echo base_url().'berkas2/'.$this->session->userdata('id_pengawas').'/'.$value->materi2_file  ?>"><i class="fas fa-download"></i></a>
                  <?php }?>
                </td>
                <td align="center">
                <?php if(!empty($value->url_youtube)){ ?>
                  <a class="btn btn-info" target="_blank" href="<?= $value->url_youtube  ?>"><i class="fas fa-download"></i></a>
                <?php }?>
                </td>
                <td align="center">
                  <?php if(!empty($value->url_gdrive)){ ?>
                  <a class="btn btn-info" target="_blank" href="<?= $value->url_gdrive ?>"><i class="fas fa-download"></i></a>
                <?php }?>
                </td>
                <td align="center">
                  <?php 
                  if(!empty($value->url_embed)){ echo'<i class="fas fa-check"></i>';}else{ echo''; }
                  ?>
                </td>
                <td><?= $value->materi2_tgl ?></td>
                <td align="center">
                  <a href="e_materi?pg=<?= encrypt_url('edit') ?>&aksi=<?= encrypt_url($value->materi2_id) ?>" type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                  <button data-id='<?= encrypt_url($value->materi2_id) ?>' class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                </td>
              </tr>
             <?php }?>
            </tbody>
            </table>

          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
<script type="text/javascript">
  $(document).ready(function(){
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
    $('#level').change(function() {
      var idlevel = $(this).val();
      $("#idmapel").empty();
      $.ajax({
        url: "<?php echo base_url('admin/json_mapel'); ?>",
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
        }
      });
    });
    <?php //simpan materi ?>
    $('#formtugas').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url('admin/t_materi') ?>',
          enctype: 'multipart/form-data',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
            if (data == 'add') {
              toastr.success("Materi berhasil disimpan");
              setTimeout(function(){
               window.location.reload(1);
              }, 1000);
            } 
            else if(data == 0){
              toastr.error("Gagal Upload File");
            }
            else {
              toastr.error("Materi gagal dibuat");
            }
          }
        });
        return false;
      });
    $('#table_materi').on('click', '.hapus', function() {
      var id = $(this).data('id');
      //console.log(id);
      swal({
        title: 'Apa Anda Yakin?',
        text: "Akan Menghapus Materi ini!",

        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: "<?php echo base_url('admin/h_materi'); ?>",
            method: "POST",
            data: 'id=' + id,
            success: function(data) {
              //console.log(data);
              if(data=="add"){
                toastr.success('Materi berhasil dihapus');
                $("#table_materi").load(window.location + " #table_materi");
              }
              else{
                toastr.error('Materi Gagal dihapus');
              }
            }
          });
        }
      });

    });

  } );
</script>

