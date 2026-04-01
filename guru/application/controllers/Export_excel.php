<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export_excel extends CI_Controller {
	
  function __construct(){
    parent::__construct();
    cek_session(); // untuk cek_sesion login di helper, agar bisa akases conttroler 
    $this->load->model('M_excel','excel'); 
    $this->load->helper(array('fungsi','excelnilai','excel_nilai_tugas'));  
    date_default_timezone_set('Asia/Jakarta');
  }

  function cache(){
  	$this->output->cache(60); 
  }
  function session_kelas(){ return $this->session->userdata('id_kelas');}
	function session_jurusan(){ return $this->session->userdata('id_jurusan');}
	
	function excel_nilai(){
		$idujian = decrypt_url($this->uri->segment(3));
		export_nilai_ke_excel($idujian);
	}
	function excel_nilai_tugas(){
    $id = decrypt_url($this->uri->segment(3));
		export_nilai_tugas($id);
	}

	


}
