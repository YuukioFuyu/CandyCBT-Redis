<?php 

function cek_session() //untuk cek apakah sudah login
{
	$ci = & get_instance(); //pengganti akses $this, karna helper tidak bisa akses $this
	$session = $ci->session->userdata('id_pengawas');
	if(empty($session)){
		redirect('');
	}
}

?>