<!DOCTYPE html>
<?php

require("../config/config.login_admin.php");
require("../config/config.function.php");
require("../config/config.candy2.php");
$cekdb = mysqli_query($koneksi, "SELECT 1 FROM pengawas LIMIT 1");
if ($cekdb == false) {
	header("Location: ../install.php");
}

$ceks = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting"));
$token_bot = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM bot_telegram"));

$namaaplikasi = $ceks['aplikasi'];
$namasekolah = $ceks['sekolah'];
$dbtoken = $ceks['db_token'];


$dbb= new Login(); 
$daa1=$dbb->CacheSetting();
foreach ($daa1 as $value) {
	$setting = $value;
}
?>
<html lang="en">

<head>
	<title>Login | <?php echo $setting['aplikasi']; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../dist/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../plugins/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="dist/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="../plugins/animate/animate.min.css">
	<link rel='stylesheet' href='<?php echo $homeurl; ?>/plugins/sweetalert2/dist/sweetalert2.min.css'>
	<link rel="stylesheet" type="text/css" href="../dist/bootstrap/css/util.css">
	<link rel="stylesheet" type="text/css" href="../dist/bootstrap/css/main.css">
	<style>
		.judul {
			position: absolute;
			right: 20px;
			top: 20px;
			z-index: 2;
			color: #000;
		}
		.judul2 {
			position: absolute;
			right: 380px;
			top: 20px;
			z-index: 2;
			color: #000;
		}

		.logo {
			position: absolute;
			left: 20px;
			top: 20px;
			z-index: 2;
			color: #000;
			-webkit-filter: drop-shadow(5px 5px 5px #222);
			filter: drop-shadow(5px 5px 5px #222);
		}

		.candy {
			position: absolute;
			left: 10px;
			top: 90%;
			z-index: 3;
			color: #000;
			-webkit-filter: drop-shadow(5px 5px 5px #222);
			filter: drop-shadow(5px 5px 5px #222);
			opacity: 0.4;
			filter: alpha(opacity=40);
		}

		.candy:hover {
			opacity: 1.0;
			filter: alpha(opacity=100);
		}

		.wrap-login100-form-btn {
			display: block;
			position: relative;
			z-index: 1;
			border-radius: 0px;
			overflow: hidden;
		}
	</style>
</head>

<body style="background-color: #999999;">

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
								<a href="https://bit.ly/3nlO0Lt" class="txt2 hov1">
								&copy; 2020 <?= APLIKASI . " " . VERSI . " " ?>
								</a>
							</div>
						</footer>
					</div>


				</form>
			</div>
		</div>
	</div>

	<!--===============================================================================================-->
	<script src="dist/vendor/jquery/jquery-3.2.1.min.js"></script>

	<!--===============================================================================================-->
	<script src="dist/vendor/bootstrap/js/popper.js"></script>
	<script src="dist/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src='<?php echo $homeurl; ?>/plugins/sweetalert2/dist/sweetalert2.min.js'></script>
	<script src="dist/js/main.js"></script>
	<?php 
	if (isset($_POST['submit'])) {


	$username = htmlspecialchars($_POST['username'], ENT_QUOTES);
	$password = htmlspecialchars($_POST['password'], ENT_QUOTES);
	$query = mysqli_query($koneksi, "SELECT * FROM pengawas WHERE username='$username'");

	$cek = mysqli_num_rows($query);
	$user = mysqli_fetch_array($query);


	if ($cek <> 0) {

		if ($user['level'] == 'admin') {
			if (!password_verify($password, $user['password'])) {
				$info = info("Password salah!", "NO");
			} else {
				
				$_SESSION['id_pengawas'] = $user['id_pengawas'];
				$_SESSION['level'] = 'admin';
				// validasi session token
				$_SESSION['token'] = $ceks['db_token'];
				$_SESSION['token1'] = $ceks['db_token1'];
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['password'] = $_POST['password'];
				$_SESSION['token_bot_telegram'] = $token_bot['botToken'];
				echo "<script>location.href = '.';</script>";
			}
		} 
		elseif ($user['level'] == 'peng') {
			if (!password_verify($password, $user['password'])) {
				$info = info("Password salah!", "NO");
			} else {
				$_SESSION['id_pengawas'] = $user['id_pengawas'];
				$_SESSION['level'] = 'peng';

				// validasi session token
				$_SESSION['token'] = $ceks['db_token'];
				$_SESSION['token1'] = $ceks['db_token1'];
				$_SESSION['token_bot_telegram'] = $token_bot['botToken'];
				echo "<script>location.href = '.';</script>";
			}
		}
		elseif ($user['level'] == 'guru') {

			if (!password_verify($password, $user['password'])) {
				$info = info("Password salah!", "NO");
			} else {
				$_SESSION['id_pengawas'] = $user['id_pengawas'];
				$_SESSION['level'] = 'guru';
				$_SESSION['jrs'] = $user['id_jrs'];
				$_SESSION['kls'] = $user['id_kls'];
				$_SESSION['jabatan'] = $user['jabatan'];
				// validasi session token
				$_SESSION['token'] = $ceks['db_token'];
				$_SESSION['token1'] = $ceks['db_token1'];
				$_SESSION['token_bot_telegram'] = $token_bot['botToken'];

				echo "<script>location.href = '.';</script>";
			}
		}
	} elseif ($cek == 0 or $cekguru == 0) {
		echo "<script>alert('Pengguna tidak terdaftar');</script>";
	}
}

	?>

</body>

</html>