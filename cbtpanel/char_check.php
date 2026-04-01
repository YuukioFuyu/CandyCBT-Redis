<?php
$content = file_get_contents('m_admin_dec.php');
$s = substr($content, 0, 50);
for ($i = 0; $i < strlen($s); $i++) {
    echo $s[$i] . " -> " . dechex(ord($s[$i])) . "\n";
}
?>
