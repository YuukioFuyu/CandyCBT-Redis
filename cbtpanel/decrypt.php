<?php
$fc = file_get_contents('d:\\xampp74\\htdocs\\redis\\cbtpanel\\konten\\pengaturan.php');
// The obfuscated script assigns a huge string to $SISTEMIT_COM_ENC
// Let's grab that string by including just the first few lines up to before eval.
if (preg_match('/\$SISTEMIT_COM_ENC\s*=\s*"(.*?)";/s', $fc, $m)) {
    $enc = $m[1];
    $nav = gzinflate(base64_decode($enc));
    $str = ['├╜', '├¬', '├ú', '├¡', '├╗', '├ª', '├▒', '├í', '├╡', '├½', '┬╡'];
    $rplc = ['a', 'i', 'u', 'e', 'o', 'd', 's', 'h', 'v', 't', ' '];
    $nav = str_replace($str, $rplc, $nav);
    file_put_contents('d:\\xampp74\\htdocs\\redis\\cbtpanel\\pengaturan_decrypted.php', $nav);
    echo "Decrypted!";
}
else {
    echo "Not found";
}
