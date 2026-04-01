<?php 
require "config/setting_url.php";
 
// $query = "select * from data";
// $hasil  =mysqli_query($koneksi, "SELECT * FROM nilai");
 
  header('Content-Type: application/json; charset=utf8');
  // header("Pragma: no-cache");
  // header("Expires: 0");
  // header("Content-Disposition: attachment; filename=json_siswa.json"); 


 //untuk sementara parameter url $_GET['id'] tidak di enkripsi
 
if(!empty($_GET['id'])){ 
  if($setting['db_token']==$_GET['id']){


   //query tabel produk
   //$sql="SELECT * FROM nilai";
   $query=mysqli_query($koneksi, "SELECT * FROM soal a LEFT JOIN mapel b ON a.id_mapel=b.id_mapel WHERE b.status='1'") or die(mysqli_error());
  //data array
   $array=array();
   while($data=mysqli_fetch_array($query)){
   	$array[]=array(
   		'id_soal' => $data['id_soal'],
   		'id_mapel' => $data['id_mapel'],
   		'nomor' => $data['nomor'],
   		'soal' => $data['soal'],
   		'jenis' => $data['jenis'],
   		'pila' => $data['pilA'],
   		'pilb' => $data['pilB'],
   		'pilc' => $data['pilC'],
   		'pild' => $data['pilD'],
   		'pile' => $data['pilE'],
   		'jawaban' => $data['jawaban'],
   		'file' => $data['file'],
   		'file1' => $data['file1'],
   		'filea' => $data['fileA'],
   		'fileb' => $data['fileB'],
   		'filec' => $data['fileC'],
   		'filed' => $data['fileD'],
   		'filee' => $data['fileE'],

   	);
   }
   // $json = array(
   // 	'status' =>'sukses',
   // 	'data' =>$array
   // );  
   
  //mengubah data array menjadi json
   echo json_encode($array);
  }
  else{
  	$json = array(
   	'status' =>'error',
    'pesan' =>'Token Tidak Sesuai',
  	 );  
  	echo json_encode($json);
  }
}else{
  $json = array(
    'status' =>'error',
    'pesan' =>'Token Kosong',
     );  
    echo json_encode($json);
}
?>