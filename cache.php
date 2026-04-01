<?php 
error_reporting(0);
//setting up one redis-----------------------------------------
include_once __DIR__ . '/config/setting_database.php';
$Redis = new Redis();
$host = isset($_ENV['REDIS_HOST']) ? $_ENV['REDIS_HOST'] : '127.0.0.1';
$port = isset($_ENV['REDIS_PORT']) ? $_ENV['REDIS_PORT'] : 6379;
$timeout = isset($_ENV['REDIS_TIMEOUT']) ? $_ENV['REDIS_TIMEOUT'] : 0;
$password = isset($_ENV['REDIS_PASSWORD']) ? $_ENV['REDIS_PASSWORD'] : '';
$username = isset($_ENV['REDIS_USERNAME']) ? $_ENV['REDIS_USERNAME'] : '';
$database = isset($_ENV['REDIS_DATABASE']) ? $_ENV['REDIS_DATABASE'] : 0;

try {
    $Redis->connect($host, $port, $timeout);
    if (!empty($password)) {
        if (!empty($username)) {
            $Redis->auth([$username, $password]);
        } else {
            $Redis->auth($password);
        }
    }
    if ($database > 0) {
        $Redis->select($database);
    }
} catch (Exception $e) { }
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