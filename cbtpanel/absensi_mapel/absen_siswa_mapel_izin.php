
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'>Izin Absen Siswa Mapel</h3>
      </div>
      <div class='box-body'>
        <div class="row" >
          <div class="col-md-12">
            <div class="alert alert-info">
              <strong>Info !</strong> Pada Menu ini Guru bisa Memberikan Izin Absensi Mapel
            </div>
          </div>
        </div>
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
                  <input class='datepicker2 form-control' autocomplete=off id="tgl" type="text" value="<?php  echo date("d-m-Y") ?>" id="tgl">
                </div>
                <div class="col-md-2" style="padding-bottom: 3px">
                  <select id="keterangan" class="form-control">
                    <option value="">Pilih Keterangan</option>
                    <option value="A">Alpha</option>
                    <option value="I">Izin</option>
                    <option value="S">Sakit</option>
                    <option value="T">Terlambat</option>
                    <option value="B">Bolos</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10" >
              <textarea id="keterangan_status" class="form-control " placeholder="Keterangan Izin Ketikan Di Sini..."></textarea>
            </div>
          </div>
          <div class="row">
                <div class="col-md-2" style="padding-bottom: 3px; padding-top: 10px;">
                  <button id="cari_absen" class="btn btn-info"> Klik Untuk Mengabsen Siswa</button>
                </div>
              </div>
          <center><label style="font-size: 20px">Silahkan Pilih Siswa Yang Akan Di Absen Kehadiran Mapel</label></center>
          <table id='tableabsenmapel' class='table table-bordered table-hover'>
            <thead class="title_bar_table">
              <tr>
                <th width='5px'>
                  All<input type='checkbox' id='ceksemua'></th>
                <th width='5px'>#</th>
                <th >Nama Siswa</th>
                <th >Kelas</th>
                <th >Jurusan</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($db->v_siswa($_GET['kodekelas'],'semua') as $vl) { ?>
                <tr>
                  <td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih' value="<?= $vl['id_siswa']?>"></td>
                  <td><?= $no++;?></td>
                  <td><?= $vl['nama']?></td>
                  <td><?= $vl['id_kelas']?></td>
                  <td><?= $vl['idpk']?></td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#ceksemua').change(function() {
        $(this).parents('#tableabsenmapel:eq(0)').
        find(':checkbox').attr('checked', this.checked);
      });

    //jika level sudha ada maka kelas tampil
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
           var option = '<option data-idkls="'+objek.id_kelas+'" '+select+' value="'+objek.idkls+'">'+objek.nama+'</option>';
           dataMapel.push(option);
         });
          $('#kelas').append('<option value="">Pilih Kelas</option>'+dataMapel);
          console.log(data);
        }
      });
    <?php endif; ?>

    //jika kelas di pilih
    $('#kelas').change(function() { 
      var kelas = $(this).val();
      var mapel = $("#mapel").val();
   
      var lv = $('#mapel').find(':selected').data('level');
      var kodekelas = $('#kelas').find(':selected').data('idkls');
      location.replace("?pg=absen_izin&mapel="+mapel+"&level="+lv+"&kelas="+kelas+"&kodekelas="+kodekelas);
      

     });

    //insert absen 
    $(document).on('click', '#cari_absen', function() {
      var idkelas = $("#kelas").val();
      var mapel = $("#mapel").val();
      var ket = $("#keterangan").val();
      var keterangan_status = $("#keterangan_status").val();
      var idabsenmapel = $('#mapel').find(':selected').data('absenmapel');
      var tgl = $("#tgl").val();

      

      id_array = new Array();
        i = 0;
        $("input.cekpilih:checked").each(function() {
          id_array[i] = $(this).val();
          i++;
        });
        if(id_array.length === 0){
          toastr.warning(' Siswa Belum Di Pilih');
        }
        else if(idkelas==''){
          toastr.warning('Kelas Belum Di Pilih ');
        }
        else if(keterangan_status==''){
          toastr.warning('Keterangan Belum Di Pilih');
        }
        else{
          //console.log(i);
          $.ajax({
            url: "<?php echo "c_aksi.php?absen_mapel_siswa=izin"; ?>",
            data: { 
              idsiswa: id_array,
              idkelas:idkelas,
              idabsenmapel:idabsenmapel,
              kodemapel:mapel,
              tgl:tgl,
              ket:ket,
              ktrs:keterangan_status,
            },
            type: "POST",
            success: function(respon) {
              console.log(respon); 
              if(respon==1){
                toastr.success('Berhasil Tambah Absensi ');
                setTimeout(function () { location.reload(1); }, 1000);
              }
              else{
                toastr.error('Upss Sepertinya Tanggal Ini Absen Siswa Pada Mapel Ini Sudah Ada ');
              }
            }
          });
        }
        return false;
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
           var option = '<option data-idkls="'+objek.id_kelas+'" value="'+objek.idkls+'">'+objek.nama+'</option>';
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
      "lengthMenu": [[10,20,30,50, -1], [10,20,30,50, "All"]],
      pageLength: 200,

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


