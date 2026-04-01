<?php
    $getData = $db->CekUserRedis($setting['lisensiId']);
    if($getData->status=='oke'){
        echo'
        <center>
        <h2 class="text-blue">LISENSI '.$getData->data->statusUser.'</h2>
        <span>'.$getData->data->NamaSekolah.'</span><br>
        <span style="font-size:9px;">'.$getData->data->Paket->KodePaket.'</span>
        </center>';
    }
    else{
        echo'
        <center>
        <h2 class="text-red">LISENSI TIDAK TERDAFTAR</h2>
        <span>'.$getData->data->NamaSekolah.'</span>
        </center>';
    }
 
?>