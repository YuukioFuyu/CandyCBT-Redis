<?php

// require("../config/config.default.php");
include("core/c_admin.php"); 
require "../config/config.function.php";
//cek session id_suer dan id_pengawas
if($token == $token1) {

	function restore($file)
	{
		$db2= new Budut();
		//require("../config/config.database.php");
		$extensionList = array("sql");

		global $rest_dir;
		$nama_file	= $file['name'];
		$ukrn_file	= $file['size'];
		$tmp_file	= $file['tmp_name'];

		//filter jenis file
		$pecah = explode(".", $nama_file);
		$ekstensi = $pecah[1];
		if(in_array($ekstensi, $extensionList)){

			if ($nama_file == "") {
				echo "Fatal Error";
			} else {
				$alamatfile	= "upload_data/".$rest_dir . $nama_file;
				$templine	= array();

				if (move_uploaded_file($tmp_file, $alamatfile)) {

					$templine	= '';

					$lines	= file($alamatfile);

					foreach ($lines as $line) {
						if (substr($line, 0, 2) == '--' || $line == '')
							continue;

						$templine .= $line;

						if (substr(trim($line), -1, 1) == ';') {
							//mysqli_query($koneksi, $templine);
							$restore1 = $db2->restore($templine);
							$templine = '';
							if($restore1==1){
								unlink($alamatfile);
							}
							else{
								unlink($alamatfile);
							}
						}
						unlink($alamatfile);
					}
					//echo $alamatfile;
				} else {
					echo "Proses upload gagal, kode error = " . $file['error'];
					unlink($alamatfile);
				}
			}
		}
		else{
			echo"File Extension Tidak Sesuai";
		}
	}
	restore($_FILES['datafile']);
	if (isset($_FILES['datafile'])) {
		echo"Berhasil Restore Database";
	}
}
else{
	jump("$homeurl");
	//exit;
}
