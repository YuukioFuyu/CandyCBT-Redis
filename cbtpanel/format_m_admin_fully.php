<?php
$c = file_get_contents('d:\xampp74\htdocs\redis\config\m_admin_fully_clean.php');
$pretty = str_replace([';', '{', '}'], [";\n", "{\n", "}\n"], $c);
file_put_contents('d:\xampp74\htdocs\redis\config\m_admin_fully_pretty.php', $pretty);
echo "Saved to m_admin_fully_pretty.php\n";
