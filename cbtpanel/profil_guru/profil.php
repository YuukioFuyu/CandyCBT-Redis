<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');

?>
<?php
if($token == $token1) {
if (isset($_POST['submit'])){
	$username = $_POST['username'];
	$nip = $_POST['nip'];
	$nama = $_POST['nama'];
	$nama = str_replace("'", "&#39;", $nama);
	if(!empty($_POST['password'])){
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$exec = mysqli_query($koneksi, "UPDATE pengawas SET username='$username', nama='$nama',nip='$nip',password='$password' WHERE id_pengawas='$id_pengawas'");
	}
	else{
		$exec = mysqli_query($koneksi, "UPDATE pengawas SET username='$username', nama='$nama',nip='$nip' WHERE id_pengawas='$id_pengawas'");
	}
	
};
?>
<?php if ($ac == '') { ?>
	<?php
	$guru = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE id_pengawas='$pengawas[id_pengawas]'"));
	?>
	<div class='row'>
		<div class='col-md-3'>
			<div class='box box-solid'>
				<div class='box-body box-profile'>
					<img style="width: 200px;" class='profile-user-img img-responsive' alt='User profile picture' src="<?= $homeurl ?>/guru/fotoguru/<?= $guru['id_pengawas'] ?>/<?= $guru['foto_pengawas'] ?>">
					<h3 class='profile-username text-center'><?= $guru['nip'] ?></h3>
				</div>
			</div>
			<div class="row" style="padding-bottom: 10px;">
				<div class="col-md-12">
					<form id='formfotoguru'>
						<div class="row" style="padding-bottom: 10px;">
							<div class="col-md-12">
							<label>Upload Foto Guru</label>
							<input required type="file" name="foto_guru" id="foto_guru" class="form-control-file" aria-describedby="fileHelpId">
						</div></div>
						<div class="row">
							<div class="col-md-12">
            	<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Upload Foto</button>
          	</div></div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$('#formfotoguru').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var homeurl = 'profil_guru';

      $.ajax({
        type: 'POST',
        url: homeurl + '/upload_foto_guru.php',
        enctype: 'multipart/form-data',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
				$("#pesanku").text("Proses Foto Sedang Di Upload");
				$('.loader').show();
			},
        success: function(data) {
        	console.log(data);
        	$('.loader').hide();
          if (data == 1) {
            toastr.success("Foto Berhasil Di Upload");
            $('.loader').css('display', 'none');
            setTimeout(function () { location.reload(1); }, 1000);
          }
          else if(data == 99){
          	toastr.warning("Cek Tipe Format Fotonya");
          } 
          else {
            toastr.error("Upss Gagal");
            $('.loader').css('display', 'none');
          }
        }
      });
      return false;
    });
		</script>
		<div class='col-md-9'>
			<div class='nav-tabs-custom'>
				<ul class='nav nav-tabs'>
					<li class='active'><a aria-expanded='true' href='#detail' data-toggle='tab'><i class='fa fa-user'></i> Detail Profile</a></li>
				</ul>
				<div class='tab-content'>
					<div class='tab-pane active' id='detail'>
						<div class='row margin-bottom'>
							<form action='' method='post'>
								<div class='col-sm-12'>
									<table class='table table-striped table-bordered'>
										<tbody>
											<tr>
												<th scope='row'>Nama Lengkap</th>
												<td><input class='form-control' name='nama' value="<?= $guru['nama'] ?>" /></td>
											</tr>
											<tr>
												<th scope='row'>Nip</th>
												<td><input class='form-control' name='nip' value="<?= $guru['nip'] ?>" /></td>
											</tr>
											<tr>
												<th scope='row'>Username</th>
												<td><input class='form-control' name='username' value="<?= $guru['username'] ?>" /></td>
											</tr>
											<tr>
												<th scope='row'>Password</th>
												<td><input class='form-control' name='password' placeholder="Silahkan di sini untuk mengganti password" /></td>
											</tr>
										</tbody>
									</table>
									<button name='submit' class='btn btn-sm btn-flat btn-success pull-right'>Perbarui Data </button>
								</div>
							</form>
						</div>
					</div>
					<div class='tab-pane' id='alamat'>
						<div class='row margin-bottom'>
							<div class='col-sm-12'>
								<table class='table  table-striped no-margin'>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class='tab-pane' id='kesehatan'>
						<div class='row margin-bottom'>
							<div class='col-sm-12'>
								<table class='table  table-striped no-margin'>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- /.tab-content -->
			</div>
		</div>
	</div>
	<?php
	} 
}else{
	jump("$homeurl");
	//exit;
}
	?>