<?php 
require "../config/config.redis.php";

$redis= new Budut();

 
  header('Content-Type: application/json; charset=utf8');

if(!empty($_GET['id'])){ 
  if("hjHsEdJUsvWW3Rq9k0iZrjO8RhTjDbaGpIc0VkSlVzdldXM1JxOWswaVpyak84UmhUakRi"==$_GET['id']){
    //izin_status 
   $sql ="SELECT FROM soal WHERE mapel.status = 1";
   $table='setting';
   $data = array(
    'izin_status' =>0,
   );
   $where = array(
    'id_setting' =>1,
   );
   $cek = $redis->update($table,$data,$where);
     if($cek){
      $json = array(
        'status' =>200,
        'pesan' =>'Berhasil Update',
      );  
     }
     else{
      $json = array(
        'status' =>203,
        'pesan' =>'Gagal Update',
      );  
     }
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