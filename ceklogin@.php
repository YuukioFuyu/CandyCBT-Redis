<?php
	require("config/config.login_siswa.php");
	
	$username = htmlspecialchars($_POST['username'], ENT_QUOTES);
	$password = htmlspecialchars($_POST['password'], ENT_QUOTES);
		$siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa WHERE username='$username'");

		//cek apakah login di catat atau tidak
		$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting "));
		$token_bot = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM bot_telegram")); 
		

		if($username<>"" and $password<>""){
		if(mysqli_num_rows($siswaQ)==0) {
			echo "td";
		} else {
			$siswa = mysqli_fetch_array($siswaQ);
			$ceklogin = mysqli_num_rows(mysqli_query($koneksi, "select * from login where id_siswa='$siswa[id_siswa]'"));
			
				if($password<>$siswa['password']) {
					echo "nopass";
				} else {
					if($ceklogin==0){
						$_SESSION['id_siswa'] = $siswa['id_siswa'];
						$_SESSION['nama_depan'] = $siswa['firt_nama'];
						$_SESSION['full_nama'] = $siswa['nama'];
						$_SESSION['agama'] = $siswa['agama'];
						$_SESSION['id_kelas'] = $siswa['id_kelas'];
						$_SESSION['id_jrs'] = $siswa['idpk'];
						$_SESSION['token_bot_telegram'] = $token_bot['botToken'];
						$_SESSION['nama_sekolah'] = $query['sekolah'];
						mysqli_query($koneksi, "INSERT INTO log (id_siswa,type,text,date) VALUES ('$siswa[id_siswa]','login','masuk','$tanggal $waktu')");

						if($query['catat_login'] == 1 or $query['catat_login'] == 2){
							//cek catat_login aktif 1 atau automatis 2
							mysqli_query($koneksi, "INSERT INTO login (id_siswa) VALUES ('$siswa[id_siswa]')");
						}
						echo "ok";
					}else{
						echo "nologin";
					}
				}
			
		}
		}


// <?php
// require("config/config.default.php");

// $username = $_POST['username'];
// $password = $_POST['password'];
// $siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa WHERE username='$username'");
// if ($username <> "" and $password <> "") {
// 	if (mysqli_num_rows($siswaQ) == 0) {
// 		echo "td";
// 	} else {
// 		$siswa = mysqli_fetch_array($siswaQ);
// 		//$ceklogin=mysqli_num_rows(mysqli_query($koneksi, "select * from login where id_siswa='$siswa[id_siswa]'"));

// 		if ($password <> $siswa['password']) {
// 			echo "nopass";
// 		} else {
// 			//if($ceklogin==0){
// 			$_SESSION['id_siswa'] = $siswa['id_siswa'];
// 			mysqli_query($koneksi, "INSERT INTO log (id_siswa,type,text,date) VALUES ('$siswa[id_siswa]','login','masuk','$tanggal $waktu')");
// 			//mysqli_query($koneksi, "INSERT INTO login (id_siswa) VALUES ('$siswa[id_siswa]')");
// 			echo "ok";
// 			//}else{
// 			//	echo "nologin";
// 			//}
// 		}
// 	}
// }
