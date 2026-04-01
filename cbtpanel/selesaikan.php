<?php
// require("../config/config.default.php");
include("core/c_admin.php"); 
require("../config/config.function.php");
require("../config/functions.crud.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;
	
/*
------ mryes
Untuk Menyelesaikan Secara Paksa Ujian
*/ 


$idnilai = $_POST['id'];
$nilai = fetch($koneksi, 'nilai', array('id_nilai' => $idnilai));
$idm = $nilai['id_mapel'];
$ids = $nilai['id_siswa'];
$idu = $nilai['kode_ujian'];
$iduj = $nilai['id_ujian'];
// $where = array(
// 	'id_mapel' => $idm,
// 	'id_siswa' => $ids,
// 	'kode_ujian' => $idu
// );
// $where2 = array(
// 	'id_mapel' => $idm,
// 	'id_siswa' => $ids,
// 	'id_ujian' => $iduj
// );

$where = array(
	'id_siswa' => $ids,
	'id_mapel' => $idm
);
$where2 = array(
	'id_siswa' => $ids,
	'id_mapel' => $idm,
	'id_ujian' => $iduj
);


$benar='benar_';
$salah='salah_';
$mapel = fetch($koneksi, 'mapel', array('id_mapel' => $idm));
$siswa = fetch($koneksi, 'siswa', array('id_siswa' => $ids));
$ceksoal = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 1));
$ceksoalesai = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 2));
$arrayjawab = array();
$arrayjawabesai = array();

foreach ($ceksoalesai as $getsoalesai) {
	$w2 = array(
		'id_siswa' => $ids,
		'id_mapel' => $idm,
		'id_soal' => $getsoalesai['id_soal'],
		'jenis' => 2
	);
	$getjwb2 = fetch($koneksi, 'jawaban', $w2);
	$arrayjawabesai[$getjwb2['id_soal']] = str_replace("'"," ",$getjwb2['esai']);
}

foreach ($ceksoal as $getsoal) {
	$w = array(
		'id_siswa' => $ids,
		'id_mapel' => $idm,
		'id_soal' => $getsoal['id_soal'],
		'jenis' => 1
	);

	$cekjwb = rowcount($koneksi, 'jawaban', $w);
	if ($cekjwb <> 0) {
		$getjwb = fetch($koneksi, 'jawaban', $w);
		$arrayjawab[$getjwb['id_soal']] = $getjwb['jawaban'];
		($getjwb['jawaban'] == $getsoal['jawaban']) ? ${$benar.$ids}++ : ${$salah.$ids}++;
	} else {
		${$salah.$ids}++;
	}
}

// $getjawab = fetch($koneksi, 'jawaban', $where2);
// $datanilai = array(
// 	'id_jawaban' 			=> $getjawab['id_jawaban'],
// 	'id_siswa' 				=> $getjawab['id_siswa'],
// 	'id_mapel' 				=> $getjawab['id_mapel'],
// 	'id_soal' 				=> $getjawab['id_soal'],
// 	'id_ujian'				=> $getjawab['id_ujian'],
// 	'jawaban' 				=> $getjawab['jawaban'],
// 	'jawabx' 					=> $getjawab['jawabx'],
// 	'jenis' 					=> $getjawab['jenis'],
// 	'esai' 						=> $getjawab['esai'],
// 	'nilai_esai' 			=> $getjawab['nilai_esai'],
// 	'ragu' 						=> $getjawab['ragu'],
// );


${$jumsalah.$ids} = $mapel['tampil_pg'] - ${$benar.$ids};
$bagi = $mapel['tampil_pg'] / 100;
$bobot = $mapel['bobot_pg'] / 100;
$skorx = (${$benar.$ids} / $bagi) * $bobot;
$skor = number_format($skorx, 2, '.', '');
//mryes


$data = array(
	'ujian_selesai' => $datetime,
	'jml_benar' => ${$benar.$ids},
	'jml_salah' => ${$jumsalah.$ids},
	'skor' => $skor,
	'total' => $skor,
	'online' => 0,
	'selesai' => 1,
	'jawaban' => serialize($arrayjawab),
	'jawaban_esai' => serialize($arrayjawabesai)
);

$da2=$db->Status_sudah_ujian($ids,$idm,$iduj);

if($da2==1){
	?><script type="text/javascript">alert('Upsss Siswa Sudah Di Isi Nilainya')</script><?php
}
else{
	$upnilai = update($koneksi, 'nilai', $data, $where);
	if($upnilai=='OK'){
		// $copy = insert($koneksi, 'jawaban_copy', $data);
		// if($copy=='OK'){
			delete($koneksi, 'jawaban', $where2);
			delete($koneksi, 'pengacak', $where);
		//}
	}
	//echo mysqli_error($koneksi);
	
}
//delete($koneksi, 'pengacakopsi', $where);
