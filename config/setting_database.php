<?php 
/*
  Mohon untuk bisa mejaga Lisensi yang sudah di dapat dari admin
  Tidak menyebar luaskan Souce Code yang sudah di berika
  Jika Terdeteksi 1 Lisensi di gunakan berbeda Instansi 
  Makan admin akan melakukan blokir Lisensi 
  Dan akan di stop support 
  Terimakasih
*/
//======Pengaturan Koneksi Database======================================
$envFile = __DIR__ . '/../.env';
$env = [];
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
    foreach ($env as $key => $value) {
        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

$hostdb = isset($_ENV['DATABASE_HOST']) ? $_ENV['DATABASE_HOST'] : 'localhost';
$userdb = isset($_ENV['DATABASE_USERNAME']) ? $_ENV['DATABASE_USERNAME'] : 'root';
$passdb = isset($_ENV['DATABASE_PASSWORD']) ? $_ENV['DATABASE_PASSWORD'] : '';
$namadb = isset($_ENV['DATABASE_NAME']) ? $_ENV['DATABASE_NAME'] : 'redis3';
$kodeRedis = isset($_ENV['REDIS_PREFIX']) ? $_ENV['REDIS_PREFIX'] : 'redis13'; //untuk kode cache redis, isikan saja sesuka hati contoh "ruang1" jadi "ruangku" 

//koneksi database server
/*
koneksi database server di gunakan untuk menghubungkan 2 aplikasi cbt atau lebih pada 1 server utama
jadi 1 server utaman akan membagi soal jadwal dll
server cbt clint akan mengirim hasil nilai ujian ke server utama
*/
// $hostdb_server = '';
// $userdb_server = 'cbtus1';
// $passdb_server = 'cbtus1';
// $namadb_server = 'cbtus1';

//=========Pengaturan Panel Admin=========================================
/*
Di gunakan untuk mengganti nama panel adminya
Jika akan di ganti pastikan juga 
Nama foldernya di ganti juga
Folder panel adminya
*/
$crew ='cbtpanel';

//=========================================================================
$linkguru = 'guru'; //untuk menuju ke folder guru
$serverApiKu='server_api';


?>