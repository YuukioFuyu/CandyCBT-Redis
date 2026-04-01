<?php

require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:index.php') : null;

	$id_mapel = $_POST['id'];
	$tabel ='mapel';
	$tabel2='soal';

		//query cari mapel berdasarkan id
	$mapelQ = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM mapel where id_mapel='$id_mapel'"));
	$idpk= $mapelQ['idpk'];
	$idguru= $mapelQ['idguru'];
	$nama_mapel= $mapelQ['nama'];
	$jlmsoal= $mapelQ['jml_soal'];
	$jlmesai= $mapelQ['jml_esai'];
	$tmplpg= $mapelQ['tampil_pg'];
	$tmplesai= $mapelQ['tampil_esai'];
	$bobotpg= $mapelQ['bobot_pg'];
	$bobotesai= $mapelQ['bobot_esai'];
	$level= $mapelQ['level'];
	$opsi= $mapelQ['opsi'];
	$kelas= $mapelQ['kelas'];
	$siswa= $mapelQ['siswa'];
	$date= $mapelQ['date'];
	$status= $mapelQ['status'];
	
	if($mapelQ['statusujian']==null){
		$statusuji=null;
	}
	else{
		$statusuji= $mapelQ['statusujian'];
	}


	$data2 = array(
		'idpk'					=>$idpk,
		'idguru' 				=>$idguru,
		'nama'					=>$nama_mapel,
		'jml_soal'			=>$jlmsoal,
		'jml_esai'			=>$jlmesai,
		'tampil_pg'			=>$tmplpg,
		'tampil_esai' 	=>$tmplesai,
		'bobot_pg'			=>$bobotpg,
		'bobot_esai'		=>$bobotesai,
		'level'					=>$level,
		'opsi'					=>$opsi,
		'kelas'					=>$kelas,
		'siswa'					=>$siswa,
		'date'					=>$date,
		'status'				=>$status,
		'statusujian'		=>$statusuji
	);

		//tambah ke mapel /bank soal 
   $cek = insert($koneksi,$tabel,$data2);

   if($cek=='OK'){ //cek apakah berhasil input bank soal
      echo 1;		
    }
   else{
      echo 0;
   }



?>