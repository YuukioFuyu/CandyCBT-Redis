<?php
$file_in = 'd:\xampp74\htdocs\redis\cbtpanel\konten\pengaturan.php';
$code = file_get_contents($file_in);

for ($i = 0; $i < 100; $i++) {
    // If there is no eval, we are done
    if (strpos($code, 'eval(') === false && stripos($code, 'eval (') === false) {
        echo "Decrypted completely after $i iterations.\n";
        break;
    }

    // Replace the *last* eval with an echo or simply replace eval( with return( so we can capture it.
    // The obfuscation typically looks like eval(str_replace(..., gzinflate(base64_decode($var))));
    // A safe way is to change the first "eval" (or the one doing the main payload) to "return".

    // Some obfuscators have multiple evals, but usually the last one executes the decoded string.
    $pos = strrpos($code, 'eval');
    if ($pos !== false) {
        // Change eval to return
        $code = substr_replace($code, 'return ', $pos, 4);

        // Remove <?php tags if present
        $code = str_replace('<?php', '', $code);
        $code = str_replace('?>', '', $code);

        // Execute to get the next layer
        $next_code = eval($code);

        if ($next_code === false || empty($next_code)) {
            echo "Failed to evaluate at iteration $i.\n";
            file_put_contents('d:\xampp74\htdocs\redis\cbtpanel\eval_failed.php', $code);
            break;
        }

        $code = $next_code;
    }
    else {
        break;
    }
}

file_put_contents('d:\xampp74\htdocs\redis\cbtpanel\pengaturan_decrypted_final.php', $code);
echo "Final saved.\n";
