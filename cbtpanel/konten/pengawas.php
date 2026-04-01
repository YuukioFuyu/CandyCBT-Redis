<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>

<?php cek_session_admin(); ?>
<div class='row'>
	<div class='col-md-8'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'><img src='../dist/img/svg/manajemen_user.svg' width='20'> Manajemen User</h3>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<div class='table-responsive'>
					<table id='example1' class='table table-bordered table-striped'>
						<thead>
							<tr>
								<th width='5px'>#</th>
								<th>NIP</th>
								<th>Nama</th>
								<th>Username</th>
								<th>Level</th>
								<th width=60px></th>
							</tr>
						</thead>
						<tbody>
							<?php $pengawasQ = mysqli_query($koneksi, "SELECT * FROM pengawas where level='admin' or level='peng' ORDER BY nama ASC"); ?>
							<?php while ($pengawas = mysqli_fetch_array($pengawasQ)) : ?>
								<?php $no++; ?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $pengawas['nip'] ?></td>
									<td><?= $pengawas['nama'] ?></td>
									<td><?= $pengawas['username'] ?></td>
									<td>
										<?php 
										if($pengawas['level']=='admin'){ $level='admin'; }
										else{ $level='Pengawas Ruang'; } 
										echo $level;
										?>		
									</td>
									<td style="text-align:center">
										<div class=''>
											<a href="?pg=<?= $pg ?>&ac=edit&id=<?= $pengawas['id_pengawas'] ?>"> <button class='btn btn-flat btn-xs btn-warning'><i class='fa fa-edit'></i></button></a>
											<a href="?pg=<?= $pg ?>&ac=hapus&id=<?= $pengawas['id_pengawas'] ?>"> <button class='btn btn-flat btn-xs bg-maroon'><i class='fa fa-trash'></i></button></a>
										</div>
									</td>
								</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
	<div class='col-md-4'>
		<?php if ($ac == '') : ?>
			<?php
			if($token == $token1) {
			if (isset($_POST['submit'])) :
				$nip = $_POST['nip'];
				$nama = $_POST['nama'];
				$nama = str_replace("'", "&#39;", $nama);
				$username = $_POST['username'];
				$pass1 = $_POST['pass1'];
				$pass2 = $_POST['pass2'];
				$level = $_POST['level'];

				$cekuser = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE username='$username'"));
				if ($cekuser > 0) {
					$info = info("Username $username sudah ada!", "NO");
				} else {
					if ($pass1 <> $pass2) :
						$info = info("Password tidak cocok!", "NO");
					else :
						$password = password_hash($pass1, PASSWORD_BCRYPT);
						$exec = mysqli_query($koneksi, "INSERT INTO pengawas (nip,nama,username,password,level) VALUES ('$nip','$nama','$username','$password','$level')") or die (mysqli_error());
						(!$exec) ? $info = info("Gagal menyimpan!", "NO") : jump("?pg=$pg");
					endif;
				}
			endif;
				}
				else{
			jump("$homeurl");
			exit;
		}
			?>
			<form action='' method='post'>
				<div class='box box-solid'>
					<div class='box-header with-border'>
						<h3 class='box-title'>Tambah</h3>
						<div class='box-tools pull-right '>
							<button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
						</div>
					</div><!-- /.box-header -->
					<div class='box-body'>
						<?= $info ?>
						<div class='form-group'>
							<label>NIP</label>
							<input type='text' name='nip' class='form-control' required='true' />
						</div>
						<div class='form-group'>
							<label>Nama</label>
							<input type='text' name='nama' class='form-control' required='true' />
						</div>
						<div class='form-group'>
							<label>Username</label>
							<input type='text' name='username' class='form-control' required='true' />
						</div>
						<div class='form-group'>
							<label>Level</label>
							<select required="required" name="level" id="level" class='select2 form-control'>
								<option value="">Level</option>
								<option value="admin">Admin</option>
								<option value="peng">Pengawas Ruangan</option>
							</select>
						</div>
						<div class='form-group'>
							<div class='row'>
								<div class='col-md-6'>
									<label>Password</label>
									<input type='password' name='pass1' class='form-control' required='true' />
								</div>
								<div class='col-md-6'>
									<label>Ulang Password</label>
									<input type='password' name='pass2' class='form-control' required='true' />
								</div>
							</div>
						</div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</form>
			<?php elseif ($ac == 'edit') : ?>
				<?php
				$id = $_GET['id'];
				$value = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE id_pengawas='$id'"));
				if (isset($_POST['submit'])) :
					$nip = $_POST['nip'];
					$nama = $_POST['nama'];
					$nama = str_replace("'", "&#39;", $nama);
					$username = $_POST['username'];
					$pass1 = $_POST['pass1'];
					$pass2 = $_POST['pass2'];
					$level = $_POST['level'];
					if ($pass1 <> '' and $pass2 <> '') {
						if ($pass1 <> $pass2) :
							$info = info("Password tidak cocok!", "NO");
						else :
							$password = password_hash($pass1, PASSWORD_BCRYPT);
							$exec = mysqli_query($koneksi, "UPDATE pengawas SET nip='$nip',nama='$nama',username='$username',password='$password',level='$level' WHERE id_pengawas='$id'");
						endif;
					} else {
						$exec = mysqli_query($koneksi, "UPDATE pengawas SET nip='$nip',nama='$nama',username='$username',level='$level' WHERE id_pengawas='$id'");
					}
					(!$exec) ? $info = info("Gagal menyimpan!", "NO") : jump("?pg=$pg");
				endif;
				?>
				<form action='' method='post'>
					<div class='box box-solid'>
						<div class='box-header with-border'>
							<h3 class='box-title'>Edit</h3>
							<div class='box-tools pull-right '>
								<button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
								<a href='?pg=<?= $pg ?>' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
							</div>
						</div><!-- /.box-header -->
						<div class='box-body'>
							<?= $info ?>
							<div class='form-group'>
								<label>NIP</label>
								<input type='text' name='nip' value="<?= $value['nip'] ?>" class='form-control' required='true' />
							</div>
							<div class='form-group'>
								<label>Nama</label>
								<input type='text' name='nama' value="<?= $value['nama'] ?>" class='form-control' required='true' />
							</div>
							<div class='form-group'>
								<label>Username</label>
								<input type='text' name='username' value="<?= $value['username'] ?>" class='form-control' required='true' />
							</div>
							<div class='form-group'>
							<label>Level</label>
							<select required="required" name="level" id="level" class='select2 form-control'>
								<?php 
								if($value['level']=='admin'){ $admin='selected'; }else{ $admin=''; } 
								if($value['level']=='peng'){ $peng='selected'; }else{ $peng=''; } 
								?>
								<option value="">Level</option>
								<option <?= $admin; ?> value="admin">Admin</option>
								<option <?= $peng; ?> value="peng">Pengawas Ruangan</option>
							</select>
						</div>
							<div class='form-group'>
								<div class='row'>
									<div class='col-md-6'>
										<label>Password</label>
										<input type='password' name='pass1' class='form-control' />
									</div>
									<div class='col-md-6'>
										<label>Ulang Password</label>
										<input type='password' name='pass2' class='form-control' />
									</div>
								</div>
							</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</form>
				<?php elseif ($ac == 'hapus') : ?>
					<?php
					$id = $_GET['id'];
					$info = info("Anda yakin akan menghapus pengawas ini?");
					if (isset($_POST['submit'])) {
						$exec = mysqli_query($koneksi, "DELETE FROM pengawas WHERE id_pengawas='$id'");
						(!$exec) ? $info = info("Gagal menghapus!", "NO") : jump("?pg=$pg");
					}
					?>
					<form action='' method='post'>
						<div class='box box-danger'>
							<div class='box-header with-border'>
								<h3 class='box-title'>Hapus</h3>
								<div class='box-tools pull-right '>
									<button type='submit' name='submit' class='btn btn-sm bg-maroon'><i class='fa fa-trash'></i> Hapus</button>
									<a href='?pg=<?= $pg ?>' class='btn btn-sm btn-default' title='Batal'><i class='fa fa-times'></i></a>
								</div>
							</div><!-- /.box-header -->
							<div class='box-body'>
								<?= $info ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</form>
				<?php endif; ?>
			</div>
		</div>