<?php 
require "../config/config.redis.php";

$redis= new Budut();
 
  header('Content-Type: application/json; charset=utf8');
  // header("Pragma: no-cache");
  // header("Expires: 0");
  // header("Content-Disposition: attachment; filename=json_siswa.json"); 

if(!empty($_GET['id'])){ 
  if($setting['db_token']==$_GET['id']){

   $sql ="SELECT * FROM  server where status='aktif' ";
   $data = $redis->getDataRedis('server',$sql);
   $data1 = $data[0];

    if($data1->kode_server == $_GET['kode']){
      $json = array(
        'status' =>200,
        'pesan' =>'Berhasil',
        'data' =>'Server Aktif', 
      );     
    }
    else{
      $json = array(
        'status' =>203,
        'pesan' =>'Kode Server Tidak Di Temukan',
        'data' =>'Server Aktif', 
      );     
    }  
  
   echo json_encode($json);
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