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
    $dir    = '../files/';
    $files = scandir($dir);
    $allowed_ext_program = array('php','PHP','js','htaccess');
    foreach ($files as $file) {   
     $tmp = explode(".", $file);
     $file_ext = end($tmp);
     if (in_array($file_ext, $allowed_ext_program)) {
        
      }
      else{
        $lokasifile2 = $file;
        if($lokasifile2 ==='.' or $lokasifile2==='..'){ continue; }
        else{
          $lokasifile = $lokasifile2;
          if($lokasifile ==='.' or $lokasifile==='..'){ continue; }
          else{
            $lokasifile3 = $lokasifile;
          }
        }
        $data_array[] =$lokasifile3;
      }
      
    }
   
  

    $json = array(
      'status' =>200,
      'aksi' =>'file_pendukung',
      'pesan' =>'berasil',
      'jumlah' => count($data_array),
      'data' =>$data_array,
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