<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<?php if ($ac == '') : ?>
	<?php
	$id_mapel = $_GET['id'];//ini id ujian
	
	//mryes
	if(empty($_GET['kelas'])){
		$id_kls = "";
	}
	else{
		$id_kls = $_GET['kelas'];
		$downlaod = "report_excel.php?m=".$id_mapel."&kls=".$id_kls;
	}	
	if(empty($_GET['jrs'])){
		$id_jrs = ""; 
	}
	else{
		$id_jrs = $_GET['jrs'];
		$downlaod = "report_excel.php?m=".$id_mapel."&jrs=".$id_jrs;
	}	


	$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$id_mapel'"));
	$kelas = unserialize($mapel['kelas']);

	$kelas = implode("','", $kelas);
	$sqlkelas = "";
	if (!$kelas == 'semua') {
		$sqlkelas = " and a.id_kelas in ('" . $kelas . "')";
	}
	
	$level =$mapel['level'];
	$sqllevel = "";
	if (!$level == 'semua') {
		$sqlkelas = "where a.level='" . $level . "'";
	}
	?>
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'> NILAI <?= $mapel['nama'] ?></h3>
					<div class='box-tools pull-right btn-grou'>
						<!-- <button class='btn btn-sm btn-primary' onclick="frames['frameresult'].print()"><i class='fa fa-print'></i> Print</button> -->
						<span>Dowonload Nilai (Semua) Per Mapel </span>
						<a class='btn btn-sm btn-success' href='report_excel.php?m=<?= $id_mapel ?>'><i class='fa fa-download'></i> Download Excel</a>
						<a class='btn btn-sm btn-danger' href='?pg=jadwal'><i class='fa fa-times'></i></a>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<div class='table-responsive'>
						<div class="row" style="padding-bottom: 10px;">
							<div class="col-md-12"><i>Silahkan Tampil Nilai Berdasarkan Kelas atau Jurusan Pilih Salah Satu | Pilih Jadwal </i></div>
						</div>
						<div class="row" style="padding-bottom: 10px;">
						<!-- mryes -->
						<?php if($setting['jenjang']=='SMK'): ?>
						<div class="col-md-3">
							<select class="form-control select2 jurusan">
								<?php $jurusan = $db->v_jurusan($id=null); ?>
								<option value=""> Pilih Jurusan</option>
								<?php foreach ($jurusan as $jrs) : ?>
									<option <?php if($id_jrs==$jrs['id_pk']){ echo "selected";}else{} ?> value="<?= $jrs['id_pk'] ?>"><?= $jrs['program_keahlian'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<?php else : ?>
							<select class="jurusan" style="display: none;">
								<option value="" selected="selected"></option>
							</select>
						<?php endif ?>
						<div class="col-md-3">
							<select class="form-control select2 kelas">
								<?php $kelas = $db->v_kelas($id=null); ?>
									<option value=""> Pilih Kelas</option>
									<?php foreach ($kelas as $value) : ?>
										<option <?php if($id_kls==$value['id_kelas']){ echo "selected";}else{} ?>  value="<?= $value['id_kelas'] ?>"><?= $value['nama'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-3">
							<select class="form-control select2 ujian">
								<?php $ujian = $db->v_jadwal(); ?>
								<option> Pilih Jadwal</option>
								<?php foreach ($ujian as $uj) : ?>
									<option <?php if($id_mapel==$uj['id_ujian']){ echo "selected";}else{} ?> value="<?= $uj['id_ujian'] ?>"><?= $uj['nama'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-3">
						<button id="cari_nilai" class="btn btn-primary">Cari Nilai</button>
						<?php 
						if(!empty($id_mapel)){ ?>
							<!-- <button id="down_excel" class="btn btn-warning"><i class="fa fa-download"></i> Download Excel </button> -->
							<a href="<?= $downlaod; ?>" class="btn btn-warning"><i class="fa fa-download"></i> Download Excel </a>
						<?php } ?>
						</div>
						<!-- mryes -->
					</div>
						<table id="tablenilai" class='table table-bordered table-striped'>
							<thead>
								<tr>
									<th width='5px'>#</th>
									<th>No Peserta</th>
									<th>Nama</th>
									<th>Kelas</th>
									<th>Mapel</th>
									<th>Lama Ujian</th>
									<th>B</th>
									<th>S</th>
									<th>Nilai PG</th>
									<th>Essai</th>
									<th>Total</th>
									<th>Jawaban</th>
								</tr>
							</thead>
							<tbody>
								<?php 

								$siswaQ = $db->Tampil_nilai2(); 
								

								while ($siswa = mysqli_fetch_array($siswaQ)) :
									//mapel------------------------
									

									$no++;
									$ket = '';
									$esai =  $jawaban = $skor = $total = '--';
									$selisih = 0;
									
									$id_siswa = $siswa['id_siswa'];
									$nilaiQ = $db->Tampil_nilai3($id_siswa);

									$nilaiC = mysqli_num_rows($nilaiQ);
									$nilai = mysqli_fetch_array($nilaiQ);
									$mapel2= $db->v_mapel($nilai['id_mapel']);
									foreach ($mapel2 as $value) {
										$mapel3= $value['nama'];
									}

									if ($nilaiC <> 0) :
										$selisih = '';
										if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') :
											$selisih = strtotime($nilai['ujian_selesai']) - strtotime($nilai['ujian_mulai']);

											$esai = "$nilai[nilai_esai]";
											$jawabanb = "<small class='label bg-green'>$nilai[jml_benar] <i class='fa fa-check'></i></small>";
											$jawabans = "<small class='label bg-red'>$nilai[jml_salah] <i class='fa fa-times'></i></small>";
											$skor = number_format($nilai['skor'], 2, '.', '');
											$nilai_esai = number_format($nilai['nilai_esai'], 2, '.', '');
											$totalall = $skor + $nilai_esai;
											$total = "<small class='label bg-blue'>" . number_format($totalall, 2, '.', '') . "</small>";
											$ket = "";
										elseif ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] == '') :
											$selisih = strtotime($nilai['ujian_berlangsung']) - strtotime($nilai['ujian_mulai']);

											$ket = "<i class='fa fa-spin fa-spinner' title='Sedang ujian'></i>";
											$skor = $total = '--';
										endif;
									endif;
									?>
									<tr>
										<td><?= $no ?></td>
										<td><?= $siswa['no_peserta'] ?></td>
										<td><?= $siswa['nama'] ?></td>
										<td><?= $siswa['id_kelas'] ?></td>
										<td><?= $mapel3; ?></td>
										<td><?= $ket . " " . lamaujian($selisih) ?></td>
										<td><?= $jawabanb ?></td>
										<td><?= $jawabans ?></td>
										<td><?= $skor ?></td>
										<td><?= $esai ?></td>
										<td><?= $total ?></td>
										<td>
											<?php if ($nilai['skor'] <> "") : ?>
												<?php

												if ($nilai['jawaban'] <> "") :
													$ket = '';
													$link = "?pg=" . $pg . "&ac=esai&id=" . $_GET['id'] . "&ids=" . $siswa['id_siswa'];
													$link2 = "?pg=" . $pg . "&ac=jawaban&id=" . $_GET['id'] .  "&ids=" . $siswa['id_siswa'];
												else :
													$ket = 'style="display:none"';
													$link = '#';
													$link2 = '#';
												endif;
												?>
												<!-- <a href='<?= $link ?>' class='btn btn-xs btn-success' <?= $ket ?>><i class='fa fa-pencil-square-o'></i>input esai</a> -->
												<a href='<?= $link2 ?>' class='btn btn-sm btn-success' <?= $ket ?>><i class='fa fa-eye'></i> lihat dan Esai</a>
												<button class='ulangnilai btn btn-sm btn-danger' data-id="<?= $nilai['id_nilai'] ?>" <?= $ket ?>><i class='fa fa-recycle'></i> Ulang</button>
											<?php endif; ?>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
						<iframe name='frameresult' src='report.php?m=<?= $id_mapel ?>&i=<?= $kode_ujian ?>&k=<?= $id_kelas ?>' style='border:none;width:1px;height:1px;'></iframe>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
<?php elseif ($ac == 'esai') :
	$tabel ='nilai_pindah';
	$id_mapel = $_GET['idm'];
	$id_kelas = $_GET['idk'];
	$id_siswa = $_GET['ids'];
	$kode_ujian = $_GET['idu'];
	$nilai = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM $tabel WHERE id_mapel='$id_mapel' AND id_siswa='$id_siswa' AND kode_ujian='$kode_ujian'"));
	if (isset($_POST['simpanesai'])) :
		$jml_data = count($_POST['idsoal']);
		$id_soal = $_POST['idsoal'];
		$nilaiesai = $_POST['nilaiesai'];
		$nilai = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM $tabel WHERE id_mapel='$id_mapel' AND id_siswa='$id_siswa' AND kode_ujian='$kode_ujian'"));
		for ($i = 1; $i <= $jml_data; $i++) :
			$exec = mysqli_query($koneksi, "UPDATE hasil_jawaban SET nilai_esai='" . $nilaiesai[$i] . "' WHERE id_soal='" . $id_soal[$i] . "' AND jenis='2' and id_mapel='$id_mapel' AND id_ujian='$nilai[id_ujian]' AND id_siswa='$id_siswa'");
			(!$exec) ? $info = info("Gagal menyimpan!", "NO") : jump("?pg=nilai&ac=esai&idu=$kode_ujian&idm=$id_mapel&idk=$id_kelas&ids=$id_siswa");
		endfor;
		$sqljumlah = mysqli_query($koneksi, "SELECT sum(nilai_esai) AS hasil FROM hasil_jawaban WHERE id_mapel='$id_mapel' AND id_siswa='$id_siswa' AND jenis='2'");
		$jumlah = mysqli_fetch_array($sqljumlah);
		$bobot = mysqli_fetch_array(mysqli_query($koneksi, "select * from mapel where id_mapel='$id_mapel'"));
		$nilai_esai1 = $jumlah['hasil'] * $bobot['bobot_esai'] / 100;
		$nilai_esai = number_format($nilai_esai1, 2, '.', '');
		$nilai_pg = number_format($nilai['skor'], 2, '.', '');
		$total = $nilai_esai + $nilai_pg;
		mysqli_query($koneksi, "UPDATE $tabel SET nilai_esai='$nilai_esai',total='$total' WHERE id_mapel='$id_mapel' and id_siswa='$id_siswa' and id_ujian='$nilai[id_ujian]'");
	endif;
	$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id_mapel'"));
?>
	<div class='row'>
		<div class='col-md-12'>
			<form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
				<div class='box box-primary'>
					<div class='box-header with-border'>
						<h3 class='box-title'>Nilai Essai <?= $mapel['nama'] ?></h3>
						<div class='box-tools pull-right btn-group'>
							<!--<button class='btn btn-sm btn-default' onclick=frames['frameresult'].print()><i class='fa fa-print'></i> Print</button>-->
							<!--<a class='btn btn-sm btn-success' href='report_excel.php?m=$id_mapel&k=$id_kelas'><i class='fa fa-download'></i> Excel</a>-->
							<button class='btn btn-sm btn-primary' name='simpanesai'><i class='fa fa-check'></i> Simpan</button>
							<a class='btn btn-sm btn-danger' href='?pg=nilai&ac=lihat&idu=<?= $kode_ujian ?>&idm=<?= $id_mapel ?>&idk=<?= $id_kelas ?>'><i class='fa fa-times'></i></a>
						</div>
					</div><!-- /.box-header -->
					<div class='box-body'>
						<div class='table-responsive'>
							<table class='table table-bordered table-striped'>
								<thead>
									<tr>
										<th width='5px'>#</th>
										<th>Soal & Jawaban</th>
										<th width='100px'>Input Nilai</th>
									</tr>
								</thead>
								<tbody>
									<?php $jawabanQ = mysqli_query($koneksi, "SELECT * FROM hasil_jawaban WHERE id_mapel='$id_mapel' and id_siswa='$id_siswa' and jenis='2' and id_ujian='$nilai[id_ujian]' "); ?>
									<?php while ($jawaban = mysqli_fetch_array($jawabanQ)) : ?>
										<?php
										$no++;
										$soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_soal='$jawaban[id_soal]' and jenis='2' and id_mapel='$id_mapel' "));
										if ($soal['file'] == '') {
											$gambar = '';
										} else {
											$gambar = "<img src='$homeurl/$soal[file]' class='img-responsive' style='max-width:300px;'/><p>";
										}
										if ($soal['file1'] == '') {
											$gambar2 = '';
										} else {
											$gambar2 = "<img src='$homeurl/$soal[file1]' class='img-responsive' style='max-width:300px;'/><p>";
										}
										?>
										<tr><input type='hidden' value='<?= $jawaban['id_soal'] ?>' name='idsoal[<?= $no ?>]'>
											<td><?= $no ?></td>
											<td><?= $gambar ?> <?= $gambar2 ?> <?= $soal['soal'] ?><p><b>Jawaban :</b> <?= $jawaban['esai'] ?></td>
											<td><input type='text' class='form-control' value="<?= $jawaban['nilai_esai'] ?>" name='nilaiesai[<?= $no ?>]'></td>
										</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
							<iframe name='frameresult' src='report.php?m=<?= $id_mapel ?>&k=<?= $id_kelas ?>' style='border:none;width:1px;height:1px;'></iframe>
						</div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</form>
		</div>
	</div>

<!-- rincian jawaban mryes -->
<?php elseif ($ac == 'jawaban') : ?>
	<?php
	$tabel='nilai_pindah';
	$idmapel = $_GET['id']; // nilainya id ujian bukan id mapel

	$id_siswa = $_GET['ids'];
	$nilai = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM $tabel WHERE id_siswa='$id_siswa' and id_ujian='$idmapel'"));
	$ujian = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$idmapel'"));
	$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel where id_mapel='$nilai[id_mapel]'"));

	$siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$id_siswa'"));
	$total= number_format($nilai['skor']+$nilai['nilai_esai'], 2, '.', '');
	?>
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid'>
				<div class='box-header with-border '>
					<h3 class='box-title'>Data Hasil Ujian</h3>
					<a href="?pg=nilai2&kelas=<?= $siswa['id_kelas'] ?>&id=<?= $idmapel ?>" class='btn btn-sm  btn-success' ><i class='fas fa-arrow-left'></i> Kembali</a>
					<div class='box-tools pull-right btn-group'>
					
						<!-- <button class='btn btn-sm btn-primary' onclick="frames['framejawab'].print()"><i class='fa fa-print'></i> Print</button> -->
						<!-- <i class='btn btn-sm btn-danger' href='?pg=nilai&ac=lihat&id=<?= $idmapel ?>'><i class='fa fa-times'></i></a> -->
						<!-- <iframe name='framejawab' src='printjawab.php?m=<?= $idmapel ?>&s=<?= $id_siswa ?>' style='display:none;'></iframe> -->
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<table class='table table-bordered table-striped'>
						<tr>
							<th width='150'>No Induk</th>
							<td width='10'>:</td>
							<td><?= $siswa['nis'] ?></td>
							<td style="text-align:center;">Nilai PG</td>
							<td style="text-align:center; ">Nilai ESSAI</td>
							<td style="text-align:center;">Total Nilai</td>
							<td style="text-align:center;">KKM</td>
							<td style="text-align:center;">STATUS</td>
						</tr>
						<tr>
							<th>Nama</th>
							<td width='10'>:</td>
							<td><?= $siswa['nama'] ?></td>
							<td rowspan='3' style='font-size:30px; text-align:center; '><?= 	number_format($nilai['skor'], 2, '.', '');?></td>
							<td rowspan='3' style='font-size:30px; text-align:center; '>
								
								<?php 
								if($nilai['nilai_esai']==null){ echo "00.00"; }
								else{ echo number_format($nilai['nilai_esai'], 2, '.', ''); }
								?>
									
							</td>
							<td rowspan='3' style='font-size:30px; text-align:center; width:150'>
								<b 
								<?php 
								if($total < 75){ echo"style='color:red;'"; }
								else{  echo"style='color:blue;'"; } ?>><?= 	$total ?></b></td>
								<td rowspan='3' style='font-size:30px; text-align:center; width:150'><b><?= $ujian['kkm'];?></b></td>
								<td rowspan='3' style='font-size:30px; text-align:center; width:150'>
									<?php 
									if($total >= $ujian['kkm']){
										echo"<small class='label bg-green' style='font-size: 20px;'>LULUS</small>";
									}
									else{
										echo"<small class='label bg-red' style='font-size: 20px;'>COBA LAGI</small>";
									}
									?>
								</td>
						</tr>
						<tr>
							<th>Kelas</th>
							<td width='10'>:</td>
							<td><?= $siswa['id_kelas'] ?></td>
						</tr>
						<tr>
							<th>Mata Pelajaran</th>
							<td width='10'>:</td>
							<td><?= $mapel['nama'] ?></td>
						</tr>
						<tr>
							<th>Soal PG</th>
							<td width='10'>:</td>
							<td><?= $mapel['tampil_pg'].' Soal' ?></td>
							<td colspan='3'>Jumlah Bener : <small class='label bg-green' style="font-size: 13px;"><?= $nilai['jml_benar'];?> <i class='fa fa-check'></i></small> || Jumlah Salah : <small class='label bg-red' style="font-size: 13px;"> <?= $nilai['jml_salah'];?> <i class='fa fa-times'></i></small> </td>
							<td></td>
							<td></td>
						</tr>

						<tr>
							<th>Soal Esai</th>
							<td width='10'>:</td>
							<td><?= $mapel['tampil_esai'].' Soal' ?></td>
						</tr>
					</table>
					<br>
					<div class='table-responsive'>
						<legend>Rumusnya PG : (NILAI PG BENAR/JUMLAH SOAL) * Bobot Nilai PG </legend>
						<table class='table table-bordered table-striped'>
							<thead>
								<tr>
									<th width='5px'>#</th>
									<th>Soal PG</th>
									<th style='text-align:center'>Jawab Peserta</th>
									<th style='text-align:center'>Jawab Yang Benar</th>
									<th style='text-align:center'>Hasil</th>
									<th style='text-align:center'>Skor/Soal</th>
								</tr>
							</thead>
							<tbody>
								<?php $jawaban = unserialize($nilai['jawaban']); 
								//$jum = count($jawaban); 
								$jum = $mapel['tampil_pg']; 
								$bobot = $mapel['bobot_pg'];
								//jika pecahan bobot per item soal tidak tampil esai
								if($jum % 2==0){
									$nilai_soal_pg = number_format($bobot/$jum, 2, '.', ''); 
								
								}
								else{
									$nilai_soal_pg="";
								}

								foreach ($jawaban as $key => $value) : ?>
									<?php
									$no++;
									$soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_soal='$key'"));
										/*load gambar soal*/
										if ($soal['file'] == '') {
												$gambar = '';
											} else {
												$gambar = "<img src='$homeurl/files/$soal[file]' class='img-responsive' style='max-width:75px;'/><p>";
											}
											if ($soal['file1'] == '') {
												$gambar2 = '';
											} else {
												$gambar2 = "<img src='$homeurl/files/$soal[file1]' class='img-responsive' style='max-width:75px;'/><p>";
											}
											/*load gambar soal*/

									/*Bandikan Jawaban Benar dan Salah*/
									if($soal['jenis'] == 4){
										$jawabanDariSoal = explode(",",$soal['jawaban']); #string to array 
										$count = count($jawabanDariSoal ); //totaol array jawaban
										
										$jwb = unserialize($value);
										$nojwbSoal =0;
										
										foreach($jwb as $val){
											if(in_array($val,$jawabanDariSoal)){
												$nojwbSoal++;
											}	
										}
										if($nojwbSoal == $count){ #jika pencocokan in array jumlahnya sama dengan count array maka jawaban benar
											$jawabanyasiswa = implode(",",$jwb);
											$status = "<span class='text-green'><i class='fa fa-check'></i></span>";
											$nojwbSoal=0;
										}
										else{
											$jawabanyasiswa = implode(",",$jwb);
											$status = "<span class='text-red'><i class='fa fa-times'></i></span>";
										}
									}
									else{
										if ($value == $soal['jawaban']) :
											$jawabanyasiswa = $value;
											$nilai_soal_pg1 = $nilai_soal_pg;
											$status = "<span class='text-green'><i class='fa fa-check'></i></span>";
										else :
											$jawabanyasiswa = $value;
											$nilai_soal_pg1 = 0;
											$status = "<span class='text-red'><i class='fa fa-times'></i></span>";
										endif;
									}
									
									/*Bandikan Jawaban Benar dan Salah*/
									?>
									<tr>
										<td><?= $no ?></td>
										<td><?= $gambar ?> <?= $gambar2 ?><?= $soal['soal'] ?></td>
										<td style='text-align:center'><?= $jawabanyasiswa ?></td>
										<td style='text-align:center'><?= $soal['jawaban'] ?></td>
										<td style='text-align:center'><?= $status ?></td>
										<td style='text-align:center'><?= $nilai_soal_pg1; ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<?php 
							$idnilai = $nilai['id_nilai'];
							$idujian = $nilai['id_ujian'];
							$idmapel = $nilai['id_mapel'];
							$idsiswa = $nilai['id_siswa'];
							$kodeujian = $nilai['kode_ujian']; 
							$bobotesai = $mapel['bobot_esai'];
						?>
						
						<?php if ($nilai['jawaban_esai'] <> null) { ?>
							<form action="" method="post" id="form_esai">
							<!-- cek jika jawaban essai ada atau ada soal essai -->
							<table class='table table-bordered table-striped'>
								<thead>
									<tr>
										<th width='5px'>#</th>
										<th>Soal ESAI</th>
										<th style='text-align:center; width:50%;'>Jawab</th>
										<th style='text-align:center'>Nilai</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									//unserialize data dulu biar bisa di looping
									$jawabanesai = unserialize($nilai['jawaban_esai']);
									$nilai_esai2 = unserialize($nilai['nilai_esai2']);
									
									foreach ($nilai_esai2 as $key3 => $value3) :
											$data[] = array(
												"kunci" =>$key3,
												"nilai"	=> $value3,
											);
									endforeach;
									foreach ($jawabanesai as $key4 => $value4) :
										$data2[] = array(
												"kunci" =>$key4,
												"jawaban"	=> $value3,
											);
									endforeach;

									//$gabung3 = array_combine($jawabanesai,$data);
									//var_dump($data3);

									$noX = 0;
									if($nilai_esai2 ==null){ 
									?>
									<?php	foreach ($jawabanesai as $key2 => $value2) {
										$noX++;
										$soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_soal='$key2'"));
										/*load gambar soal*/
										if ($soal['file'] == '') {
											$gambar = '';
										} else {
											$gambar = "<img src='$homeurl/files/$soal[file]' class='img-responsive' style='max-width:100px;'/><p>";
										}
										if ($soal['file1'] == '') {
											$gambar2 = '';
										} else {
											$gambar2 = "<img src='$homeurl/files/$soal[file1]' class='img-responsive' style='max-width:100px;'/><p>";
										}
										/*load gambar soal*/
									?>
									<tr>
										<td><?= $noX ?></td>
										<td><?= $gambar ?> <?= $gambar2 ?> <?= $soal['soal'] ?></td>
										<td><?=  $value2 ?></td>
										<td width="100"><input value="0" type="number" name="<?= $key2; ?>" class="form-control nilai_soal_esai"></td>
									</tr>
										
									<?php } ?>

									<?php }
									// jika nilai esai sudah ada maka tampilkan
									else{ 
										foreach ($data as $key2 => $value2){
											$kunci = $value2['kunci'];
											$nilai = $value2['nilai'];
											$noX++;
											$soal = $db->v_nilai_esai($kunci);

											/*load gambar soal*/
											if ($soal['file'] == '') {
												$gambar = '';
											} else {
												$gambar = "<img src='$homeurl/files/$soal[file]' class='img-responsive' style='max-width:100px;'/><p>";
											}
											if ($soal['file1'] == '') {
												$gambar2 = '';
											} else {
												$gambar2 = "<img src='$homeurl/files/$soal[file1]' class='img-responsive' style='max-width:100px;'/><p>";
											}
											/*load gambar soal*/

										?>	
										<tr>
											<td><?= $noX ?></td>
											<td><?= $gambar ?> <?= $gambar2 ?> <?= $soal['soal'] ?></td>
											<td><?php 
												foreach ($jawabanesai as $key5 => $value5) {
													if($kunci==$key5){
														echo $value5;
													}
												}
											?>
											</td>

											
											<td width="100"><input value="<?= $nilai;?>" type="text" name="<?= $kunci; ?>" class="form-control nilai_soal_esai"></td>
										</tr>

									<?php }  } ?>

								</tbody>

							</table>
						<?php } ?>
						<legend>Rumusnya : (Total Nilai Essay * Bobot Nilai Esai) / 100 </legend>
						<button name="save_esai" class="btn btn-primary" id="s_soal_esai">Simpan Nilai Esai </button>
						<input type="hidden" name="bobot" value="<?= $bobotesai; ?>">
						<input type="hidden" name="id_ujian" value="<?= $idujian; ?>">
						<input type="hidden" name="id_mapel" value="<?= $idmapel; ?>">
						<input type="hidden" name="id_nilai" value="<?= $idnilai; ?>">
						<input type="hidden" name="id_siswa" value="<?= $idsiswa; ?>">
						</form>
						<?php echo $info1; ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<script>
	$('#tablenilai').dataTable();
	$(document).on('click', '.ulangnilai', function() {
		var id = $(this).data('id');
		console.log(id);
		swal({
			title: 'Apa anda yakin?',
			text: " Akan Mengulang Ujian Ini ??",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: 'ulangujian_nilai.php',
					method: "POST",
					data: 'id=' + id,
					success: function(data) {
						toastr.success("berhasil diulang");
						$('#tablenilai').load(location.href + ' #tablenilai');
					}
				});
			}
		})
	});
	$('#cari_nilai').click(function(){
		var kelas = $('.kelas').val();
		var ujian = $('.ujian').val();
		var jurusan = $('.jurusan').val();

		if(kelas =="" && jurusan != ""){
			location.replace("?pg=nilai2&jrs="+jurusan+"&id="+ujian);
		}
		else if(jurusan =="" && kelas != ''){
			location.replace("?pg=nilai2&kelas="+kelas+"&id="+ujian);
		}
		else{
			alert("Uppps Pilih Kelas Atau Jurusan Salah Satu");
		}
		

	}); //ke url
	$(document).on('click', '#s_soal_esai', function(c) {
		c.preventDefault();
		
		var data_nilai_esai = new FormData($('#form_esai')[0]);
		$.ajax({
      type : 'POST',
      url : 'c_aksi.php?esai=oke', 
      data:data_nilai_esai,
      processData : false,
      contentType : false,
      beforeSend: function() {
				$('.loader').css('display', 'block');
			}, 
      success : function(response){
      	if(response==1){
      		$('.loader').css('display', 'none');
					location.reload();
      	}
       
      }
    });

	});

	$(document).on('click','#down_excel',function(){
		$("#tablenilai").table2excel({
        
        filename: "data_nilai.xls",
        fileext: ".xls",
        //preserveColors: preserveColors,
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
       // preserveColors:true

      });
 
	});

</script>
