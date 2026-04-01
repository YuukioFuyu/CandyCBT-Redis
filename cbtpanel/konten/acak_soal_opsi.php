<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<?php $info = ''; ?>
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Status Soal Peserta</h3>
				<div class='box-tools pull-right '>
					<div class='box-tools pull-right '>
						<button id='btnresetsoal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Reset Soal</button>&nbsp;&nbsp;&nbsp;<a class='btn btn-sm btn-flat btn-primary' data-toggle='modal' data-backdrop='static' data-target='#infojadwal'><i class='glyphicon glyphicon-info-sign'></i> <span class='hidden-xs'>Info Reset Soal</span></a>
					</div>
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<!-- pengacak mryes -->
				<div class="row" style="padding-bottom: 10px;">
					<div class="col-md-12">
						Pastika Tidak ada Ujian Berjalan Untuk Menggunakan Fitur Hapus Acak Soal Masal <button id="hapus_acakk" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus Masal Acak</button> Jika Masih ada yang belum Terhapus
					</div>
					<div class="col-md-12">
						<blockquote class="blockquote"> Lakukan Reset Soal Saat Pertama Kali Soal tidak Tampil saat siswa Memulai Test  <br><i style="color: red"> Jika Di Reset Soal Saat Berjalan Ujian Makan Siswa Akan Mengulang Kembali Ujian</i></blockquote>
					</div>
					<script type="text/javascript">
						$(document).ready(function() {
							$("#hapus_acakk").click(function() {
								swal({
									title: 'Hapus Data Acak',
									text: 'Apakah kamu yakin akan menghapus Semua Data Acak, Yuk Berdoa dulu, Resiko Di tanggung Sendiri ^_^??',
									type: 'warning',
									showCancelButton: true,
									confirmButtonColor: '#3085d6',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Ya, Hapus!'
								}).then((result) => {
									if (result.value) {
										var tb = 'acak';
										$.ajax({
											url: 'hapus_all.php',
											data: "id=" + tb,
											type: "POST",
											success: function(respon) {
																		//toastr.success('Tabel Pengacak Berhasil di Hapus Semua');
																		location.reload();
																	}
																});
									}
								});
								
							});
						});
						$(function () {
							$('[data-toggle="tooltip"]').tooltip()
						})
					</script>
				</div>
				
				<?= $info ?> <!-- tableresetacak -->
				<div id='tablereset' class='table-responsive'>
					<table id='example1' class='table table-bordered table-striped'>
						<thead>
							<tr>
								<th width='5px'><input type='checkbox' id='ceksemua'></th>
								<th width='5px'>#</th>
								<th>Acak Opsi</th>
								<th>No Peserta</th>
								<th>Nama Peserta</th>
								<th>Nomor Soal</th>
								<th>Nomor Opsi</th>
								<th>Nomor Soal Essai</th>
							</tr>
						</thead>
						<tbody>
							<?php $nilaiq = mysqli_query($koneksi, "SELECT *  FROM pengacak LEFT JOIN siswa ON siswa.id_siswa=pengacak.id_siswa"); ?>
							<?php while ($pengacak = mysqli_fetch_array($nilaiq)) : ?>
								<?php
								$siswa = mysqli_fetch_array(mysqli_query($koneksi, "select * from siswa where id_siswa='$pengacak[id_siswa]'"));
								$ujianid = mysqli_fetch_array(mysqli_query($koneksi, "select * from ujian where id_ujian='$pengacak[id_ujian]'"));
								$no++;
								?>
								<tr>
									<td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-<?= $no ?>' value="<?= $siswa['id_siswa'] ?>"></td>
									<td><?= $no ?></td>
									<td>
										<?php if($ujianid['acak']==1){ ?>
											<button data-idu="<?= $pengacak['id_ujian'] ?>" data-id="<?= $pengacak['id_pengacak'] ?>" class="btnresetacak btn btn-sm btn-danger">Acak Soal</button>
										<?php } ?>
										<br>
										<?php if($ujianid['acak_opsi']==1){ ?>
											<button data-idu="<?= $pengacak['id_ujian'] ?>" data-id="<?= $pengacak['id_pengacak'] ?>" class="btnresetacakpg btn btn-sm btn-success">Acak PG</button>
										<?php } ?>
									</td>
									<td><?= $siswa['username'] ?></td>
									<td><?= $siswa['nama'] ?></td>
									<td ><?= $pengacak['id_soal'] ?></td>
									<td><?= $pengacak['id_opsi'] ?></td>
									<td><?= $pengacak['id_esai'] ?></td>
								</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
				<!-- /pengacak mryes -->
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
	<div class='modal fade' id='infojadwal' style='display: none;'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header bg-maroon'>
						<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
						<h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Infromasi Reset Soal</h4>
					</div>
					<!-- tambah jadwal mryes -->
					<div class='modal-body'>
						<p>
							Fitur ini bisa mereset soal ketika soal siswa tidak tampil (untuk pertama kali setelah login)
							<hr>
							Silahkan Acak Kembali Soal dengan Menekan <b>Tombol Acak Soal</b>
							<hr>
							Silahakn Acak Kembali Opsi Pilihan Ganda dengan Menekan <b>Tombol Acak PG</b>
						</p>
					</div>
				</div>
			</div>
		</div>
</div>