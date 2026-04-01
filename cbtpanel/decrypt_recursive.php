<?php
$fc = file_get_contents('d:\\xampp74\\htdocs\\redis\\cbtpanel\\konten\\pengaturan.php');

$depth = 0;
while (true) {
    echo "Depth: $depth\n";
    // Usually the payload is $SISTEMIT_COM_ENC = "base64/zlib payload";
    // First, find the payload
    if (!preg_match('/\$SISTEMIT_COM_ENC\s*.\s*"(.*?)";/s', $fc, $m)) {
        echo "No more SISTEMIT_COM_ENC found.\n";
        break;
    }
    $enc = $m[1];
    $nav = @gzinflate(base64_decode($enc));
    if ($nav === false) {
        echo "Failed to gzinflate.\n";
        break;
    }
    $str = ['├╜', '├¬', '├ú', '├¡', '├╗', '├ª', '├▒', '├í', '├╡', '├½', '┬╡'];
    $rplc = ['a', 'i', 'u', 'e', 'o', 'd', 's', 'h', 'v', 't', ' '];
    $nav = str_replace($str, $rplc, $nav);

    // Check if it's valid code or still obfuscated
    if (strpos($nav, 'SISTEMIT_COM_ENC') !== false) {
        $fc = $nav;
        $depth++;
    }
    else {
        echo "Decrypted fully at depth $depth!\n";
        $fc = $nav;
        break;
    }
    if ($depth > 100) {
        echo "Too deep!\n";
        break;
    }
}

file_put_contents('d:\\xampp74\\htdocs\\redis\\cbtpanel\\pengaturan_decrypted_final.php', $fc);
echo "Done saving to pengaturan_decrypted_final.php\n";
