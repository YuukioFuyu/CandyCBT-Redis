<?php
$lines = file('d:\\xampp74\\htdocs\\redis\\cbtpanel\\konten\\pengaturan.php');
foreach ($lines as $k => $v) {
    if (strpos($v, 'SISTEMIT_COM_ENC') !== false || strpos($v, 'eval') !== false || strpos($v, 'base64_decode') !== false) {
        echo "Line " . ($k + 1) . ": " . substr(trim($v), 0, 100) . " ... " . substr(trim($v), -100) . "\n";
    }
}
