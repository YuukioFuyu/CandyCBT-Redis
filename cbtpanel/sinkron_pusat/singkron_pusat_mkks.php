<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<?php $info = ''; ?>
<link rel='stylesheet' href='<?= $homeurl ?>/dist/css/mryes.css' />
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'><i class="fa fa-download"></i> SINGKRON DATA</h3>
				
			</div><!-- /.box-header -->
			<div class='box-body'>
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="pill" href="#home">DATA UJIAN</a></li>
					<li><a data-toggle="pill" href="#menu1">UPLOAD FILE JSON</a></li>
					<li><a data-toggle="pill" href="#menu2">FILE PENDUKUNG</a></li>
				</ul>
				<div class="tab-content" style="padding-top: 20px;">
					<div id="home" class="tab-pane fade in active">
						<div class="row">
							<div class="col-md-12">
								<form id="inserIdServer">
									<div class="form-group">
										<div class="row" >
											<div class="col-md-2" style="padding-bottom: 5px;">
												<input value="<?= $setting['id_server']?>" type="text" name="kodeserver" value="" class="form-control" placeholder="kodeserver" >
											</div>
											<div class="col-md-3" style="padding-bottom: 5px;">
												<input value="<?= $setting['db_host']?>" type="text" name="urlserver" value="" class="form-control" placeholder="https://domain.com/" >
											</div>
											<div class="col-md-4" style="padding-bottom: 5px;">
												<input value="<?= $setting['tokenApi']?>" type="text" name="tokeapi" value="" class="form-control" placeholder="Token Api Server">
											</div>
											<div class="col-md-2" style="padding-bottom: 5px;">
												<button class="btn btn-primary"><i class="fa fa-upload"></i> Simpan</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="box box-solid ">
							<div class="box-header with-border">
								<h3 class="box-title"><i class="fa fa-desktop"></i> Status Server</h3>

							</div><!-- /.box-header -->
							<div class="box-body">
								<center><img id="loading-image" src="../dist/img/ajax-loader.gif" style="width: 50px; display: none;">
									<center>
										<?php $server = $db->CekServerCurl($setting['tokenApi'],$setting['id_server'],$setting['db_host']);  ?>
										<?php if($server->status == 200): ?>
										<div id="statusserver">
											<h2 class="text-blue"><?= $server->data; ?></h2>
											<span><?= $server->pesan; ?></span>
										</div>
										<?php elseif($server->status == 203): ?>
											<div id="statusserver">
												<h2 class="text-yellow"><?= $server->data; ?></h2>
												<span><?= $server->pesan; ?></span>
											</div>
										<?php else: ?>
											<div id="statusserver">
												<h3 class="text-red">Tidak Ada Koneksi</h3>
												<span><?= $server->pesan; ?></span>
											</div>
										<?php endif; ?>
									</center></center>
							</div><!-- /.box-body -->
             </div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<h5 class="box-title" style="color: #3d6baf;"><i class="fa fa-spinner fa-spin"></i> STATUS SINKRONISASI | PASTIKA SINKRON BERURUTAN </h5>
								<div class='table-responsive'>
									<table class="table table-bordered ">
										<thead class="color-mryes">
											<th>NO</th>
											<th>AKSI</th>
											<th>NAMA</th>
											<th>DATA YANG MASUK</th>
											<th>DATA DI SERVER</th>
											<th>TANGGAL SINKRON</th>
											<th>STATUS</th>
											<th>AKSI</th>
										</thead>
										<tbody>
											<?php 
											$no=1;
											$array = array('DATA_MASTER','KELAS','SISWA','MAPEL','BANK_SOAL','SOAL','JADWAL');//,'FILE_PENDUKUNG'
											$data = $db->getDataSinkron(); 
											foreach ($data as $val): 
											if(in_array($val['nama_data'], $array)):
											?>
											<tr>
												<td><?= $no++; ?></td>	
												<td><button data-id="<?= $val['nama_data'] ?>"  class="getdata btn btn-primary"><i class="glyphicon glyphicon glyphicon-transfer"></i> Sinkron</button></td>
												<td><?php 
													if($val['nama_data'] == 'KELAS'){
														echo "LEVEL ".$val['nama_data']; 
													}
													else if($val['nama_data'] == 'DATA_MASTER'){
														echo"SERVER/KELAS/SESI/RUANG";
														
													}
													else{
														echo $val['nama_data'];
													}
												?></td>
												<td><?= $val['jumlah'] ?></td>
												<td><?= $val['jumlah_server'] ?></td>
												<td><?php 
												if(!empty($val['tanggal'])){ 
													echo date('d-m-Y H:i:s', strtotime($val['tanggal'])); 
												} ?></td>
												<td>
													<?php if($val['status_sinkron'] == 1): ?>
														<span class="label label-primary">SUDA</span>
													<?php else: ?>
														<span class="label label-warning">BELUM</span>
													<?php endif;?>
												</td>
												<td>
													<?php if($val['status_sinkron'] == 1): ?>
														<button class="resetsinkron btn btn-danger" data-id="<?= $val['nama_data'] ?>" >Reset</button>
													<?php else: ?>
														
													<?php endif;?>
												</td>
											</tr>
											<?php 
											endif; 
											endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div id="menu1" class="tab-pane fade">
						<div class="row">
							<div class='col-md-6'>
								<div class='box box-solid'>
									<div class='box-header '>
										<h3 class='box-title'>Upload File Json</h3>
									</div>
									<div class='box-body'>
										<form id='formjson'>
											<p>Klik Tombol dibawah ini untuk Upload File Json Data</p>
											<div class='col-md-8' style="padding-bottom: 20px;">
												<input class='form-control' name='json' type='file' required />
											</div>
											<button name='filejson' class='btn btn-flat btn-success'><i class='fa fa-database'></i> Upload</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id="menu2" class="tab-pane fade">
						<div class="row">
								<div class='col-md-6'>
								<div class='box box-solid'>
									<div class='box-header '>
										<h3 class='box-title'>Upload File Pendukung</h3>
									</div>
									<div class='box-body'>
										<form id='formdukung'>
											<p>Klik Tombol dibawah ini untuk Upload File Pendukung</p>
											<div class='col-md-8' style="padding-bottom: 20px;">
												<input class='form-control' name='dukung' type='file' required />
											</div>
											<button name='dukungfile' class='btn btn-flat btn-success'><i class='fa fa-database'></i> Upload</button>
										</form>
									</div>
								</div>
							</div>
							</div>
					</div>
				</div>
				
				<!-- /pengacak mryes -->
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
	<script type="text/javascript">
		$(document).ready(function() {

			$(".resetsinkron").click(function(e){
				e.preventDefault();
				var id = $(this).data("id");
				$.ajax({
						type: 'POST',
						url: 'c_aksi.php?sinkronmkks=resetsinkron',
						data: {id:id},

						beforeSend: function() {
							$("#pesanku").text("Proses ....");
							$('.loader').css('display', 'block');
						},
						success: function(data) {
							//console.log(data);
							var cek = JSON.parse(data);
							console.log(cek);
							if (cek.status == 200) {
								toastr.success(cek.pesan);
								setTimeout(function () { location.reload(1); }, 1000);
							} 
							else {
								$('.loader').css('display', 'none');
								toastr.error(cek.pesan);
							}
						}
					});
			});

			$(".getdata").click(function(e){
				e.preventDefault();
					var id = $(this).data("id");
					$.ajax({
						type: 'POST',
						url: 'c_aksi.php?sinkronmkks=getdataserver',
						data: {id:id},

						beforeSend: function() {
							$("#pesanku").text("Proses Sinkron Data ....");
							$('.loader').css('display', 'block');
						},
						success: function(data) {
							//console.log(data);
							var cek = JSON.parse(data);
							console.log(cek);
							if (cek.status == 200) {
								toastr.success(cek.pesan+' '+cek.jumlah);
								setTimeout(function () { location.reload(1); }, 1000);
							} 
							else {
								$('.loader').css('display', 'none');
								toastr.error(cek.pesan);
							}
						}
					});
			});
			$('#inserIdServer').submit(function(e) {
				e.preventDefault();
					var data = new FormData(this);
					$.ajax({
						type: 'POST',
						url: 'c_aksi.php?sinkronmkks=idserver',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						success: function(data) {
							//console.log(data);
							if (data == 1) {
								toastr.success("Berhasil Save");
								setTimeout(function () { location.reload(1); }, 1000);
							} 
							else {
								$('.loader').css('display', 'none');
								toastr.error("Upss Gagal");
							}
						}
					});
			});
			$('#formdukung').submit(function(e) {
				e.preventDefault();
				var data = new FormData(this);
					//console.log(data);
				$.ajax({
					type: 'POST',
					url: 'backup_file_pendukung.php?restore=yes',
					enctype: 'multipart/form-data',
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function() {
						$("#pesanku").text("Mohon Tunggu Proses Restore ...! 5-10 Menit");
						$('.loader').show();
					},
					success: function(data) {
					$('.loader').hide();
						if(data==1){
							toastr.success('Berhasil Upload File Pendukung');
						}
						else if(data==99){
							$('.loader').css('display', 'none');
							toastr.error("Terdapat File Bahaya");
						}
						else if(data==100){
							$('.loader').css('display', 'none');
							toastr.error("Upsss Terjadi Error");
						}
						else{
							$('.loader').css('display', 'none');
							toastr.error(data);
						}
						
					}
					});
				return false;
			});
		
			$('#formjson').submit(function(e) {
				e.preventDefault();
				var data = new FormData(this);
				$.ajax({
					type: 'POST',
					url: 'backup_restor_json.php?restorejson=yes',
					data: data,
					enctype: 'multipart/form-data',
					cache: false,
					contentType: false,
					processData: false,

					beforeSend: function() {
						$("#pesanku").text("Mohon Tunggu Proses Restore ...! 5-10 Menit");
						$('.loader').show();
					},
					success: function(data) {
						console.log(data);
						var cek = JSON.parse(data);
						console.log(cek);
							if (cek.status == 200) {
								toastr.success(cek.pesan+' '+cek.jumlah);
								setTimeout(function () { location.reload(1); }, 1000);
							} 
							else {
								$('.loader').css('display', 'none');
								toastr.error(cek.pesan);
							}
						
						}
					});
				return false;
			});

		});
	</script>

</div>
