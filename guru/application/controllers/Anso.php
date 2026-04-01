<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anso extends CI_Controller {
	
	function __construct(){
    parent::__construct(); 
    //cek_session(); // untuk cek_sesion login di helper, agar bisa akases conttroler
    $this->load->model('M_login'); 
    $this->load->model('M_anso','anso'); 
    $this->load->helper(array('fungsi'));  
    date_default_timezone_set('Asia/Jakarta');
    // $error = $db->error()
  }
  function cache($id){
  	$this->output->cache($id); 
  }
  
 
//&siswa----------------------------------------------------------	
	function session_kelas(){ return $this->session->userdata('id_kelas');}
	function session_jurusan(){ return $this->session->userdata('id_jurusan');}
	function session_idguru(){ return $this->session->userdata('id_pengawas');}
	
	function daftar_soal(){ //
	$this->cache(1);
		$data['setting'] = $this->M_login->setting();
		$data['konten'] = "anso/daftar_soal.php";
		
		$this->load->view('admin',$data);
	}
	function v_daftar_soal_json(){
		$data= $this->anso->v_daftar_ujia($this->session_idguru());
		$data2 = array();
		$no=1;
		foreach ($data as $value) {
			$href = base_url('anso/analisa?idmapel=').encrypt_url($value->id_mapel);
			$kumpulData = array();
			$kumpulData[]=$no++;
			$kumpulData[]=$value->nama_mapel;
			$kumpulData[]='<small class="label label-warning">'.$value->jml_soal.'/'.$value->tampil_pg.'</small>&nbsp;<small class="label label-danger">'.$value->bobot_pg.' %</small>&nbsp;<small class="label label-danger">'.$value->opsi.'</small>';
			$kumpulData[]='<small class="label label-warning">'.$value->jml_esai.'/'.$value->tampil_esai.'</small>&nbsp;<small class="label label-danger">'.$value->bobot_esai.' %</small>';
			$kumpulData[]=$value->nama_guru;
			$kumpulData[]='<a href="'.$href.'" class="btn btn-flat btn-success btn-flat btn-xs"><i class="fa fa-search"></i></a>';
			$data2[] = $kumpulData;
		}
		$json_data = array(
			'data' =>$data2
		);
		echo json_encode($json_data);
	}
	function analisa(){
		//$this->cache(1);
		$idmapel = decrypt_url($_GET['idmapel']);
		$data['setting'] = $this->M_login->setting();
		$data['konten'] = "anso/anso";
		$data['select_ujian'] = $this->anso->select_ujian($idmapel);
		$data['select_soal'] = $this->anso->select_soal($idmapel);
		$select_soal = $this->anso->select_ujian($idmapel);
		$data['jawaban_siswa'] = $this->anso->jawaban_siswa($idmapel);
		foreach ($select_soal as $rata2) {
			$data['nilai_rata2'] = $this->anso->nilai_rata2($rata2->id_mapel);
		}
		
		$this->load->view('admin',$data);
	}
	
	
}
