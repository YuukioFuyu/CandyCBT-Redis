<?php
include("core/c_admin.php"); 
require("../config/config.function.php");
require("../config/functions.crud.php");
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;
	
	/*mryes*/
	$post = $_POST;

	//print_r($post);

	$jawab = $post['jawab'];
	$atas = $post['atas'];
	$kiri = $post['kiri'];
	$tinggi = $post['tinggi'];
	$lebar = $post['lebar'];

	$data = array(
		'header_kartu' => $jawab,
		'kartu_atas' => $atas,
		'kartu_kiri' => $kiri,
		'kartu_tinggi' => $tinggi,
		'kartu_lebar' => $lebar
	);

	$where =array(
		'id_setting' =>1
	);
	//print_r($data);

	$table ='setting';
    
    $cek2 = update($koneksi,$table,$data,$where);
    if($cek2){
    	echo"oke";
    }
    else{
    	echo"gagal";
    }

    if($post['aksi']=='block'){
    	$data2 = array(
		'judul_block' => $post['judul'],
		'isi_block' => $post['isi'],
		'footer_block' => $post['footer']
		);
		$where2 =array(
		'id_block' =>1
		);
		$table2 ='tb_block';
		$cek3 = update($koneksi,$table2,$data2,$where2);
		if($cek3){
	    	echo"oke";
	    }
	    else{
	    	echo"gagal";
	    }
    }

	
?>
	