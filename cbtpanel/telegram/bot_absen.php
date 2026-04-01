<?php

function KirimAbsen($pesan,$idbot='1370442644:AAFVfxZnhCIf5GfOwi4CfBxoybo5qAw0Dbk',$idgrub='-415714734'){

	// $nama = 'Mryes';
 //  $kelas = 'XII';
	// $date = date("d-m-Y h:i:sa");
 //  $title = '---Absen Kehadiran---';

  //silahakan modifikasi di bagian ini

  $message="<b><i>".$title."</i></b>%0A";
  $message.="Nama : <b>".$nama."</b>%0A";
  $message.="Kelas : <b>".$kelas."</b>%0A";
  $message.="Tgl : ".$date."%0A";
  	
  //----------------------No Edit------------------------------------------------------
	$api = 'https://api.telegram.org/bot'.$idbot.'/sendMessage?chat_id='.$idgrub.'&text='.$message.'&parse_mode=HTML';

	$ch = curl_init($api);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	curl_close($ch);
  //----------------------No Edit------------------------------------------------------

	return $api;

}

// $cek = KirimAbsen();

?>
