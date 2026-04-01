<?php 

function Tambah_data($data,$tabel)
{
  $ci = & get_instance(); //pengganti akses $this, karna helper tidak bisa akses $this
  return $ci->db->insert($tabel,$data); 
}
function Hapus_data($where,$tabel){
	$ci = & get_instance();
	return $ci->db->delete($tabel, $where);
}
function Update_data($where,$data,$tabel){
	$ci = & get_instance();
	$ci->db->where($where);
	return $ci->db->update($tabel, $data);
}
// function logout(){ //proses logout
	
// 	// $out = $this->modelku->hapus_user_login();
// 	// if($out==true){
// 	$this->session->sess_destroy();
// 	redirect('');
// 	// }
// }


?>