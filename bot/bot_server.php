<?php
//untuk merespon perintah yang di kirim dari telegram ke server bot kita

$TOKEN = "TOKENYA";  //token api bot telegram anda (ubah dan sesuaikan)
$apiURL = "https://api.telegram.org/bot$TOKEN";
$update = json_decode(file_get_contents("php://input"), TRUE);
$chatID = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];
$IdKu = $update["message"]["from"]["id"];

/* /star merupakan perintah yang akan di ketikan di telegram anda */

if (strpos($message, "/start") === 0) {
 
    $message="<b>Hellow ^_^</b>%0A";
    $message.="<b>Ini Perintah yang Bisa di Gunakan</b>%0A";
    $message.=" /cekping %0A";
    $message.=" /cekidgrup %0A";
    $message.=" /cekidku %0A";
    

  file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$message."&parse_mode=HTML");
}
else if(strpos($message, "/cekping") === 0){
     file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Pong</b>&parse_mode=HTML");
}
else if(strpos($message, "/cekidgrup") === 0){
     file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Id Grup  : <b>".$chatID."</b>&parse_mode=HTML");
}
else if(strpos($message, "/cekidku") === 0){
     file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Id Ku : <b>".$IdKu."</b>&parse_mode=HTML");
}

else{
    
}

?>