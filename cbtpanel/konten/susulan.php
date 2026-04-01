<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border '>
				<h3 class='box-title'><i class='fa fa-file'></i> Daftar Siswa Susulan</h3>
				<div class='box-tools pull-right '>
				</div>
			</div>
			<div class='box-body'>
				<div id='tableberita' class='table-responsive'>
					<table class='table table-bordered table-striped  table-hover'>
						<thead>
							<tr>
								<th width='5px'>#</th>
								<th>No Peserta</th>
								<th>Nama Siswa</th>
								<th>Nama Ujian</th>
								<th>Mata Pelajaran</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$beritaQ = mysqli_query($koneksi, "SELECT * FROM berita WHERE no_susulan <> ''");
							?>
							<?php while ($berita = mysqli_fetch_array($beritaQ)) : ?>
								<?php
								$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel a LEFT JOIN mata_pelajaran b ON a.KodeMapel=b.kode_mapel WHERE a.id_mapel='$berita[id_mapel]'"));

								?>

								<?php
								if ($berita['no_susulan'] <> "") :
									$dataArray = unserialize($berita['no_susulan']);
									foreach ($dataArray as $key => $value) : ?>
										<?php
										$siswaQ = mysqli_query($koneksi, "select * from siswa where no_peserta='$value'");
										?>
										<?php while ($siswa = mysqli_fetch_array($siswaQ)) : ?>
											<?php
											$cek = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai_pindah where id_mapel='$berita[id_mapel]' and id_siswa='$siswa[id_siswa]'"));
											?>
											<?php if ($cek == 0) : ?>
												<?php $no++; ?>
												<tr>
													<td><?= $no ?></td>
													<td><?= $siswa['no_peserta'] ?></td>
													<td><?= $siswa['nama'] ?></td>
													<td><?= $mapel['nama'] ?></td>
													<td><?= $mapel['nama_mapel'] ?></td>
												</tr>
											<?php endif ?>
										<?php endwhile ?>
									<?php endforeach ?>
								<?php endif ?>
							<?php endwhile ?>
						</tbody>
					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>