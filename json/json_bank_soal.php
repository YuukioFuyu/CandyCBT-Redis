<?php 
require "../config/config.redis.php";

$redis= new Budut();
 
  header('Content-Type: application/json; charset=utf8');
  // header("Pragma: no-cache");
  // header("Expires: 0");
  // header("Content-Disposition: attachment; filename=json_siswa.json"); 
 
if(!empty($_GET['id'])){ 
  if($setting['db_token']==$_GET['id']){

   $sql ="SELECT *,mapel.nama as nama_mapel, mapel.level as level_mapel FROM  mapel INNER JOIN pengawas ON pengawas.id_pengawas =  mapel.idguru where status=1";
   $data = $redis->getDataRedis('json_bank_soal',$sql);
  
  //mengubah data array menjadi json
   
    $json = array(
      'status' =>200,
      'pesan' =>'berhasil',
      'aksi' =>'bank_soal',
      'jumlah' => count($data),
      'data'  =>$data,
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