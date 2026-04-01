<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct(){
    parent::__construct(); 
    $this->load->model('M_login'); 
    date_default_timezone_set('Asia/Jakarta');
  }

  function cache($id){
  	$this->output->cache($id); 
  }

	public function index()
	{
		//$this->output->cache(30); 
		$data['setting'] = $this->M_login->setting();
		$this->load->view('login',$data);
		
	}
	function login(){
		$data = array(
			'username'=>$this->input->post('_username'),
			'password'=>$this->input->post('_password'),
		);
		$tabel="pengawas";
		$cek_login = $this->M_login->cek_login($data,$tabel);
		if($cek_login->num_rows() > 0){
			$data = $cek_login->row_array();
			$this->session->set_userdata(array(
				'id_pengawas' => $data['id_pengawas'],
				'jabatan' => $data['jabatan'],
				'level' => $data['level'],
				'id_kelas' => $data['id_kls'],
				'id_jurusan' => $data['id_jrs'],
			));

			echo "login";
		}
		else{
			
			echo "error";
		}
	}
	function log_out()
	{
		$this->session->sess_destroy();
		echo "<script>localStorage.clear();</script>";
		redirect('');
	}


	
}
