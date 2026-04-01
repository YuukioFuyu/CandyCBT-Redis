<?php 

//-------------Jika di Localhost-----------------
$uri = $_SERVER['REQUEST_URI'];
$pageurl = explode("/", $uri);
if ($uri == '/') {
    $homeurl = "http://" . $_SERVER['HTTP_HOST'];
    (isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
    (isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
    (isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;
} else {
    $homeurl = "http://" . $_SERVER['HTTP_HOST'] . "/" . $pageurl[1];
    (isset($pageurl[2])) ? $pg = $pageurl[2] : $pg = '';
    (isset($pageurl[3])) ? $ac = $pageurl[3] : $ac = '';
    (isset($pageurl[4])) ? $id = $pageurl[4] : $id = 0;
}

//-------------Jika di Localhost-----------------

//---Matikan Salah Satu 

//-------------Jika di Hosting-----------------
//$uri = $_SERVER['REQUEST_URI'];
//$pageurl = explode("/",$uri);

//$homeurl = "http://".$_SERVER['HTTP_HOST']; //---tambah s pada http jika web sudah mendukung https
//(isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
//(isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
//(isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;
//-------------Jika di Hosting-----------------

function WaktuLamaCache2(){ // ganti untuk lama waktu cache
    return 3600; //dalam detik
    //1 jam 3600, 30 menit = 1800,10 menit=600,20 menit = 1200,5 menit = 300
}
require "config.database.php";

$setting = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'"));

//time CBT ------------------------------------
$no = $jam = $mnt = $dtk = 0;
$info = '';
$waktu = date('H:i:s');
$tanggal = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');



if (strpos($_SERVER['HTTP_SEC_CH_UA'], 'Edge')) {
    // Blok kode untuk browser Edge
} else if (strpos($_SERVER['HTTP_SEC_CH_UA'], 'Chrome')) {
    // Blok kode untuk browser Chrome
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'cbt-') !== false) {
    // Blok kode untuk izin akses string UA "cbt-"
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'cbtredis') !== false) {
    // Blok kode untuk izin akses string UA "cbt-    
} else if (strpos($_SERVER['HTTP_SEC_CH_UA_MOBILE'], 'cbtredis')) {
    // Blok kode untuk browser cbtredis
} else if (strpos($_SERVER['HTTP_SEC_CH_UA_MOBILE'], '')) {
    // Blok kode untuk browser mobile
    
} else {
    header('Location: warningbro.html');
}

?>