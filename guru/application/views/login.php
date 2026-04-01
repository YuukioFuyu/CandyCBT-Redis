
<!DOCTYPE html>
<html lang="en">
<?php include 'copyright.php'; ?>
<head>
	<title>Login | </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../dist/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../dist/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="../dist/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="../dist/css/util.css">
	<link rel="stylesheet" type="text/css" href="../dist/css/main.css">
	<link rel='stylesheet' href='../plugins/sweetalert2/dist/sweetalert2.min.css'>
</head>

<body style="background-image: url(../dist/img/bg-header.jpg);">

	<div class="limiter">
		<div class="container-login101">
			<div class="animated wrap-login100" style="padding-top:30px">
				<form id="formlogin" action="<?= base_url('login/login');?>" class="login100-form validate-form">

					<span class="animated infinite pulse delay-5s login100-form-title p-b-40">
						<?php $url="../".$setting['logo']; ?>
						<img src="<?php echo $url; ?>" style="max-height:100px" class="img-responsive" alt="Responsive image">
					</span>
					<span  class="login100-form-title p-b-26">
						<?php echo $setting['sekolah']; ?>
						<p id="skl"><small>Support By <?= APLIKASI ?></small></p>
					</span>

					<div id="send"><?php echo $this->session->flashdata('error'); ?></div>
		        
					<div class="wrap-input100 validate-input" data-validate="Enter Username" required>
						<input class="input100" type="text" name="_username">
						<span class="focus-input100" data-placeholder="Username"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="_password">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>
					<p style="font-size: 20px;line-height: 1.2;"><center><b>Login Guru</b></center></p>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Login
							</button>

						</div>
						<footer class='main-footer ' style="padding-top: 10px;">
							<div >&copy; 
								<a href="" class="txt2 hov1">
									<b><?= VERSI ." ". REVISI ?></b>
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
	<script src="../dist/vendor/jquery/jquery-3.2.1.min.js"></script>

	<!--===============================================================================================-->
	<script src="../dist/vendor/bootstrap/js/popper.js"></script>
	<script src="../dist/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src='../plugins/sweetalert2/dist/sweetalert2.min.js'></script>
	<script src="../dist/js/main.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			localStorage.clear();
			$('#formlogin').submit(function(e) {
				var homeurl;
				homeurl = '<?php echo base_url('admin/'); ?>';
				e.preventDefault();
				$.ajax({
					type: 'POST',
					url: $(this).attr('action'),
					data: $(this).serialize(),
					success: function(data) {
						if (data == "login") {
							window.location = homeurl;
						}
						if (data == "error") {
							swal({
								position: 'top-end',
								type: 'warning',
								title: 'Upsss ! Cek Username dan Password',
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