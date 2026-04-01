<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>

<?php if ($ac == '') : ?>
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'><i class="fas fa-file-signature fa-fw   "></i> DATA UJIAN AKTIF SEMUA NILAI PER MATA PELAJARAN</h3>
					<div class='box-tools pull-right btn-group'>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'><?= $info ?>
					<?php $jq = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
					<?php while ($jenis = mysqli_fetch_array($jq)) : ?>
						<div class="col-lg-2 ">
							<div class="small-box bg-blue">
								<div class="inner">
									<h4><?= $jenis['id_kelas'] ?></h4>

								</div>
								<!-- <div class="icon">
									<i class="fa fa-school"></i>
								</div> -->
								<a href="?pg=<?= $pg ?>&ac=lihat&idk=<?= $jenis['id_kelas'] ?>" class="small-box-footer">Lihat Nilai <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>

					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
<?php elseif ($ac == 'lihat') : ?>
	<?php
	$tabel='nilai_pindah';
	$id_kelas = $_GET['idk'];
	//$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel")); 
	$getBankSoalPerMapel = $db->getMatapelajaranBerdasarkanNilai();
	?>
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'><i class="fas fa-file-signature fa-fw   "></i> REKAP NILAI KELAS <?= $id_kelas ?></h3>
					<div class='box-tools pull-right'>
						<a class='btn btn-sm btn-primary' href='report_excel_semuanilai_mapel.php?k=<?= $id_kelas ?>'><i class='fa fa-download'></i> Excel</a>
						<a class='btn btn-sm btn-danger' href='?pg=semuanilai'><i class='fa fa-times'></i> Keluar</a>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<div class='table-responsive'>
						<table id='example' class='table table-bordered table-striped'>
							<thead>
								<tr>
									<th rowspan='3' style="vertical-align:middle; width:5px">#</th>
									<th style='text-align:center;vertical-align:middle' rowspan='3'>No Peserta</th>
									<th style='text-align:center;vertical-align:middle' rowspan='3'>Nama Peserta</th>
									<th style='text-align:center;vertical-align:middle' rowspan='3'>Kelas</th>
									<?php
									foreach ($getBankSoalPerMapel as $mapel):
										echo "<th style='text-align:center' colspan='4'>$mapel[nama_mapel]</th>";
									endforeach;
									?>
								</tr>
								<tr>
									<?php
									foreach ($getBankSoalPerMapel as $mapel):
										echo "<th style='text-align:center' colspan='4'>$mapel[kode_ujian]</th>";
									endforeach;
									?>
								</tr>
								<tr>
									<?php
									foreach ($getBankSoalPerMapel as $mapel):
										echo"<th style='text-align:center'>PAKET</th>";
										echo"<th style='text-align:center'>B</th>";
										echo"<th style='text-align:center'>S</th>";
										echo"<th style='text-align:center'>SKOR</th>";
										
									endforeach;
									?>
								</tr>
							</thead>
							<tbody>
								<?php 
								//get data siswa berdasarkan id kelas
								$siswaQ = $db->v_siswa($id_kelas);
								?>
                <?php foreach ($siswaQ as $siswa) : ?>
                  <?php
                  $no++;
                  $ket = '';
                  $esai = $lama = $jawaban = $skor = $total = '--';
                  ?>
                  <tr>
                    <td><?= $no ?></td>
                     <td style="text-align:center"><?= $siswa['no_peserta'] ?></td>
                    <td><?= $siswa['nama'] ?></td>
                    <td style="text-align:center"><?= $siswa['id_kelas'] ?></td>
                    <?php $getBankSoalGroupBy = $db->getBankSoalGroupBy() ?>
                    <?php foreach ($getBankSoalGroupBy as $mapel2): ?>
                    	<?php 
                    	//getdata nilai siswa berdasarka Id Ujian da Id Siswa 
                    	$nilai = $db->getNilaiSiswa($siswa['id_siswa'],$mapel2['KodeMapel']);
                    	?>
                    	<td style="text-align:center"><?= $nilai['nilaiPaketSoal'] ?></td>
                      <td style="text-align:center"><?= $nilai['jml_benar'] ?></td>
                      <td style="text-align:center"><?= $nilai['jml_salah'] ?></td>
                      <td style="text-align:center"><?= $nilai['skor'] ?></td>
										<?php endforeach; ?>
										
                  </tr>
                <?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
<?php endif; ?>