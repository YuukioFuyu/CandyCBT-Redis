<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<?php

if ($ac == '') :
?>
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid '>
				<div class='box-header with-border '>
					<h3 class='box-title'><i class='fa fa-briefcase'></i> Data Bank Soal</h3>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<div id='tablereset' class='table-responsive'>
						<table id='example1' class='table table-bordered table-striped'>
							<thead>
								<tr>
									<th width='5px'><input type='checkbox' id='ceksemua'></th>
									<th width='5px'>#</th>
									<th>Mata Pelajaran</th>
									<th>Soal PG</th>
									<th>Soal Esai</th>
									<th>Kelas</th>
									<th>Guru</th>
									<th>Status</th>
									<?php if ($setting['server'] == 'pusat') : ?>
										<th>Aksi</th>
									<?php endif ?>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($pengawas['level'] == 'admin') :
									$mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY date ASC");
								elseif ($pengawas['level'] == 'guru') :
									$mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel WHERE idguru='$pengawas[id_pengawas]' ORDER BY date ASC");
								endif;
								?>
								<?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
									<?php
									$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$mapel[id_mapel]'"));
									$no++;
									?>
									<tr>
										<td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-$no' value="<?= $mapel['id_mapel'] ?>"></td>
										<td><?= $no ?></td>
										<td>
											<?php
											if ($mapel['idpk'] == 'semua') :
												$jur = 'Semua';
											else :
												$jur = $mapel['idpk'];
											endif;
											?>
											<b><small class='label bg-purple'><?= $mapel['nama'] ?></small></b>
											<small class='label label-primary'><?= $mapel['level'] ?></small>
											<small class='label label-primary'><?= $jur ?></small>
										</td>
										<td>
											<small class='label label-warning'><?= $mapel['tampil_pg'] ?>/<?= $mapel['jml_soal'] ?></small>
											<small class='label label-danger'><?= $mapel['bobot_pg'] ?> %</small>
											<small class='label label-danger'><?= $mapel['opsi'] ?> opsi</small>
										</td>
										<td>
											<small class='label label-warning'><?= $mapel['tampil_esai'] ?>/<?= $mapel['jml_esai'] ?></small>
											<small class='label label-danger'><?= $mapel['bobot_esai'] ?> %</small>
										</td>
										<td>
											<?php
											$dataArray = unserialize($mapel['kelas']);
											foreach ($dataArray as $key => $value) :
												echo "<small class='label label-success'>$value </small>&nbsp;";
											endforeach;
											?>
										</td>
										<?php
										if ($cek <> 0) {
											if ($mapel['status'] == '0') :
												$status = '<label class="label label-danger">non aktif</label>';
											else :
												$status = '<label class="label label-success"> aktif </label>';
											endif;
										} else {
											$status = '<label class="label label-warning"> Soal Kosong </label>';
										}
										$guruku = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE id_pengawas = '$mapel[idguru]'"));
										?>
										<td>
											<small class='label label-primary'><?= $guruku['nama'] ?></small>
										</td>
										<td style="text-align:center">
											<?= $status ?>
										</td>
										<?php if ($setting['server'] == 'pusat') : ?>
											<td style="text-align:center">
												<div class=''>
													<a title="Lihat Soal" href='?pg=<?= $pg ?>&ac=lihat&idmapel=<?= $mapel['id_mapel'] ?>'><button class='btn btn-flat btn-success btn-flat btn-xs'><i class='fa fa-search'></i></button></a>
													
													
												</div>
											</td>
											
										<?php endif ?>
									</tr>
									<!-- edit bang soal mryes -->
									<div class='modal fade' id='editbanksoal<?= $mapel['id_mapel'] ?>' style='display: none;'>
										<div class='modal-dialog'>
											<div class='modal-content'>
												<div class='modal-header bg-blue'>
													<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
													<h3 class='modal-title'>Edit Bank Soal</h3>
												</div>
												<form action='' method='post'>
													<div class='modal-body'>
														<input type='hidden' id='idm' name='idm' value='<?= $mapel['id_mapel'] ?>' />
														<div class='form-group'>
															<label>Mata Pelajaran</label>
															<select name='nama' class='form-control' required='true'>
																<option value=''></option>
																<?php
																$pkQ = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran ORDER BY nama_mapel ASC");
																while ($pk = mysqli_fetch_array($pkQ)) : ($pk['kode_mapel'] == $mapel['nama']) ? $s = 'selected' : $s = '';
																	echo "<option value='$pk[kode_mapel]' $s>$pk[nama_mapel]</option>";
																endwhile;
																?>
															</select>
														</div>
														<?php if ($setting['jenjang'] == 'SMK') : ?>
															<div class='form-group'>
																<label>Program Keahlian</label>
																<select name='id_pk' class='form-control' required='true'>
																	<option value='semua'>Semua</option>
																	<?php
																	$pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
																	while ($pk = mysqli_fetch_array($pkQ)) : ($pk['id_pk'] == $mapel['idpk']) ? $s = 'selected' : $s = '';
																		echo "<option value='$pk[id_pk]' $s>$pk[program_keahlian]</option>";
																	endwhile;
																	?>
																</select>
															</div>
														<?php endif; ?>
														<div class='form-group'>
															<div class='row'>
																<div class='col-md-6'>
																	<label>Pilih Level</label>
																	<select name='level' class='form-control'>
																		<option value='semua'>Semua Level</option>
																		<?php
																		$lev = mysqli_query($koneksi, "SELECT * FROM level");
																		while ($level = mysqli_fetch_array($lev)) : ($level['kode_level'] == $mapel['level']) ? $s = 'selected' : $s = '';
																			echo "<option value='$level[kode_level]' $s>$level[kode_level]</option>";
																		endwhile;
																		?>
																	</select>
																</div>
																<div class='col-md-6'>
																	<label>Pilih Kelas</label><br>
																	<select name='kelas[]' class='form-control select2 ' style='width:100%' multiple required='true'>
																		<option value='semua'>Semua Kelas</option>
																		<option value='khusus'>Khusus</option>
																		<?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
																		<?php while ($kelas = mysqli_fetch_array($lev)) : ?>
																			<?php if (in_array($kelas['id_kelas'], unserialize($mapel['kelas']))) : ?>
																				<option value="<?= $kelas['id_kelas'] ?>" selected><?= $kelas['id_kelas'] ?></option>"
																				<?php else : ?>
																					<option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
																				<?php endif; ?>
																			<?php endwhile ?>
																		</select>
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
																				<?php if (in_array($kelas['id_siswa'], unserialize($mapel['kelas']))) : ?>
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
																			<label>Jumlah Soal PG</label>
																			<input type='number' name='jml_soal' class='form-control' value="<?= $mapel['jml_soal'] ?>" required='true' />
																		</div>
																		<div class='col-md-3'>
																			<label>Bobot Soal PG %</label>
																			<input type='number' name='bobot_pg' class='form-control' value="<?= $mapel['bobot_pg'] ?>" required='true' />
																		</div>
																		<div class='col-md-3'>
																			<label>Soal Tampil</label>
																			<input type='number' name='tampil_pg' class='form-control' value="<?= $mapel['tampil_pg'] ?>" required='true' />
																		</div>
																		<div class='col-md-3'>
																			<label>Opsi</label>
																			<select name='opsi' class='form-control'>
																				<?php
																				$opsi = array("3", "4", "5");
																				for ($x = 0; $x < count($opsi); $x++) {
																					if ($mapel['opsi'] == $opsi[$x]) :
																						echo "<option value='$opsi[$x]' selected>$opsi[$x]</option>";
																					else :
																						echo "<option value='$opsi[$x]'>$opsi[$x]</option>";
																					endif;
																				}
																				?>
																			</select>
																		</div>
																	</div>
																</div>
																<div class='form-group'>
																	<div class='row'>
																		<div class='col-md-4'>
																			<label>Jumlah Soal Essai</label>
																			<input type='number' name='jml_esai' class='form-control' value="<?= $mapel['jml_esai'] ?>" required='true' />
																		</div>
																		<div class='col-md-4'>
																			<label>Bobot Soal Essai %</label>
																			<input type='number' name='bobot_esai' class='form-control' value="<?= $mapel['bobot_esai'] ?>" required='true' />
																		</div>
																		<div class='col-md-4'>
																			<label>Soal Tampil</label>
																			<input type='number' name='tampil_esai' class='form-control' value="<?= $mapel['tampil_esai'] ?>" required='true' />
																		</div>
																	</div>
																</div>
																<div class='form-group'>
																	<div class='row'>
																		<?php if ($pengawas['level'] == 'admin') : ?>
																			<div class='col-md-6'>
																				<label>Guru Pengampu</label>
																				<select name='guru' class='form-control' required='true'>
																					<?php
																					$guruku = mysqli_query($koneksi, "SELECT * FROM pengawas where level='guru' order by nama asc");
																					while ($guru = mysqli_fetch_array($guruku)) {
																						($guru['id_pengawas'] == $mapel['idguru']) ? $s = 'selected' : $s = '';
																						echo "<option value='$guru[id_pengawas]' $s>$guru[nama]</option>";
																					}
																					?>
																				</select>
																			</div>
																		<?php endif; ?>
																		<div class='col-md-6'>
																			<label>Status Soal</label>
																			<select name='status' class='form-control' required='true'>
																				<option value='1'>Aktif</option>
																				<option value='0'>Non Aktif</option>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															<div class='modal-footer'>
																<button type='submit' name='editbanksoal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>

															</div>
														</form>
													</div>
												</div>
											</div>
										<?php endwhile; ?>
									</tbody>
								</table>
							</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
			</div>

			<?php 
