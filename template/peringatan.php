<div id="cek_selesai" <?php echo $hidenDiv; ?>>
  <button style="margin-left: 2px;" onclick="location.reload();" class='btn btn-flat btn-primary'><i class="fa fa-spinner fa-spin "></i> Refres</button>
  <div class="panel panel-primary">
    <div class="panel-heading">PELANGGARAN</div>
    <div class="panel-body" align="center">
      <?php if ($AdminBukaBlokir == 0) { ?>
        <div class="row">
          <div class="col-md-12">
            <label style="color: black">
              ANDA DI BLOKIR DARI UJIAN<br>
              SISTEM MENDETEKSI ANDA MELAKUKAN PELANGGARAN PADA SAAT UJIAN<br>
              DENGAN MENINGGALKAN HALAM UJIAN SAMPAI 3 KALI<br>
              SILAHKAN HUBUNGI ADMIN UNTUK MEMBUKA BLOKIR ANDA <br>
            </label>
          </div>
        </div>
      <?php } else { ?>
        <div class="row">
          <div class="col-md-12">
            <label style="color: black">
              SELAMAT ANDA SUDAH BISA MENGAKSES KEMBALI HALAMAN UJIAN
              <br>
              KLIK TOMBOL LANJUTKAN MENUJU KE HALAMA UJIAN
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <button id="lanjut_setelah_diblokir" class="btn btn-primary">&nbsp; LANJUTKAN</button>
          </div>
        </div>
      <?php } ?>


    </div>
  </div>
</div>
<script type="text/javascript">
  $('#lanjut_setelah_diblokir').click(function(e) {
    var idnilai = $('#idnilai').val();
    $.ajax({
      type: 'POST',
      url: '../../c_jawaban.php?peringatan=buka_blokir',
      data: {
        idnilai: idnilai,
      },
      success: function(response) {
        console.log(response);
        location.reload();
        localStorage.setItem("warning",0);
      }
    });
  });
</script>