<?php
$fc = file_get_contents('d:\\xampp74\\htdocs\\redis\\cbtpanel\\konten\\pengaturan.php');
if (preg_match('/eval\(base64_decode\((.*?)\)\);/', $fc, $matches)) {
    $var_name = $matches[1];
    echo "Eval base64_decode uses variable: $var_name\n";
    // We can just execute the script but replace eval with echo
    $decoding_script = str_replace('eval(base64_decode($rand));', 'echo base64_decode($rand);', $fc);
    file_put_contents('d:\\xampp74\\htdocs\\redis\\cbtpanel\\tmp_dec2.php', $decoding_script);
    echo "Wrote modified script to tmp_dec2.php\n";
}
else {
    echo "Could not find eval\n";
}
