<?php 
require "../config/config.redis.php";

$redis= new Budut();

 
  header('Content-Type: application/json; charset=utf8');
  // header("Pragma: no-cache");
  // header("Expires: 0");
  // header("Content-Disposition: attachment; filename=json_siswa.json"); 


 
if(!empty($_GET['id'])){ 
  if($setting['db_token']==$_GET['id']){

   $sql ="SELECT * FROM  kelas";
   $log=$redis->con->query($sql) or die($redis->con->error);
   foreach ($log as $value) { $kelas[]=$value; }

   $sql ="SELECT * FROM  pk";
   $log=$redis->con->query($sql) or die($redis->con->error);
   foreach ($log as $value) { $jurusan[]=$value; }

   $sql ="SELECT * FROM  sesi";
   $log=$redis->con->query($sql) or die($redis->con->error);
   foreach ($log as $value) { $sesi[]=$value; }

   $sql ="SELECT * FROM  ruang";
   $log=$redis->con->query($sql) or die($redis->con->error);
   foreach ($log as $value) { $ruang[]=$value; }

   $sql ="SELECT * FROM  server";
   $log=$redis->con->query($sql) or die($redis->con->error);
   foreach ($log as $value) { $server[]=$value; }

   // $sql ="SELECT * FROM  siswa";
   // $log=$redis->con->query($sql) or die($redis->con->error);
   // foreach ($log as $value) { $siswa[]=$value; }
   
   $data_json = array(

      'data_kelas' => array(
        'jumlah' => count($kelas),
        'data'   => $kelas,
      ),

      'data_server' => array(
        'jumlah' => count($server),
        'data'   => $server,
      ),

      'data_sesi'=> array(
        'jumlah' => count($sesi),
        'data'   => $sesi,
      ),

      'data_ruang'=> array(
        'jumlah' => count($ruang),
        'data'   => $ruang,
      ),

      'data_jurusan'=> array(
        'jumlah' => count($jurusan),
        'data'   => $jurusan,
      ),

      // 'data_siswa'=> array(
      //   'jumlah' => count($siswa),
      //   'data'   => $siswa,
      // ),

   );

    
      // $data_kelas = array(
      //   'jumlah' => count($kelas),
      //   'data'   => $kelas,
      // );

      // $data_server = array(
      //   'jumlah' => count($server),
      //   'data'   => $server,
      // );

      // $data_sesi=array(
      //   'jumlah' => count($sesi),
      //   'data'   => $sesi,
      // );

      // $data_ruang = array(
      //   'jumlah' => count($ruang),
      //   'data'   => $ruang,
      // );

      // $data_jurusan = array(
      //   'jumlah' => count($jurusan),
      //   'data'   => $jurusan,
      // );

    $json = array(
      'status' =>200,
      'aksi' =>'data_master',
      'pesan' =>'berasil',
      // 'jumlah' => count($data_json),
      'datanya' => $data_json
      // 'data_server'   => $data_server,
      // 'data_jurusan'  => $data_jurusan,
      // 'data_kelas'    => $data_kelas,
      // 'data_sesi'     => $data_sesi,
      // 'data_ruang'    => $data_ruang,

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