elseif($ac=='lihat') :
	$id_mapel = $_GET['idmapel'];								
	?>
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Analisis Soal</h3>
					<div class='box-tools pull-right btn-group'>
						<button class='btn btn-sm btn-info' onclick="window.print()"><i class='fa fa-print'></i> Print</button>
						<!-- href='report_excel_analisis.php?m=$id_mapel&k=$id_kelas' -->
						<!-- id="down_excel" -->
						<a  href="anso_excel.php?idmapel=<?= $id_mapel; ?>"  class='btn btn-sm btn-success' ><i class='fa fa-file-excel'></i> Excel</a>
						<a class='btn btn-sm btn-danger' href='?pg=anso'><i class='fa fa-times'></i> Keluar</a>
					</div>
				</div>
				<div class='box-body' id="tbabsenday" >
					<table class='table table-bordered table-striped'> 
						<?php 
						$data_soal = $db->v_anso2($id_mapel);
						foreach ($data_soal as $d) {
							?>
							<tr>
								<th width='100'>Mapel</th>
								<td >:</td>
								<td><?=  $d['nama'];?></td>
								<td width='150' align='center'>Nilai Rata-Rata</td>
							</tr>
							<tr>
								<th>Tingkat</th>
								<td width='10'>:</td>
								<td><?=  $d['level'];?></td>
								<td rowspan='3' width='150' align='center' style='text-align: center; vertical-align:middle;'>
									<span style='font-size:40px' class='text-bold badge bg-green'>
										<?php $nilai = $db->nilairata2($id_mapel); echo $nilai; ?>		
									</span>
								</td>
							</tr>
							<tr>
								<th>Jurusan</th>
								<td width='10'>:</td>
								<td><?= $d['idpk'];?></td>
							</tr>
							<tr>
								<th>Kelas</th>
								<td width='10'>:</td>
								<td>
									<?php 
									$dataArray = unserialize($d['kelas']);
									foreach ($dataArray as $key => $value) {
										echo "<small class='label label-success'>$value</small>&nbsp;";
									}
									?>	
								</td>
							</tr>
						<?php } ?>
					</table>
					<br>
					<div class='table-responsive'>
						<table class='table table-bordered table-striped'>
							<thead>
								<tr>
									<th width='5px'>No</th>
									<th>Soal Pilihan Ganda</th>
									<th>Jawaban Benar</th>
									<th style='text-align:center;'>Responden</th>
									<th style='text-align:center'>Benar</th>	
									<th style='text-align:center'>Salah</th>	
									<th style='text-align:center'>Indikator</th>												
									<th style='text-align:center'>Analisis</th>					
								</tr>
							</thead>
							<tbody>
								<?php 
								$data1 = $db->v_anso1($id_mapel);
								foreach ($data1 as $value) {

									if ($value['file'] == '') {
										$gambar = '';
									} else {
										$gambar = "<img src='$homeurl/files/$value[file]' class='img-responsive' style='max-width:30px;'/><p>";
									}
									if ($value['file1'] == '') {
										$gambar2 = '';
									} else {
										$gambar2 = "<img src='$homeurl/files/$value[file1]' class='img-responsive' style='max-width:30px;'/><p>";
									}

									?>
									<tr>
										<td><?= $value['nomor'] ?></td>
										<td><?= $gambar ?> <?= $gambar2 ?><?= $value['soal'] ?></td>
										<td style='text-align:center;'><?= $value['jawaban'] ?></td>
										<td style='text-align:center;'>
											<?php
											$no=0;
											$bener=$salah=0;
											$data2 = $db->v_anso_soal($id_mapel);

											foreach ($data2 as $value2) {
												$pecah= unserialize($value2);
												foreach ($pecah as $key3 => $value3) {
													if($value['id_soal']==$key3){
																$no++; //jika id_soal sama maka tambah jumlah responden
																if($value['jawaban']==$value3){
																	$bener++; //jika id jawaban benar maka tamaba nilai benar
																}
																else{
																	$salah++; //jika id jawaban salah
																}
															}

														}	
													}
													echo $no;
													?>	
												</td>
												<td style='text-align:center;'>
													<?= $bener; ?>
												</td>
												<td style='text-align:center;'><?= $salah ?></td>
												<td style='text-align:center;'><?= $total_bener = floor(($bener/$no)*100).' %'; ?></td>
												<td><?php 
												if($total_bener <= 30){ $hasil = "<span class='label label-danger'>Sulit</span>"; } 
												elseif($total_bener <= 70){ $hasil = "<span class='label label-warning'>Sedang</span>"; }
												elseif($total_bener >= 71){ $hasil = "<span class='label label-primary'>Mudah</span>"; }
												else{ }
													echo $hasil;
												?>

											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
							<iframe name='frameresult' src='reportanso.php?m=$id_mapel' style='border:none;width:1px;height:1px;'></iframe>
						</div>
					</div>
			</div>
		</div>
	</div>


<?php endif; ?>
<script type="text/javascript">
	$(document).on('click','#down_excel',function(){
		$("#tbabsenday").table2excel({
        //filename: "data_absen_<?php echo $bulan; ?>" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
        filename: "data_analisi_soal_<?php echo $d['nama']; ?>.xls",
        fileext: ".xls",
        //preserveColors: preserveColors,
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
        
      });
 
	});

</script>

