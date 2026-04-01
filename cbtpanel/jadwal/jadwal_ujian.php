<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
date_default_timezone_set('Asia/Jakarta');
?>
<div class='modal fade' id='tambahjadwal' style='display: none;'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header bg-maroon'>
				<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
				<h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Tambah Jadwal Ujian</h4>
			</div>
			<!-- tambah jadwal mryes -->
			<div class='modal-body'>
				<form id="formtambahujian" method='post'>
					<div class='form-group'>
						<label>Nama Bank Soal</label>
						<select name='idmapel' class='form-control' required='true'>
							<?php
							if ($pengawas['level'] == 'admin') {
								$namamapelx = mysqli_query($koneksi, "SELECT * FROM mapel where status='1' order by nama ASC");
							} else {
								$namamapelx = mysqli_query($koneksi, "SELECT * FROM mapel where status='1' and idguru='$id_pengawas' order by nama ASC");
							}
							while ($namamapel = mysqli_fetch_array($namamapelx)) {
								$dataArray = unserialize($namamapel['kelas']);
								echo "<option value='$namamapel[id_mapel]'>$namamapel[nama] - $namamapel[level] - ";
								foreach ($dataArray as $key => $value) {
									echo "$value ";
								}
								echo "</option>";
							}
							?>
						</select>
					</div>
					<div class='form-group'>
						<label>Nama Jenis Ujian</label>
						<select name='kode_ujian' class='form-control' required='true'>
							<option value=''>Pilih Jenis Ujian </option>
							<?php
							$namaujianx = mysqli_query($koneksi, "SELECT * FROM jenis where status='aktif' order by nama ASC");
							while ($ujian = mysqli_fetch_array($namaujianx)) {
								echo "<option value='$ujian[id_jenis]'>$ujian[id_jenis] - $ujian[nama] </option>";
							}
							?>
						</select>
					</div>
					<div class='form-group'>
						<div class='row'>
							<div class='col-md-6'>
								<label>Tanggal Mulai Ujian</label>
								<input type='text' name='tgl_ujian' class='tgl form-control' autocomplete='off' required='true' />
							</div>
							<div class='col-md-6'>
								<label>Tanggal Waktu Expired</label>
								<input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' />
							</div>
						</div>
					</div>
					<div class='form-group'>
						<div class='row'>
							<div class="col-md-3">
								<label>Sesi</label>
								<select name='sesi' class='form-control' required='true'>
									<?php
									$sesix = mysqli_query($koneksi, "SELECT * from sesi");
									while ($sesi = mysqli_fetch_array($sesix)) {
										echo "<option value='$sesi[kode_sesi]'>$sesi[kode_sesi]</option>";
									}
									?>
								</select>
							</div>
							<div class='col-md-4'>
								<label>Blokir <i class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Secara Defaul fitur ini aktif, jika di NONAKTIFKAN fitur ini akan off deteksi siswa melakukan kecurangan dengan membuka tab baru pada browser"></i></label>
								<!-- //$mapel['tombol_selsai'] -->
								<select class="form-control" name='blokir'>
									<option selected value="1">AKTIF</option>
									<option value="0">TIDAK AKTIF</option>
								</select>
								<i style="font-size: 10px;">Blokir Otomatis siswa melanggar ujian</i>
							</div>	
							<div class='col-md-5'>
								<label>Tombol Selsai</label>
								<!-- //$mapel['tombol_selsai'] -->
								<select class="form-control" name='tombol_selsai'>
									<option value="1">AKTIF</option>
									<option value="0">TIDAK AKTIF</option>
								</select>
								<i style="font-size: 10px;">Akan Tampil, Lama Waktu Ujian / 1.5</i>
							</div>			
						</div>
						<i style="color:red;">Silahkan di isi Waktu Tombol Selesai sesuai dengan yang di inginkan tombol akan tampil<br>
						atau bisa di kosongkan saja, agar nanti manual atur tombolnya  </i>
					</div>
					<div class='form-group'>
						<div class='row'>
							<div class='col-md-3'>
								<label>Lama ujian (menit)</label>
								<input type='number' name='lama_ujian' class='form-control' required='true' />
							</div>
							<div class='col-md-3'>
								<label>KKM</label>
								<input type='number' name='kkm' class='form-control' />
							</div>
							<div class='col-md-3'>
								<label>Jumlah Remidi</label>
								<input value="0" type='number' name='ulang' class='form-control' />
							</div>
							<div class='col-md-3'>
								<label>Histori Jawaban</label>
								<select id="history" name="history" class='form-control'>
									<option value="0">Tidak Aktif</option>
									<option value="1">Aktif</option>
								</select>
							</div>
						</div>
					</div>
					<div class='form-group'>
						<label></label><br>
						<label>
							<input type='checkbox' class='icheckbox_square-green' name='acak' value='1' $acak /> Acak Soal
						</label>

						<!-- <label>
							<input type='checkbox' class='icheckbox_square-green' name='opsipg' value='1' $acak /> Acak Opsi PG
						</label> -->

						<label>
							<input type='checkbox' class='icheckbox_square-green' name='token' value='1' $token /> Token Soal
						</label>

						<label>
							<input type='checkbox' class='icheckbox_square-green' name='hasil' value='1' $hasil /> Hasil Tampil
						</label>
						<label>
							<input type='checkbox' class='icheckbox_square-green' name='status_reset' value='1' $hasil /> Reset Login
						</label>
					</div>
					<div>
						<i>Silahkan Di Ceklis Jika Ingin di Aktifkan | Jika Tidak Ingin di Aktifkan Bisa Di Abaikan Saja</i>
					</div>
					<div class='modal-footer'>
						<button name='tambahjadwal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan Semua</button>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border '>
				<h3 class='box-title'><i class="fas fa-envelope-open-text"></i> Aktifasi Ujian</h3>
				<div class='box-tools pull-right '>
					<?php if ($setting['server'] == 'pusat') : ?>
						<button class='btn btn-sm btn-primary' data-toggle='modal' data-backdrop='static' data-target='#infojadwal'><i class='glyphicon glyphicon-info-sign'></i> <span class='hidden-xs'>Informasi Baca Dulu</span></button>
						<button class='btn btn-sm btn-success' data-toggle='modal' data-backdrop='static' data-target='#tambahjadwal'><i class='glyphicon glyphicon-plus'></i> <span class='hidden-xs'>Tambah Jadwal</span></button>
					<?php endif ?>
					<?php if ($setting['server'] == 'lokal') { ?>
						<button id="getjadwalserver" class='btn btn-sm btn-warning getjadwalserver' ><i class='glyphicon glyphicon-plus'></i> <span class='hidden-xs'>Ambil Jadwal Server</span></button>
						<?php } ?>
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
				
				<div class="col-md-9">
					<form id='formaktivasi' action="">
						<div class="form-group">
							<div class="row">
								<div class="col-md-9">
									<label for="">Pilih Jadwal Ujian</label>
									<select class="form-control select2" name="ujian[]" style="width:100%" multiple='true' required>
										<?php $jadwal = mysqli_query($koneksi, "select * from ujian"); ?>
										<?php while ($ujian = mysqli_fetch_array($jadwal)) : ?>
											<option value="<?= $ujian['id_ujian'] ?>"><?= $ujian['nama'] . "-" . $ujian['id_pk'] ?></option>
										<?php endwhile; ?>
									</select>
								</div>
								<div class="col-md-3">
									<label for="">Mode Jawaban <i class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Kirim Server Langsun Akan Mengirim Jawaban Siswa Ke Server setiap 5 Menit"></i>
										<i class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Kirim Setelah Selesai Ujian Akan Mengirim Semua Jawaban Siswa Ke Server Setelah di Klik Tombol Kirim Jawaban Oleh Siswa"></i></label>
									 <select data-id="1" class="form-control select2" name="mode_jawab" id="mode_jawab">
										<option value="0" <?php if($setting['mode_jawab']==0){ echo "selected"; } ?>>Kirim Server Langsung</option>
										<option value="1" <?php if($setting['mode_jawab']==1){ echo "selected"; } ?>>Kirim Setelah Selesai Ujian</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<label for="">Kelompok Test / Sesi</label>
									<select class="form-control select2" name="sesi" id="">
										<?php $sesi = mysqli_query($koneksi, "select * from siswa group by sesi"); ?>
										<?php while ($ses = mysqli_fetch_array($sesi)) : ?>
											<option value="<?= $ses['sesi'] ?>"><?= $ses['sesi'] ?></option>
										<?php endwhile; ?>
									</select>
								</div>
								<div class="col-md-2">
									<label for="">Pilih Aksi</label>
									<select class="form-control select2" name="aksi" required>
										<option value=""></option>
										<option value="1">aktif</option>
										<option value="0">non aktif</option>
										<option value="hapus">hapus</option>
									</select>
								</div>
								<div class="col-md-5">
									<label for="">Catat Login<i class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Jika Catatan Login Aktif Maka Setiap Siswa login akan di catat untuk di Cek Lagi Status Loginya"></i></label>

									<?php $query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting ")); 
									if($query['catat_login'] == 0){ $a = 'selected'; }
									if($query['catat_login'] == 1){ $b = 'selected'; }
									if($query['catat_login'] == 2){ $c = 'selected'; }
									?>
									<select data-id="<?= $query['id_setting'] ?>" id="login" class="form-control select2" name="catat_login">
										<option <?= $b; ?> value="1" >Aktif</option>
										<option <?= $a; ?> value="0">Non Aktif</option>
										<option <?= $c; ?> value="2">Automatis</option>
									</select>
									<i style="font-size: 11px;">Non Aktif Jika Tidak Ingin Catat Login Siswa </i><i class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Aktifkan No Reset Login Juga Pada Jadwal Di Pilih, Agar Berfungsi Maksimal"></i>
								</div>
								<div class="col-md-2">
									<label for="">Jadwal Tampil</label>
									<select class="form-control select2" id="jdwl_aktif">
										<option value=""></option>
										<option value="1">aktif</option>
										<option value="0">non aktif</option>
									</select>
									<i style="padding-top: 2px;" class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="Untuk Menampilkan Jadwal Aktif Atau Tidak Aktif Sebagai Tampilan Awal"></i>
								</div>
							</div>
						</div><!-- onclick="return confirm('Yakin Ingin Hapus Cache Soal ?')" -->
						<button name="simpan" class="btn btn-success"><i class='fa fa-save'></i> Simpan Semua</button>
						
					</form>

				</div>
				<div class="col-md-3">
					<div class="box-body">
						<div class='small-box bg-aqua'>
							<div class='inner'>
								<?php $token = mysqli_fetch_array(mysqli_query($koneksi, "select token from token")) ?>
								<h3><span name='token' id='isi_token'><?= $token['token'] ?></span></h3>
								<p>Token Tes</p>
							</div>
							<div class='icon'>
								<i class='fa fa-barcode'></i>
							</div>
						</div>
						<a id="btntoken" href="#"><i class='fa fa-spin fa-refresh'></i> Refreh Token Sekarang</a>
						<p>Token akan refresh setiap 15 menit</p>
					</div>
				</div>
			</div><!-- /.box -->
		</div>

	</div>
	<!-- temapt jadwal keluar atau di tampilkan -->
	<div id="bodyreset">
		<div class='row'>
			<div class='col-md-12' style="padding-left: 30px; padding-right: 30px;">
				<div class='box box-solid'>
					<ul class="nav nav-tabs">
						<li class="jdwl1 "><a data-toggle="tab" href="#home"><b>Jadwal Aktif</b></a></li>
						<li class="jdwl2 "><a data-toggle="tab" href="#menu1"><b>Jadwal Tidak Aktif</b></a></li>
						<!-- <li><a data-toggle="tab" href="#menu2">Cooming Soon</a></li> -->
					</ul>

					<div class="tab-content" style="padding-left: 20px;">
						<div id="home" class="tab-pane fade in ">
							<div class="row" style="padding-top: 10px;">
								<?php
								if($_SESSION['level']=='admin'){
									$mapelQ = mysqli_query($koneksi, "SELECT * FROM ujian where status=1 ORDER BY status DESC, tgl_ujian ASC, waktu_ujian ASC");
								}
								elseif($_SESSION['level']=='guru'){
									$id_guru = $_SESSION['id_pengawas'];
									$mapelQ = mysqli_query($koneksi, "SELECT * FROM ujian where id_guru='$id_guru' and status=1 ORDER BY status DESC, tgl_ujian ASC, waktu_ujian ASC");
								}
								else{ }  

									?>
								<div class='table-responsive'>
									<style type="text/css">
										tr:nth-child(even) {
											background-color: #f4fcff;
										}
									</style>
									<table id='tablestatus3' class='table table-bordered '>
										<thead style="background-color: #0071a2; color: white;">
											<tr>
												<th >Aksi</th>
												<th >Status Jadwal</th>
												<th width="170">Kode Bank Soal</th>
												<th >Nama Mata Pelajara</th>
												<th >Kode Ujian</th>
												<th >Paket</th>
												<!-- <th >Level</th> -->
												<th >Jenis Jadwal</th>
												<th >Ujian Mulai</th>
												<th >Ujian Selesai</th>
												<th >Soal /Waktu Ujian</th>
												<th >Status/Sesi</th>
												<th >Acak Soal/Opsi</th>
												<th >Tampil  Token/Nilai</th>
											</tr>
										</thead>
										<tbody>
											<?php
											
											$no=1; 
											while ($mapel = mysqli_fetch_array($mapelQ)){ 
												$datakelas2 = unserialize($mapel['kelas']);
												$dataidsiswa2 = unserialize($mapel['siswa']);

												if(in_array('khusus', $datakelas2) and  !empty($dataidsiswa2)){
													$bage = '<i class="fa fa-circle text-red"></i>';
													$warna = 'Siswa Tertentu';
												}
												elseif(in_array('semua', $datakelas2)){
													$bage = '<i class="fa fa-circle text-blue"></i>';
													$warna = 'Semua';
												}
												elseif(!empty($datakelas2) and  !empty($dataidsiswa2)){
													$bage = '<i class="fa fa-circle text-purple"></i>';
													$warna = 'Siswa Tertentu <br>Pada Kelas Tertentu';
												}
												elseif(!empty($datakelas2) and  empty($dataidsiswa2)){
													$bage = '<i class="fa fa-circle text-green"></i>';
													$warna = 'Kelas Tertentu';
												}

												else{
													$warna = 'bg-blue';
												}

												if ($mapel['id_pk'] == '0') {
													$jur = 'Semua';
												} else {
													$jur = $mapel['id_pk'];
												}

												$waktu_sekarang = strtotime(date("Y-m-d H:i:s"));
												$waktu_ujia_mulai = strtotime($mapel['tgl_ujian']);
												$waktu_ujia_selesai = strtotime($mapel['tgl_selesai']);

												if($waktu_sekarang >= $waktu_ujia_mulai and $waktu_sekarang < $waktu_ujia_selesai){
													${$status.$no}= 1 ;//Ujian Mulai
												}
												elseif ($waktu_sekarang > $waktu_ujia_selesai) {
													${$status.$no}= 2 ;//UJIAN SELESAI'
												}
												else{ 
													${$status.$no}= 0 ;//Ujian Belum Mulai
												} 
													?> 
													<tr>
														<td>
															<!-- <a class="btn btn-primary " href="?pg=nilai2"><i class="fa fa-hand-peace "></i> Nilai</a> -->
															<div style="padding-bottom: 3px;"><a class="btn btn-primary btn-xs" href="?pg=status2"><i class="fa fa-binoculars "></i> Status</a></div>
															<div style="padding-bottom: 3px;"><a class="btn btn-primary btn-xs" href="?pg=banksoal&ac=lihat&id=<?= $mapel['id_mapel'] ?>"><i class="fa fa-search "></i> Soal</a></div>
															<!-- Button trigger modal -->
															<div style="padding-bottom: 3px;"><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modelId<?= $mapel['id_ujian'] ?>">
																<i class="fa fa-edit"></i> edit
															</button></div>


														</td>
														<td>
															<?php 
															if (${$status.$no} == 1) {
																	echo "<i class='fa fa-spinner fa-spin' data-toggle='tooltip' title='Ujian Sedang Berjalan'></i> Proses";
																} elseif (${$status.$no} == 0) {
																	echo "<i class='fa fa-clock' style='font-size:15px;' data-toggle='tooltip' title='Menuggu Waktu Ujian'></i> Tunggu";
																}
																else{
																	echo "<i class='fa fa-times' style='color:red; font-size:20px;' data-toggle='tooltip' title='Waktu Ujian Habis'></i> Habis";
																}
																echo"<br>";
															?>
															<i class="fa fa-circle text-green"></i>
															<?=
															$useronline = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_mapel='$mapel[id_mapel]' and id_ujian='$mapel[id_ujian]' and ujian_selesai is null"));
															?> Aktif
															<br>
															<i class="fa fa-circle text-danger"></i>
															<?=
															$userend = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_mapel='$mapel[id_mapel]' and id_ujian='$mapel[id_ujian]' and ujian_selesai <> ''"));
															?> End
														</td>
														<td><?= $mapel['nama'] ?></td>
														<td><?= $mapel['slagNama'] ?></td>
														<td><?= $mapel['kode_ujian'] ?> </td>
														<td><?php echo"<label class='badge bg-blue'> $mapel[soalPaket]</label>"; ?></td>
														<!-- <td><?= $mapel['level'] ?></td> -->
														<td> <?= $bage.' '.$warna ?></td>
														<td><?= $mapel['tgl_ujian'] ?></td>
														<td><?= $mapel['tgl_selesai'] ?></td>
														<td>

															<span class="badge bg-purple"><?= $mapel['tampil_pg'] ?> Soal PG </span><br> 
															<span class="badge bg-purple"><?= $mapel['tampil_esai'] ?> Soal Esai </span><br>
															<span class="badge bg-purple"><?= $mapel['lama_ujian'] ?> menit </span></td>
															<td>

																<?php
																if ($mapel['status'] == 1) {
																	echo "<label class='badge bg-green'>Aktif</label> <label class='badge bg-red'>$mapel[sesi]</label>";
																} elseif ($mapel['status'] == 0) {
																	echo "<label class='badge bg-red'>Tidak</label> <label class='badge bg-red'>$mapel[sesi]</label>";
																}
																else{

																}
																
																?>

															</td>
															<td>

																<?php 
																if($mapel['acak']==1){ echo"<label class='badge bg-blue'>YES</label>"; }
																else{ echo "<label class='badge'>NO</label>"; } 
																?>
																<?php 
																// if($mapel['acak_opsi']==1){ echo"<label class='badge bg-blue'>YES</label>"; }
																// else{ echo "<label class='badge'>NO</label>"; } 
																?>
															</td>
															<td>
																<?php 
																if($mapel['token']==1){ echo"<label class='badge bg-blue'>YES</label>"; }
																else{ echo "<label class='badge'>NO</label>"; } 
																?>
																/
																<?php 
																if($mapel['hasil']==1){ echo"<label class='badge bg-blue'>YES</label>"; }
																else{ echo "<label class='badge'>NO</label>"; } 
																?>
															</td>
														</tr>
														<!-- modal edit waktu jadwal ujian -->
														<div class='modal fade' id='modelId<?= $mapel['id_ujian'] ?>' style='display: none;'>
															<div class='modal-dialog'>
																<div class='modal-content'>
																	<div class='modal-header bg-blue'>
																		<h5 class='modal-title'>Edit Waktu Ujian</h5>
																	</div>
																	<form id="formedit<?= $mapel['id_ujian'] ?>">
																		<div class='modal-body'>
																			<input type='hidden' name='idm' value="<?= $mapel['id_ujian'] ?>" />
																			<input type='hidden' name='idmapel' value="<?= $mapel['id_mapel'] ?>" />
																			<div class="form-group">
																				<div class="row">
																					<div class="col-md-4">
																						<label for="mulaiujian">Waktu Mulai Ujian</label>
																						<input type="text" class="tgl form-control" name="mulaiujian" value="<?= $mapel['tgl_ujian'] ?>" aria-describedby="helpId" placeholder="">
																						<small id="helpId" class="form-text text-muted">Tanggal dan waktu ujian dibuka</small>
																					</div>
																					
																					<div class="col-md-4">
																						<label for="selesaiujian">Waktu Ujian Ditutup</label>
																						<input type="text" class="tgl form-control" name="selesaiujian" value="<?= $mapel['tgl_selesai'] ?>" aria-describedby="helpId" placeholder="">
																						<small id="helpId" class="form-text text-muted">Tanggal dan waktu ujian ditutup</small>
																					</div>
																					<div class="col-md-4">
																						<label for="mulaiujian">Nama Bayangan Mapel</label>
																						<input type="text" class="form-control" name="slagnama" value="<?= $mapel['slagNama'] ?>" aria-describedby="helpId" placeholder="">
																							<small id="helpId" class="form-text text-muted">Bisa Di Ganti Untuk Menyesuaikan</small>
																					</div>
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="row">
																					<div class="col-md-6">
														                <label>Jenis Soal</label>
														                <select name='jnSoal' class='form-control' required='true'>
														                  <option <?php selectAktif($mapel['jenisSoalUjian'],1) ?> value="1">HANYA SOAL PG </option>
																							<option <?php selectAktif($mapel['jenisSoalUjian'],2) ?> value="2">HANYA SOAL ESAI</option>
																							<option <?php selectAktif($mapel['jenisSoalUjian'],3) ?> value="3">SOAL PG & ESAI </option>
																							<option <?php selectAktif($mapel['jenisSoalUjian'],0) ?> value="0">Opss Pilih Jenis Soal</option>

														                </select>
														              </div>
																					<div class='col-md-3'>
																						<label>Reset Login</label>
																						<select id="status_reset" name="status_reset" class='form-control'>
																							<option <?php if($mapel['status_reset']==1){ echo "selected"; } ?> value="1">Aktif</option>
																							<option <?php if($mapel['status_reset']==0){ echo "selected"; } ?> value="0">Tidak Aktif</option>
																						</select>
																					</div>
																					<div class='col-md-3'>
																						<label>Histori Jawaban</label>
																						<select id="history" name="history" class='form-control'>
																							<option <?php if($mapel['history']==1){ echo "selected"; } ?> value="1">Aktif</option>
																							<option <?php if($mapel['history']==0){ echo "selected"; } ?> value="0">Tidak Aktif</option>

																						</select>
																					</div>
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="row">
																					<div class="col-md-4">
																						<label>Paket Agama</label>
											                        <select name='soalagama' class='form-control' required='true'>
											                          <option <?php selectAktif($mapel['soalAgama'],0) ?> value="0">Umum</option>
											                          <option <?php selectAktif($mapel['soalAgama'],1) ?> value="1">Soal Agama</option>
											                        </select>
																					</div>
																					<div class="col-md-4">
																						<label>Pilih Agama</label>
														                <select name='jenisagama' class='form-control'>
														                	<?php $agama = $mapel['soalAgamaList']; ?>
					                                    <option <?php selectAktif($agama,"umum") ?> value="umum">Umum</option>
					                                    <option <?php selectAktif($agama,"islam") ?> value="islam">Islam</option>
					                                    <option <?php selectAktif($agama,"protestan") ?> value="protestan">Protestan</option>
					                                    <option <?php selectAktif($agama,"katolik") ?> value="katolik">Katolik</option>
					                                    <option <?php selectAktif($agama,"hindu") ?> value="hindu">Hindu</option>
					                                    <option <?php selectAktif($agama,"buddha") ?> value="buddha">Buddha</option>
					                                    <option <?php selectAktif($agama,"khonghucu") ?> value="khonghucu">Khonghucu</option>
					                                  </select>
					                                </div>
					                                <div class='col-md-4'>
										                        <label>Paket Soal</label>
										                        <?php $soalpaket = $mapel['soalPaket']; ?>
										                        <select name='soalPaket' class='form-control' required='true'>
										                          <option <?php selectAktif($soalpaket,"A") ?> value="A">PAKET A</option>
										                          <option <?php selectAktif($soalpaket,"B") ?> value="B">PAKET B</option>
										                          <option <?php selectAktif($soalpaket,"C") ?> value="C">PAKET C</option>
										                          <option <?php selectAktif($soalpaket,"D") ?> value="D">PAKET D</option>
										                        </select>
										                      </div>
																					</div>
																				</div>
																			

																			<!-- mryes edit jadwal -->
																			<div class='form-group'>
																				<div class='row'>
																					<div class='col-md-3'>
																						<label>Lama Ujian</label>
																						<input type='number' name='lama_ujian' value="<?= $mapel['lama_ujian'] ?>" class='form-control' required='true' />
																					</div>
																					<div class='col-md-3'>
																						<label>Sesi</label>
																						<input type='number' name='sesi' value="<?= $mapel['sesi'] ?>" class='form-control' required='true' />
																					</div>
																					<div class='col-md-2'>
																						<label>KKM</label>
																						<input type='number' name='kkm' value="<?= $mapel['kkm'] ?>" class='form-control' required='true' />
																					</div>
																					<div class='col-md-4'>
			                                      <label>Tombol Selsai</label>
																							<select class="form-control" name='tombol_selsai'>
																								<option <?php if($mapel['tombol_selsai']==1){ echo'selected="selected"';} ?>  value="1">AKTIF</option>
																								<option <?php if($mapel['tombol_selsai']==0){ echo'selected="selected"';} ?> value="0">TIDAK AKTIF</option>
																							</select>
																							<i style="font-size: 10px;">Akan Tampil, Lama Waktu Ujian / 1.5</i>
			                                    </div>
																				</div>
																			</div>
																			<div class='form-group'>
																				<div class='row'>
																					<div class='col-md-3'>
																						<label>Bobot PG %</label>
																						<input type='number' name='bobot_pg' value="<?= $mapel['bobot_pg'] ?>" class='form-control' required='true' />
																					</div>
																					<div class='col-md-3'>
																						<label>Bobot Esai %</label>
																						<input type='number' name='bobot_esai' value="<?= $mapel['bobot_esai'] ?>" class='form-control' required='true' />
																					</div>
																					<div class='col-md-3'>
																						<label>Program Keahlian</label>
																						<select name='id_pk' class='form-control'>
																							<option value='semua'>Semua</option>
																							<?php
																							$pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
																							while ($pk = mysqli_fetch_array($pkQ)) : 
																								if($pk['id_pk'] == $mapel['id_pk']){ $s = 'selected';} else{ $s = ''; }
																								echo "<option value='$pk[id_pk]' $s>$pk[program_keahlian]</option>";
																							endwhile;
																							?>
																						</select>
																					</div>
																					<div class='col-md-3'>
																						<label>Pilih Level</label>
																						<select name='level' class='form-control'>
																							<option value='semua'>Semua</option>
																							<?php
																							$lev = mysqli_query($koneksi, "SELECT * FROM level");
																							while ($level = mysqli_fetch_array($lev)) : ($level['kode_level'] == $mapel['level']) ? $s = 'selected' : $s = '';
																								echo "<option value='$level[kode_level]' $s>$level[kode_level]</option>";
																							endwhile;
																							?>
																						</select>
																					</div>
																					
																					</div>
																				</div>
																				<div class='form-group'>
																					<div class='row'>
																						<div class='col-md-12'>
																						<label>Pilih Kelas</label><br>
																						<select name='kelas[]' class='form-control select2 ' style='width:100%' multiple required="true">
																							<option value='semua'>Semua Kelas</option>
																							<option value='khusus'>Khusus</option>
																							<?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
																							<?php while ($kelas = mysqli_fetch_array($lev)) : ?>
																								<?php $ap =unserialize($mapel['kelas']); 
																								if (in_array($kelas['id_kelas'],$ap ) ): ?>
																									<option value="<?= $kelas['id_kelas'] ?>" selected><?= $kelas['id_kelas'] ?></option>"
																									<?php else : ?>
																										<option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
																									<?php endif; ?>
																								<?php endwhile ?>
																							</select>
																							<i style="font-size: 10px;">Pilih Semua Jika di Tampilkan Publik</i>
																						</div>
																					</div>
																				</div>

																				<div class='form-group'>
																					<div class='row'>
																						<div class='col-md-12'>
																							<label>Pilih Siswa</label><br>
																							<select name='siswa[]' class='form-control select2 ' style='width:100%' multiple >
																								<option value='semua'>Semua Siswa</option>
																								<?php $lev = mysqli_query($koneksi, "SELECT * FROM siswa"); ?>
																								<?php while ($kelas = mysqli_fetch_array($lev)) : ?>
																									<?php if (in_array($kelas['id_siswa'], unserialize($mapel['siswa']))) : ?>
																										<option value="<?= $kelas['id_siswa'] ?>" selected><?= $kelas['nama'] ?></option>"
																										<?php else : ?>
																											<option value="<?= $kelas['id_siswa'] ?>"><?= $kelas['nama'] ?></option>"
																										<?php endif; ?>
																									<?php endwhile ?>
																								</select>
																								<span style="color: red;">Jika Untuk Siswa Tertentu Pilih Program Keahli dan Level Pilih Semua, Kelas Pilih Khusus, Kemudia Silahkan Pilih Siswa, Bisa Ketik Langsung Namanya</span>
																							</div>
																						</div>
																					</div>
																					<div class='form-group'>
																						<div class='row'>
																							<div class='col-md-3'>
																								<label>Acak Soal</label>
																								<select name="acak_soal" class='form-control'>
																									<option <?php if($mapel['acak']==1){ echo "selected"; } ?> value="1">IYES</option>
																									<option <?php if($mapel['acak']==0){ echo "selected"; } ?> value="0">TIDAK</option>
																								</select>
																							</div>
																							<!-- <div class='col-md-3'>
																								<label>Acak PG</label>
																								<select name="acak_pg" class='form-control'>
																									<option <?php if($mapel['acak_opsi']==1){ echo "selected"; } ?> value="1">IYES</option>
																									<option <?php if($mapel['acak_opsi']==0){ echo "selected"; } ?> value="0">TIDAK</option>
																								</select>
																							</div> -->
																							<div class='col-md-3'>
																								<label>Token Soal</label>
																								<select name="token" class='form-control'>
																									<option <?php if($mapel['token']==1){ echo "selected"; } ?> value="1">IYES</option>
																									<option <?php if($mapel['token']==0){ echo "selected"; } ?> value="0">TIDAK</option>
																								</select>
																							</div>
																							<div class='col-md-3'>
																								<label>Hasil Tampil</label>
																								<select name="hasil" class='form-control'>
																									<option <?php if($mapel['hasil']==1){ echo "selected"; } ?> value="1">IYES</option>
																									<option <?php if($mapel['hasil']==0){ echo "selected"; } ?> value="0">TIDAK</option>
																								</select>
																							</div>
																						</div>
																					</div>
																					<!-- /mryes edit jadwal -->
																				</div>
																				<div class='modal-footer'>

																					<center>
																						<button type="submit" class='btn btn-primary' name='simpan'><i class='fa fa-save'></i> Ganti Waktu Ujian</button>
																						<a class='btn btn-sm btn-flat btn-primary' data-toggle='modal' data-backdrop='static' data-target='#infojadwal'><i class='glyphicon glyphicon-info-sign'></i> <span class='hidden-xs'>Info Jadwal</span></a>
																					</center>

																				</div>
																			</form>
																		</div>
																	</div>
																</div>

																<script>
																	$("#formedit<?= $mapel['id_ujian'] ?>").submit(function(e) {
																		e.preventDefault();
																		$.ajax({
																			type: 'POST',
																			url: 'jadwal/edit_jadwal.php',
																			data: $(this).serialize(),
																			success: function(data) {
																				console.log(data)
																				if(data == 1){
																					toastr.success('jadwal ujian berhasil di Edit');
																					location.reload();
																				}
																				else{
																					alert(data);
																					toastr.error("jadwal gagal Edit");
																				}
																				location.reload();

																			}
																		});
																		return false;
																	});
																</script>	

													<?php } 
													?>
												</tbody>
											</table>
								</div>

							</div>  <!-- /row -->
						</div>  <!-- /home -->
										
						<!-- Jadwal Tidak Aktif -->
						<div id="menu1" class="tab-pane fade ">
							<div class="row" style="padding-top: 10px;">
								<?php
								if($_SESSION['level']=='admin'){
									$mapel2 = mysqli_query($koneksi, "SELECT * FROM ujian where status=0 ORDER BY status DESC, tgl_ujian ASC, waktu_ujian ASC");
								}
								elseif($_SESSION['level']=='guru'){
									$id_guru2 = $_SESSION['id_pengawas'];
									$mapel2 = mysqli_query($koneksi, "SELECT * FROM ujian where id_guru='$id_guru2' and status=0 ORDER BY status DESC, tgl_ujian ASC, waktu_ujian ASC");
								}
								else{ }  ?>
								<div class='table-responsive'>
									<style type="text/css">
										tr:nth-child(even) {
											background-color: #f4fcff;
										}
									</style>
									<table id='tablestatus2' class='table table-bordered '>
										<thead style="background-color: #0071a2; color: white;">
											<tr>
												<th >Aksi</th>
												<th >Status Jadwal</th>
												<th width="170">Kode Bank Soal</th>
												<th >Kode Ujian</th>
												<!-- <th >Level</th> -->
												<th >Jenis Jadwal</th>
												<th >Ujian Mulai</th>
												<th >Ujian Selesai</th>
												<th >Soal /Waktu Ujian</th>
												<th >Status/Sesi</th>
												<th >Acak Soal/Opsi</th>
												<th >Tampil  Token/Nilai</th>
											</tr>
										</thead>
										<tbody>
											<?php
											
											$no=1; 
											while ($mapel = mysqli_fetch_array($mapel2)){ 
												$datakelas2 = unserialize($mapel['kelas']);
												$dataidsiswa2 = unserialize($mapel['siswa']);

												if(in_array('khusus', $datakelas2) and  !empty($dataidsiswa2)){
													$warna = 'Siswa Tertentu';
												}
												elseif(in_array('semua', $datakelas2)){
													$warna = 'Semua';
												}
												elseif(!empty($datakelas2) and  !empty($dataidsiswa2)){
													$warna = 'Siswa Tertentu Pada Kelas Tertentu';
												}
												elseif(!empty($datakelas2) and  empty($dataidsiswa2)){
													$warna = 'Kelas Tertentu';
												}
												else{
													$warna = 'bg-blue';
												}

												if ($mapel['id_pk'] == '0') {
													$jur = 'Semua';
												} else {
													$jur = $mapel['id_pk'];
												}

												$waktu_sekarang = strtotime(date("Y-m-d H:i:s"));
												$waktu_ujia_mulai = strtotime($mapel['tgl_ujian']);
												$waktu_ujia_selesai = strtotime($mapel['tgl_selesai']);

												if($waktu_sekarang >= $waktu_ujia_mulai and $waktu_sekarang < $waktu_ujia_selesai){
													${$status.$no}= 1 ;//Ujian Mulai
												}
												elseif ($waktu_sekarang > $waktu_ujia_selesai) {
													${$status.$no}= 2 ;//UJIAN SELESAI'
												}
												else{ 
													${$status.$no}= 0 ;//Ujian Belum Mulai
												} 
													?> 
													<tr>
														<td>
															<!-- <a class="btn btn-primary " href="?pg=nilai2"><i class="fa fa-hand-peace "></i> Nilai</a> -->
															<div style="padding-bottom: 3px;"><a class="btn btn-primary btn-xs" href="?pg=status2"><i class="fa fa-binoculars "></i> Status</a></div>
															<div style="padding-bottom: 3px;"><a class="btn btn-primary btn-xs" href="?pg=banksoal&ac=lihat&id=<?= $mapel['id_mapel'] ?>"><i class="fa fa-search "></i> Soal</a></div>
															<!-- Button trigger modal -->
															<!-- <div style="padding-bottom: 3px;"><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modelId<?= $mapel['id_ujian'] ?>">
																<i class="fa fa-edit"></i> edit
															</button></div> -->


														</td>
														<td>
															<?php 
															if (${$status.$no} == 1) {
																	echo "<i class='fa fa-spinner fa-spin' data-toggle='tooltip' title='Ujian Sedang Berjalan'></i> Proses";
																} elseif (${$status.$no} == 0) {
																	echo "<i class='fa fa-clock' style='font-size:15px;' data-toggle='tooltip' title='Menuggu Waktu Ujian'></i> Tunggu";
																}
																else{
																	echo "<i class='fa fa-times' style='color:red; font-size:20px;' data-toggle='tooltip' title='Waktu Ujian Habis'></i> Habis";
																}
																echo"<br>";
															?>
															<i class="fa fa-circle text-green"></i>
															<?=
															$useronline = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_mapel='$mapel[id_mapel]' and id_ujian='$mapel[id_ujian]' and ujian_selesai is null"));
															?> Aktif
															<br>
															<i class="fa fa-circle text-danger"></i>
															<?=
															$userend = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_mapel='$mapel[id_mapel]' and id_ujian='$mapel[id_ujian]' and ujian_selesai <> ''"));
															?> End
														</td>
														<td><?= $mapel['nama'] ?></td>
														<td><?= $mapel['kode_ujian'] ?></td>
														<!-- <td><?= $mapel['level'] ?></td> -->
														<td><?= $warna ?></td>
														<td><?= $mapel['tgl_ujian'] ?></td>
														<td><?= $mapel['tgl_selesai'] ?></td>
														<td>

															<span class="badge bg-purple"><?= $mapel['tampil_pg'] ?> Soal PG </span><br> 
															<span class="badge bg-purple"><?= $mapel['tampil_esai'] ?> Soal Esai </span><br>
															<span class="badge bg-purple"><?= $mapel['lama_ujian'] ?> menit </span></td>
															<td>

																<?php
																if ($mapel['status'] == 1) {
																	echo "<label class='badge bg-green'>Aktif</label> <label class='badge bg-red'>$mapel[sesi]</label>";
																} elseif ($mapel['status'] == 0) {
																	echo "<label class='badge bg-green'>Aktif</label> <label class='badge bg-red'>$mapel[sesi]</label>";
																}
																else{

																}
																
																?>

															</td>
															<td>

																<?php 
																if($mapel['acak']==1){ echo"<label class='badge bg-blue'>YES</label>"; }
																else{ echo "<label class='badge'>NO</label>"; } 
																?>
																/
																<?php 
																if($mapel['acak_opsi']==1){ echo"<label class='badge bg-blue'>YES</label>"; }
																else{ echo "<label class='badge'>NO</label>"; } 
																?>
															</td>
															<td>
																<?php 
																if($mapel['token']==1){ echo"<label class='badge bg-blue'>YES</label>"; }
																else{ echo "<label class='badge'>NO</label>"; } 
																?>
																/
																<?php 
																if($mapel['hasil']==1){ echo"<label class='badge bg-blue'>YES</label>"; }
																else{ echo "<label class='badge'>NO</label>"; } 
																?>
															</td>
														</tr>
													

													<?php } 
													?>
												</tbody>
											</table>
								</div>
							</div> <!-- end row menu1 -->
						</div>
					</div>
				</div> <!-- .box box-solid -->
			</div>
		</div>
	</div>
