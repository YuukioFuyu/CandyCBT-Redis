<?php 
require "../config/config.redis.php";

$redis= new Budut();

 
  header('Content-Type: application/json; charset=utf8');
  // header("Pragma: no-cache");
  // header("Expires: 0");
  // header("Content-Disposition: attachment; filename=json_siswa.json"); 


 //untuk sementara parameter url $_GET['id'] tidak di enkripsi
 
if(!empty($_GET['id'])){ 
  if($setting['db_token']==$_GET['id']){

   $sql ="SELECT * FROM  siswa ";
   $array = $redis->getDataRedis('json_data_siswa',$sql);

    $json = array(
      'status' =>200,
      'aksi' =>'siswa',
      'pesan' =>'berasil',
      'jumlah' => count($array),
      'data' =>$array,
    );  
  
  
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