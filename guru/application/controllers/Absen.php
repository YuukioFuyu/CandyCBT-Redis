<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absen extends CI_Controller {
	
	function __construct(){
    parent::__construct(); 
    cek_session(); // untuk cek_sesion login di helper, agar bisa akases conttroler
    $this->load->model('M_login'); 
    $this->load->model('M_admin','admin'); 
    $this->load->model('M_absen','absen'); 
    $this->load->helper(array('fungsi'));  
    date_default_timezone_set('Asia/Jakarta');
    // $error = $db->error()
  }

  
//&siswa----------------------------------------------------------	
	function session_kelas(){ return $this->session->userdata('id_kelas');}
	function session_jurusan(){ return $this->session->userdata('id_jurusan');}
	function session_idguru(){ return $this->session->userdata('id_pengawas');}
	
	function absen_mapel(){ //
		
		$data['setting'] = $this->M_login->setting();
		//$data['v_absen'] = $this->absen->get_absen();
		$data['v_kelas'] = $this->M_admin->get_kelas();
		$data['v_level'] = $this->M_admin->get_level();
		$data['absen_mapel'] = $this->absen->get_absen_mapel_by_id($this->session_idguru());
		$data['konten'] = "absensi/v_absen";
		$this->load->view('admin',$data);
	}
	function absen_mapel_siswa(){ //
		
		$data['setting'] = $this->M_login->setting();
		$data['getTahun'] = $this->absen->getTahun();
		$data['getAbsenSiswaMapel']= $this->absen->get_absen_mapel_siswa();
		$data['absen_mapel'] = $this->absen->get_absen_mapel_by_id($this->session_idguru());
		$data['v_kelas2'] = $this->M_admin->get_kelas_by_guru($this->session_idguru());
		$data['konten'] = "absensi/v_absen_detail";
		$this->load->view('admin',$data);
	}
	public function insert_absen_mapel()
	{
		//print_r($_POST);
		$mapel  = $this->M_admin->get_mapel_by2($_POST['mapel']);
		$tabel='absensi_mapel';
		foreach ($mapel as $ml) {
			$data = array(
				'amIdMapel'=>$ml->idmapel,
				'amIdGuru'=>$this->session_idguru(),
				'amNamaMapel'=>$ml->nama_mapel,
				'amKelas' =>$_POST['idkelas'],
				'amJamMulai'=>$_POST['jamin'],
				'amJamAkhir'=>$_POST['jamout'],
				'amHari'=>$_POST['hari'],
			);
			$cek =$this->absen->get_absen_mapel($_POST['idkelas'],$ml->idmapel);
			if(count($cek) > 0){
				$cek_add =99;
			}
			else{
				$cek_add = $this->admin->tambah_data($tabel,$data);
			}
			
		$this->db->cache_delete_all();
		}
		if($cek_add==1){ echo 1;}elseif($cek_add==99){	echo 99; }else{ echo 0;}

	}
	public function update_absen_mapel()
	{
		//print_r($_POST);
		$tabel='absensi_mapel';
			$data = array(
				'amJamMulai'=>$_POST['jamin2'],
				'amJamAkhir'=>$_POST['jamout2'],
				'amHari'=>$_POST['hari2'],
			);
		$where = array('amId'=>$_POST['id']);
			
		$cek_add = $this->admin->update_data($where,$data,$tabel);
		$this->db->cache_delete_all();
		if($cek_add==1){ echo 1;}elseif($cek_add==99){	echo 99; }else{ echo 0;}

	}
	public function delet_absen_mapel(){
		$tabel='absensi_mapel';
		$where = array('amId'=>$_POST['id']);
		$cek_hapus = $this->admin->hapus_semua($tabel,$where);
		$this->db->cache_delete_all();
		if($cek_hapus==1){ echo 1;}else{ echo 0 ;}
	}
	

}