</div>


<div class='modal fade bd-example-modal-xl' id='infojadwal' style='display: none;' tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" style="width: 1200px;">
		<div class='modal-content'>
			<div class='modal-header bg-maroon'>
				<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
				<h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Infromasi Jadwal</h4>
			</div>

			<div class='modal-body'>
				<p>
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<legend style="font-weight: bold;">Fungsi Jadwal Berdasarkan Warna</legend>
								Warna <span style="color: blue;">BIRU</span> untuk Jadwal Siswa Semua
								<br>Pilih Keahlian Semua, Level Semua, Kelas Semua, Siswa Kosong
								<hr>
								Warna <span style="color: red;">MERAH</span> untuk Jadwal Khusus Siswa Tertentu Tapi Semua (Global)
								<br>Pilih Keahlian Semua, Level Semua, Kelas Khusus, Siswa Pilih Siswa yang akan di tampilkan soal
								<hr>
								Warna <span style="color: blueviolet;">UNGU</span> untuk Jadwal Khusus Siswa Tertentu pada Kelas Tertentu
								<br>Pilih Keahlian Semua, Level Semua, Kelas Pilih Kelas yang di pilih, Siswa Pilih Siswa yang akan di tampilkan soal
								<hr>
								Warna <span style="color: green;">Hijau</span> untuk Jadwal Khusus Kelas Tertentu<br>
								Pilih Keahlian Semua, Level Semua, Kelas Pilih Kelas yang akan di tampilkan soal, Siswa Kosong
								<hr>
								Pilih Kelas Semua Jika Ingin Tampil di Semua Siswa

							</div>
							<div class="col-md-6">
								<legend style="font-weight: bold;">Tombol Selesai</legend>
								Tombol Selesai Jika Aktif Maka Akan Tampil Seteleah 1/5 di bagi Waktu Ujian<br>
								Jika Tidak Aktif Maka Bisa di Klik Kapan Saja
								<br><br>
								<legend style="font-weight: bold;">History Jawaban atau Duplikasi Jawaban</legend>
								History Jawaban bisa di aktifkan agar jawaban siswa ada jejaknya atau historinya
								<br>atau juga bisa tidak di aktifkan<br>
								Jika Histori Jawaban sudah tidak di butuh kan bisa di hapus, dengan cara klik Simbol Gir yang di samping kanan, akan muncul tombol hapus histori jawaban<br>
								Hapus Histori Jawaban setelah ujian selesai dan di rasa tidak di butuhkan, agar meringankan database ^_^
								<br><br>
								<legend style="font-weight: bold;">Nama Bayangan</legend>
								Nama Bayangan Pada Nama Mata Pelajaran Dapat di Ganti Sesuai Keinginan dan Kebutuhan (Agar Mudah di Sisi Siswa)
								<br><br>
								<legend style="font-weight: bold;">Edit Jadwal Langsung</legend>
								Fitur Edit Prodi, Kelas, Siswa, Tombol Selesai yang ada di jadwal. hanya untuk memudahkan jika ingin membuat jadwal tertentu sesuai kondis tanpa harus melakukan ( hapus jadwal dan edit bank soal lagi dan buat jadwal lagi )
								<br><b>Silahkan Edit bank soal terlebih dahulu dan tambah jadwal, baru edit jadwal sesuai kebutuhan</b>

							</div>
						</div>
					</div>
					<hr>	
					<div class="row">
						<div class="col-md-12">
							<legend style="font-weight: bold;">Reset Login / Catatan Login</legend>
							<b>1. Aktif</b><br>
							<i style="color: red">Tapi di edit Jadwal menu Reset Login di Aktifkan </i><br>
							Pilih Aktif, maka semua aktifitas login siswa akan di catat dan Reset Login akan di lakukan manual oleh Admin (Seperti UNBK)
							<hr>
							<b>2. Non Aktif</b><br>
							<i style="color: red">Tapi di edit Jadwal menu Reset Login di Tidak Aktifkan agar berfungsi maksimal</i><br>
							Pilih Non Aktif, maka semua aktifitas login siswa dan reset siswa di tiadakan tidak di catat oleh sistem (User atau siswa suka-suka untuk logut login dan lanjutkan soal lagi)
							<hr>
							<b>3. Automatis</b><br>
							<i style="color: red">Tapi di edit Jadwal menu Reset Login di Aktifkan </i><br>
							Pilih Automatis, maka semua aktifitas login siswa akan di caran dan Reset login akan di lakukan automatis oleh <b>sistem setia 15 Menit sekali</b>, mengikuti pergantian token <br>
							atau bisa juga di manual denga klik <i>Refreh Token Sekarang</i>
							<br>
						</div>
					</div>

				</p>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#tablestatus2').DataTable({});
	$('#tablestatus3').DataTable({});
	$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
