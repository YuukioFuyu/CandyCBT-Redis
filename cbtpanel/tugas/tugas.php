<?php if ($ac == '') {  $id_guru = $_SESSION['id_pengawas']; ?>
  <div class='row'>
    <div class='col-md-12'>
      <div class='box box-solid'>
        <div class='box-header with-border '>
          <h3 class='box-title'> Daftar Tugas Terstruktur</h3>
          <div class='box-tools pull-right '>

          </div>
        </div><!-- /.box-header -->
        <div class='box-body'>
          <!-- Button trigger modal -->
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
                    <input type="hidden" class="form-control" name="id_mapel" value="<?= $id_mapel ?>">
                    <div class="form-group">
                      <input type="text" class="form-control" name="mapel" aria-describedby="helpId" placeholder="Mata Pelajaran" required>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="judul" aria-describedby="helpId" placeholder="Judul Tugas" required>
                    </div>
                    <div class="form-group">
                      <!-- <textarea name='isitugas' class='editor1' rows='10' cols='80' style='width:100%;'></textarea> -->
                      <textarea id="summernote" name='isitugas'></textarea>
                    </div>
                    <div class='form-group'>
                      <div class='row'>
                        <div class='col-md-2'>
                          <label>Pilih Level</label><br>
                          <select id="idlevel" name="idlevel" class="form-control select2" style="width: 100px" required>
                            <option>Pilih Level</option>
                            <?php $db2 = $db->v_level(); 
                            foreach ($db2 as $value) { ?>
                              <option value="<?= $value['kode_level']; ?>"><?= $value['kode_level']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class='col-md-4'>
                          <label>Pilih Kelas</label><br>
                          <select id="kelas1" name='kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                            
                          </select>
                        </div>
                        <div class='col-md-3'>
                          <label>Tanggal Mulai</label>
                          <input type='text' name='tgl_mulai' class='tgl form-control' autocomplete='off' required='true' />
                        </div>
                        <div class='col-md-3'>
                          <label>Tanggal Selesai</label>
                          <input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="file">File Pendukung</label>
                      <input type="file" class="form-control-file" name="file" placeholder="" aria-describedby="fileHelpId"><br>
                      Format file ( doc/docx/xls/xlsx/ppt/pdf )<br>
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
                $lev = mysqli_query($koneksi, "SELECT * FROM pengawas "); 
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
            <table id="tabeltugas" class='table table-bordered table-striped  table-hover'>
              <thead>
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
                  <th width='200px'></th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(empty($_GET['guru'])){

                }
                else{
                  $kelas = $_GET['kelas'];
                if ($pengawas['level'] == 'guru') {
                  $tugasQ = mysqli_query($koneksi, "SELECT * FROM tugas where id_guru='$_SESSION[id_pengawas]'");
                } else {
                  $tugasQ = mysqli_query($koneksi, "SELECT * FROM tugas  where id_guru='$_GET[guru]' ");
                }
                foreach ($tugasQ as $value) {
                $datakelas = unserialize($value['kelas']);
                if (in_array($kelas, $datakelas)){
                  $data2[] = $value;
                  } 
                }
                ?>
                <?php foreach ($data2 as $tugas) {  ?>
                  <?php
                  $guru = mysqli_fetch_array(mysqli_query($koneksi, "select * from pengawas where id_pengawas='$tugas[id_guru]'"));
                  $no++
                  ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td>
                      <?= $tugas['mapel'] ?>
                    </td>
                    <td>
                      <?= $guru['nama'] ?>
                    </td>
                    <td>
                      <?= $tugas['judul'] ?>
                    </td>

                    <td style="text-align:center">
                      <?= $tugas['tgl_mulai'] ?>
                    </td>
                    <td style="text-align:center">
                      <?= $tugas['tgl_selesai'] ?>
                    </td>
                    <td style="text-align:center">
                      <?php $kelas = unserialize($tugas['kelas']);
                      foreach ($kelas as $kelas) {
                        echo $kelas . " ";
                      }
                      ?>
                    </td>
                    <td>

                      <?php if ($tugas['file']==null) { }else{  ?>
                        <a href="<?= $homeurl?>/<?= $linkguru ?>/tugas/<?= $tugas['id_guru']; ?>/<?= $tugas['file'] ?>" target="_blank">Lihat File</a>
                      <?php } ?>
                    </td>
                    <td>
                      <?php 
                      if($tugas['status'] ==1){ echo'<span class="label label-success">AKTIF</span>'; }
                      else{ echo'<span class="label label-danger">TIDAK AKTIF</span>';}
                      ?>
                    </td>
                    <td style="text-align:center">
                      <div class=''>
                        <a href='?pg=tugas_pb&kelas=<?= $_GET['kelas'] ?>&ac=jawaban&id=<?= $tugas['id_tugas'] ?>' class='btn btn-sm btn-success '><i class='fas fa-eye'></i> Lihat</a>
                        <!-- Button trigger modal -->
                        <a href="?pg=tugas_pb&ac=edit&id=<?= $tugas['id_tugas'] ?>" type="button" class="btn btn-primary btn-sm" >
                        <i class="fas fa-edit    "></i>
                      </a>

                        <button data-id='<?= $tugas['id_tugas'] ?>' class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt    "></i></button>
                      </div>
                    </td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                </tbody>
              </table>
         </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
    </div>
<?php } 
elseif($ac=='edit'){ ?>
  <div class='row'>
    <div class='col-md-12'>
      <div class='box box-solid'>
        <div class='box-header with-border '>
          <button onclick="window.history.back();" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali </button>&nbsp;&nbsp;
          <h3 class='box-title'> Edit Tugas Siswa</h3>
          <!-- <a href="<?= $homeurl ?>/<?= $crew ?>/?pg=tugas_pb" type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-arrow-left"></i> Kembali</a> -->
          
          <div class='box-tools pull-right '>
          </div>
        </div><!-- /.box-header -->
        <div class='box-body' id="tablejawaban">
        <?php 
        $id_guru = $_SESSION['id_pengawas'];
        if(empty($_GET['id'])){ $id=null; }else{ $id=$_GET['id']; } 
        $db2 = $db->edit_tugas($id);
        foreach ($db2 as $tugas) {
        ?>
        <form id="formedittugas">
          <div class="modal-body">
            <input type="hidden" value="<?= $tugas['id_tugas'] ?>" name='id'>
            <div class="form-group">

              <input type="text" class="form-control" name="mapel" aria-describedby="helpId" placeholder="Mata Pelajaran" value="<?= $tugas['mapel'] ?>" required>

            </div>
            <div class="form-group">

              <input type="text" class="form-control" name="judul" aria-describedby="helpId" placeholder="Judul Tugas" value="<?= $tugas['judul'] ?>" required>

            </div>
            <div class="form-group">
              <textarea id="summernote_edit" name='isitugas'><?= $tugas['tugas'] ?></textarea>
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
                  <div class='col-md-4'>
                    <label>Tanggal Mulai</label>
                    <input type='text' name='tgl_mulai' class='tgl form-control' autocomplete='off' required='true' value="<?= $tugas['tgl_mulai'] ?>" />
                  </div>
                  <div class='col-md-4'>
                    <label>Tanggal Selesai</label>
                    <input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' value="<?= $tugas['tgl_selesai'] ?>" />
                  </div>

                </div>
              </div>
              <div class="form-group">
                <div class='row'>
                  <div class='col-md-4'>
                   <label for="file">Status Tugas</label><br>
                   <?php if($tugas['status']==1){ $select="selected";}else{ $select2="selected"; } ?>
                   <select class="form-control" name="status_tugas">
                    <option value="1" <?= $select; ?> >AKTIF</option>
                    <option value="0" <?= $select2; ?>>TIDAK AKTIF</option>
                  </select>
                </div>
                <div class='col-md-4' style="padding-bottom: 10px;">
                  <label for="file">File Pendukung</label>
                  <input type="file" class="form-control-file" name="file" id="file" placeholder="" aria-describedby="fileHelpId">
                  <small id="fileHelpId" class="form-text text-muted">format file (doc/docx/xls/xlsx/ppt/pdf)</small>
                </div>
                <div class='col-md-4'>
                  <label for="file">Nama File Pendukung</label><br>
                  <?php if($tugas['file'] == ""){ echo "Kosong";}else{  ?>
                    <b><a href="../<?= $linkguru ?>/tugas/<?= $id_guru; ?>/<?= $tugas['file'] ?>" target="_blank"><?= $tugas['file'] ?></a></b>
                  <?php } ?>
                </div>
                

              </div>
              <div class="form-group">
                <div class="row">
                  <div class='col-md-4'>
                    <label for="file">Nama Guru</label><br>
                    <select name='idguru' class='form-control select2' style='width:100%' required='true'>
                      <?php foreach ($db->getGuru() as $guru) { ?>
                        <option value="<?= $guru['id_pengawas']; ?>" <?php selectAktif($tugas['id_guru'],$guru['id_pengawas']) ?>> <?= $guru['nama']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="<?= $homeurl ?>/<?= $crew ?>/?pg=tugas_pb" type="button" class="btn btn-default" data-dismiss="modal">Kembali</a>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
        <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <script>
    $('#formedittugas').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      $.ajax({
        type: 'POST',
        url: 'tugas/edit_tugas.php',
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

          if (data == "ok") {
            toastr.success("tugas berhasil dirubah");
          } else {
            toastr.error(data);
          }
          $('#modaledit<?= $tugas['id_tugas'] ?>').modal('hide');
          setTimeout(function() {
            location.reload();
          }, 1000);

        }
      });
      return false;
    });
  </script>
<?php }
elseif ($ac == 'jawaban') { ?>
    <div class='row'>
      <div class='col-md-12'>
        <div class='box box-solid'>
          <div class='box-header with-border '>
            <h3 class='box-title'> Daftar Jawaban Siswa</h3>
             <button id="btn_tambah3" class="btn btn-default " onclick="window.history.back();">
              <i class="fas fa-arrow-left"></i> Kembali
            </button>
            <div class='box-tools pull-right '>
              <button class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult'].print()"><i class='fa fa-print'></i> Print</button>
              <a href="report_excel_tugas.php?id=<?= $_GET[id]; ?>" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Download Nilai Excel</a>
            </div>
          </div><!-- /.box-header -->
          <br>
          <div class="row" style="padding-left: 10px;">
            <div class="col-md-12">
              <span>Input Nilai Manual di gunakan untuk Input Nilai secara manual oleh guru yang memberikan tugas</span><br>
              <a href='?pg=tugas_pb&kelas=<?= $_GET['kelas'] ?>&ac=inputmanual&id=<?= $_GET['id'] ?>' class='btn btn-sm btn-primary '><i class='fas fa-edit'></i> Input Nilai Manual</a>
            </div>
          </div>
          <div class='box-body' id="tablejawaban">

            <table class="table" id="tabeltugas2">
              <thead>
                <tr>
                  <th>USERNAME</th>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>File</th>
                  <th>Nilai</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $id = $_GET['id'];
                $kelas = $_GET['kelas'];
                $id_guru = $_SESSION['id_pengawas'];
                $jawabx = mysqli_query($koneksi, "SELECT * FROM siswa
                  INNER JOIN jawaban_tugas ON siswa.id_siswa=jawaban_tugas.id_siswa
                  WHERE siswa.id_kelas='$kelas' AND id_tugas=$id ");
                $no = 1; 
                while ($jawab = mysqli_fetch_array($jawabx)) {
                   $noo = $no++;
                 
                  ?>
                  <tr>
                    <td scope="row"><?= $jawab['username'] ?></td>
                    <td><?= $jawab['nama'] ?></td>
                    <td><?= $jawab['id_kelas'] ?></td>
                    <td>
                      <?php if ($jawab['file'] <> null) { 
                        $datafile = unserialize($jawab['file']);
                        $nojawaban=1;
                        foreach ($datafile as $data) {
                      ?>
                        <a  href="../guru/tugas_siswa/<?= $jawab['id_guru']; ?>/<?= $jawab['id_tugas'] ?>/<?= $data ?>" target="_blank" download>Lihat File Ke <?=  $nojawaban++; ?> &nbsp;</a>
                      <?php } } ?>
                    </td>
                    <td><?= $jawab['nilai'] ?></td>

                    <td>
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalnilai<?= $noo ?>">
                        <i class="fas fa-edit    "></i> Input Nilai
                      </button>
                      <button data-id='<?= $jawab['id_jawaban'] ?>' class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt    "></i></button>
                      <!-- Modal -->
                      <div class="modal fade" id="modalnilai<?= $noo ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <form id="formnilaitugas<?= $jawab['id_jawaban'] ?>">
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <input type="hidden" class="form-control" name="id" value="<?= $jawab['id_jawaban'] ?>">
                                    <div class="form-group">
                                    <label for="nilai">Input Nilai</label><br>
                                    <input type="number" class="form-control" name="nilai<?= $jawab['id_jawaban'] ?>" aria-describedby="helpId" placeholder="">
                                    <small id="helpId" class="form-text text-muted">masukan nilai</small>
                                    </div>
                                  </div>
                                </div>

                                <div class="row" style="padding-top: 20px;">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="">Jawaban Siswa</label><br>
                                      <p><?= $jawab['jawaban'] ?></p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <script>
                        $("#formnilaitugas<?= $jawab['id_jawaban'] ?>").submit(function(e) {
                          e.preventDefault();
                          var id = '<?= $jawab['id_jawaban'] ?>';
                          $.ajax({
                            type: "POST",
                            url: "tugas/simpan_nilai.php",
                            data: $(this).serialize(),
                            success: function(result) {
                              toastr.success(result);
                              $('#modalnilai<?= $no ?>').modal('hide');
                              setTimeout(function() {
                                location.reload();
                              }, 1000);


                            }
                          });
                        });
                      </script>

                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

<iframe id='loadframe' name='frameresult' src="cetak_tugas.php?id=<?= $_GET['id']; ?>&idguru=<?= $_SESSION['id_pengawas']?>" style='border:none;width:1px;height:1px;'></iframe>
<?php } elseif($ac =='inputmanual'){ ?>
        <div class='row'>
      <div class='col-md-12'>
        <div class='box box-solid'>
          <div class='box-header with-border '>
            <h3 class='box-title'> Input Nilai Manual</h3>
             <button id="btn_tambah3" class="btn btn-default " onclick="window.history.back();">
              <i class="fas fa-arrow-left"></i> Kembali
            </button>
          </div><!-- /.box-header -->
         <?php
         $kelas = $_GET['kelas'];
         $no=1;
         $idtugas =$_GET['id'];
         $id_guru = $_SESSION['id_pengawas'];
         
         $siswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$kelas' ");
         ?>
         <form action="" method="post" id="form_nilai_tugas_manual">
          <div class='box-body' id="tablejawaban">
            <button name="save_esai" class="btn btn-primary" id="s_nilai_tugasl_manual">Simpan Nilai Tugas</button>
            <br><br>
            <table class="table table-bordered" id="tabeltugas3">
              <thead>
                <tr>
                  <th>No</th>
                  <th>User Name</th>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Nilai</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($siswa as $data) { ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['username']; ?></td>
                    <td><?= $data['nama']; ?></td>
                    <td><?= $data['id_kelas']; ?></td>
                    <td>
                      <input type="hidden" name="idguru[]" value="<?= $id_guru; ?>">
                      <input type="hidden" name="idtugas[]" value="<?= $idtugas; ?>">
                      <input type="hidden" name="idsiswa[]" value="<?= $data['id_siswa']; ?>">
                      <input type="text" name="nilai[]" class="form-control">
                    </td>
                  </tr>
                <?php $noo++; } ?>
              </tbody>
            </table>
          </div>

         </form>
        </div>
      </div>
    </div>
<?php } ?>


<script type="text/javascript">
  $(document).on('click', '#s_nilai_tugasl_manual', function(c) {
    c.preventDefault();
    
    var data_nilai_tugas = new FormData($('#form_nilai_tugas_manual')[0]);
    $.ajax({
      type : 'POST',
      url : 'c_aksi.php?nilai_tugas=manual_save', 
      data:data_nilai_tugas,
      processData : false,
      contentType : false,
      beforeSend: function() {
        $('.loader').css('display', 'block');
      }, 
      success : function(response){
        console.log(response);
        if(response==1){
          $('.loader').css('display', 'none');
          toastr.success("Nilai Tugas Berhasil Di Tambah");
              setTimeout(function() {
                location.reload();
              }, 1000);
        }
        else{
          $('.loader').css('display', 'none');
          toastr.error("Opss Gagal");
        }
       
      }
    });

  });
$(document).ready(function() {
  //Agar Video Summoner editor responsif
        jQuery('.note-video-clip').each(function(){
            var tmp = jQuery(this).wrap('<p/>').parent().html();
            jQuery(this).parent().html('<div class="embed-responsive embed-responsive-16by9">'+tmp+'</div>');
          });
   var tabel = $('#tabeltugas').dataTable();
   var tabel2 = $('#tabeltugas2').dataTable();
   var tabel2 = $('#tabeltugas3').dataTable({
    "pageLength": 50,
   });
  
    $('#carimateri').click(function() {
      var idkelas = $('#pilihkelas').val();
      var guru = $('#pilihguru').val();
      location.replace("?pg=tugas_pb&kelas="+idkelas+"&guru="+guru);
    });


    $(document).on('click', '#btn_tambah', function() {
      $('#form_materi').slideDown(1000);
      $('#form_materi').removeAttr("style");
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
   $('#idlevel').change(function() {
    var idlevel = $('#idlevel').val();
    $("#kelas1").empty();
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
    $('#formtugas').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: 'tugas/buat_tugas.php',
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
            $('#modaltugas').modal('hide');
            if (data = 'ok') {
              toastr.success("Tugas berhasil disimpan");
              setTimeout(function() {
                location.reload();
              }, 1000);
            } else {
              toastr.error("tugas gagal dibuat");
            }
          }
        });
        return false;
      });
    $('#tabletugas').on('click', '.hapus', function() {
      var id = $(this).data('id');
      console.log(id);
      swal({
        title: 'Apa anda yakin?',
        text: "akan menghapus tugas ini!",

        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: 'tugas/hapus_tugas.php',
            method: "POST",
            data: 'id=' + id,
            beforeSend: function() {
                $("#pesanku").text("Sedang Proses ...!");
                $('.loader').show();
              },
            success: function(data) {
              $('.loader').hide();
              toastr.success('tugas berhasil dihapus');
              setTimeout(function() {
                location.reload();
              }, 1000);
            }
          });
        }
      })
    });
    $('#tablejawaban').on('click', '.hapus', function() {
      var id = $(this).data('id');
      console.log(id);
      swal({
        title: 'Apa anda yakin?',
        text: "akan menghapus nilai ini!",

        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: 'tugas/hapus_nilai.php',
            method: "POST",
            data: 'id=' + id,
            beforeSend: function() {
                $("#pesanku").text("Sedang Proses ...!");
                $('.loader').show();
              },
            success: function(data) {
              toastr.success('tugas berhasil dihapus');
              $("#tablejawaban").load(window.location + " #tablejawaban");
            }
          });
        }
      })
    });
});
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