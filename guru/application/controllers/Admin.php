<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	function __construct(){
    parent::__construct(); 
    cek_session(); // untuk cek_sesion login di helper, agar bisa akases conttroler
    $this->load->model('M_login'); 
    $this->load->model('M_admin','admin'); 
    $this->load->helper(array('fungsi'));  
    date_default_timezone_set('Asia/Jakarta');
    // $error = $db->error()
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
 
//&siswa----------------------------------------------------------	
	function session_kelas(){ return $this->session->userdata('id_kelas');}
	function session_jurusan(){ return $this->session->userdata('id_jurusan');}
	function session_idguru(){ return $this->session->userdata('id_pengawas');}
	
	function index(){ //
		$this->cache(1);
		$data['setting'] = $this->M_login->setting();
		$data['konten'] = "home";

		$this->load->view('admin',$data);
	}
	function v_siswa(){ //
		$this->cache(1);
		$data['setting'] = $this->M_login->setting();
		$data['v_kelas'] = $this->M_admin->get_kelas();
		$data['konten'] = "siswa/v_siswa";
		$this->load->view('admin',$data);
	}
	function siswa_json()
	{
		$idkls = $_POST['idkls'];
		$v_siswa = $this->M_admin->v_siswa($idkls);
		foreach ($v_siswa as $value) {
				$data[]=$value;
		}
		$json = json_encode($data);
    echo $json;
	}
//&ujian----------------------------------------------------------	
	function no_ujian(){
		$this->cache(1);
		$data['setting'] = $this->M_login->setting();
		$data['get_ujian'] = $this->M_admin->get_ujian();
		$data['get_kelas'] = $this->M_admin->get_kelas();
		$data['konten'] = "siswa/tidak_ujian";
		$this->load->view('admin',$data);
	}
	function cek_siswa_noujian(){
		$ujian = decrypt_url($_POST['ujian']);
		$kelas = decrypt_url($_POST['kelas']);
		$data= $this->M_admin->siswa_noujian($ujian,$kelas);
		echo $data;
		//$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	function daftar_ujian(){
		$this->cache(1);
		$data['setting'] = $this->M_login->setting();
		$data['konten'] = "siswa/daftar_ujian";
		$data['get_ujian'] = $this->M_admin->get_ujian();
		
		$this->load->view('admin',$data);
	}
//&kelas----------------------------------------------------------	
	function json_mapel()
	{
		$data = $this->M_admin->get_mapel_by($_POST['id']);
		$json = json_encode($data);
    echo $json;
	}
//&materi----------------------------------------------------------	
	// public function asd()
	// {
	// 	$josn = $this->M_admin->datatables_vmateri($this->session_idguru());
	// 	$this->output->set_content_type('application/json')->set_output($josn);
	// }
	function materi()//
	{
		$this->cache(1);
		$data['setting'] = $this->M_login->setting();
		$data['v_kelas'] = $this->M_admin->get_kelas();
		$data['v_level'] = $this->M_admin->get_level();
		$data['v_materi'] =$this->M_admin->get_materi_by($this->session_idguru());
		$data['konten'] = "materi/v_materi";
		$data['kelas_select'] = "kelas/kelas_select";
		$data['level_select'] = "kelas/level_select";
		$data['kelas_kelompok'] = "kelas/kelas_kelompok";
		$this->load->view('admin',$data);
	}
	function materi_json()
	{
		
		$data =$this->M_admin->get_materi_by($this->session_idguru());
		$count = count($data);
		$data2 = array('jumlah'=>$count); 
		$this->output->set_content_type('application/json')->set_output(json_encode($data2));
	}
	function e_materi()
	{
		$this->cache(1);
		$id = decrypt_url($_GET['aksi']);
		$data['v_kelas'] = $this->M_admin->get_kelas();
		$data['v_level'] = $this->M_admin->get_level();
		$data['e_materi'] =$this->M_admin->get_materi_by2($id);
		$data['kelas_select'] = "kelas/kelas_select";
		$data['kelas_kelompok'] = "kelas/kelas_kelompok";
		$data['level_select'] = "kelas/level_select";
		$data['konten'] = "materi/e_materi";
		$data['setting'] = $this->M_login->setting();
		$this->load->view('admin',$data);
	}

	function t_materi()
	{
		//print_r($_FILES);
		$path = './berkas2/'.$this->session_idguru().'/';
		if (!file_exists($path)) { // cek folder dengan id guru ada atau tida
		   mkdir($path, 0755, true);
		}
		else{
			$allowed = ['jpg', 'png','xlsx','pdf','docx','doc','xls','jpeg'];
			$cek_file = $_FILES['file_materi']['name'];//get nama file
			if(!empty($cek_file)){ //jika file pendukung di isi
				$ext = pathinfo($cek_file, PATHINFO_EXTENSION);
				if(!in_array($ext, $allowed)) { // cek extensi file yang di upload
				    echo 'cek file extensi';
				}
				else{
					// config cek file CI
					$config = array( 
					'upload_path' => $path, 
					'allowed_types' => "jpg|png|jpeg|pdf|doc|docx|xls|xlsx",
					'overwrite' => TRUE,
					'max_size' => "2048000",
					);
					$tabel = "materi2";
					$kelas = serialize($_POST['k_kelas']);
					$data = array(
						'materi2_mapel' => $_POST['mapel'], 
						'materi2_judul' => $_POST['judul_materi'], 
						'materi2_isi' => $_POST['isimateri'],
						'materi2_file' => $cek_file,
						'kelas' => $kelas,
						'url_gdrive' => $_POST['gdrive'],
						'url_youtube' => $_POST['youtube'],
						'url_embed' => $_POST['idyoutube'],
						'id_guru' => $this->session_idguru(), 
					);
						$this->load->library('upload', $config);
						if($this->upload->do_upload('file_materi')){
							$cek_add = $this->M_admin->tambah_data($tabel,$data);
							if($cek_add==1){ echo"add";}else{ echo"no_add";}
						}
						else{
							return 0;
						}
				}
				
			}
			else{ //jika file pendukung tida di isi
				$tabel = "materi2";
				$kelas = serialize($_POST['k_kelas']);
				$data = array(
					'materi2_mapel' => $_POST['mapel'], 
					'materi2_judul' => $_POST['judul_materi'], 
					'materi2_isi' => $_POST['isimateri'],
					'kelas' => $kelas,
					'url_gdrive' => $_POST['gdrive'],
					'url_youtube' => $_POST['youtube'],
					'url_embed' => $_POST['idyoutube'],
					'id_guru' => $this->session_idguru(), 
				);
				$cek_add = $this->M_admin->tambah_data($tabel,$data);
				if($cek_add==1){ echo"add";}else{ echo"no_add";}
			}
		}
	}
	function up_materi()
	{
		 //print_r($_POST);
		$path = './berkas2/'.$this->session_idguru().'/';
		if (!file_exists($path)) { // cek folder dengan id guru ada atau tida
		   mkdir($path, 0755, true);
		}
		else{
			$allowed = ['jpg', 'png','xlsx','pdf','docx','doc','xls','jpeg'];
			$cek_file = $_FILES['file_materi']['name'];//get nama file
			if(!empty($cek_file)){ //jika file pendukung di isi
				$ext = pathinfo($cek_file, PATHINFO_EXTENSION);
				if(!in_array($ext, $allowed)) { // cek extensi file yang di upload
				    echo 'cek file extensi';
				}
				else{
					// config cek file CI
					$config = array( 
					'upload_path' => $path, 
					'allowed_types' => "jpg|png|jpeg|pdf|doc|docx|xls|xlsx",
					'overwrite' => TRUE,
					'max_size' => "2048000",
					);
					$tabel = "materi2";
					$where = array('materi2_id'=>$_POST['id_mapel']);
					$kelas = serialize($_POST['k_kelas']);
					$data = array(
						'materi2_judul' => $_POST['judul_materi'], 
						'materi2_isi' => $_POST['isimateri'],
						'materi2_file' => $cek_file,
						'kelas' => $kelas,
						'url_gdrive' => $_POST['gdrive'],
						'url_youtube' => $_POST['youtube'],
						'url_embed' => $_POST['idyoutube'],
						'id_guru' => $this->session_idguru(), 
					);

						$this->load->library('upload', $config);
						if($this->upload->do_upload('file_materi')){
							$cek_add = $this->M_admin->update_data($where,$data,$tabel);
							if($cek_add==1){ echo"add";}else{ echo"no_add";}
						}
						else{
							return 0;
							var_dump($this->file_type);
						}
				}
				
			}
			else{ //jika file pendukung tida di isi
				$tabel = "materi2";
				$where = array('materi2_id'=>$_POST['id_mapel']);
				$kelas = serialize($_POST['k_kelas']);
				$data = array(
					'materi2_judul' => $_POST['judul_materi'], 
					'materi2_isi' => $_POST['isimateri'],
					'kelas' => $kelas,
					'url_gdrive' => $_POST['gdrive'],
					'url_youtube' => $_POST['youtube'],
					'url_embed' => $_POST['idyoutube'],
					'id_guru' => $this->session_idguru(), 
				);
				$cek_add = $this->M_admin->update_data($where,$data,$tabel);
				if($cek_add==1){ echo"add";}else{ echo"no_add";}
			}
		}
	}
	function h_materi(){
		$id = decrypt_url($_POST['id']);
		$tabel = "materi2";
		$where = array("materi2_id"=>$id);
		$cek_hapus = $this->M_admin->hapus_semua($tabel,$where);
		if($cek_hapus==1){ echo"add";}else{ echo"no_add";}
	}
//&tugas---------------------------------------------------
	function tugas()//
	{

		$data['setting'] = $this->M_login->setting();
		$data['v_kelas'] = $this->M_admin->get_kelas();
		$data['v_level'] = $this->M_admin->get_level();
		$data['v_tugas'] =$this->M_admin->get_tugas_by($this->session_idguru());
		$data['konten'] = "tugas/v_tugas";
		$data['kelas_select'] = "kelas/kelas_select";
		$data['level_select'] = "kelas/level_select";
		$data['kelas_kelompok'] = "kelas/kelas_kelompok";
		$this->load->view('admin',$data);
	}
	function e_tugas()
	{
		$id= decrypt_url($_GET['aksi']);

		$data['e_tugas'] =$this->M_admin->get_tugas_by2($id);
		$data['konten'] = "tugas/e_tugas";
		$data['v_kelas'] = $this->M_admin->get_kelas();
		$data['setting'] = $this->M_login->setting();
		$this->load->view('admin',$data);
	}
	function tugas_json()
	{
		$data =$this->M_admin->get_tugas_by($this->session_idguru());
		$count = count($data);
		$data2 = array('jumlah'=>$count); 
		$this->output->set_content_type('application/json')->set_output(json_encode($data2));
	}
	function t_tugas(){
		$id_aksi = $_POST['id_aksi'];
		$path = './tugas/'.$this->session_idguru().'/';
		if (!file_exists($path)) { // cek folder dengan id guru ada atau tida
		   mkdir($path, 0755, true);
		}
		else{
			$allowed = ['jpg', 'png','xlsx','pdf','docx','doc','xls','jpeg'];
			$cek_file = $_FILES['file_tugas']['name'];//get nama file
			if(!empty($cek_file)){ //jika file pendukung di isi
				$ext = pathinfo($cek_file, PATHINFO_EXTENSION);
				if(!in_array($ext, $allowed)) { // cek extensi file yang di upload
				    echo 200;
				}
				else{
					// config cek file CI
					$config = array( 
					'upload_path' => $path, 
					'allowed_types' => "jpg|png|jpeg|pdf|doc|docx|xls|xlsx",
					'overwrite' => TRUE,
					'max_size' => "2048000",
					);
					$tabel = "tugas";
					$kelas = serialize($_POST['k_kelas']);
					$data = array(
						'id_guru' => $this->session_idguru(),
						'kelas' => $kelas, 
						'mapel' => $_POST['mapel'],
						'judul' => $_POST['judul'],
						'tugas' => $_POST['isitugas'],
						'file' => $cek_file,
						'tgl_mulai' => $_POST['tgl_mulai'],
						'tgl_selesai' => $_POST['tgl_selesai'],
						'status' => $_POST['status'],
						
					);
						$this->load->library('upload', $config);
						if($this->upload->do_upload('file_tugas')){
							if($id_aksi==1){
							$cek_add = $this->M_admin->tambah_data($tabel,$data);
							if($cek_add==1){ echo"add";}else{ echo"no_add";}
							}
							if($id_aksi==2){
								$where =array('id_tugas'=>@$_POST['id_tugas']);
								$cek_add = $this->M_admin->update_data($where,$data,$tabel);
								if($cek_add==1){ echo"add";}else{ echo"no_add";}
							}
						}
						else{
							return 0;
						}
				}
				
			}
			else{ //jika file pendukung tida di isi
				$tabel = "tugas";
				$kelas = serialize($_POST['k_kelas']);
				$data = array(
						'id_guru' => $this->session_idguru(),
						'kelas' => $kelas, 
						'mapel' => $_POST['mapel'],
						'judul' => $_POST['judul'],
						'tugas' => $_POST['isitugas'],
						'tgl_mulai' => $_POST['tgl_mulai'],
						'tgl_selesai' => $_POST['tgl_selesai'],
						'status' => $_POST['status'],
					);
				if($id_aksi==1){
					$cek_add = $this->M_admin->tambah_data($tabel,$data);	
					if($cek_add==1){ echo"add";}else{ echo"no_add";}
				}
				if($id_aksi==2){
					$where =array('id_tugas'=>@$_POST['id_tugas']);
					$cek_add = $this->M_admin->update_data($where,$data,$tabel);
					if($cek_add==1){ echo"add";}else{ echo"no_add";}
				}
			}
		}
	}
	function v_nilai_tugas(){
		$id = decrypt_url($_GET['aksi']);
		$data = array(
			'setting' => $this->M_login->setting(),
			'id'			=> $id,
			'v_nilai_tugas' =>$this->M_admin->get_nilai_tugas($id),
			'konten' => "tugas/v_nilai_tugas",
		);
		
		$this->load->view('admin',$data);
	}
	function input_nilai_tugas(){
		$id = decrypt_url($_POST['id']);
		$id_siswa = decrypt_url($_POST['id_siswa']);
		$data = array(
			'get_nilai' =>$this->M_admin->get_nilai_tugas($id,$id_siswa)
		);
		$this->load->view('tugas/input_nilai',$data);
	}
	function up_nilai_tugas(){
    $tabel="jawaban_tugas";
    $where = array(
      'id_tugas' =>$_POST['id_tugas'],
      'id_siswa' =>$_POST['id_siswa'],
    );
    $data=array(
      'nilai' =>$_POST['nilai']
    );
    $cek_add = $this->M_admin->update_data($where,$data,$tabel);
		if($cek_add==1){ echo"add";}else{ echo"no_add";}
  }
  function h_tugas(){
  	$id_tugas= decrypt_url($this->uri->segment(3));
  	$tabel="tugas";
  	$where = array('id_tugas' => $id_tugas);
  	$cek_add = $this->M_admin->hapus_semua($tabel,$where);
  	if($cek_add==1){ 
  		$this->session->set_flashdata('success', 'Berhasil Menghapus Tugas');
  		redirect($_SERVER['HTTP_REFERER']);
  	}
  	else{ 
  		$this->session->set_flashdata('error', 'Gagal Menghapus Tugas');
  		redirect($_SERVER['HTTP_REFERER']);
  	}
  }
  function h_nilai_tugas(){
  	$id_tugas= decrypt_url($this->uri->segment(3));
  	$id_siswa= decrypt_url($this->uri->segment(4));
  	$tabel="jawaban_tugas";
  	$where = array('id_tugas' => $id_tugas);
  	$where2 = array('id_tugas' => $id_tugas,'id_siswa' =>$id_siswa);
  	if(empty($id_siswa)){
  		$cek_add = $this->M_admin->hapus_semua($tabel,$where);
  	}
  	else{
  		$cek_add = $this->M_admin->hapus_semua($tabel,$where2);
  	}
  	if($cek_add==1){ 
  		$this->session->set_flashdata('success', 'Berhasil Menghapus Nilai');
  		redirect($_SERVER['HTTP_REFERER']);
  	}
  	else{ 
  		$this->session->set_flashdata('error', 'Gagal Menghapus Nilai');
  		redirect($_SERVER['HTTP_REFERER']);
  	}
  	
  }
//&status_peserta---------------------------------------------
  function status_peserta(){ //
		$data['setting'] = $this->M_login->setting();
		$data['v_kelas'] = $this->M_admin->get_kelas();
		$data['konten'] = "siswa/status_peserta";
		$this->load->view('admin',$data);
	}
}
