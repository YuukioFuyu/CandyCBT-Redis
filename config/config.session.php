<?php
include_once __DIR__ . '/setting_database.php';

$redisHost = isset($_ENV['REDIS_HOST']) ? $_ENV['REDIS_HOST'] : '127.0.0.1';
$redisPort = isset($_ENV['REDIS_PORT']) ? $_ENV['REDIS_PORT'] : 6379;
$redisUser = isset($_ENV['REDIS_USERNAME']) ? $_ENV['REDIS_USERNAME'] : '';
$redisPass = isset($_ENV['REDIS_PASSWORD']) ? $_ENV['REDIS_PASSWORD'] : '';
$redisPrefix = urlencode(isset($_ENV['REDIS_PREFIX']) ? $_ENV['REDIS_PREFIX'] . 'sessions:' : 'sessions:');

$authString = "";
if (!empty($redisUser) && !empty($redisPass)) {
    $authString = "&auth%5B0%5D=" . urlencode($redisUser) . "&auth%5B1%5D=" . urlencode($redisPass);
} elseif (!empty($redisPass)) {
    $authString = "&auth=" . urlencode($redisPass);
}

$redisSavePath = "tcp://{$redisHost}:{$redisPort}?prefix={$redisPrefix}{$authString}";

ini_set('session.save_handler', 'redis');
ini_set('session.save_path', $redisSavePath);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
