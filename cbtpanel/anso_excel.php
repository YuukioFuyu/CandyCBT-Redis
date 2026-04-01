<?php
include("core/c_admin.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;
if($token == $token1) {
$id_mapel = $_GET['idmapel'];								
//$id_mapel = 1;

$data_soal2 = $db->v_anso2($id_mapel);

foreach ($data_soal2 as $d) {
	$data_mapel = $d;
}
$data_ujian2 = $db->v_ujian_nilai($id_mapel);
foreach ($data_ujian2 as $d2) {
	$ujian = $d2;
}

$dataArray2 = unserialize($data_mapel['kelas']);
foreach ($dataArray2 as $key => $value) {
	$kelas = $value;
}
					
$file = "Rekap_Nilai_".$data_mapel['nama']."_".$ujian['tgl_ujian'];
$file = str_replace(" ", "-", $file);
$file = str_replace(":", "", $file);

header("Content-type: application/vnd-ms-excel");
header("Content-type: application/octet-stream");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=" . $file . ".xls"); 

?>
Mata Pelajaran: <?= $data_mapel['nama'] ?><br>
Tanggal Ujian: <?php echo $db->tgl_indo(date('Y-m-d', strtotime($ujian['tgl_ujian']))); ?><br>
Jumlah Soal: <?= $data_mapel['jml_soal'] ?><br>
Kelas : <?= $kelas; ?><br>
Nilai Rata : <?php $nilai = $db->nilairata2($id_mapel); echo $nilai; ?><br><br>

	<table class='table table-bordered table-striped' border="1"> 
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
		<table class='table table-bordered table-striped' border="1">
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
						<td><?= $value['soal'] ?></td>
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
<?php } else{ jump("$homeurl"); exit; }?>						
