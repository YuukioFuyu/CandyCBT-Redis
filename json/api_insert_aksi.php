<?php 
require "../config/setting_url.php";
require("../config/functions.crud.php");
 
  header('Content-Type: application/json; charset=utf8');
  // header("Pragma: no-cache");
  // header("Expires: 0");
  // header("Content-Disposition: attachment; filename=json_siswa.json"); 

if(!empty($_GET['id'])){ 
  if($setting['db_token']==$_GET['id']){
      $query=mysqli_query($koneksi, "SELECT * FROM  server") or die(mysqli_error());
      $cek = mysqli_fetch_array($query);
    if($cek['kode_server'] == $_GET['kode']){
    //   $json = array(
    //     'status' =>200,
    //     'pesan' =>'Berhasil',
    //     'data' =>'Server Aktif', 
    //   );     
        $data = json_decode($_GET['data']);
            $dataArray = array(
              'tssKode'           =>$data->tssKode,
              'tssNama'           =>base64_decode($data->tssNama),
              'tssKepalaSekolah'  =>base64_decode($data->tssKepalaSekolah),
              'tssOpretator'      =>base64_decode($data->tssOpretator),
              'tssDateSinkron'    =>base64_decode($data->tssDateSinkron),
              'tssNamaSinkron'    =>$data->tssNamaSinkron,
              'tssJmlDataOk'      =>$data->tssJmlDataOk,
              'tssJmlDataNo'      =>$data->tssJmlDataNo,
            );
            $where = array(
             'tssKode'           =>$data->tssKode,
             'tssNamaSinkron'    =>$data->tssNamaSinkron,
            );
        $cek = fetch($koneksi,'total_sekolah_sinkron',$where);
        if(count($cek) > 1){
             update($koneksi, 'total_sekolah_sinkron',$dataArray,$where);
        }
        else{
            insert($koneksi, 'total_sekolah_sinkron',$dataArray);
        }

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