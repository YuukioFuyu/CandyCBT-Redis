
<?php
  include_once 'core/c_user.php'; 
  include_once 'template/css_soal.php';

  
  $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
  $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
  //-------------------------------------------------------------------------------
  
  $id_ujian = $_POST['idujian'];
  $idMapel = $_POST['idmapel'];
  $idSiswa = $_POST['idsiswa'];
  $nilaiId = $_POST['idNilai'];


  $homeurl = $_POST['homeurl'];
  $modejawab = $_POST['modejawab'];
  $jenisSoal = $_POST['jenissoal'];
  
  $jumlahSoalEsai= $_POST['jumlahsoalesai']; //jumlah soal

  //urutan soal utnuk nex dan prev------------
  $urutanSoal = $_POST['urutansoal'];
  $no_prev = $urutanSoal;
  $no_next = $urutanSoal + 1;

  //urutan soal utnuk nex dan prev-------------
  
  //get soal ujian ------------------------------------

    //get id soal di tabel pengacak
    $pengacakq =$dbb->getPegacakSoalId($idMapel,$idSiswa,$id_ujian);
    foreach ($pengacakq as $dataacak) {
      $pengacak = explode(',', $dataacak->id_esai);//pecah ke array
    }

    
    //ambil soal berdasarkan idmapel dan idsoal berdasarkan acakan
    $getSoal= $dbb->getSoalUjianId($idMapel,$pengacak[$urutanSoal]);

    //ambil semua soal yang jenis 1 atau PG untuk di Daftar Soal
    //$getSoalAllPg= $dbb->getSoalUjian($idMapel,1);
  //get soal ujian ------------------------------------
  
  $idSoalArrayAcak = remove_empty($pengacak);
  function remove_empty($array) {
  return array_filter($array, '_remove_empty_internal');
  }

  function _remove_empty_internal($value) {
    return !empty($value) || $value === 0;
  }
  

