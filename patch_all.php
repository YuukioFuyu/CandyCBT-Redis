<?php
// Script to patch all required files in one go
// Place this script in the root directory (e.g. redis/patch_all.php) and run it via browser or CLI.

$base_dir = __DIR__;

echo "<pre>";
echo "Starting patch process...\n\n";

// 1. Patch config/m_admin.php
$m_admin_file = $base_dir . '/config/m_admin.php';
if (file_exists($m_admin_file)) {
    $c = file_get_contents($m_admin_file);

    // Bypass License / User Check
    if (strpos($c, 'function CekUserRedis($id)') !== false && strpos($c, 'return json_decode') === false) {
        $c = preg_replace('/function CekUserRedis\(\$id\)\{.*?\}/s', 'function CekUserRedis($id){ return json_decode( \'{"status": "oke", "data": {"statusUser": "Aktif", "NamaSekolah": "Sekolah Portabel", "NamaSekolah2": "Sekolah Portabel", "aktif": 1, "Lisensi": "12345", "Paket": {"KodePaket": "VIP"}, "TokenTelegram": "", "IdTelegram": "", "Keterangan": "Lisensi Bebas"}}\'); }', $c);
    }

    // Disable telegram and hacker protection if they exist in m_admin.php
    $c = str_replace('function PengamanHacker($id){', 'function PengamanHacker($id){return;', $c);
    $c = str_replace('function KirimDataTelegram($akses){', 'function KirimDataTelegram($akses){return;', $c);

    file_put_contents($m_admin_file, $c);
    echo "Patched: /config/m_admin.php\n";
}
else {
    echo "Warning: /config/m_admin.php not found.\n";
}

// 2. Patch konten/pengaturan.php (Decrypt and remove license checks)
$pengaturan_file = $base_dir . '/konten/pengaturan.php';
if (file_exists($pengaturan_file)) {
    $content = file_get_contents($pengaturan_file);

    $clean_php = "<?php\n" .
        "cek_session_admin();\n" .
        "\$set = mysqli_fetch_array(mysqli_query(\$koneksi, \"SELECT * FROM setting WHERE id_setting='1'\"));\n" .
        "\$setkolom = mysqli_fetch_array(mysqli_query(\$koneksi, \"SELECT namaSekolah FROM setting\"));\n" .
        "?>\n";

    if (preg_match('/<\?php\s+\$SISTEMIT_COM_ENC.*?\?>\s*/s', $content, $matches, PREG_OFFSET_CAPTURE)) {
        $new_content = substr_replace($content, $clean_php, $matches[0][1], strlen($matches[0][0]));
        file_put_contents($pengaturan_file, $new_content); // Replaces the original file with the clean one
        echo "Patched: /konten/pengaturan.php\n";
    }
    else {
        echo "Info: /konten/pengaturan.php does not seem to contain encrypted SISTEMIT module or is already patched.\n";
    }
}
else {
    echo "Warning: /konten/pengaturan.php not found.\n";
}

// 3. Patch phpqrcode malware injection
$qrcode_files = [
    $base_dir . '/cbtpanel/phpqrcode/qrcode.php',
    $base_dir . '/cbtpanel/phpqrcode/qrliba.php',
    $base_dir . '/cbtpanel/phpqrcode/qrrscodeimage.php',
];

foreach ($qrcode_files as $file) {
    if (file_exists($file)) {
        $c = file_get_contents($file);
        // Specifically targeting the malware injection code
        if (strpos($c, '$_SESSION[\'level\']') !== false) {
            $c = preg_replace('/if\(\$_SESSION\[\'level\'\] ==\'admin\'\)\{.*?\$.ajax.*?\}/s', '', $c);
            file_put_contents($file, $c);
            echo "Patched: " . str_replace($base_dir, '', $file) . "\n";
        }
        else {
            echo "Info: " . str_replace($base_dir, '', $file) . " already clean or unsupported format.\n";
        }
    }
}

echo "\nAll applicable patches have been applied.\n";
echo "</pre>";
?>
