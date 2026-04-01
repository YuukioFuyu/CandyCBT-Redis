<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');

?>
<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid '>
				<div class='box-header with-border '>
					<h3 class='box-title'><i class='fa fa-briefcase'></i> Jam Absensi</h3>
					
				</div><!-- /.box-header -->
				<div class='box-body'>
					<legend>Silahkan di Atur untuk Jam Masuk, Jam Pulang, Jam Terlambat dan Jam Alpa biar 00:00:00</legend>
					<form id='formjawaban'>
						<?php $jamskl = $db->getJamSkl(); ?>
						<input value="<?= $jamskl['jmId'] ?>" type='hidden' name='jamid' >
					  <div class="form-group">
					    <label for="email">Jam Masuk</label>
					    <input value="<?= $jamskl['jamIn'] ?>" type='text' name='jamin' class='timer form-control' autocomplete='off' required='true' />
					  </div>
					  <div class="form-group">
					    <label for="pwd">Jam Pulang</label>
					    <input value="<?= $jamskl['jamOut'] ?>" type='text' name='jamout' class='timer form-control' autocomplete='off' required='true' />
					  </div>
					  <div class="form-group">
					    <label for="pwd">Jam Alpa</label>
					    <input value="<?= $jamskl['jamAlpah'] ?>" type='text' name='jamalpa' class='timer form-control' autocomplete='off' required='true' />
					  </div>
					  <div class="form-group">
					    <label for="pwd">Jam Terlambat</label>
					    <input value="<?= $jamskl['jamTerlambat'] ?>" type='text' name='jamterlambat' class='timer form-control' autocomplete='off' required='true' />
					  </div>
					  <button class="btn btn-info"><i class="fa fa-paper-plane"></i> Simpan Jam</button>
					</form>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
</div>

<script type="text/javascript">
$('#formjawaban').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
      $.ajax({
        type: 'POST',
        url: 'c_aksi.php?absen=jamabsen',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);
          if (data == 1) {
            toastr.success("Berhasil Atur Jam Absen Sekolah");
            setTimeout(function () { location.reload(1); }, 2000);
          } 
          else {
            toastr.error("Upss Gagal");
          }
       	}
      });
      //return false;
    });
</script>
	