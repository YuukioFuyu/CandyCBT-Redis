<?php
function decrypt_layer($code) {
    // Some obfuscators will use eval(gzinflate(base64_decode(...)));
    // We want to find the LAST "eval(" or "eval (" and replace it with "return ("
    $pos = strrpos($code, 'eval');
    if ($pos === false) return false;
    
    // Replace "eval" with "return"
    $modified_code = substr_replace($code, 'return ', $pos, 4);
    
    // Execute the code using "eval('?>'.$modified_code)" to properly parse an exact file
    // Note: If the code uses return in the global scope like this, eval will return the value!
    ob_start();
    try {
        $result = eval("?> " . $modified_code);
    } catch (Throwable $e) {
        $result = false;
        echo "Error: " . $e->getMessage() . "\n";
    }
    ob_end_clean();
    
    return $result;
}

$file_in = 'd:\xampp74\htdocs\redis\cbtpanel\konten\pengaturan.php';
$code = file_get_contents($file_in);

for ($i = 0; $i < 100; $i++) {
    if (strpos($code, 'eval') === false) {
        echo "Decryption complete after $i iterations!\n";
        break;
    }
    
    $next_layer = decrypt_layer($code);
    
    if ($next_layer === false || empty($next_layer) || $next_layer === $code) {
        echo "Decryption stopped or failed at iteration $i.\n";
        break;
    }
    
    $code = $next_layer;
}

file_put_contents('d:\xampp74\htdocs\redis\cbtpanel\pengaturan_decrypted_final.php', $code);
echo "Final saved.\n";
