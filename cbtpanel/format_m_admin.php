<?php
$c = file_get_contents('d:\xampp74\htdocs\redis\config\m_admin_clean.php');
echo count(explode("\n", $c)) . " lines originally.\n";
$pretty = str_replace([';', '{', '}'], [";\n", "{\n", "}\n"], $c);
file_put_contents('d:\xampp74\htdocs\redis\config\m_admin_pretty.php', $pretty);
echo "Saved to m_admin_pretty.php\n";
