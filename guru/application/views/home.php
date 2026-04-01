<section class='content' >
	<div class="row">
		<div class="col-md-12">
			<div class='row'>
				<div class='col-md-8'>
					<div class='box box-solid direct-chat direct-chat-warning'>
						<div class='box-header with-border'>
							<h3 class='box-title'><i class='fa fa-bullhorn'></i> Halaman Home &nbsp;&nbsp;<a href="clear_cache">Clear Cache</a> 
							</h3>
							<div class='box-tools pull-right'></div>
						</div><!-- /.box-header -->
						<div class='box-body'>
							<div class="row" style="padding-left: 5px; padding-top: 10px;">
							<div class="col-lg-5">
								<div class="small-box" style="background-color: #0173b7;
								background-image: linear-gradient(141deg, #5e7f92 0%, #0173b7 51%, #0173b7 75%);color: white;opacity: 0.95;">
									<div class="inner">
										<h3 id="jml_materi"></h3>
										<p>Jumlah Siswa</p>
									</div>
									<div class="icon" style="padding-top: 10px;">
										<i class="fa fa-flask"></i>
									</div>
									<a href="v_siswa" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-5">
								<div class="small-box bg-yellow" style="background: linear-gradient(to right, orange , #da9501);">
									<div class="inner">
										<h3 id="jml_tugas"></h3>
										<p>Jumlah Mapel2</p>
									</div>
									<div class="icon" style="padding-top: 10px;">
										<i class="fa fa-edit"></i>
									</div>
									<a href="daftar_ujian" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
				<div class='col-md-4'>
					<div class='box box-solid '>
						<div class='box-body'>
							<strong><i class='fa fa-building-o'></i> <?= $setting['sekolah'] ?></strong><br />
							<?= $setting['alamat'] ?><br /><br />
							<strong><i class='fa fa-phone'></i> Telepon</strong><br />
							<?= $setting['telp'] ?><br /><br />
							<strong><i class='fa fa-fax'></i> Fax</strong><br />
							<?= $setting['fax'] ?><br /><br />
							<strong><i class='fa fa-globe'></i> Website</strong><br />
							<?= $setting['web'] ?><br /><br />
							<strong><i class='fa fa-at'></i> E-mail</strong><br />
							<?= $setting['email'] ?><br />
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$.getJSON('<?= base_url('admin/materi_json')?>', function(data) {
		$.each(data, function(index,objek){
      $('#jml_materi').html(objek);
			//console.log(objek);
		});        
	});
	$.getJSON('<?= base_url('admin/tugas_json')?>', function(data) {
		$.each(data, function(index,objek){
      $('#jml_tugas').html(objek);
			//console.log(objek);
		});        
	});
</script>