?>
<?php if($getBlok[0]->blok == 1){ #cek status blok ?>
	<?php //-----Load Halaman Blokir---- ?>
	<?php include "template/peringatan.php"; ?>
<?php }else{ ?>
<script type="text/javascript">
  $(document).ready(function(){
<?php //cek jika localStorage jawaban null ubah ke string "" ?>
    var cek_jwbs = localStorage.getItem("jwbesai");
    if(cek_jwbs === "undefined"){
      localStorage.setItem('jwbesai', JSON.stringify(""));
    }
    if(cek_jwbs === "null"){
      localStorage.setItem('jwbesai', JSON.stringify(""));
    }
  });
</script>
<div id="grub_soal" > <?php //untuk kepala / header soal ?>
  <?php foreach ($getSoal as  $data) { 

  ?>
<div class="bagian_sola" >
  <div id='divujian'>
    <span style='display:none' id='htmlujianselesai'><?= $ujianselesai ?></span>
  </div>
  <h3 class='box-title'><span class='btn hidden-xs bg-gray active'>SOAL NO </span> <span class='btn bg-green' id='displaynum'><b><?= $no_next; ?></b></span></h3>
  <div class='btn-group'>
    
    <button type='button' class='btn bg-purple smaller_font'> - </button>
    <button type='button' class='btn bg-purple reset_font'><i class='fa fa-sync-alt'></i></button>
    <button type='button' class='btn bg-purple bigger_font'> + </button>
  </div>
  <button style="margin-left: 2px;" onclick="location.reload();" class='btn btn-flat btn-primary'><i class="fa fa-spinner fa-spin "></i> Refres</button>
  <button data-toggle="modal" data-target="#myModal" style="margin-left: 2px;" data-backdrop="false" class='btn btn-flat btn-primary'><i class="fa fa-th-large "></i> Soal</button>

  <div id='loadsoal'>
    <div class='box-body thema' >
      <div class='row'>
        <div class="col-md-12 col-xm-6">
          <?php //---------view soal-------- ?>
          <div class='col-md-12'>
            <input type="hidden" id="id_soal<?= $data->id_soal ?>" name="id_soal" value="<?= $data->id_soal ?>">
            <input type="hidden" id="id_siswa" name="id_siswa" value="<?= $idSiswa;?>">
            <input type="hidden" id="id_mapel" name="id_mapel" value="<?= $idMapel ?>">
            <input type="hidden" id="id_ujian" name="id_ujian" value="<?= $id_ujian;?>">
            <input type="hidden" id="no_urut" name="no_urut" value="<?= $data->nomor ?>">
            <input type="hidden" id="jenis_soal<?= $data->id_soal ?>" name="jenis_soal" value="<?= $data->jenis ?>">

            <div class='callout soal'>
              <?php 
                //gamabr soal ke 1
              $datafile = $data->file;
              if ($datafile <> '') {
                $ext = explode(".", $datafile);
                $ext = end($ext);
                if (in_array($ext, $image)) {
                  echo "<a  data-id='$datafile' class='foto_click' href='#'' data-toggle='modal' data-target='#modalfoto' style='display:inline-block'> <img src='$homeurl/files/$datafile' class='img-responsive'/></a>";
                } elseif (in_array($ext, $audio)) {
                  echo "<audio controls='controls' ><source src='$homeurl/files/$datafile' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                } else {
                  echo "File tidak didukung!";
                }
              }
              ?>
                
              <div class='soaltanya' id="soaltanya" >
                <?= $data->soal ?>
              </div>
              <?php
                //gamabr soal ke 2 
              $datafile1 = $data->file1;
              if ($datafile1 <> '') {
                $ext = explode(".", $datafile1);
                $ext = end($ext);
                if (in_array($ext, $image)) {
                  echo "<a  data-id='$datafile1' class='foto_click' href='#'' data-toggle='modal' data-target='#modalfoto' style='display:inline-block'> <img  src='$homeurl/files/$datafile1' class='img-responsive'/></a>";
                } elseif (in_array($ext, $audio)) {
                  echo "<audio controls='controls' ><source src='$homeurl/files/$datafile1' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
                } else {
                  echo "File tidak didukung!";
                }
              }
              ?>
            </div>
          </div>
          <?php //---------view soal-------- ?>
          <?php //---------opsi pg-------- ?>
          <div class='col-md-12'>
            <textarea id="isiesai<?= $data->id_soal ?>" name="jawab<?= $data->id_soal ?>" class="summernote form-control"></textarea>
            <br>
            <button id="simpanesai<?= $data->id_soal ?>" class="btn btn-primary "><i class="fa fa-save"></i> Simpan Jawaban</button>
          </div>
          <?php //---------opsi pg-------- ?>

          <?php //---------next back-------- ?>
          <div class='box-footer navbar-fixed-bottom lanjut' >
            <table width='100%'>
            <tr>
              <td style="text-align:center">
                <?php if($no_prev <= 0){ ?>
                  <button disabled="disabled" id='prev' class='btn  btn-primary' ><i class='fas fa-angle-double-left'></i> <span class='hidden-xs'>SEBELUMNYA</span></button>
                 <?php }else{  ?>
                  <button  onclick="loadsoalpg(<?= $no_prev-1; ?>,1)" class='btn btn-primary kembali' ><i class='fas fa-angle-double-left'></i> <span class='hidden-xs'>SEBELUMNYA</span></button>
                <?php } ?>
              </td>

              <td style="text-align:center">
                <button class='btn btn-success' ><input id="ragu" name="ragu" class="ragu<?= $data->id_soal ?>" type='checkbox' value=""  /> RAGU</button>
              </td>
              <td style="text-align:center">
                <?php if($no_next != $jumlahSoalEsai){ ?>
                  <button onclick="loadsoalpg(<?= $no_next ?>,1)" class='btn btn-primary '><span class='hidden-xs'>SELANJUTNYA </span><i class='fas fa-angle-double-right'></i></button>
                <?php }else{ ?>
                  <button id="finis2"  class='btn btn-danger' ><i class="fas fa-flag-checkered"></i><span class='hidden-xs'>&nbsp;SELESAI</span> </button>
                <?php }?>
                  
              </td>
            </tr>
          </table>
          </div>
          <?php //---------next back-------- ?>
          <?php //---------Popout Gambar-------- ?>
            <script type="text/javascript">
              $( document ).ready(function() {
                $(".foto_click").click(function(){
                  var id = $(this).data('id');
                  var cek_foto = '/files/'+id;
                  var base_url = '<?= $homeurl; ?>'
                  var foto = '<img style="width:100%" src="'+base_url+''+cek_foto+'">';
                  $('#foto_modal').html(foto);
                });
              });
            </script>
            <div class="modal" id="modalfoto" aria-hidden="true" role="dialog" tabindex="-1" class="modal fade">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header" style="background-color: #0d7fa0; padding: 0px; padding-left: 20px;padding-top: 20px;">
                    <button type="button" class="close" data-dismiss="modal"><span style="color: red;">Keluar</span>&times;</button>
                  </div> 
                  <!-- Modal body -->
                  <div class="modal-body" id="foto_modal">
                  </div>
                </div>
              </div>
            </div>
          <?php //---------End Popout Gambar-------- ?>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
<?php //-------load jawaban saat refres atau ganti soal ---------------- ?>
function get(item) {
      return JSON.parse(localStorage.getItem(item));
    }
    function getPanjang(item) {
      return JSON.parse(localStorage.getItem(item)).length;
    }

  $(document).ready(function(){
    
    var jawabs_cek = JSON.parse(localStorage.getItem("jwbesai"));
      var id_soal_cek = "<?= $data->id_soal ?>";
      $.each(jawabs_cek, function(index, obj){
        if(id_soal_cek == obj.idsoal){
            $("#isiesai<?= $data->id_soal ?>").val(obj.jawaban);
          }
      });
      <?php //-------load tombol ragu ---------------- ?>
        var cek_ragu_lenght = getPanjang('ragu');
        var cek_ragu = get('ragu');

        if(cek_ragu_lenght > 0 ){
          //console.log(cek_ragu);
          $.each(cek_ragu, function(index, obje){
            if(id_soal_cek == obje.idsoal){
              $(".ragu"+obje.idsoal).attr("checked","checked");
            }
            else{
              $(".ragu"+obje.idsoal).removeAttr("checked");
            }
          });
        }
        else{
          $(".ragu"+id_soal_cek).removeAttr("checked");
        }
        <?php //-------end load tombol ragu ---------------- ?>
  });
<?php //-------load jawaban saat refres atau ganti soal ---------------- ?>
    
    <?php //Simpan Jawaban Esai Localstorage ----------------------- ?>
    $('#simpanesai<?= $data->id_soal ?> ').click(function(){
      let isi_esai = $.trim($("#isiesai<?= $data->id_soal ?>").val());
      let id_soal = $("#id_soal<?= $data->id_soal ?>").val();
      let id_mapel = $("#id_mapel").val();
      let id_siswa = $("#id_siswa").val();
      let id_ujian = $("#id_ujian").val();
      let jenis_soal = $("#jenis_soal<?= $data->id_soal ?>").val();
      //-----------------
      let jwb = getPanjang('jwbesai');
      let jwbs = get('jwbesai');
      let jawaban = [];
      let jawaban1 = [];
      //------------------
      //alert(jwb);
      if(jwb > 0 ){
        $.each(jwbs, function(index, obj){ //loping jawaban untuk cocok id soal

          if(obj.idsoal==id_soal){ }
            else{
              var arr1 = obj;
              jawaban1.push(arr1);    
            }
          });
        var arr = [{"idsoal":id_soal, "jawaban":isi_esai, "status":0,"idsiswa":id_siswa,"idmapel":id_mapel,"idujian":id_ujian,"jenissoal":jenis_soal}];
        var angkaBaru = jawaban1.concat(arr);
        localStorage.setItem("jwbesai", JSON.stringify(angkaBaru)); 
      }
      else{
        var arr = {"idsoal":id_soal, "jawaban":isi_esai, "status":0,"idsiswa":id_siswa,"idmapel":id_mapel,"idujian":id_ujian,"jenissoal":jenis_soal};
        jawaban.push(arr);
        localStorage.setItem('jwbesai', JSON.stringify(jawaban)); 
        
      }
      $(".daftarsoal"+id_soal).attr("style","background: #ffe08a;min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium;");
      $("#cekjawaban"+id_soal).val("1");

    });
    <?php //End Simpan Jawaban Esai Localstorage ----------------------- ?>
</script>
<?php //------Tombol ragu ragu ----------------------- ?>
<script type="text/javascript">
  <?php //clik tombol ragu ragu ?>
  $('#ragu').on('click', function() {

    var isAktif = $(this).val();
    var id_soal = $("#id_soal<?= $data->id_soal ?>").val();
    var jawaban = [];
    var ragu = [];
    var ragu1 = [];
    var getragu = getPanjang('ragu');
    var getragus = get('ragu');
    var cekYes = cekNo = 0;

    <?php //cek apakah ada datanya id soal pada localstorage ragu ?>
    if(getragu > 0 ){ 
      $.each(getragus, function(index, obj){
        if(obj.idsoal == id_soal){ 
          cekYes = 1;
        }
        else{
          cekNo = 0;

        }
      });
    }
    else{
      var cekdata =0;
    }
    <?php //jika ada maka hapus data pada localstorage ragu ?>
    if(cekYes == 1){
      $.each(getragus, function(index, obj){
        if(obj.idsoal==id_soal){ }
          else{
            var arr1 = obj;
            ragu1.push(arr1);
          }
        });
      var raguBaru = ragu1;
      localStorage.setItem("ragu", JSON.stringify(raguBaru)); 
      
    }
    <?php //jika tidak ada maka tambah data pada localstorage ragu ?>
    else{
      if(getragu > 0 ){
        $.each(getragus, function(index, obj){
          if(obj.idsoal==id_soal){ }
            else{
              var arr1 = obj;
              ragu1.push(arr1);   
            }
          });
        var arr = [{"idsoal":id_soal}];
        var raguBaru = ragu1.concat(arr);
        localStorage.setItem("ragu", JSON.stringify(raguBaru)); 

      }
      else{
        var arr = {"idsoal":id_soal};
        ragu.push(arr);
        localStorage.setItem('ragu', JSON.stringify(ragu)); 
      }
      var style = 'background:#00a65a; color:white; min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium;"';
      $(".daftarsoal"+id_soal).attr('style',style);
    }
  });
</script>
<?php //------End Tombol ragu ragu ----------------------- ?>
</div>
<?php } //end forach?>
</div>
<!-- --------------------------------------------------------------------------- -->
<?php //-----Konfirmasi Selesai Ujian---- ?>
<?php include "template/selesaiujian.php"; ?>

<!-- --------------------------------------------------------------------------- -->
<?php //-----Tampilkan Daftar Soal---- ?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Daftar Soal</h4>
      </div>
      <div class="modal-body">
        <?php 
        $no=1; $noo=0; 
        
        foreach ($idSoalArrayAcak as $valuee){  
          $getIdSoal2=array(
            'idsoal'=>$valuee,
          );
        ?>
        <button onclick="loadsoalpg(<?= $noo++; ?>,1)" class='daftarsoal<?= $valuee; ?> btn btn-app' id="sola-id-daftar-<?= $valuee; ?>" data-id="<?= $valuee; ?>" style="min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium;" ><?= $no++;?><span id='jawabtemp-daftar<?= $valuee; ?>' class='badge bg-green' style="font-size:medium"></span></button>
        <input value="" type="hidden" id="cekjawaban<?= $valuee; ?>" name="cekjawaban<?= $valuee; ?>" >
        <script type="text/javascript">
          <?php //-------load jawaban pada daftar soal saat refres atau ganti soal ---------------- ?>
            $(document).ready(function(){
              var jawabs_cek2 = JSON.parse(localStorage.getItem("jwbesai"));
              var id_soal_cek2 = "<?= $valuee ?>";
              var ragu = JSON.parse(localStorage.getItem("ragu"));
              var idragu =0;
              var style ="";

              $.each(jawabs_cek2, function(index, obje){
                <?php //tombol ragu pada daftar soal ?>
                  $.each(ragu, function(index, objragu){
                    if(id_soal_cek2 == objragu.idsoal){
                      idragu = 1;
                    }
                  });

                  if(idragu > 0 ){
                    style = 'background:#00a65a; color:white; min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium;"';
                  }
                  else{
                    style = 'background:#ffe08a;min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium;"';
                  }
                <?php //end tombol ragu pada daftar soal ?>

                if(id_soal_cek2 == obje.idsoal){
                    $(".daftarsoal"+obje.idsoal).attr('style',style);
                    $("#cekjawaban"+obje.idsoal).val("1");
                  
                }
              });
            });
          <?php //-------load jawaban pada daftar soal saat refres atau ganti soal ---------------- ?>
        </script>
        <?php $getIdSoal[]=$getIdSoal2;  } //end if
        ?>
        <script type="text/javascript">
          localStorage.setItem("daftaridsoal",JSON.stringify(<?= json_encode($getIdSoal) ?>));
        </script>
        <?php //but pindah soal secara daftar soal ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
<?php //------------Font Size------------------ ?>
  $(document).ready(function(){
      $('.summernote').summernote({
        placeholder:'Silahkan isi jawaban di sini',
        toolbar: []});
      $('.smaller_font').on('click', function() {
        fontSize = localStorage.getItem('fontSize')
        fontSize--;
        localStorage.setItem('fontSize', fontSize)
        soalFont(fontSize)
      });

      $('.bigger_font').on('click', function() {
        fontSize = localStorage.getItem('fontSize')
        fontSize++;
        localStorage.setItem('fontSize', fontSize)
        soalFont(fontSize)
      });

      $('.reset_font').on('click', function() {
        fontSize = defaultFontSize
        localStorage.setItem('fontSize', fontSize)
        soalFont(fontSize)
      });
        fontSize = defaultFontSize
        localStorage.setItem('fontSize', fontSize)
        soalFont(fontSize)
    });
<?php //------------Font Size------------------ ?>
</script>
<script type="text/javascript">
  $(document).ready(function() {
    <?php //-----------------Thema Gelap----------------------------- ?>
    var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
    function switchTheme(e) {
      if (e.target.checked) {
        localStorage.setItem('theme',1); 
        $("#thema").css("background-color","rgb(53, 54, 58)");
        $(".thema").css("color","rgb(232, 234, 237)");
        $("#waktu_ujian_user").css("color","white");
        $(".btn-slide").css("color","rgb(232, 234, 237)");
        $("#modeag").css("color","rgb(232, 234, 237)");
        $(".lanjut").css("background-color","rgb(53, 54, 58)");
      }
      else {
        localStorage.setItem('theme',0); 
        $("#thema").css("background-color","#ffffff");
        $(".thema").css("color","black");
        $("#waktu_ujian_user").css("color","black");
        $(".lanjut").css("background-color","#ffffff");
      }    
    }
    toggleSwitch.addEventListener('change', switchTheme, false);

    var get_thema = localStorage.getItem('theme');
    if (get_thema==1) {
      toggleSwitch.checked = true;
      $("#thema").css("background-color","rgb(53, 54, 58)");
      $(".thema").css("color","rgb(232, 234, 237)");
      $("#waktu_ujian_user").css("color","white");
      $(".btn-slide").css("color","rgb(232, 234, 237)");
      $("#modeag").css("color","rgb(232, 234, 237)");
      $(".lanjut").css("background-color","rgb(53, 54, 58)");

    }
    else {
      $("#thema").css("background-color","#ffffff");
      $(".thema").css("color","black");
      $(".lanjut").css("background-color","#ffffff");
      $("#waktu_ujian_user").css("color","black");
      toggleSwitch.checked = false;
    }  

  });
<?php //----------------tombol finis-------------------- ?>
  $("#finis").click(function(){

    let send =[];
    let jawab_all = JSON.parse(localStorage.getItem("jwbesai"));
    jawab_all.map(function(item,index){
      if(item.status != 1){ 
        send.push(item);
      }
    });
    $.ajax({
      type: 'POST',
      url:'../../c_jawaban.php?siswa=kirim_jawabanesai',
      data: {nilai:send},
      beforeSend: function() {
          $('#finis').html('<i class="fa fa-spinner fa-spin "> </i>Loding');// Note the ,e that I added
        },
        success: function(response) {
           console.log(response);
          if (response == 1) {
            $('#finis').html('<i class="fa fa-check"></i> Oke Selesai Di Kirim');
            $("#finis").attr("style","color:black");
            let jawab_all2 = JSON.parse(localStorage.getItem("jwbesai"));
            let jawaban_ganti = [];
            let jawaban_ganti2 = [];
            let gabung = [];
            let arr= [];
            let arr2= [];
            jawab_all2.map(function(item,index){
              if(item.status != 1){ 
                arr = {"idsoal":item.idsoal, "jawaban":item.jawaban, "status":1,"idsiswa":item.idsiswa,"idmapel":item.idmapel,"idujian":item.idujian,"jenissoal":item.jenissoal};
                jawaban_ganti.push(arr);
              }
              else{
                arr2 = item;
                jawaban_ganti2.push(arr2);
              }
            });
             gabung = jawaban_ganti.concat(jawaban_ganti2);
             localStorage.setItem('jwbesai', JSON.stringify(gabung));
          }
          else if(response == 2){
            $('#finis').html('<i class="fa fa-check"></i> Sudah Di Kirim Semua');
            $("#finis").attr("disabled","disabled");
            $("#finis").attr("style","color:black");
          }
          else{

          }

        }
      });

  });
  <?php //konfirmasi tombol selesai ?>
  $('#finis2').on('click', function() { 
    
    let ada = 0;
    let tidakada = 0;
    let jawab_all = JSON.parse(localStorage.getItem("daftaridsoal"));
    var getragu = getPanjang('ragu');
    
    jawab_all.map(function(item,index){
      var cek = $("#cekjawaban"+item.idsoal).val();
      if(cek == ""){
        ada++;
      }else{ tidakada++; }  
    
     });
    if(ada==""){
      <?php //tombol ragu  ?>
      if(getragu > 0){
        swal({
            title: 'Opsss !!!',
            html: '<br>Ada <b style="color:red;">'+getragu+'</b> Soal yang masih Ragu</b><br>Cek Kembali atau  tekan Iya untuk tetap menyelesaikan ujian',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya'
          }).then((result) => {
            if (result.value) { 
              $("#grub_soal").attr("style","display:none");
              $("#cek_selesai").removeAttr("style");
            }
          });
      }
      else{
       $("#grub_soal").attr("style","display:none");
       $("#cek_selesai").removeAttr("style");
      }
      
    }
    else{
      swal({
            title: 'Opsss !!!',
            html: "Ada <b style='color:red;'>"+ada+"</b> Soal Yang Belum Di Jawab, Silahkan Di Cek di Daftar Soal",
            type: 'warning',
            //showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya'
          });
    }

  });
  $('#back_soal').on('click', function() {
    $("#cek_selesai").attr("style","display:none");
    $("#grub_soal").removeAttr("style");
  });
  
<?php //----------------tombol finis-------------------- ?>

</script>
<?php } ?>



