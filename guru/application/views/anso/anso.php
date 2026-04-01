<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Analisis Soal</h3>
				<div class='box-tools pull-right btn-group'>
					<button class='btn btn-sm btn-info' onclick="window.print()"><i class='fa fa-print'></i> Print</button>
					<!-- <a  href="anso_excel.php?idmapel=<?= $id_mapel; ?>"  class='btn btn-sm btn-success' ><i class='fa fa-file-excel'></i> Excel</a> -->
					<a class='btn btn-sm btn-danger' onclick="window.history.back()"><i class='fa fa-times'></i> Keluar</a>
				</div>
			</div>
			<div class='box-body' id="tbabsenday" >

				<table class='table table-bordered table-striped'> 
					<?php 
					foreach ($select_ujian as $d) {
						?>
						<tr>
							<th width='100'>Mapel</th>
							<td >:</td>
							<td><?=  $d->nama;?></td>
							<td width='150' align='center'>Nilai Rata-Rata</td>
						</tr>
						<tr>
							<th>Tingkat</th>
							<td width='10'>:</td>
							<td><?=  $d->level;?></td>
							<td rowspan='3' width='150' align='center' style='text-align: center; vertical-align:middle;'>
								<span style='font-size:40px' class='text-bold badge bg-green'>
									<?php echo $nilai_rata2['jml_nilai'] ?>		
								</span>
							</td>
						</tr>
						<tr>
							<th>Jurusan</th>
							<td width='10'>:</td>
							<td><?= $d->idpk;?></td>
						</tr>
						<tr>
							<th>Kelas</th>
							<td width='10'>:</td>
							<td>
								<?php 
								$dataArray = unserialize($d->kelas);
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
							foreach ($select_soal as $value) {

								if ($value->file == '') {
									$gambar = '';
								} else {
									$gambar = "<img src='../../files/".$value->file."' class='img-responsive' style='max-width:30px;'/><p>";
								}
								if ($value->file1 == '') {
									$gambar2 = '';
								} else {
									$gambar2 = "<img src='../../files/".$value->file1."' class='img-responsive' style='max-width:30px;'/><p>";
								}?>
								<tr>
									<td><?= $value->nomor ?></td>
									<td><?= $gambar ?> <?= $gambar2 ?><?= $value->soal ?></td>
									<td style='text-align:center;'><?= $value->jawaban ?></td>
									<td style='text-align:center;'>
										<?php
										$no=0;
										$bener=$salah=0;
										foreach ($jawaban_siswa as $value2) {
											$pecah= unserialize($value2);
											foreach ($pecah as $key3 => $value3) {
												if($value->id_soal==$key3){
													$no++; //jika id_soal sama maka tambah jumlah responden
													if($value->jawaban==$value3){
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
									<td style='text-align:center;'><?= $bener; ?></td>
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
</div></div></div>