<script type="text/javascript">
	$(document).ready(function() {
	
			$("#getjadwalserver").click(function() {
		
			swal({
				title: 'Are you sure?',
				text: 'Fungsi ini akan mengambil jadwal aktif dari server pusat',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Ambil '
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: 'POST',
						url: 'jadwal_server.php',
						//data: 'id=' + idujian,
						beforeSend: function() {
							$('.loader').css('display', 'block');

						},
						success: function(response) {
							console.log(response);
						$('.loader').css('display', 'none');
						$('.getjadwalserver').html(response);
						$("#tabledataujian").load(window.location + " #tabledataujian");
							

						}
					});

				}
			});

			});

		$("#jdwl_aktif").change(function() {
			id = document.getElementById('jdwl_aktif').value;
			localStorage.setItem('jadwal', id);
			location.reload();
		});
		var get_jdwl = localStorage.getItem('jadwal');
		if(get_jdwl==0){
			$(".jdwl1").removeClass("active");
			$(".jdwl2").addClass("active");
			$("#menu1").addClass("active in");
		}
		else{
			$(".jdwl2").removeClass("active");
			$(".jdwl1").addClass("active");
			$("#home").addClass("active in");
		}
		
	});
	$(document).ready(function() {
    $("#btntoken").click(function() {
     $.ajax({
      url: "_load.php?pg=token",
      type: "POST",
      success: function(respon) {
       $('#isi_token').html(respon);
       toastr.success('token berhasil diperbarui');
     }
   });
     return false;
   })
    $('#formaktivasi').submit(function(e) {
     e.preventDefault();
     $.ajax({
      type: 'POST',
      url: 'jadwalaktivasi.php?key=1616161616',
      data: $(this).serialize(),
      success: function(data) {
       if (data == 'hapus') {
        toastr.success('jadwal ujian berhasil di hapus');
      }
      if (data == 'update') {
        toastr.success('jadwal ujian berhasil diperbarui');
      }
      $('#bodyreset').load(location.href + ' #bodyreset');
      window.setTimeout(function(){location.reload()},1000);
    }
  });
     return false;
   });

  });
