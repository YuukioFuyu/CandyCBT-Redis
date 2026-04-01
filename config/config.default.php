<?php
error_reporting(0);

session_cache_expire(0);
session_cache_limiter(0);

include_once __DIR__ . '/setting_database.php';
$redisHost = isset($_ENV['REDIS_HOST']) ? $_ENV['REDIS_HOST'] : '127.0.0.1';
$redisPort = isset($_ENV['REDIS_PORT']) ? $_ENV['REDIS_PORT'] : 6379;
$redisUser = isset($_ENV['REDIS_USERNAME']) ? $_ENV['REDIS_USERNAME'] : '';
$redisPass = isset($_ENV['REDIS_PASSWORD']) ? $_ENV['REDIS_PASSWORD'] : '';
$redisPrefix = isset($_ENV['REDIS_PREFIX']) ? $_ENV['REDIS_PREFIX'] . 'PHPREDIS_SESSION:' : 'PHPREDIS_SESSION:';
$redisDb = isset($_ENV['REDIS_DATABASE']) ? $_ENV['REDIS_DATABASE'] : 0;
$redisTimeout = isset($_ENV['REDIS_TIMEOUT']) ? $_ENV['REDIS_TIMEOUT'] : 0;

$authString = "";
if (!empty($redisUser) || !empty($redisPass)) {
    $authString = rawurlencode($redisUser) . ':' . rawurlencode($redisPass) . '@';
}
$redisSavePath = "redis://{$authString}{$redisHost}:{$redisPort}?prefix={$redisPrefix}&timeout={$redisTimeout}&database={$redisDb}";

ini_set('session.save_handler', 'redis');
ini_set('session.save_path', $redisSavePath);

session_start();
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
