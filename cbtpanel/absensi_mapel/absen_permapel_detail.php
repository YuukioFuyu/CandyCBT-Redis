
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'>Daftar Absen Mapel Detail </h3>
        <div class='box-tools pull-right '>
          <?php if(!empty($_GET['tahun'])){ ?>
             <a class='btn btn-sm btn-success' href='report_excel_absen_bulan.php?tahun=<?=$_GET['tahun']?>&bulan=<?=$_GET['bulan']?>&mapel=<?=$_GET['mapel']?>&kelas=<?=$_GET['kelas']?>'><i class='fa fa-download'></i> Download Excel Absen Bulan</a>
            <button onclick="frames['frameresult'].print()" target="_blank"  class="btn btn-sm btn-info"><i class="fa fa-download"></i> Print Absen Bulan</button>
          <button id="down_excel" class="btn btn-sm btn-warning"><i class="fa fa-download"></i> Download Excel Absen Detail</button>
          <?PHP } ?>
        </div>
      </div>
      <iframe id='loadframe' name='frameresult' src="cetak_absen_mapel_detail.php?tahun=<?=$_GET['tahun']?>&bulan=<?=$_GET['bulan']?>&mapel=<?=$_GET['mapel']?>&kelas=<?=$_GET['kelas']?>" style='border:none;width:1px;height:1px;'></iframe>
      <div class='box-body'>
        <div  class='table-responsive' id='tabletugas2' style="">
          <div class='form-group'>
            <div class="form-group">
              <div class="row">
                <div class="col-md-3">
                  <select class="form-control select2 level" id="mapel" name="mapel">
                    <option value=""> Pilih Jadwal Mapel</option>
                    <?php $db2 = $db->get_absen_mapel_by_id_manual(); 
                      foreach ($db2 as $value) { ?>
                      <option data-absenmapel="<?= $value[amIdMapel] ?>" data-level="<?= $value[id_level] ?>" 
                        <?= selectAktif($value['amId'],$_GET['mapel']) ?> value="<?= $value['amId']; ?>">
                        <?= $value['amSlag'].' '.hariIndo($value['amHari']); ?>
                        </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-2" style="padding-bottom: 3px">
                  <select id="kelas" class="form-control select2 kelas">
                    <option value="">Pilih Kelas</option>
                  </select>
                </div>
                <div class="col-md-2" style="padding-bottom: 3px">
                  <select id="tahun" class="form-control select2 ">
                    <?php $kelas = $db->getTahun(); ?>
                    <option value="all"> Pilih Tahun</option>
                    <?php foreach ($kelas as $value) : ?>
                      <option <?= selectAktif($value['thKode'],$_GET['tahun']) ?> value="<?= $value['thKode'] ?>"><?= $value['thKode'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-2" style="padding-bottom: 3px">
                  <select id="bulan" class="form-control select2 ">
                    <option value="all"> Pilih Bulan</option>
                    <?php for ($i=1; $i <=12 ; $i++) { ?>
                      <option <?= selectAktif($i,$_GET['bulan']) ?> value="<?= $i ?>"><?= bulanIndo($i) ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-2" style="padding-bottom: 3px">
                  <select id="tgl" class="form-control select2 ">
                    <option value="all"> Pilih Tanggal</option>
                    <?php for ($i=1; $i <=31 ; $i++) { ?>
                      <option <?= selectAktif($i,$_GET['tgl']) ?> value="<?= $i ?>"><?= $i ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2" style="padding-bottom: 3px">
                  <button id="cari_absen" class="btn btn-info"> Cari Data Absen</button>
                </div>
              </div>
            </div>
          </div>
          <table id='tableabsenmapel' class='table table-bordered table-hover'>
            <thead class="title_bar_table">
              <tr>
                <th width='5px'>#</th>
                <th >Aksi</th>
                <th >Nama Siswa</th>
                <th >Kelas</th>
                <th >Mata Pelajaran</th>
                <th style="text-align: center;">Tanggal</th>
                <th style="text-align: center;">Hari Mapel</th>
                <th style="text-align: center;">Tanggal</th>
                <th style="text-align: center;">Jam Absen</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Ktr</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($db->get_absen_siswa_mapel() as $vl) { ?>
                <tr>
                  <td><?= $no++;?></td>
                  <td><button data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info cariedit" data-id="<?= $vl['amaId']?>" data-nama="<?= $vl['nama']?>"><i class="fa fa-edit"></i> </button> </td>
                  <td><?= $vl['nama']?></td>
                  <td><?= $vl['id_kelas']?></td>
                  <td><?= $vl['amNamaMapel']?></td>
                  <td><?= $vl['amaTgl']?></td>
                  <td><?= HariIndo($vl['amHari'])?></td>
                  <td><?= buat_tanggal('d-m-Y',$vl['amaTgl']) ?></td>
                  
                  <td><?= $vl['amaJamIn']?></td>
                  <td><?= $vl['amaStatus']?></td>
                  <td><textarea class="form-control" rows="1" readonly="true" ><?= $vl['amaKeterangan']?></textarea></td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Kehadiran</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="sel1">Nama Siswa</label>
          <input type="hidden" name="idsiswa" id="idsiswa" class="form-control" value="">
          <input type="text" name="namasiswa" id="namasiswa" class="form-control" value="">
        </div>
        <div class="form-group">
          <input type="text" name="tgl2" id="tgl2" value="<?= date('d-m-Y H:i:s');?>" class="tgl form-control">
        </div>
        <div class="form-group">
          <label for="sel1">Pilih Status</label>
          <select class="form-control" id="status">
            <option value="H">HADIR</option>
            <option value="I">IZIN</option>
            <option value="S">SAKIT</option>
            <option value="T">TERLAMBAT</option>
            <!-- <option value="B">BOLOS</option> -->
            <option value="A">ALPHA</option>
          </select>
        </div>
        <div class="form-group">
          <textarea id="ktr" class="form-control" placeholder="Isi Keteragan Di Sini, Jika Ingin Di Beri Keterangan"></textarea>
        </div>
        <div class="form-group">
          <button class="btn btn-sm btn-success edit"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  </div>
<script type="text/javascript">
   
  $(document).ready(function(){
    $(document).on('click', '.cariedit', function() {
      var id= $(this).data("id");
      var nama= $(this).data("nama");
      $("#idsiswa").val(id);
      $("#namasiswa").val(nama);

    });
    $(document).on('click', '.edit', function() {
      var idsiswa= $("#idsiswa").val();
      var mapel= $("#mapel").find(':selected').data('idabs')
      var status= $("#status").val();
      var ktr= $("#ktr").val();
      var tgl= $("#tgl2").val();
      $.ajax({
        url: "<?php echo "c_aksi.php?absen_mapel_siswa=edit"; ?>",
        data:{idsiswa:idsiswa,status:status,ktr:ktr,tgl:tgl,idmapel:mapel},
        type: 'post',
        success: function(respon){
          if(respon==1){
              toastr.success('Berhasil Edit Absen');
              setTimeout(function () { location.reload(1); }, 1000);
            }
            else{
              toastr.error('Upss Gagal');
            }
        }
      });
   });

    <?php if(!empty($_GET['level'])): ?>
    var lv = "<?= $_GET[level]?>";
    var kelas = "<?= $_GET[kelas]?>";
    $("#kelas").empty();
    $.ajax({
        url: "<?php echo "c_aksi.php?kelas=getkelas"; ?>",
        data:{idlevel:lv},
        type: 'post',
        dataType: "json",
        success: function(data){
          var dataMapel = [];
          $.each(data, function(index, objek){
            if(objek.idkls == kelas){ var select="selected='selected'";  }else{ var select=""; }
           var option = '<option '+select+' value="'+objek.idkls+'">'+objek.nama+'</option>';
           dataMapel.push(option);
         });
          $('#kelas').append('<option value="">Pilih Kelas</option>'+dataMapel);
          console.log(data);
        }
      });
    <?php endif; ?>

    $(document).on('click', '#cari_absen', function() {
      var tahun = $('#tahun').val();
      var bulan = $('#bulan').val();
      var mapel = $('#mapel').val();
      var kelas = $('#kelas').val();
      var tgl = $('#tgl').val();
      var lv = $('#mapel').find(':selected').data('level');
      if(tahun=='' || mapel==''){
        alert('Silahkan Pilih Mapel. Tahun, Bulan Terlebih Dahulu');
      }
      else if(kelas==''){
        alert('Silahkan Pilih Kelas Terlebih Dahulu');
      }
      else{
      location.replace("?pg=absen_permapel_detail&tahun="+tahun+"&bulan="+bulan+"&mapel="+mapel+"&level="+lv+"&kelas="+kelas+"&tgl="+tgl);
      }
    });
    $('#mapel').change(function() {
      var lv = $(this).find(':selected').data('level');
      $("#kelas").empty();
      //get kelas json
      $.ajax({
        url: "<?php echo "c_aksi.php?kelas=getkelas"; ?>",
        data:{idlevel:lv},
        type: 'post',

        dataType: "json",
        success: function(data){
          var dataMapel = [];
          $.each(data, function(index, objek){
           var option = '<option value="'+objek.idkls+'">'+objek.nama+'</option>';
           dataMapel.push(option);
         });
          $('#kelas').append('<option value="">Pilih Kelas</option>'+dataMapel);
          //console.log(data);
        }
      });
    });
    $('.editabsmapel').click(function() {
      var id = $(this).data('id');
      var mapel = $(this).data('nama');
      var jamin = $(this).data('jamin');
      var jamout = $(this).data('jamout');
      var hari = $(this).data('hari');
      $('#id').val(id);
      $('#jamin2').val(jamin);
      $('#jamout2').val(jamout);
      $('#mapel').val(mapel);
      $('#hari2').val(hari).change();
    });
    $('.hapusabsmapel').click(function() {
      var id = $(this).data('id');
      if (confirm("Yakin Akan Di Hapus Ini Absen Mapel ? Semua Absen Siswa dengan Mapel Ini Akan Terhapus Juga")) {
      $.ajax({
          type: 'POST',
           url: 'c_aksi.php?absen_mapel=delet',
          data: {id:id},
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Hapus Absen Mapel');
              setTimeout(function () { location.reload(1); }, 1500);
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
      }
    });

    $('#tableabsenmapel').DataTable({
      "lengthMenu": [[10,20,30,50, -1], [10,20,30,50, "All"]]
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
          url: 'c_aksi.php?absen_mapel=getmapel',
          data:{idlevel:idlevel},
          type: 'post',
          dataType: "json",
          success: function(data){
            //console.log(data);
            var dataMapel = [];
            $.each(data, function(index, objek){
             var option = '<option value="'+objek.idmapel+'">'+objek.nama_mapel+'</option>';
             dataMapel.push(option);
           });
            $('#idmapel').append('<option value="">Pilih Mapel</option>'+dataMapel);
          }
        });
        $.ajax({
          url: 'c_aksi.php?absen_mapel=getkelas',
          data:{idlevel:idlevel},
          type: 'post',
          dataType: "json",
          success: function(data){
            //console.log(data);
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
          url: 'c_aksi.php?absen_mapel=insert',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Tambah Absen Mapel');
              setTimeout(function () { location.reload(1); }, 1000);
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
          url: 'c_aksi.php?absen_mapel=update',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Update Absen Mapel');
              setTimeout(function () { location.reload(1); }, 1000);
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
        return false;
    });
    $(document).on('click','#down_excel',function(){
    $("#tableabsenmapel").table2excel({
        filename: "data_absen_permapel_detail.xls",
        fileext: ".xls",
        //preserveColors: preserveColors,
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
       // preserveColors:true

      });
    });


  } );
</script>