</script>
<script>
 $('#formtambahujian').submit(function(e) {
  e.preventDefault();
  $.ajax({
   type: 'POST',
   url: 'jadwal/tambah_jadwal.php',
   data: $(this).serialize(),
   success: function(data) {
				console.log(data);
				if (data == "OK") {
					toastr.success("jadwal berhasil dibuat");
					//alert(data);
				} else {
					toastr.error("jadwal gagal tersimpan");
					//alert(data);
				}
				$('#tambahjadwal').modal('hide');
				$('#bodyreset').load(location.href + ' #bodyreset');
				window.setTimeout(function(){location.reload()},1000);
			}
		});
  return false;
});

 $("#login").change(function() {
 	var a = $(this).val();
 	var b = $(this).data('id');
 	if(a==1){ var ca = 'Di Aktifkan';}
 	else if(a==2){ var ca = 'Di Automatis';}
 	else{ var ca =" Di Non Aktifkan"; }
 	$.ajax({
 		data :{data:a,id:b},
 		url: 'jadwalaktivasi.php?setting=ganti',
 		type: "POST",
 		success: function(respon) {
			console.log(respon);
 			if(respon==1){
 				toastr.success('Catat Login Berhasil '+ca);
 			}
 			else{
 				toastr.error('Gagal');
 			}

 		}
 	});
 	return false;

 });
 $(document).on('click', '#cache_jadwal', function() {
 	$.ajax({
 		url: '<?= $homeurl; ?>/server_api/index.php/Cache',
 		success: function(data) {
 			if(data.status == true){
 				alert("Horee Cache Soal Berhasil Di Bersihkan")
 			}
 		}
 	});
 });
 $(document).on('change', '#mode_jawab', function() {
 	let a = $(this).val();
 	let b = $(this).data("id");
 	if(a==1){ var ca = ' Kirim Setelah Selesai Ujian';}
 	else{ var ca =" Kirim Ke Server Langsung"; }

 	$.ajax({
 		data :{data:a,id:b},
 		url: 'jadwalaktivasi.php?setting=mode_jawab',
 		type: "POST",
 		success: function(respon) {
 			if(respon==1){
 				toastr.success('Jawaban '+ca+" Aktif");
 			}
 			else{
 				toastr.error('Gagal');
 			}

 		}
 	});

 });
</script>
