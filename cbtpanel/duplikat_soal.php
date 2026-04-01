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
   	//jika berhasil langsung duplikasi soal

   		//ambil id tertinggi atau terbesar di tb mapel
      $mapmax = mysqli_query($koneksi,"SELECT MAX(id_mapel) as maxi from mapel");
      $hmapmax = mysqli_fetch_array($mapmax);
      $maximap = $hmapmax['maxi']; 
      
      	//fungsi ganda soal di ambil dari candy cbt nanov5
      
      	//ambil nomor tertinggi pada soal berdasarkan id mapel (jumlah soal)
      	$soalmax = mysqli_query($koneksi,"SELECT max(nomor) as maxinom from soal where id_mapel='$id_mapel'");
      	//looping data berdasarakn jumlah soal
      	while ($hsoalmax = mysqli_fetch_array($soalmax)) {
      		$maxisoal = $hsoalmax['maxinom']; }
      		$maxiisoal = $maxisoal+1;
      		$minisoal=1;
      		//proses penampungan data soal
      		while ($minisoal<$maxiisoal) {
      			//array data soal berdasarkan id mapel dan nomor urut
      			$duplikatQ = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM soal where id_mapel='$id_mapel' and nomor='$minisoal'"));

      			//tampung array ke variabel
      			$no= $duplikatQ['nomor'];
      			$soal= $duplikatQ['soal'];
      			$pilA= $duplikatQ['pilA'];
      			$pilB= $duplikatQ['pilB'];
      			$pilC= $duplikatQ['pilC'];
      			$pilD= $duplikatQ['pilD'];
      			$pilE= $duplikatQ['pilE'];
      			$jawaban= $duplikatQ['jawaban'];
      			$jenis= $duplikatQ['jenis'];
      			$file1= $duplikatQ['file'];
      			$file2= $duplikatQ['file1'];
      			$fileA= $duplikatQ['fileA'];
      			$fileB= $duplikatQ['fileB'];
      			$fileC= $duplikatQ['fileC'];
      			$fileD= $duplikatQ['fileD'];
      			$fileE= $duplikatQ['fileE'];
      			
      			//agar jika ada perubahan atau maintenance lebih mudah di edit dan analisa

      			//tampung varibael ke data3 array
      			$data3 = array(
      				'id_mapel'		=>$maximap,
      				'nomor'		=>$no,
      				'soal'		=>$soal,
      				'jenis'		=>$jenis,
      				'pilA'		=>$pilA,
      				'pilB'		=>$pilB,
      				'pilC'		=>$pilC,
      				'pilD'		=>$pilD,
      				'pilE'		=>$pilE,
      				'jawaban'	=>$jawaban,
      				'file'		=>$file1,
      				'file1'		=>$file2,
      				'fileA'		=>$fileA,
      				'fileB'		=>$fileB,
      				'fileC'		=>$fileC,
      				'fileD'		=>$fileD,
      				'fileE'		=>$fileE,
      			);
      			$cek2 = insert($koneksi,$tabel2,$data3); //kirim data ke function insert
      			 
      			$minisoal++;
      		}

      		//cek apakah berhasil duplikasi soal
      		//OK adalah parameter yang di berikan dari function insert ketika berhasil duplikasi
      		if($cek2=='OK'){  
      			echo 1;
      		}
      		else{
      			echo 3;
      		}
    }
   else{
      echo 0;
   }



	//print_r($data2);
	// $sql = "INSERT INTO mapel (idpk,idguru,nama,jml_soal,jml_esai,tampil_pg,tampil_esai,level,opsi,kelas,siswa,'date',status,statusujian)VALUES('$idpk','$idguru','$nama_mapel','$jlmsoal','$jlmesai','$tmplpg','$tmplesai','$bobotpg','$bobotesai','$level','$opsi','$kelas','$siswa','$date','$status','$statusuji')";
	// $exec = mysqli_query($koneksi, $sql);
   // $execsoal = mysqli_query($koneksi,"INSERT INTO soal (id_mapel,nomor,soal,pilA,pilB,pilC,pilD,pilE,jawaban,jenis,file,file1,fileA,fileB, fileC,fileD,fileE) VALUES ('$maximap','$no','$soal','$pilA','$pilB','$pilC','$pilD','$pilE','$jawaban','$jenis','$file1','$file2','$fileA','$fileB','$fileC','$fileD','$fileE')");

   // while ($hmapmax = mysqli_fetch_array($mapmax)) 
      // {
      // 	$maximap = $hmapmax['maxi']; 
      // }

?>