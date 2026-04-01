<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>

<?php cek_session_admin(); ?>
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Manajemen Guru</h3>
				<div class='box-tools pull-right '>
					<a href='?pg=importguru' class='btn btn-sm btn-flat btn-success'><i class='fa fa-upload'></i> Import Guru</a>
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<div class="row" style="padding-left: 10px;">
					<div class="col-md-12" >
						Pilih Guru Dahulu <button id='btnresetlogin' class='btn btn-sm btn-flat btn-danger'><i class='fa fa-trash'></i> Hapus Guru Di Pilih</button>
					</div>
				</div>
				<div id='tablereset' class='table-responsive'>
					<table id='example1' class='table table-bordered table-striped'>
						<thead>
							<tr>
								<th width='5px'>
									<input type='checkbox' id='ceksemua'></th>
								<th width='5px'>#</th>
								<th>NIP</th>
								<th>Nama</th>
								<th>Username</th>
								<th>Password</th>
								<th>Level</th>
								<th>Jabatan</th>
								<th>Wali Kelas</th>
								<th>Ketua Jurusan</th>
								<th width=60px></th>
							</tr>
						</thead>
						<tbody>
							<?php $guruku = mysqli_query($koneksi, "SELECT * FROM pengawas where level='guru' ORDER BY nama ASC"); ?>
							<?php while ($pengawas = mysqli_fetch_array($guruku)) : ?>
								<?php $no++; ?>
								<tr>
									<td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-<?= $no ?>' value="<?= $pengawas['id_pengawas'] ?>"></td>
									<td><?= $no ?></td>
									<td><?= $pengawas['nip'] ?></td>
									<td><?= $pengawas['nama'] ?></td>
									<td><small class='label bg-purple'><?= $pengawas['username'] ?></small></td>
									<td><small class='label bg-blue'><?= $pengawas['password'] ?></small></td>
									<td><?= $pengawas['level'] ?></td>
									<td><?= $pengawas['jabatan'] ?></td>
									<td><?= $pengawas['id_kls'] ?></td>
									<td><?= $pengawas['id_jrs'] ?></td>
									<td style="text-align:center">
										<div class=''>
											<a href="?pg=<?= $pg ?>&ac=edit&id=<?= $pengawas['id_pengawas'] ?>"> <button class='btn btn-flat btn-xs btn-warning'><i class='fa fa-edit'></i></button></a>
											<a href="?pg=<?= $pg ?>&ac=hapus&id=<?= $pengawas['id_pengawas'] ?>"> <button class='btn btn-flat btn-xs bg-maroon'><i class='fa fa-trash'></i></button></a>
										</div>
									</td>
								</tr>
							<?php endwhile ?>
						</tbody>
					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
	<div class='col-md-4'>
		<?php if ($ac == '') : ?>
			<?php
			if (isset($_POST['submit'])) {
				$nip = $_POST['nip'];
				$nama = $_POST['nama'];
				$nama = str_replace("'", "&#39;", $nama);
				$username = $_POST['username'];
				$pass1 = $_POST['pass1'];
				$pass2 = $_POST['pass2'];
				
				
				if(empty($_POST['jabatan'])){ $jabatan=null; }else{ $jabatan = $_POST['jabatan']; }
				if(empty($_POST['kls'])){ $kls=null; }else{ $kls = $_POST['kls']; }
				if(empty($_POST['jrs'])){ $jrs=null; }else{ $jrs = $_POST['jrs']; }

				$cekuser = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE username='$username'"));
				if ($cekuser > 0) {
					$info = info("Username $username sudah ada!", "NO");
				} else {
					if ($pass1 <> $pass2) {
						$info = info("Password tidak cocok!", "NO");
					} else {
						$password = password_hash($pass1, PASSWORD_BCRYPT);
						$exec = mysqli_query($koneksi, "INSERT INTO pengawas (nip,nama,username,password,level,jabatan,id_kls,id_jrs) VALUES ('$nip','$nama','$username','$password','guru','$jabatan','$kls','$jrs')");
						(!$exec) ? $info = info("Gagal menyimpan!", "NO") : jump("?pg=$pg");
					}
				}
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
						<?= $info; ?>
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
							<label>Jabatan</label>
							<select name="jabatan" id="jabatan" class='select2 form-control'>
								<option value="">Pilih Jabatan</option>
								<option value="guru">Guru</option>
								<option value="wali">Wali Kelas</option>
								<option value="kajur">Ketua Jurusan</option>
								<!-- <option value="peng">Pengawas</option> -->
							</select>
						</div>
						<div class='form-group' id="kelas" style="display: none;" >
							<label>Wali Dari Kelas </label>
							<select  name="kls" class='select2 form-control' style="width: 200px;">
								<option value="">Pilih Kelas</option>
								<?php 
								$kelas = $db->v_kelas(); 
								foreach ($kelas as $value) {
								?>
								<option value="<?= $value['id_kelas'] ?>"><?= $value['nama'] ?></option>
							<?php } ?>
							</select>
						</div>
						<div class='form-group' id="jurusan" style="display: none;" >
							<label>Kajur </label>
							<select  name="jrs" class='select2 form-control' style="width: 200px;">
								<option value="">Pilih Jurusan</option>
								<?php 
								$jur = $db->v_jurusan(); 
								foreach ($jur as $value) {
								?>
								<option value="<?= $value['id_pk'] ?>"><?= $value['id_pk'] ?></option>
							<?php } ?>
							</select>
						</div>
						<script type="text/javascript">
							$(document).ready(function() { 
		            $("#jabatan").change(function() { 
		                var a = $(this).val();
		                if(a=='wali'){
		                	$('#kelas').removeAttr('style');
		                }
		                else{
		                	$("#kelas").attr("style", "display:none;");
		                }
		            });
		            $("#jabatan").change(function() { 
		                var a = $(this).val();
		                if(a=='kajur'){
		                	$('#jurusan').removeAttr('style');
		                }
		                else{
		                	$("#jurusan").attr("style", "display:none;");
		                }
		            });  
		        }); 
						</script>

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
				if (isset($_POST['submit'])) {
					$nip = $_POST['nip'];
					$nama = $_POST['nama'];
					$nama = str_replace("'", "&#39;", $nama);
					$username = $_POST['username'];
					$pass1 = $_POST['pass1'];
					$pass2 = $_POST['pass2'];
					if($_POST['jabatan']==""){ $jabatan=null;}else{ $jabatan = $_POST['jabatan']; }
					if($_POST['kls']==""){ $walikelas=null;}else{ $walikelas = $_POST['kls']; }
					if($_POST['jrs']==""){ $kajur=null;}else{$kajur = $_POST['jrs']; }

					if ($pass1 <> '' and $pass2 <> '') {
						if ($pass1 <> $pass2) {
							$info = info("Password tidak cocok!", "NO");
						} else {
							$password = password_hash($pass1, PASSWORD_BCRYPT);
							$exec = mysqli_query($koneksi, "UPDATE pengawas SET nip='$nip',nama='$nama',username='$username',password='$password',level='guru',jabatan='$jabatan',id_kls='$walikelas',id_jrs='$kajur' WHERE id_pengawas='$id'");
						}
					} else {
						$exec = mysqli_query($koneksi, "UPDATE pengawas SET nip='$nip',nama='$nama',username='$username',level='guru',jabatan='$jabatan',id_kls='$walikelas',id_jrs='$kajur' WHERE id_pengawas='$id'");
					}
					(!$exec) ? $info = info("Gagal menyimpan!", "NO") : jump("?pg=$pg");
				}
				?>
				<form action='' method='post'>
					<div class='box box-solid'>
						<div class='box-header with-border'>
							<h3 class='box-title'>Edit</h3>
							<div class='box-tools pull-right '>
								<a href="?pg=guru" id="tambah" class='btn btn-sm btn-flat btn-info'><i class='fa fa-plus'></i> Tambah</a>
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
							<label>Jabatan</label>
							<select name="jabatan" id="jabatan" class='select2 form-control'>
								<?php 
								if($value['jabatan']=='guru'){ $guru2 = 'selected="selected"';}else{ $guru2 ="";}
								if($value['jabatan']=='wali'){ $wali2 = 'selected="selected"';}else{ $wali2 ="";}
								if($value['jabatan']=='kajur'){ $kajur2 = 'selected="selected"';}else{ $kajur2 ="";}
								// if($value['jabatan']=='peng'){ $peng2 = 'selected="selected"';} else{ $peng2 ="";}
								
									 ?>
								<option value="" >Pilih Jabatan <?= $value['jabatan'];?></option>
								<option <?= $guru2; ?> value="guru">Guru</option>
								<option <?= $wali2; ?> value="wali">Wali Kelas</option>
								<option <?= $kajur2; ?> value="kajur">Ketua Jurusan</option>
								<!-- <option <?= $peng2; ?> value="peng">Pengawas</option> -->
							</select>
						</div>
						<div class='form-group' id="kelas">
							<label>Wali Dari Kelas </label>
							<select  name="kls" class='select2 form-control' style="width: 200px;">
								<option value="">Pilih Kelas</option>
								<?php 
								$kelas = $db->v_kelas(); 
								foreach ($kelas as $value2) {
									if($value['id_kls']==$value2['id_kelas']){ $select = 'selected="selected"';}
									else{ $select ="";}
								?>
								<option <?= $select; ?> value="<?= $value2['id_kelas'] ?>"><?= $value2['nama'] ?></option>
							<?php } ?>
							</select>
						</div>
						<div class='form-group' id="jurusan">
							<label>Kajur </label>
							<select  name="jrs" class='select2 form-control' style="width: 200px;">
								<option value="">Pilih Jurusan</option>
								<?php 
								$jur = $db->v_jurusan(); 
								foreach ($jur as $value2) {

									if($value['id_jrs']==$value2['id_pk']){ $select = 'selected="selected"';}
									else{ $select ="";}
								?>
								<option <?= $select; ?> value="<?= $value2['id_pk'] ?>"><?= $value2['id_pk'] ?></option>
							<?php } ?>
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
						(!$exec) ? $info = info("Gagal menghapus!", "NO") : jump("?pg=" . $pg);
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
				<?php endif ?>
			</div>
		</div>
		<script type="text/javascript">
			$(function() {
			$("#btnresetlogin").click(function() {
				id_array = new Array();
				i = 0;
				$("input.cekpilih:checked").each(function() {
					id_array[i] = $(this).val();
					i++;
				});
				var id = "guru_id";
				$.ajax({
					url: "hapus_all.php",
					data: "id="+id+"&kode=" + id_array,
					type: "POST",
					success: function(respon) {
						console.log(id_array);
						console.log(respon);
						if (respon == 1) {
							$("input.cekpilih:checked").each(function() {
								$(this).parent().parent().remove('.cekpilih').animate({
									opacity: "hide"
								}, "slow");
							})
						}
					}
				});
				return false;
			})
		});
		</script>
