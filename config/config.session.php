<?php
include_once __DIR__ . '/setting_database.php';

$redisHost = isset($_ENV['REDIS_HOST']) ? $_ENV['REDIS_HOST'] : '127.0.0.1';
$redisPort = isset($_ENV['REDIS_PORT']) ? $_ENV['REDIS_PORT'] : 6379;
$redisUser = isset($_ENV['REDIS_USERNAME']) ? $_ENV['REDIS_USERNAME'] : '';
$redisPass = isset($_ENV['REDIS_PASSWORD']) ? $_ENV['REDIS_PASSWORD'] : '';
$redisPrefix = isset($_ENV['REDIS_PREFIX']) ? $_ENV['REDIS_PREFIX'] . 'PHPREDIS_SESSION:' : 'PHPREDIS_SESSION:';
$redisDb = isset($_ENV['REDIS_DATABASE']) ? $_ENV['REDIS_DATABASE'] : 0;
$redisTimeout = isset($_ENV['REDIS_TIMEOUT']) ? $_ENV['REDIS_TIMEOUT'] : 0;

$authString = "";
if (!empty($redisUser) && !empty($redisPass)) {
    $authString = "&auth=[" . $redisUser . "," . $redisPass . "]";
} elseif (!empty($redisPass)) {
    $authString = "&auth=" . $redisPass;
}
$redisSavePath = "tcp://{$redisHost}:{$redisPort}?prefix={$redisPrefix}&timeout={$redisTimeout}&database={$redisDb}{$authString}";

ini_set('session.save_handler', 'redis');
ini_set('session.save_path', $redisSavePath);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
