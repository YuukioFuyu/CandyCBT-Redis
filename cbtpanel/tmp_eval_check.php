<?php
$fc = file_get_contents('d:\\xampp74\\htdocs\\redis\\cbtpanel\\konten\\pengaturan.php');
$php_blocks = explode('?>', $fc);
if (count($php_blocks) > 0) {
    echo "First PHP Block:\n";
    $first = $php_blocks[0];
    echo substr($first, 0, 100) . "\n...\n" . substr($first, -300) . "\n";
}
