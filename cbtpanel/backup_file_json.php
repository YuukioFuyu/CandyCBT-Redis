<?php 
include("core/c_admin.php"); 
if($token == $token1) {
  $id = $_GET['id'];
  
  header('Content-Type: application/json; charset=utf8');
  header("Pragma: no-cache");
  header("Expires: 0");
  header("Content-Disposition: attachment; filename=$id.json"); 

  if($id == "mapel"){
    $sql ="SELECT *,mapel.nama as nama_mapel, mapel.level as level_mapel FROM  mapel INNER JOIN pengawas ON pengawas.id_pengawas =  mapel.idguru where status=1";
  }
  else{
    $sql ="SELECT * FROM  $id";
  }
  
  $array = $db->getDataRedis($id,$sql);

    $json = array(
      'status' =>200,
      'aksi' =>$id,
      'pesan' =>'berasil',
      'jumlah' => count($array),
      'data' =>$array,
    );  
  
  
   echo json_encode($json);
 
}
else{
  jump("$homeurl");
  //echo"keluar";
}

?>