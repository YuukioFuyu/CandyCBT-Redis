<?php 
require "../config/config.redis.php";

$redis= new Budut();

 
  header('Content-Type: application/json; charset=utf8');
  // header("Pragma: no-cache");
  // header("Expires: 0");
  // header("Content-Disposition: attachment; filename=json_siswa.json"); 


 
if(!empty($_GET['id'])){ 
  if($setting['db_token']==$_GET['id']){

   $sql ="SELECT
   id_soal,
   soal.id_mapel,
   nomor,
   soal,
   jenis,
   pilA,
   pilB,
   pilC,
   pilD,
   pilE,
   jawaban,
   file,
   file1,
   fileA,
   fileB,
   fileC,
   fileD,
   fileE 
   FROM soal INNER JOIN mapel ON mapel.id_mapel = soal.id_mapel WHERE mapel.status = 1";
   $array = $redis->getDataRedis('json_soal',$sql);

    $json = array(
      'status' =>200,
      'aksi' =>'soal',
      'pesan' =>'berasil',
      'jumlah' => count($array),
      'data' =>$array,
    );  
   
  //mengubah data array menjadi json
   echo json_encode($json);
  }
  else{
  	$json = array(
    'status' =>203,
    'pesan' =>'Token Tidak Sesuai',
  	 );  
  	echo json_encode($json);
  }
}else{
  $json = array(
    'status' =>203,
    'pesan' =>'Token Kosong',
     );  
    echo json_encode($json);
}
?>