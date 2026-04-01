<?php
error_reporting(0);

session_cache_expire(0);
session_cache_limiter(0);

require_once __DIR__ . '/config.session.php';
set_time_limit(0);

(isset($_SESSION['id_user'])) ? $id_user = $_SESSION['id_user'] : $id_user = 0;

include 'setting_url.php';
//cek session token dan cek validasi token
if(isset($_SESSION['token']) and isset($_SESSION['token1'])){
$data22 = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting "));
$token = $data22['db_token'];

$token1 = $data22['db_token1'];

}
else{
$token =2;
$token1 =100;
}


define("KEY", "76310EEFF2B5D3C887F238976A421B638CFEB0942AB8249CD0A29B125C91B3E5");

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape')) {
	$browser = 'Netscape';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
	$browser = 'Firefox';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
	$browser = 'Chrome';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
	$browser = 'Opera';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
	$browser = 'Internet Explorer';
} else $browser = 'Other';
