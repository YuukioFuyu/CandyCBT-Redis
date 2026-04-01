<?php
require("config/config.candy2.php");
require("config/m_siswa.php");
require("config/functions.crud.php");

$dbn= new Nilai();
$dbs= new Siswa();

/*---------Catatan----------------*/

/*--------------------------------*/
if($setting['izin_status'] == 1){

if(isset($_GET['siswa'])){
	if($_GET['siswa']=="kirim_jawaban"){		
		//var_dump($_POST['nilai']);
		
		$data = $_POST['nilai'];
		if(empty($data)){
			echo 2; //kirim pesan data status sudah di kirim semua di sisi user
		}
		else{
			$tabel = "jawaban";
			$tabel2 = "jawaban_copy";
			foreach ($data as $value) {
				$idsiswa = $value['idsiswa'];
				$idmapel = $value['idmapel'];
				$idujian = $value['idujian'];

				if($value['jenissoal'] == 4){
					$jawaban = serialize($value['jawaban']);
				}
				else{
					$jawaban = $value['jawaban'];
				}
				$data = array(
					'id_siswa' => $value['idsiswa'],
					'id_mapel' => $value['idmapel'],
					'id_soal' => $value['idsoal'],
					'id_ujian' => $value['idujian'],
					'jawaban' => $jawaban,
					'jawabx' => $jawaban,
					'jenis' => $value['jenissoal'],
				);
				$where = array(
					'id_ujian' => $value['idujian'],
					'id_mapel' => $value['idmapel'],
					'id_siswa' => $value['idsiswa'],
					'id_soal' => $value['idsoal'],
				);
				$history = $dbn->v_ujian_histori($value['idujian']);
				$cek = $dbn->cek_jawaban($value['idujian'],$value['idmapel'],$value['idsiswa'],$value['idsoal'],$value['jenissoal']);
				if($cek > 0){
					$update = $dbn->update($tabel,$data,$where);
					if($history['history'] == 1){
						$update2 = $dbn->update($tabel2,$data,$where);
					}	
				}
				else{
					$tambah = $dbn->insert($tabel,$data);
					if($history['history'] == 1){
						$tambah2 = $dbn->insert($tabel2,$data);
					}
				}

			}
			$datetime = date('Y-m-d H:i:s');
			$where2 = array(
				'id_siswa' => $idsiswa,
				'id_mapel' => $idmapel,
				'id_ujian' => $idujian
			);
			$dbn->update('nilai', array('ujian_berlangsung' => $datetime), $where2);
			if($update==1){ echo 1; }
			else if($tambah ==1){ echo 1; }else{ echo 0; }
			//print_r($data);
		}
	}
	elseif($_GET['siswa']=="kirim_jawabanesai"){

		$data = $_POST['nilai'];
		if(empty($data)){
			echo 2; //kirim pesan data status sudah di kirim semua di sisi user
		}
		else{
			$tabel = "jawaban";
			$tabel2 = "jawaban_copy";
			foreach ($data as $value) {

				$idsiswa = $value['idsiswa'];
				$idmapel = $value['idmapel'];
				$idujian = $value['idujian'];
				$jawaban = addslashes($value['jawaban']); //hilangkan tanda ' "
				$data = array(
					'id_siswa' => $value['idsiswa'],
					'id_mapel' => $value['idmapel'],
					'id_soal' => $value['idsoal'],
					'id_ujian' => $value['idujian'],
					'jawaban' =>0,
					'jawabx' =>0,
					'esai' => $jawaban,
					'jenis' => $value['jenissoal'],
				);
				$where = array(
					'id_ujian' => $value['idujian'],
					'id_mapel' => $value['idmapel'],
					'id_siswa' => $value['idsiswa'],
					'id_soal' => $value['idsoal'],
				);
				$history = $dbn->v_ujian_histori($value['idujian']);
				$cek = $dbn->cek_jawaban($value['idujian'],$value['idmapel'],$value['idsiswa'],$value['idsoal'],$value['jenissoal']);
				if($cek > 0){
					$update = $dbn->update($tabel,$data,$where);
					if($history['history'] == 1){
						$update2 = $dbn->update($tabel2,$data,$where);
					}	
				}
				else{
					$tambah = $dbn->insert($tabel,$data);
					if($history['history'] == 1){
						$tambah2 = $dbn->insert($tabel2,$data);
					}
				}

			}
			$datetime = date('Y-m-d H:i:s');
			$where2 = array(
				'id_siswa' => $idsiswa,
				'id_mapel' => $idmapel,
				'id_ujian' => $idujian
			);
			$dbn->update('nilai', array('ujian_berlangsung' => $datetime), $where2);
			if($update==1){ echo 1; }
			else if($tambah ==1){ echo 1; }else{ echo 0; }
			//print_r($data);
		}
	}
	elseif($_GET['siswa']=="kirim_jawabanpgesai"){
		$data = $_POST['nilai'];
		//print_r($data);
		if(empty($data)){
			echo 2; //kirim pesan data status sudah di kirim semua di sisi user
		}
		else{
			$tabel = "jawaban";
			$tabel2 = "jawaban_copy";
			foreach ($data as $value) {
				$idsiswa = $value['idsiswa'];
				$idmapel = $value['idmapel'];
				$idujian = $value['idujian'];
				if($value['jenissoal'] == 4){
					$jawaban = serialize($value['jawaban']);
				}
				else{
					$jawaban = $value['jawaban'];
				}
				$where = array(
						'id_ujian' => $value['idujian'],
						'id_mapel' => $value['idmapel'],
						'id_siswa' => $value['idsiswa'],
						'id_soal' => $value['idsoal'],
					);
				if($value['jenissoal']==1){ //cek jenis soal PG
					$data = array(
						'id_siswa' => $value['idsiswa'],
						'id_mapel' => $value['idmapel'],
						'id_soal' => $value['idsoal'],
						'id_ujian' => $value['idujian'],
						'jawaban' => $jawaban,
						'jawabx' => $jawaban,
						'jenis' => $value['jenissoal'],
					);
				}
				else{
					$jawaban = addslashes($value['jawaban']); //hilangkan tanda ' "
					$data = array(
						'id_siswa' => $value['idsiswa'],
						'id_mapel' => $value['idmapel'],
						'id_soal' => $value['idsoal'],
						'id_ujian' => $value['idujian'],
						'jawaban' =>null,
						'jawabx' =>null,
						'esai' => $jawaban,
						'jenis' => $value['jenissoal'],
					);
					
				}
				
				
				$history = $dbn->v_ujian_histori($value['idujian']);
				$cek = $dbn->cek_jawaban($value['idujian'],$value['idmapel'],$value['idsiswa'],$value['idsoal'],$value['jenissoal']);
				if($cek > 0){
					$update = $dbn->update($tabel,$data,$where);
					if($history['history'] == 1){
						$update2 = $dbn->update($tabel2,$data,$where);
					}	
				}
				else{
					$tambah = $dbn->insert($tabel,$data);
					if($history['history'] == 1){
						$tambah2 = $dbn->insert($tabel2,$data);
					}
				}

			}
			$datetime = date('Y-m-d H:i:s');
			$where2 = array(
				'id_siswa' => $idsiswa,
				'id_mapel' => $idmapel,
				'id_ujian' => $idujian
			);
			$dbn->update('nilai', array('ujian_berlangsung' => $datetime), $where2);
			if($update==1){ echo 1; }
			else if($tambah ==1){ echo 1; }else{ echo 0; }
			
		}
	}
	elseif ($_GET['siswa']=="lama_ujian") {
		$data = $_POST;
		$where2 = array(
				'id_siswa' => $data['idsiswa'],
				'id_mapel' => $data['idmapel'],
				'id_ujian' => $data['idujian'],
			);
		$ex = $dbn->update('nilai', array('ujian_berlangsung' => $datetime), $where2);
		if($ex==1){ echo 1; }else{ echo 0; }
	}
	
	else{

	}


}
if(isset($_GET['jawaban'])){
	//proses penyelesaian jawaban siswa ujian ---------------------------------------------------------------
	if ($_GET['jawaban']=="proses_nilai"){ 
		
		$id_siswa = $_POST['siswaid'];
		$ac = $_POST['ujianid'];
		$idmapel = $_POST['mapelid'];
		$jenisSoal = $_POST['jenissoalid'];
		$datetime = date('Y-m-d H:i:s');
		
		$mapel = fetch($koneksi, 'ujian', array('id_ujian' => $ac));
		
		$where = array(
			'id_siswa' => $id_siswa,
			'id_ujian' => $ac
		);
		$where2 = array(
			'id_siswa' => $id_siswa,
			'id_ujian' => $ac
		);
		$logdata = array(
	    'id_siswa' => $id_siswa,
	    'type' => 'login',
	    'text' => 'Selesai Ujian',
	    'date' => $datetime
		);
		
		
		//cek status selesai siswa
		$da2=$dbn->Status_sudah_ujian($id_siswa,$ac);
		if($da2['selesai']==1){
			echo 90;
		}
		else{
			
			$benar='benar_';
			$salah='salah_';
			 
			if($jenisSoal==1){  //soal PG ------------------------------------------------------------------

				$ceksoal = mysqli_query($koneksi, "
      		SELECT id_soal,id_mapel,nomor,jawaban FROM soal 
      		WHERE id_mapel=$idmapel AND jenis=1 or jenis=3 or jenis=4
					ORDER BY nomor ASC
      	");

      	$arrayjawab = array();
				$arrayjawabesai = array();
        // cari nilai jawaban pg 
				foreach ($ceksoal as $getsoal) {
					$jika = array(
						'id_ujian' => $ac,
						'id_siswa' => $id_siswa,
						'id_soal' => $getsoal['id_soal'],
					);
				
				
				$getjwb = fetch($koneksi, 'jawaban', $jika);//ambil nilai jawaban pg untuk di simpan di tabel jawaban
				//var_dump($getjwb);
					if($getjwb['jenis'] == 4){
						$arrayjawab[$getjwb['id_soal']] = $getjwb['jawaban'];
						if ($getjwb) {

							#proses pencocokan multipelcois -----------------------------------------------------
								$jawabanDariSoal = explode(",",$getsoal['jawaban']); #string to array 
								$count = count($jawabanDariSoal ); //totaol array jawaban
								
								$jwb = unserialize($getjwb['jawaban']);
								$nojwbSoal =0;
								
								foreach($jwb as $val){
									if(in_array($val,$jawabanDariSoal)){
										$nojwbSoal++;
									}	
								}
								
								#jika ingin modifikasi pencocokan jawaban array di sini tempatnya
								if($nojwbSoal == $count){ #jika pencocokan in array jumlahnya sama dengan count array maka jawaban benar
									${$benar.$id_siswa}++;
									$nojwbSoal=0;
								}
								else{
									${$salah.$id_siswa}++;
								}
							#proses pencocokan multipelcois -----------------------------------------------------
							
						}
					}
					else{
						if ($getjwb) {
							$arrayjawab[$getjwb['id_soal']] = $getjwb['jawaban'];
							if($getjwb['jawaban'] == $getsoal['jawaban']){
								${$benar.$id_siswa}++;
							}
							else{
								${$salah.$id_siswa}++;
							}
						}
					}
				}
        // HITUNG BOBOT NILAI SISWA PG         
				${$jumsalah.$id_siswa} = $mapel['tampil_pg'] - ${$benar.$id_siswa};
				$bagi = $mapel['tampil_pg'] / 100;
				$bobot = $mapel['bobot_pg'] / 100;
				$skorx = (${$benar.$id_siswa} / $bagi) * $bobot;
				$skor = number_format($skorx, 2, '.', '');

        $data = array( //data array untuk di masukan di kondisi selesai
        	'ujian_selesai' => $datetime,
        	'jml_benar' => ${$benar.$id_siswa},
        	'jml_salah' => ${$jumsalah.$id_siswa},
        	'skor' => $skor,
        	'total' => $skor,
        	'online' => 0,
        	'selesai' => 1,
        	'jawaban' => serialize($arrayjawab),
        	'jawaban_esai' => serialize($arrayjawabesai)
        );
        $nilaix = update($koneksi, 'nilai', $data, $where2);
        if($nilaix=='OK'){
        	insert($koneksi, 'log', $logdata);
        	$delcak = delete($koneksi, 'pengacak', $where);
        	if($delcak=='OK'){
        		delete($koneksi, 'jawaban', $where2);
        		echo 1;
        	}
        	else{
        		echo 99;
        	}
        }
        else{
        	echo 0;

        }
      }

      
      if($jenisSoal==2){//soal Esai ------------------------------------------------------------------  
      	$ceksoalesai = mysqli_query($koneksi, "
          SELECT id_soal,id_mapel,nomor,jawaban FROM soal 
          WHERE id_mapel=$idmapel AND jenis=2
        ");
      	$arrayjawabesai = array();
        $arrayjawab = array(); //agar menjadi array null
          foreach ($ceksoalesai as $getsoalesai) {
          	$w2 = array(
          		'id_ujian' => $ac,
          		'id_siswa' => $id_siswa,
          		'id_soal' => $getsoalesai['id_soal'],
          		'jenis' => 2
          	);
          	$getjwb2 = fetch($koneksi, 'jawaban', $w2);
         		$arrayjawabesai[$getjwb2['id_soal']] = str_replace("'"," ",$getjwb2['esai']);

          }
         $data = array( //data array untuk di masukan di kondisi selesai
         	'ujian_selesai' => $datetime,
         	'jml_benar' => 0,
         	'jml_salah' => 0,
         	'skor' => 0,
         	'total' => 0,
         	'online' => 0,
         	'selesai' => 1,
         	'jawaban' => serialize($arrayjawab),
         	'jawaban_esai' => serialize($arrayjawabesai)
         );
         $nilaix = update($koneksi, 'nilai', $data, $where2);
         if($nilaix=='OK'){
         	insert($koneksi, 'log', $logdata);
         	$delcak = delete($koneksi, 'pengacak', $where);
         	if($delcak=='OK'){
         		delete($koneksi, 'jawaban', $where2);
         		echo 1;
         	}
         	else{
         		echo 99;
         	}
         }
         else{
         	echo 0;
         }

      }

      //soal PG dan Esai ------------------------------------------------------------------
      if($jenisSoal==3){ 

      	$ceksoalesai = mysqli_query($koneksi, "
      		SELECT id_soal,id_mapel,nomor,jawaban FROM soal 
      		WHERE id_mapel=$idmapel AND jenis=2
      	");
      	$arrayjawabesai = array();
      	
      	foreach ($ceksoalesai as $getsoalesai) {
      		$w2 = array(
      			'id_ujian' => $ac,
      			'id_siswa' => $id_siswa,
      			//'id_mapel' => $idmapel,
      			'id_soal' => $getsoalesai['id_soal'],
      			'jenis' => 2
      		);
      		$getjwb2 = fetch($koneksi, 'jawaban', $w2);
      		$arrayjawabesai[$getjwb2['id_soal']] = str_replace("'"," ",$getjwb2['esai']);
      		
      	}//var_dump($arrayjawabesai);
      	
      	
       //soal PG ------------------------------------------------------------------
      	// $ceksoal = select($koneksi, 'soal', array('id_mapel' => $id_mapel, 'jenis' => 1));
      	$ceksoal = mysqli_query($koneksi, "
      		SELECT id_soal,id_mapel,nomor,jawaban FROM soal 
      		WHERE id_mapel=$idmapel AND jenis=1
      	");
      	$arrayjawab = array();
      
      	foreach ($ceksoal as $getsoal) { // cari nilai jawaban pg berdasarkan id soal 
      		$jika = array(
      			'id_ujian' => $ac,
      			'id_siswa' => $id_siswa,
      			//'id_mapel' => $idmapel,
      			'id_soal' => $getsoal['id_soal'],
      			'jenis' => '1'
      		);
        	
      		$getjwb = fetch($koneksi, 'jawaban', $jika);//ambil nilai jawaban pg untuk di simpan di tabel jawaban
      		if ($getjwb) {
      			$arrayjawab[$getjwb['id_soal']] = $getjwb['jawaban'];
      			if($getjwb['jawaban'] == $getsoal['jawaban']){
      				${$benar.$id_siswa}++;
      			}
      			else{
      				${$salah.$id_siswa}++;
      			}
      		}
      	}//var_dump($arrayjawab);
      	

       	// HITUNG BOBOT NILAI SISWA PG
      	${$jumsalah.$id_siswa} = $mapel['tampil_pg'] - ${$benar.$id_siswa};
      	$bagi = $mapel['tampil_pg'] / 100;
      	$bobot = $mapel['bobot_pg'] / 100;
      	$skorx = (${$benar.$id_siswa} / $bagi) * $bobot;
      	$skor = number_format($skorx, 2, '.', '');
          $data = array( //data array untuk di masukan di kondisi selesai
          	'ujian_selesai' => $datetime,
          	'jml_benar' => ${$benar.$id_siswa},
          	'jml_salah' => ${$jumsalah.$id_siswa},
          	'skor' => $skor,
          	'total' => $skor,
          	'online' => 0,
          	'selesai' => 1,
          	'jawaban' => serialize($arrayjawab),
          	'jawaban_esai' => serialize($arrayjawabesai)
          );
          $nilaix = update($koneksi, 'nilai', $data, $where2);
          //validasi nilai 0
          if($nilaix=='OK'){
          	insert($koneksi, 'log', $logdata);
          	$delcak = delete($koneksi, 'pengacak', $where);
          	if($delcak=='OK'){
          		delete($koneksi, 'jawaban', $where2);
          		echo 1;
          	}
          	else{
          		echo 99;
          	}
          }
          else{
          	echo 0;

          }
      }//end if 3

		} //end if
		
	}
//end proses penyelesaian jawaban siswa ujian ---------------------------------------------------------------
}
if(isset($_GET['materi'])){
  if($_GET['materi']=="viewer"){
    $tabel='materi_view';
    $datetime = date('Y-m-d H:i:s');
    $data = array(
      'mtrViewIdSiswa'=>$_POST['idsiswa'],
      'mtrViewIdMateri'=>$_POST['idmateri'],
      'mtrViewJenis'=>$_POST['jenis'],
      'mtrViewDate'=>$datetime,
      'mtrViewStatus'=>1,
    );
    $tambah = $dbn->insert($tabel,$data);
    if($tambah ==1){ echo 1; }else{ echo 0; }
  }
}

/**
 * 01-01-2023
 */
if(isset($_GET['peringatan'])){
  if($_GET['peringatan']=="warning"){
    $idNilai = $_POST['idnilai'];
		
    $where = array(
			'id_nilai' => $idNilai,
		);
    $data = array(
			'blok' => 1,
		);
    $cek = $dbn->update('nilai', $data, $where);
    if($cek){
      echo "warning";
      $dbs->delRedisBlok($idNilai,$_SESSION['id_siswa']);
    }
    else{
      echo 99;
    }
  }
  elseif($_GET['peringatan']=="count"){
    $idNilai = $_POST['idnilai'];
		
    $whereCek = array(
			'id_nilai' => $idNilai,
		);
    $db = fetch($koneksi, 'nilai', $whereCek);
    
    if($db['jmlPelanggaran'] == 0){
      $data = array(
        'jmlPelanggaran' => 1,
      );
    }
    else{
      $data = array(
        'jmlPelanggaran' => $db['jmlPelanggaran'] + 1,
      );
    }

    $where = array(
			'id_nilai' => $idNilai,
		);
    $cek = $dbn->update('nilai', $data, $where);
    if($cek){
      echo "count";
      $dbs->delRedisBlok($idNilai,$_SESSION['id_siswa']);
    }
    else{
      echo 99;
    }
  }
  elseif($_GET['peringatan']=="buka_blokir"){
    $idNilai = $_POST['idnilai'];
		
    $whereBlokir = array(
			'id_nilai' => $idNilai,
		);
    $dataBlokir = array(
      'blok'          => 0,
      'blokBukaAdmin' => 0,
    );
    $dbn->update('nilai', $dataBlokir, $whereBlokir);
    $dbs->delRedisBlok($idNilai,$_SESSION['id_siswa']);
    
    
  }
  else{

  }

} // end if peringatan

}//end if izin_stat 
?>