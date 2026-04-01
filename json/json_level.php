<?php 
require "../config/config.redis.php";

$redis= new Budut();

 
  header('Content-Type: application/json; charset=utf8');
  // header("Pragma: no-cache");
  // header("Expires: 0");
  // header("Content-Disposition: attachment; filename=json_siswa.json"); 
 
if(!empty($_GET['id'])){ 
  if($setting['db_token']==$_GET['id']){

   $sql ="SELECT * FROM  level";
   $array = $redis->getDataRedis('json_level',$sql);

  
  //mengubah data array menjadi json
   
    $json = array(
      'status' =>200,
      'aksi' =>'level',
      'pesan' =>'berhasil',
      'jumlah' => count($array),
      'data'  =>$array,
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