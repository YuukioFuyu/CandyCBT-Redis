<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border '>
				<h3 class='box-title'> Berita Acara</h3>
				<div class='box-tools pull-right '>
					<?php if ($pengawas['level'] == 'admin') : ?>
						<!-- <button id='buatberita' class='btn btn-sm btn-flat btn-success'><i class='fa fa-refresh'></i> Generate</button> -->
					<?php endif ?>
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<!-- mryes -->
				<div class="row" style="padding-bottom: 10px;">
					<div class="col-md-12">
						<a class="btn btn-primary" data-toggle='modal' data-backdrop='static' data-target="#bcmanual"><i class="fa fa-plus"></i> Buat Manual Berita Acara</a>
						<button class="btn btn-danger" id="hapus_bc"><i class="fa fa-trash"></i> Hapus Bersih Berita Acara </button>
					</div>
				</div>
				<!-- /mryes -->
				<div id='tableberita' class='table-responsive'>
					<table class='table table-bordered table-striped  table-hover'>
						<thead>
							<tr>
								<th width='5px'>#</th>
								<th>Mapel/Ujian/Kode Bank Soal</th>
								<th>Level/Jur/Kelas</th>
								<th>Sesi</th>
								<th>Ruang</th>
								<th>Hadir</th>
								<th>Tidak Hadir</th>
								<th>Mulai</th>
								<th>Selesai</th>
								<th>Pengawas</th>
								<th width='50px'></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$beritaQ = mysqli_query($koneksi, "SELECT * FROM berita");
							?>
							<?php while ($berita = mysqli_fetch_array($beritaQ)) : ?>
								<?php
								$mapel = mysqli_fetch_array(mysqli_query($koneksi, "select * from mapel a left join mata_pelajaran b ON a.KodeMapel=b.kode_mapel where a.id_mapel='$berita[id_mapel]'"));
								$no++
								?>
								<tr>
									<td><?= $no ?></td>
									<td>
										<b><small class='label bg-purple'><?= $mapel['nama_mapel'] ?></small></b> <small class='label bg-red'><?= $berita['jenis'] ?></small> <small class='label label-primary'><?= $mapel['nama'] ?></small>
									</td>
									<td>
										<small class='label label-primary'><?= $mapel['level'] ?></small>
										<small class='label label-primary'><?= $mapel['idpk'] ?></small>
										<?php
										$dataArray = unserialize($mapel['kelas']);
										foreach ($dataArray as $key => $value) {
											echo "<small class='label label-success'>$value </small>&nbsp;";
										}
										?>
									</td>
									<td style="text-align:center">
										<b><small class='label bg-purple'><?= $berita['sesi'] ?></small></b>
									</td>
									<td style="text-align:center">
										<small class='label bg-green'><?= $berita['ruang'] ?></small>
									</td>
									<td style="text-align:center">
										<?= $berita['ikut'] ?>
									</td>
									<td style="text-align:center">
										<?= $berita['susulan'] ?>
									</td>
									<td style="text-align:center">
										<?= $berita['mulai'] ?>
									</td>
									<td style="text-align:center">
										<?= $berita['selesai'] ?>
									</td>
									<td>
										<?= $berita['nama_pengawas'] ?>
									</td>
									<td style="text-align:center">
										<div class=''>
											<a class='btn btn-flat btn-success btn-flat btn-xs' data-toggle='modal' data-backdrop='static' data-target="#print<?= $berita['id_berita'] ?>"><i class='glyphicon glyphicon-print'></i></a>
										</div>
									</td>
								</tr>
								<?php
								if (isset($_POST['print'])) {
									$idberita = $_POST['idu'];
									$tglujian = $_POST['tgl_ujian'];
									$hadir = $_POST['hadir'];
									$tidakhadir = $_POST['tidakhadir'];
									$mulai = $_POST['mulai'];
									$selesai = $_POST['selesai'];
									$pengawas = $_POST['nama_pengawas'];
									$nippengawas = $_POST['nip_pengawas'];
									$proktor = $_POST['nama_proktor'];
									$nipproktor = $_POST['nip_proktor'];
									$catatan = $_POST['catatan'];
									$nosusulan = serialize($_POST['nosusulan']);
									$exec = mysqli_query($koneksi, "UPDATE berita SET ikut='$hadir',susulan='$tidakhadir',mulai='$mulai',selesai='$selesai',nama_pengawas='$pengawas',nip_pengawas='$nippengawas', nama_proktor='$proktor',nip_proktor='$nipproktor',catatan='$catatan',tgl_ujian='$tglujian',no_susulan='$nosusulan' WHERE id_berita='$idberita'");
									(!$exec) ? $info = info("Gagal menyimpan!", "NO") : jump("?pg=beritaacara&id=$idberita");
								}
								?>
								<div class='modal fade' id="print<?= $berita['id_berita'] ?>" style='display: none;'>
									<div class='modal-dialog'>
										<div class='modal-content'>
											<div class='modal-header bg-olive'>
												<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
												<h4 class='modal-title'><img src='../dist/img/svg/print.svg' width='20'> Print Berita Acara</h4>
											</div>
											<div class='modal-body'>
												<form action='' method='post'>
													<div class='col-md-4'>
														<div class='form-group'>
															<label>Nama Ujian</label>
															<input type='text' name='namamapel' value="<?= $mapel['nama'] ?>" class='form-control' disabled />
														</div>
													</div>
													<div class='col-md-4'>
														<div class='form-group'>
															<label>Sesi</label>
															<input type='text' name='sesi' value="<?= $berita['sesi'] ?>" class='form-control' disabled />
														</div>
													</div>
													<div class='col-md-4'>
														<div class='form-group'>
															<label>Ruang</label>
															<input type='text' name='ruang' value="<?= $berita['ruang'] ?>" class='form-control' disabled />
														</div>
													</div>
													<div class='col-md-4'>
														<div class='form-group'>
															<label>Tanggal Ujian</label>
															<input name='tgl_ujian' value="<?= $berita['tgl_ujian'] ?>" class='datepicker form-control' autocomplete=off />
														</div>
													</div>
													<div class='col-md-2'>
														<div class='form-group'>
															<label>Mulai</label>
															<input id='waktumulai' type='text' name='mulai' value="<?= $berita['mulai'] ?>" class='timer form-control' autocomplete=off />
														</div>
													</div>
													<div class='col-md-2'>
														<div class='form-group'>
															<label>Selesai</label>
															<input id='waktumulai' type='text' name='selesai' value="<?= $berita['selesai'] ?>" class='timer form-control' autocomplete=off />
														</div>
													</div>
													<div class='col-md-2'>
														<div class='form-group'>
															<label>Hadir</label>
															<input type='number' name='hadir' value="<?= $berita['ikut'] ?>" class='form-control' required='true' />
														</div>
													</div>
													<div class='col-md-2'>
														<div class='form-group'>
															<label>Absen</label>
															<input type='number' name='tidakhadir' value="<?= $berita['susulan'] ?>" class='form-control' required='true' />
														</div>
													</div>
													<div class='col-md-12'>
														<div class='form-group'>
															<label>Siswa Tidak Hadir</label><br>
															<select name='nosusulan[]' class='form-control select2' multiple='multiple' style='width:100%'>
																<?php
																$bruang = $berita['ruang'];
																$bsesi = $berita['sesi'];
																$lev = mysqli_query($koneksi, "SELECT * FROM siswa where ruang='$bruang' and sesi='$bsesi' ORDER BY nama ASC");
																while ($siswa = mysqli_fetch_array($lev)) {
																	echo "<option value='$siswa[no_peserta]'>$siswa[no_peserta] $siswa[nama]</option>";
																}
																?>
															</select>
														</div>
													</div>
													<div class='col-md-6'>
														<div class='form-group'>
															<label>Nama Proktor</label>
															<input type='text' name='nama_proktor' value="<?= $berita['nama_proktor'] ?>" class='form-control' required='true' />
														</div>
													</div>
													<div class='col-md-6'>
														<div class='form-group'>
															<label>NIP Proktor</label>
															<input type='text' name='nip_proktor' value="<?= $berita['nip_proktor'] ?>" class='form-control' required='true' />
														</div>
													</div>
													<div class='col-md-6'>
														<div class='form-group'>
															<label>Nama Pengawas</label>
															<input type='text' name='nama_pengawas' value="<?= $berita['nama_pengawas'] ?>" class='form-control' required='true' />
														</div>
													</div>
													<div class='col-md-6'>
														<div class='form-group'>
															<label>NIP Pengawas</label>
															<input type='text' name='nip_pengawas' value="<?= $berita['nip_pengawas'] ?>" class='form-control' required='true' />
														</div>
													</div>
													<div class='col-md-12'>
														<div class='form-group'>
															<label>Catatan</label>
															<textarea type='text' name='catatan' class='form-control' required='true'><?= $berita['catatan'] ?></textarea>
														</div>
													</div>
													<input type='hidden' id='idm' name='idu' value="<?= $berita['id_berita'] ?>" />
													<div class='modal-footer'>
														<div class='box-tools pull-right '>
															<button type='submit' name='print' class='btn btn-sm btn-flat btn-success'><i class='fa fa-print'></i> Print</button>
															<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							<?php endwhile ?>
						</tbody>
					</table>
					<!-- mryes modal berita acara manual -->
					<div class='modal fade' id="bcmanual" style='display: none;'>
						<div class='modal-dialog'>
							<div class='modal-content'>
								<div class='modal-header bg-olive'>
									<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
									<h4 class='modal-title'><img src='../dist/img/svg/print.svg' width='20'> Tambah Print Berita Acara Manual</h4>
								</div>
								<div class='modal-body'>
									<form action='' method='post' id="bc_post">
										<div class='col-md-3'>
											<div class='form-group'>
												<label>Nama Ujian</label>
												<select class="form-control" name="id_ujian">
													<?php $ujian = mysqli_query($koneksi, "select * from ujian"); ?>
													<option>Jadwal</option>
													<?php while ($uj = mysqli_fetch_array($ujian)) : ?>
														<option value="<?= $uj['id_mapel'] ?>"><?= $uj['nama'] ?></option>
													<?php endwhile; ?>
												</select>
											</div>
										</div>
										<div class='col-md-3'>
											<div class='form-group'>
												<label>Sesi</label>
												<select class="form-control" name="sesi">
													<option>Sesi</option>
													<?php $sesi = mysqli_query($koneksi, "select * from sesi"); ?>
													<?php while ($ses = mysqli_fetch_array($sesi)) : ?>
														<option value="<?= $ses['kode_sesi'] ?>"><?= $ses['nama_sesi'] ?></option>
													<?php endwhile; ?>
												</select>
											</div>
										</div>
										<div class='col-md-3'>
											<div class='form-group'>
												<label>Ruang</label>
												<select class="form-control" name="ruang">
													<option>Ruang</option>
													<?php $ruang = mysqli_query($koneksi, "select * from ruang"); ?>
													<?php while ($ru = mysqli_fetch_array($ruang)) : ?>
														<option value="<?= $ru['kode_ruang'] ?>"><?= $ru['keterangan'] ?></option>
													<?php endwhile; ?>
												</select>
											</div>
										</div>
										<div class='col-md-3'>
											<div class='form-group'>
												<label>Kode Ujian</label>
												<select class="form-control" name="kode_ujian">
													<option>Ujian</option>
													<?php $ruang = mysqli_query($koneksi, "select * from jenis where status='aktif'"); ?>
													<?php while ($ru = mysqli_fetch_array($ruang)) : ?>
														<option value="<?= $ru['id_jenis'] ?>"><?= $ru['nama'] ?></option>
													<?php endwhile; ?>
												</select>
											</div>
										</div>
										<div class='col-md-4'>
											<div class='form-group'>
												<label>Tanggal Ujian</label>
												<input name='tgl_ujian' value="<?= $berita['tgl_ujian'] ?>" class='datepicker form-control' autocomplete=off />
											</div>
										</div>
										<div class='col-md-2'>
											<div class='form-group'>
												<label>Mulai</label>
												<input id='waktumulai' type='text' name='mulai' value="<?= $berita['mulai'] ?>" class='timer form-control' autocomplete=off />
											</div>
										</div>
										<div class='col-md-2'>
											<div class='form-group'>
												<label>Selesai</label>
												<input id='waktumulai' type='text' name='selesai' value="<?= $berita['selesai'] ?>" class='timer form-control' autocomplete=off />
											</div>
										</div>
															<!-- <div class='col-md-2'>
																<div class='form-group'>
																	<label>Hadir</label>
																	<input type='number' name='hadir' value="<?= $berita['ikut'] ?>" class='form-control' required='true' />
																</div>
															</div>
															<div class='col-md-2'>
																<div class='form-group'>
																	<label>Absen</label>
																	<input type='number' name='tidakhadir' value="<?= $berita['susulan'] ?>" class='form-control' required='true' />
																</div>
															</div> -->
															<!-- <div class='col-md-12'>
																<div class='form-group'>
																	<label>Siswa Tidak Hadir (ISI MANUAL YO ^_^)</label><br>
																	<select disabled name='nosusulan[]' class='form-control select2' multiple='multiple' style='width:100%'>
																		<?php
																		$bruang = $berita['ruang'];
																		$bsesi = $berita['sesi'];
																		$lev = mysqli_query($koneksi, "SELECT * FROM siswa where ruang='$bruang' and sesi='$bsesi' ORDER BY nama ASC");
																		while ($siswa = mysqli_fetch_array($lev)) {
																			echo "<option value='$siswa[no_peserta]'>$siswa[no_peserta] $siswa[nama]</option>";
																		}
																		?>
																	</select>
																</div>
															</div> -->
															<div class='col-md-6'>
																<div class='form-group'>
																	<label>Nama Proktor</label>
																	<input type='text' name='nama_proktor' value="<?= $berita['nama_proktor'] ?>" class='form-control' required='true' />
																</div>
															</div>
															<div class='col-md-6'>
																<div class='form-group'>
																	<label>NIP Proktor</label>
																	<input type='text' name='nip_proktor' value="<?= $berita['nip_proktor'] ?>" class='form-control' required='true' />
																</div>
															</div>
															<div class='col-md-6'>
																<div class='form-group'>
																	<label>Nama Pengawas</label>
																	<input type='text' name='nama_pengawas' value="<?= $berita['nama_pengawas'] ?>" class='form-control' required='true' />
																</div>
															</div>
															<div class='col-md-6'>
																<div class='form-group'>
																	<label>NIP Pengawas</label>
																	<input type='text' name='nip_pengawas' value="<?= $berita['nip_pengawas'] ?>" class='form-control' required='true' />
																</div>
															</div>
															<div class='col-md-12'>
																<div class='form-group'>
																	<label>Catatan</label>
																	<textarea type='text' name='catatan' class='form-control' required='true'><?= $berita['catatan'] ?></textarea>
																</div>
															</div>
															<!-- <input type='hidden' id='idm' name='idu' value="<?= $berita['id_berita'] ?>" /> -->
															<div class='modal-footer'>
																<div class='box-tools pull-right '>
																	<button id='buatberita2' type='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-print'></i> Print</button>
																	<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<!-- mryes modal berita acara manual -->
									</div>
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div>
					</div>	