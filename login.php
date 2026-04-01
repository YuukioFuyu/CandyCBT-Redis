<?php
require("config/config.login_siswa.php");
require("config/config.candy2.php");
if(!empty($_SESSION['id_siswa'])){
	header("Location: $homeurl");
}
else{

$cekdb = mysqli_query($koneksi, "SELECT 1 FROM pengawas LIMIT 1");
if ($cekdb == false) {
	header("Location: install.php");
}
$dbb= new Login(); 
$daa1=$dbb->CacheSetting();
foreach ($daa1 as $value) {
	$setting = $value;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login | <?php echo $setting['aplikasi']; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="dist/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="dist/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="dist/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="dist/css/util.css">
	<link rel="stylesheet" type="text/css" href="dist/css/main.css">
	<link rel='stylesheet' href='<?php echo $homeurl; ?>/plugins/sweetalert2/dist/sweetalert2.min.css'>
</head>

<body  style="background-image: url(<?php echo $homeurl.'/dist/img/loginsiswa.jpg'.'?date='.time(); ?>);">

	<div class="limiter">
		<div class="container-login101">
			<div class="animated wrap-login100" style="padding-top:30px">
				<form id="formlogin" action="ceklogin.php" class="login100-form validate-form">

					<span class="animated infinite pulse delay-5s login100-form-title p-b-40">
						<img src="<?php echo $setting['logo']; ?>" style="max-height:100px" class="img-responsive" alt="Responsive image">
					</span>
					<span class="login100-form-title p-b-26">
						<?php echo $setting['aplikasi']; ?>
						<p><small>Support By TIM IT <?php echo $setting['namaSekolah']; ?></small></p>
					</span>
					<!-- -------------------------------------------------------------------------------- -->
					<div class="wrap-input100 validate-input" data-validate="Enter Username" required>
						<?php if($setting['LoginSiswaMainten'] ==1){ ?>
						<center><span style="font-size: 25px;"><b>INFORMASI</b></span></center>
						<?php }else{ ?>		
							<input class="input100" type="text" name="username">
							<span class="focus-input100" data-placeholder="Username"></span>
						<?php } ?>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<?php if($setting['LoginSiswaMainten'] ==1){ ?>
							<center>
								<div class="alert alert-warning">
								  <strong>Mohon Maaf ! <br></strong> Sistem Sedang Maintenance.<br>
								  Silahkan Datang Kembali Untuk Beberapa Saat Lagi.
								</div>
							</center>
						<?php }else{ ?>		
							<span class="btn-show-pass">
								<i class="zmdi zmdi-eye"></i>
							</span>
							<input class="input100" type="password" name="password">
							<span class="focus-input100" data-placeholder="Password"></span>
						<?php } ?>
					</div>
						<blockquote class="blockquote text-center">
						  <p class="mb-0"><?= $setting['IsiPesanSingkat'];?></p>
						  <footer class="blockquote-footer"><cite title="Source Title"><?= $setting['JudulPesanSingkat'];?></cite></footer>
						</blockquote>
					<div class="container-login100-form-btn">
						<?php if($setting['LoginSiswaMainten'] ==1){ ?>
						<?php }else{ ?>
						
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button style="background-color: #1fc8db;background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);color: white;opacity: 0.95;" class="login100-form-btn">
								Login
							</button>
						</div>
						<?php } ?>
						
					<!-- -------------------------------------------------------------------------------- -->
						<footer class='main-footer ' style="padding-top: 10px;">
							<div >
								<a href="" class="txt2 hov1">
								&copy; 2024 <?= APLIKASI . " " . VERSI . " " ?>
								</a>
							</div>
						</footer>
					</div>


				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

	<!--===============================================================================================-->
	<script src="dist/vendor/jquery/jquery-3.2.1.min.js"></script>

	<!--===============================================================================================-->
	<script src="dist/vendor/bootstrap/js/popper.js"></script>
	<script src="dist/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src='<?php echo $homeurl; ?>/plugins/sweetalert2/dist/sweetalert2.min.js'></script>
	<script src="dist/js/main.js"></script>
	<script>
		$(document).ready(function() {
			$('#formlogin').submit(function(e) {
				var homeurl;
				homeurl = '<?php echo $homeurl; ?>';
				e.preventDefault();
				$.ajax({
					type: 'POST',
					url: $(this).attr('action'),
					data: $(this).serialize(),
					success: function(data) {
						if (data == "ok") {
							console.log('sukses');
							window.location = homeurl;
						}
						if (data == "nopass") {
							swal({
								position: 'top-end',
								type: 'warning',
								title: 'Password Salah',
								showConfirmButton: false,
								timer: 1500
							});
						}
						if (data == "td") {
							swal({
								position: 'top-end',
								type: 'warning',
								title: 'Siswa tidak terdaftar',
								showConfirmButton: false,
								timer: 1500
							});
						}
						if (data == "nologin") {
							swal({
								position: 'top-end',
								type: 'warning',
								title: 'Siswa sudah aktif',
								showConfirmButton: false,
								timer: 1500
							});
						}

					}
				})
				return false;
			});

		});

		function showpass() {
			var x = document.getElementById("pass");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
		}
	</script>

</body>

</html>
<?php } ?>