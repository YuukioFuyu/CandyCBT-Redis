<?php
require("../../config/excel_reader2.php");
require("../../config/config.default.php");
require "../../config/config.function.php";
//setting up one redis-----------------------------------------
require "../../vendor/autoload.php";
use RedisClient\RedisClient;
use RedisClient\Client\Version\RedisClient2x6;
use RedisClient\ClientFactory;

$Redis = new RedisClient();

//setting up one redis-----------------------------------------
if($token == $token1) {

  $output = '';
  if (isset($_FILES['zip_file']['name'])) {

    $file_name = $_FILES['zip_file']['name'];
    $array = explode(".", $file_name);
    $name = $array[0];
    $ext = $array[1];

    $allowed_ext_program = array('php','PHP','js','css','htaccess');
    $allowed_ext = array('jpg', 'png', 'jpeg', 'gif', 'mp3', 'wav');

    if ($ext == 'zip') {
      $path = '../../files/';
      $location = $path . $file_name;
      if (move_uploaded_file($_FILES['zip_file']['tmp_name'], $location)) {
        $zip = new ZipArchive;
        if ($zip->open($location) === TRUE) {
          // $zip->extractTo($path);
          // $zip->close();
          
          //$zip->getNameIndex ambil nama file
          //$zip->getFromIndex open isi file
          $cekno =0;
          for ($i = 0; $i <= $zip->numFiles; $i++) {
            $extensi = explode(".", $zip->getNameIndex($i));
            $file_ext = end($extensi);

            
            if (in_array($file_ext, $allowed_ext_program)) {
              $cekno++;
            }
          }

          if($cekno > 0){
            echo 'BAHAYA';
          }
          else{
            $zip->extractTo($path);
            $zip->close();
          
            $files = scandir($path);

              //$name is extract folder from zip file  
              foreach ($files as $file) {
                $tmp = explode(".", $file);
                $file_ext = end($tmp);

                if (in_array($file_ext, $allowed_ext)) {

                  $output .= '<div class="col-md-3"><div style="padding:16px; border:1px solid #CCC;"><img class="img img-responsive" style="height:150px;" src="../../files/' . $file . '"   /></div></div>';
                }
                if (in_array($file_ext, $allowed_ext_program)) {
                    $lokasifile = '../../files/'.$file;
                    unlink($lokasifile);
                   
                }
              }
               try { $Redis->flushall(); }catch (Exception $e) { } 
              unlink($location);
              echo "OK";
            }
          }
        }
    } else {
      unlink($location);
      echo "GAGAL";
    }
  }

}
else{
  jump("$homeurl");

}

