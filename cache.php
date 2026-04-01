<?php 
error_reporting(0);
//setting up one redis-----------------------------------------
require "vendor/autoload.php";
use RedisClient\RedisClient;
use RedisClient\Client\Version\RedisClient2x6;
use RedisClient\ClientFactory;

$Redis = new RedisClient();

//setting up one redis-----------------------------------------

$Redis->del("baca_materi41"); //hapus cache keys
//cek jika server redis off
// try {
//    $Redis->ping();
// } catch (Exception $e) {
//     //echo $e->getMessage();
//     if($e->getMessage()){
//       echo"tidak ada coneksi";
//     }
// }




// die;
// echo $Redis->quit();
// echo("<br>");
// echo "Support Versi ".$Redis->getSupportedVersion();
// echo("<br>");
// echo "Server Versi ". $Redis->info('Server')['redis_version'];
// if($Redis){
//   echo "string";
// }
// else{
//   echo "asdw";
// }
// var_dump($Redis);
//var_dump($Redis->info());

//cek jika server redis off



// //perintah redis untuk membuat key dan cek key kemudian retrun data ---------------------
// if($Redis->exists("redisku"))
// {
//   $value = json_decode($Redis->get("redisku"));
  
//   foreach ($value as $val) {
//    echo $val.'<br>';
//   }
// }
// else{
//   //set/up the key
//   $data = [
//     "cinta" =>"dia",
//     "cinta2" =>"dia2",
//   ];
//   $Redis->set("redisku", json_encode($data));

//   //set the expiration with the TTL value from (1)
//    $Redis->expire("redisku",10); 

//   foreach ($data as $val) {
//    echo $val.'<br>';
//   }
// }
// // end perintah redis untuk membuat key dan cek key kemudian retrun data ---------------------

// //cek koneksi cache redis

//   if($Redis->ping()){
//     echo"Koneksi Redis Aktif";
//   }
//   else{
//     echo"Koneksi Cache Redis Tidak Aktif";
//   }
  


?>