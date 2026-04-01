<script type="text/javascript">
//   document.addEventListener("contextmenu", function(e){
//     e.preventDefault();
// }, false);
</script>
<script>
var elem = document.documentElement;
function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
}

function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) {
    document.msExitFullscreen();
  }
}
</script>
<div id="cek_selesai" style="display: none;">
  <button style="margin-left: 2px;" onclick="location.reload();" class='btn btn-flat btn-primary'><i class="fa fa-spinner fa-spin "></i> Refres</button>
  <div class="panel panel-primary">
    <div class="panel-heading">Konfirmasi Selesai Ujian</div>
    <div class="panel-body" align="center">
      <div class="row">
        <div class="col-md-12">
          <label style="color: black">Apakah Kamu Yakin Ingin Menyelesaikan Ujian</label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <button id="finis" class="btn btn-danger"><i class="fas fa-paper-plane "></i>&nbsp; Kirim Jawaban Ke Server</button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <label style="color: black">Jangan Lupa Kirim Jawaban Ke Server, Kemudia Tekan Tombol Selesai Ujian</label><br>

          Waktu Tombol Selesai Muncul<div id="divCounter" style="color: red"></div>
          <button id="selesa_ujian" class="done-btn btn btn-primary" disabled="disabled"><i class="fa fa-flag-checkered"></i> Klik Untuk Selesai Ujian</button>
        </div>
        <!--  <label>Jika Waktu Tombol Selesai sudah 0 dan tidak tampil, Tekan Tombol Refres</label><br> -->
      </div>
      <div class="row" style="margin-top:5px;">
        <div class="col-md-12">
          <button class="btn btn-warning" id="back_soal"><i class="fa fa-arrow-left"></i> Kembali Ke Soal</button>
        </div>
      </div>

    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    if(sessionStorage.getItem("counter")==0){
      $(".done-btn").removeAttr("disabled");
    }
  });
</script>

