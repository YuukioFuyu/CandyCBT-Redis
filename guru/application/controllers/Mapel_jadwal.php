<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel_jadwal extends CI_Controller {
	
	function __construct(){
    parent::__construct(); 
    //cek_session(); // untuk cek_sesion login di helper, agar bisa akases conttroler
    $this->load->model('M_login'); 
    $this->load->helper(array('fungsi','crud'));  
    date_default_timezone_set('Asia/Jakarta');
  }
  function cache($id){
  	$this->output->cache($id); 
  }
  function clear_cache(){
    $this->db->cache_delete_all();
    
    $path = $this->config->item('cache_path');

    $cache_path = ($path == '') ? APPPATH.'cache/' : $path;

    $handle = opendir($cache_path);
    while (($file = readdir($handle))!== FALSE) 
    {
        //Leave the directory protection alone
        if ($file != '.htaccess' && $file != 'index.html')
        {
           @unlink($cache_path.'/'.$file);
        }
    }
    closedir($handle); 
    redirect('admin/', 'refresh');
  }
  
 

	function session_kelas(){ return $this->session->userdata('id_kelas');}
	function session_jurusan(){ return $this->session->userdata('id_jurusan');}
	function session_idguru(){ return $this->session->userdata('id_pengawas');}

//&Bank Soal----------------------------------------------------------  
	function add_bank_soal(){
    $tabel = 'mapel';
    $data = array(
      'idpk' => $_POST['id_pk'],
      'idguru' => $this->session_idguru(),
      'nama' => $_POST['nama'],
      'jml_soal' => $_POST['jml_soal'],
      'jml_esai' => $_POST['jml_esai'],
      'tampil_pg' => $_POST['tampil_pg'],
      'tampil_esai' => $_POST['tampil_esai'],
      'bobot_pg' => $_POST['bobot_pg'],
      'bobot_esai' => $_POST['bobot_esai'],
      'level' => $_POST['level'],
      'opsi' => $_POST['opsi'],
      'kelas' => serialize($_POST['kelas']),
      'siswa' => serialize($_POST['siswa']),
      'date' => date('Y-m-d H:i:s'),
      'status' => 1,
      'statusujian' => 0,

    );
    $ex = Tambah_data($data,$tabel);
    if($ex == true){ echo 1; }else{ echo 0; }
    $this->clear_cache();
  }
 
	
	
	
}
