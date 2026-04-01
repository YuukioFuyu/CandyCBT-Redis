<?php
$fc = file_get_contents('d:\\xampp74\\htdocs\\redis\\cbtpanel\\eval_dump.php');
$fc = mb_convert_encoding($fc, 'UTF-8', 'UTF-16LE');
file_put_contents('d:\\xampp74\\htdocs\\redis\\cbtpanel\\eval_dump_utf8.php', $fc);
echo "done";
