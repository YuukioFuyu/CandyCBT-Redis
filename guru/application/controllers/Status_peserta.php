<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_peserta extends CI_Controller {
	
	function __construct(){
    parent::__construct(); 
    cek_session(); // untuk cek_sesion login di helper, agar bisa akases conttroler
    
    $this->load->model('M_status','status'); 
    $this->load->helper(array('fungsi'));  
    date_default_timezone_set('Asia/Jakarta');
    // $error = $db->error()
  }

  
 
//&siswa----------------------------------------------------------	
	function session_kelas(){ return $this->session->userdata('id_kelas');}
	function session_jurusan(){ return $this->session->userdata('id_jurusan');}
	function session_idguru(){ return $this->session->userdata('id_pengawas');}
	
	function index(){ //
		$idkelas = decrypt_url($_GET['idkelas']);
		$data = $this->status->v_statsu_ujian($idkelas);
		//$data_peserta=array();
		$no=1;
		foreach ($data as  $row) {
			$sumber = $row->status_ujian === 'Masih Dikerjakan' ? strtotime($row->ujian_berlangsung) : strtotime($row->ujian_selesai);
			$selisih = $sumber - strtotime($row->ujian_mulai);
			$nestedData = array();
			$nestedData[] = $no++;
			$nestedData[] = $row->status_ujian === 'Masih Dikerjakan' ?
			"<label class='label label-danger'><i class='fa fa-spin fa-spinner' title='Sedang ujian'></i>&nbsp;Masih Dikerjakan</label>" :
			"<label class='label label-success'>Tes Selesai</label>";
			
			$nestedData[] = $row->nama;
			$nestedData[] = $row->kelas;
			$nestedData[] = $row->status_ujian === 'Masih Dikerjakan' ? lamaujian2($selisih) : lamaujian2($selisih, true);
			$nestedData[] = "<small class='label bg-red'>".$row->kode_ujian."</small><small class='label bg-purple'>".$row->mapel."</small><small class='label bg-blue'>".$row->level."</small>";
			
			
			$nestedData[] = $row->status_ujian === 'Masih Dikerjakan' ?
			' - ' :
			"<small class='label bg-green'>".$row->jml_benar."<i class='fa fa-check'></i></small>
						 <small class='label bg-red'>".$row->jml_salah." <i class='fa fa-times'></i></small>";
		
		$nestedData[] = $row->status_ujian === 'Masih Dikerjakan' ?
			' - ' :
			"<small class='label bg-green'>" . number_format($row->skor, 2, '.', '') . "</small>";
		$nestedData[] = $row->ipaddress;
		$nestedData[] = $row->nis;
		
		$data_peserta[] = $nestedData;
		}
		$json_data = array(
		"data" => $data_peserta);
		echo(json_encode($json_data));
		
	}

}
