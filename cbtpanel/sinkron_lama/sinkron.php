<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// proses singkron data dari pusat mreys
require "../config/config.koneksipusat.php";
require "../config/functions.crud.php";
$datetime = date('Y-m-d H:i:s');
if ($koneksipusat) {
	$query = mysqli_fetch_array(mysqli_query($koneksipusat, "select * from server where kode_server='$setting[id_server]'"));
	if ($query['status'] == 'aktif') {
		$data = $_POST['data'];
		$gagal = $gagal2 = $gagal3 = $gagal4 = $gagal5 = 0;
		$masuk1 = $masuk2 = $masuk3 = $masuk4 = $masuk5 = 0;
        //Tarik Data Peserta Ujian
		if ($data == 'JURUSAN') {
			$idtabel =$data; 
			$tabel = 'pk';
			$sql = mysqli_query($koneksi, "DELETE FROM ".$tabel);
			$sql = mysqli_query($koneksi, "ALTER TABLE ".$tabel." AUTO_INCREMENT =1");
			$api_url = $setting['url_host'];
			$json_get = $api_url.'/'.$serverApiKu.'/index.php/api_jurusan?token='.$setting['db_token'];
			
      // persiapkan curl----------------------------------------------
			$ch = curl_init(); 
        // set url 
			curl_setopt($ch, CURLOPT_URL, $json_get);
        // return the transfer as a string 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        // $output contains the output string 
			$output = curl_exec($ch); 
        // tutup curl 
			curl_close($ch);      
        // menampilkan hasil curl
			$get = json_decode($output);

      //--------------------------------------------------------------

			if($get->info == 'ko'){
       //echo "Cek Kembali Token, Pastika Token Server dan Pusat Sama Untuk Ambil Data Kelas <br>";
				echo($get->pesan);
			}
			else{
				foreach ($get as $data) {
					$dataa = array(
						'id_pk' =>$data->id_pk,
						'program_keahlian' =>$data->program_keahlian,
					);
					$exec = insert($koneksi,$tabel,$dataa);

					if ($exec=='OK') {
						$masuk1++; 
					} else {
						$gagal++;
					}
				}
			}
			$sintable = 'sinkron';
			$sindata = array(
				'jumlah' => $masuk1,
				'status_sinkron' =>1,
				'tanggal' =>$datetime
			);
			$sinwhere = array(
				'nama_data' =>$idtabel
			);
			$sinexec = update($koneksi,$sintable,$sindata,$sinwhere);

			?>
			<div class='row'>
				<div class='col-md-12'>
					<div class='box box-solid'>
						<div class='box-header with-border bg-blue'>
							<h5 class='box-title' style="color: white;">DATA YANG MASUK KE LOKAL</h5>
						</div>
						<div class='box-body'>
							<table class='table table-striped'>
								<th>Nama Data</th><th>Data Berhasil Masuk</th><th>Data Gagal</th>
								<tr><td>Jurusan</td><td><i class='fa fa-check text-green'></i> <?= $masuk1?></td><td><i class='fa fa-times text-red'></i><?= $gagal ?></td></tr>

							</table>

						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
			</div>
		<?php }
		if ($data == 'KELAS') {
			$idtabel =$data; 
			$tabel = 'kelas';
			$sql = mysqli_query($koneksi, "DELETE FROM ".$tabel);
			$sql = mysqli_query($koneksi, "ALTER TABLE ".$tabel." AUTO_INCREMENT =1");
			$sql = mysqli_query($koneksi, "DELETE FROM level");
			$sql = mysqli_query($koneksi, "ALTER TABLE level AUTO_INCREMENT =1");
			$api_url = $setting['url_host'];
			$json_get = $api_url.'/'.$serverApiKu.'/index.php/api_kelas?token='.$setting['db_token'];
  // persiapkan curl----------------------------------------------
			$ch = curl_init(); 
        // set url 
			curl_setopt($ch, CURLOPT_URL, $json_get);
        // return the transfer as a string 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        // $output contains the output string 
			$output = curl_exec($ch); 
        // tutup curl 
			curl_close($ch);      
        // menampilkan hasil curl
			$get = json_decode($output);

  //--------------------------------------------------------------
			if($get->info == 'ko'){
				echo($get->pesan);
			}  
			else{
				foreach ($get as $data) {
					$dataa = array(
						'id_kelas' =>$data->id_kelas,
						'nama' =>$data->nama,
						'id_level' =>$data->id_level,
						'id_pk' => $data->id_pk,
					);
					$data_level = array(
						'kode_level' =>$data->id_level,
						'keterangan' =>$data->id_level,
					);
					$exec2 = insert($koneksi,'level',$data_level);
					$exec = insert($koneksi,$tabel,$dataa);

					if ($exec=='OK') {
						$masuk1++; 
					} else {
						$gagal++;
					}
					if ($exec2=='OK') {
						$masuk4++; 
					} else {
						$gaga4++;
					}

				}
			}  	
			$sintable = 'sinkron';
			$sindata = array(
				'jumlah' => $masuk1.'/'.$masuk4,
				'status_sinkron' =>1,
				'tanggal' =>$datetime
			);
			$sinwhere = array(
				'nama_data' =>$idtabel
			);
			$sinexec = update($koneksi,$sintable,$sindata,$sinwhere);

			?>
			<div class='row'>
				<div class='col-md-12'>
					<div class='box box-solid'>
						<div class='box-header with-border bg-blue'>
							<h5 class='box-title' style="color: white;">DATA YANG MASUK KE LOKAL</h5>
						</div>
						<div class='box-body'>
							<table class='table table-striped'>
								<th>Nama Data</th><th>Data Berhasil Masuk</th><th>Data Gagal</th>
								<tr><td>Kelas / Level</td><td><i class='fa fa-check text-green'></i> <?= $masuk1.'/'.$masuk4 ?></td><td><i class='fa fa-times text-red'></i><?= $gagal.'/'.$gagal4 ?></td></tr>

							</table>

						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
			</div>
		<?php }
		if ($data == 'SISWA') {
			$idtabel =$data; 
			$tabel = 'siswa';
			$sql = mysqli_query($koneksi, "DELETE FROM ".$tabel);
			$sql = mysqli_query($koneksi, "ALTER TABLE ".$tabel." AUTO_INCREMENT =1");
			$sql = mysqli_query($koneksi, "DELETE FROM sesi");
			$sql = mysqli_query($koneksi, "ALTER TABLE sesi AUTO_INCREMENT =1");
			$sql = mysqli_query($koneksi, "DELETE FROM ruang");
			$sql = mysqli_query($koneksi, "ALTER TABLE ruang AUTO_INCREMENT =1");
			$api_url = $setting['url_host'];
      // sesi
			$json_get_sesi = $api_url.'/'.$serverApiKu.'/index.php/api_sesi?token='.$setting['db_token'];
  	  // persiapkan curl----------------------------------------------
			$ch = curl_init(); 
        // set url 
			curl_setopt($ch, CURLOPT_URL, $json_get_sesi);
        // return the transfer as a string 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        // $output contains the output string 
			$output3 = curl_exec($ch); 
        // tutup curl 
			curl_close($ch);      
        // menampilkan hasil curl
			$get_sesi = json_decode($output3);

  //--------------------------------------------------------------
			if($get_sesi->info == 'ko'){
				echo($get_sesi->pesan);
			} 
			else{
				foreach ($get_sesi as $data_sesi) {
					$data_sesi2 = array(
						'kode_sesi' =>$data_sesi->kode_sesi,
						'nama_sesi' => $data_sesi->nama_sesi,
					);
					$ex_sesi = insert($koneksi,'sesi',$data_sesi2);
					if ($ex_sesi=='OK') {
						$masuk2_sesi++; 
					} else {
						$gagal2_sesi++;
					}
				}
			} 
 			// runga
			$json_get_ruang = $api_url.'/'.$serverApiKu.'/index.php/api_ruang?token='.$setting['db_token'];
			// persiapkan curl----------------------------------------------
		  $ch = curl_init();  
		  curl_setopt($ch, CURLOPT_URL, $json_get_ruang); 
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		  $output2 = curl_exec($ch); 
		  curl_close($ch);      
		  $get_ruang = json_decode($output2);

		  //--------------------------------------------------------------
			if($get_ruang->info == 'ko'){
				echo($get_ruang->pesan);
			}
			else{
				foreach ($get_ruang as $data_ruang) {
					$data_ruang2 = array(
						'kode_ruang' => $data_ruang->kode_ruang,
						'keterangan' => $data_ruang->keterangan,
					);
					$ex_ruang= insert($koneksi,'ruang',$data_ruang2);
					if ($ex_ruang=='OK') {
						$masuk2_ruang++; 
					} else {
						$gagal2_ruang++;
					}
				}
			}
      //siswa
      $json_get = $api_url.'/'.$serverApiKu.'/index.php/api_siswaku?token='.$setting['db_token'];
      // persiapkan curl----------------------------------------------
		  $ch = curl_init(); 
		        // set url 
		  curl_setopt($ch, CURLOPT_URL, $json_get);
		        // return the transfer as a string 
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		        // $output contains the output string 
		  $output5 = curl_exec($ch); 
		        // tutup curl 
		  curl_close($ch);      
		        // menampilkan hasil curl
		  $get = json_decode($output5);

		  //--------------------------------------------------------------
			if($get->info == 'ko'){
				echo($get->pesan);
			}
			else{
				foreach ($get as $data) {
					if($data->server == $setting['kode_sekolah']){
						$dataa = array(
							'id_kelas' => $data->id_kelas,
							'idpk'    => $data->idpk,
							'nis'    => $data->nis,
							'no_peserta' => $data->no_peserta,
							'firt_nama' =>$data->firt_nama,
							'nama' => $data->nama,
							'level' => $data->level,
							'ruang'    => $data->ruang,
							'sesi'    => $data->sesi,
							'username'    => $data->username,
							'password'    => $data->password,
							'foto'    => $data->foto,
							'server'    => $data->server,
							'jenis_kelamin'    => $data->jenis_kelamin,
							'agama'    => $data->agama,
						);


					}
					// var_dump($setting['kode_sekolah']); die;
					$exec = insert($koneksi,$tabel,$dataa);
					if ($exec=='OK') {
						$masuk2++; 
					} else {
						$gagal2++;
					}
				}
				
			}

			$sintable = 'sinkron';
			$sindata = array(
				'jumlah' => $masuk2.'/'.$masuk2_sesi.'/'.$masuk2_ruang,
				'status_sinkron' =>1,
				'tanggal' =>$datetime
			);
			$sinwhere = array(
				'nama_data' =>$idtabel
			);
			$sinexec = update($koneksi,$sintable,$sindata,$sinwhere);
			?>
			<div class='row'>
				<div class='col-md-12'>
					<div class='box box-solid'>
						<div class='box-header with-border bg-blue'>
							<h5 class='box-title'style="color: white;" >DATA YANG MASUK KE LOKAL</h5>
						</div>
						<div class='box-body'>
							<?php if($gagal2 > 0){ ?>
								<div><i style="color:red;">Cek Kode Server Pada Siswa / Atau Hapus dulu Data Jawaban dan Nilai</i></div>
							<?php } ?>
							<table class='table table-striped'>
								<th>Nama Data</th><th>Data Berhasil Masuk</th><th>Data Gagal</th>
								<tr><td>Siswa/Sesi/Raung</td><td><i class='fa fa-check text-green'></i>
									<?= $masuk2.'/'.$masuk2_sesi.'/'.$masuk2_ruang ?></td><td><i class='fa fa-times text-red'></i>
										<?= $gagal2.'/'.$gagal2_sesi.'/'.$gagal2_ruang ?></td></tr>

									</table>

								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div>
					</div>
				<?php }
		if ($data == 'MAPEL') {
					$idtabel =$data; 
					$tabel = 'mata_pelajaran';
      //$sql = mysqli_query($koneksi, "DELETE FROM soal");
      //$sql = mysqli_query($koneksi, "ALTER TABLE soal AUTO_INCREMENT =1");
					$sql = mysqli_query($koneksi, "DELETE FROM ".$tabel);
					$sql = mysqli_query($koneksi, "ALTER TABLE ".$tabel." AUTO_INCREMENT =1");
					$api_url = $setting['url_host'];
					$json_get = $api_url.'/'.$serverApiKu.'/index.php/api_mata_pelajaran?token='.$setting['db_token'];

        // persiapkan curl----------------------------------------------
					$ch = curl_init(); 
        // set url 
					curl_setopt($ch, CURLOPT_URL, $json_get);
        // return the transfer as a string 
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        // $output contains the output string 
					$output = curl_exec($ch); 
        // tutup curl 
					curl_close($ch);      
        // menampilkan hasil curl
					$get = json_decode($output);
        //--------------------------------------------------------------
       
				if($get->info == 'ko'){
					echo($get->pesan);
				}
				else{

					foreach ($get as $data) {
						$dataa2 = array(
			            //'idmapel' => $data->id_mapel,
							'kode_mapel' => $data->kode_mapel,
							'nama_mapel' => $data->nama_mapel,
							'mata_pelajaran_id' => $data->mata_pelajaran_id,
							'kode_level' => $data->kode_level,
						);
						$exec2 = insert($koneksi,$tabel,$dataa2);
						if($exec2 == 'OK') {
							$masuk3++; 
						} else {
							$gagal3++;
						} 
					}
				}
					$sintable = 'sinkron';
					$sindata = array(
						'jumlah' => $masuk3,
						'status_sinkron' =>1,
						'tanggal' =>$datetime
					);
					$sinwhere = array(
						'nama_data' =>$idtabel
					);
					$sinexec = update($koneksi,$sintable,$sindata,$sinwhere);
					?>
					<div class='row'>
						<div class='col-md-12'>
							<div class='box box-solid'>
								<div class='box-header with-border bg-blue'>
									<h5 class='box-title'style="color: white;" >DATA YANG MASUK KE LOKAL</h5>
								</div>
								<div class='box-body'>
									
									<table class='table table-striped'>
										<th>Nama Data</th><th>Data Berhasil Masuk</th><th>Data Gagal</th>
										<tr><td>Mapel / Mata Pelajaran</td><td><i class='fa fa-check text-green'></i> <?= $masuk3 ?></td><td><i class='fa fa-times text-red'></i><?= $gagal3 ?></td></tr>

									</table>

								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div>
					</div>
				<?php }
		if ($data == 'BANK_SOAL') {
					$idtabel =$data; 
					$tabel = 'mapel';
      //$sql = mysqli_query($koneksi, "DELETE FROM soal");
      //$sql = mysqli_query($koneksi, "ALTER TABLE soal AUTO_INCREMENT =1");
					$sql = mysqli_query($koneksi, "DELETE FROM ".$tabel);
					$sql = mysqli_query($koneksi, "ALTER TABLE ".$tabel." AUTO_INCREMENT =1");
					$api_url = $setting['url_host'];
					$json_get = $api_url.'/'.$serverApiKu.'/index.php/api_mapel?token='.$setting['db_token'];
 				// persiapkan curl----------------------------------------------
					$ch = curl_init(); 
        // set url 
					curl_setopt($ch, CURLOPT_URL, $json_get);
        // return the transfer as a string 
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        // $output contains the output string 
					$output = curl_exec($ch); 
        // tutup curl 
					curl_close($ch);      
        // menampilkan hasil curl
					$get = json_decode($output);
        //--------------------------------------------------------------
       
				if($get->info == 'ko'){
					echo($get->pesan);
				}
				else{
					foreach ($get as $data) {
						$dataa = array(
							'id_mapel' => $data->id_mapel,
							'idpk' => $data->idpk,
							'idguru' => $data->idguru,
							'nama' => $data->nama,
							'jml_soal' => $data->jml_soal,
							'jml_esai' => $data->jml_esai,
							'tampil_pg' => $data->tampil_pg,
							'tampil_esai' => $data->tampil_esai,
							'bobot_pg' => $data->bobot_pg,
							'bobot_esai' => $data->bobot_esai,
							'level' => $data->level,
							'opsi' => $data->opsi,
							'kelas' => $data->kelas,
							'siswa' => $data->siswa,
							'date' => $data->date,
							'status' => $data->status,
							'statusujian' => $data->statusujian,
							'jenisSoalUjian' => $data->jenisSoalUjian,
							'soalAgama' => $data->soalAgama,
							'soalAgamaList' => $data->soalAgamaList,
							'soalPaket' => $data->soalPaket,
						);
           // $exec = mysqli_query($koneksi,
           //  "INSERT INTO mapel
           //  (id_mapel,idpk,idguru,nama,jml_soal,jml_esai,tampil_pg,tampil_esai,bobot_pg,bobot_esai,level,opsi,kelas,siswa,date,status,statusujian)
           //  values('$data->id_mapel','$data->idpk','$data->idguru','$data->nama','$data->jml_soal','$data->jml_esai','$data->tampil_pg','$data->tampil_esai','$data->bobot_pg','$data->bobot_esai','$data->level','$data->opsi','$data->kelas','$data->siswa','$data->date','$data->status','$data->statusujian')") or die (mysqli_error($koneksi));
           $exec = insert($koneksi,$tabel,$dataa);
            if ($exec) {
             $masuk2++; 
            } else {
              $gagal2++;
            }
            
					}
				}

					$sintable = 'sinkron';
					$sindata = array(
						'jumlah' => $masuk2,
						'status_sinkron' =>1,
						'tanggal' =>$datetime
					);
					$sinwhere = array(
						'nama_data' =>$idtabel
					);
					$sinexec = update($koneksi,$sintable,$sindata,$sinwhere);
					?>
					<div class='row'>
						<div class='col-md-12'>
							<div class='box box-solid'>
								<div class='box-header with-border bg-blue'>
									<h5 class='box-title'style="color: white;" >DATA YANG MASUK KE LOKAL</h5>
								</div>
								<div class='box-body'>
									
									<table class='table table-striped'>
										<th>Nama Data</th><th>Data Berhasil Masuk</th><th>Data Gagal</th>
										<tr><td>Mapel / Mata Pelajaran</td><td><i class='fa fa-check text-green'></i> <?= $masuk2 ?></td><td><i class='fa fa-times text-red'></i><?= $gagal2?></td></tr>

									</table>

								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div>
					</div>
				<?php }
	if ($data == 'SOAL') {
            //Tarik Data Soal

					$tabel = 'soal';
					$sql = mysqli_query($koneksi, "DELETE FROM ".$tabel);
					$sql2 = mysqli_query($koneksi, "ALTER TABLE ".$tabel." AUTO_INCREMENT =1");
           
            //ambil url host dari db
					$homeurl_sinkron = $setting['url_host'];
            //link file json web server dan id tokenya untuk validasi
					$link = '/soal_json.php?id='.$setting['db_token'];
            //gabung url
					$url2 = $homeurl_sinkron.$link;
           
					$gagal3 = 0;

            // mryes crul
					$curl = curl_init($url);
            //buka linknya
					curl_setopt($curl, CURLOPT_URL, $url2);
            //ubah ke text datanya yang akan di ubah ke array
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            //tampung harilnya
					$array1= curl_exec($curl);
					curl_close();
					$array = json_decode($array1,true);


					if($array['status'] != 'error'){

              foreach ($array as $r) { //looping data json array

              	$soal = addslashes($r['soal']);
              	$pila = addslashes($r['pila']);
              	$pilb = addslashes($r['pilb']);
              	$pilc = addslashes($r['pilc']);
              	$pild = addslashes($r['pild']);
              	$pile = addslashes($r['pile']);
              	$sql2 = mysqli_query($koneksi, "INSERT INTO soal
              		(id_soal,id_mapel,nomor,soal,jenis,pilA,pilB,pilC,pilD,pilE,jawaban,file,file1,fileA,fileB,fileC,fileD,fileE) values            
              		('$r[id_soal]','$r[id_mapel]','$r[nomor]','$soal','$r[jenis]','$pila','$pilb','$pilc','$pild','$pile','$r[jawaban]','$r[file]','$r[file1]','$r[filea]','$r[fileb]','$r[filec]','$r[filed]','$r[filee]')");
              	if (!$sql2) {
              		$gagal3++;
              	} else {
              		$masuk3++;
              	}
              }
              $exec = mysqli_query($koneksi, "update sinkron set jumlah='$masuk3', status_sinkron='1',tanggal='$datetime' where nama_data='$data'");
          }
          else{
          	$error ="Priksa Kembali Token dan Url Host (url web servernya)";
          }
          ?>
          <div class='row'>
          	<div class='col-md-12'>
          		<div class='box box-solid'>
          			<div class='box-header with-border bg-blue'>
          				<h5 class='box-title' style="color: white;">DATA YANG MASUK KE LOKAL</h5>
          			</div>
          			<div class='box-body'>
          				<table class='table table-striped'>
          					<th>Nama Data</th><th>Data Berhasil Masuk</th><th>Data Gagal</th>
          					<tr><td>Data Soal</td><td><i class='fa fa-check text-green'></i><?= $masuk3 ?></td><td><i class='fa fa-times text-red'></i> <?= $gagal3; ?></td></tr>
          				</table>
          				<legend><?= $error; ?></legend>
          			</div><!-- /.box-body -->

          		</div><!-- /.box -->
          	</div>
          </div>
      <?php }
    if ($data == 'JADWAL') {
            //Tarik Jadwal
            //$sql = mysqli_query($koneksi, "truncate table ujian");
      	$idtabel =$data; 
      	$tabel = 'ujian';
      	$sql = mysqli_query($koneksi, "DELETE FROM ".$tabel);
      	$sql = mysqli_query($koneksi, "ALTER TABLE ".$tabel." AUTO_INCREMENT =1");
      	$api_url = $setting['url_host'];
      	$json_get = $api_url.'/'.$serverApiKu.'/index.php/api_jadwal?token='.$setting['db_token'];
      	// persiapkan curl----------------------------------------------
					$ch = curl_init(); 
        // set url 
					curl_setopt($ch, CURLOPT_URL, $json_get);
        // return the transfer as a string 
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        // $output contains the output string 
					$output = curl_exec($ch); 
        // tutup curl 
					curl_close($ch);      
        // menampilkan hasil curl
					$get = json_decode($output);
        //--------------------------------------------------------------
       
				if($get->info == 'ko'){
					echo($get->pesan);
				}
				else{
      	foreach ($get as $data) {
              //if($data->server == $setting['kode_sekolah']){
      		$dataa = array(
      			'id_ujian' => $data->id_ujian,
      			'id_pk' => $data->id_pk,
      			'id_guru' => $data->id_guru,
      			'id_mapel' => $data->id_mapel,
      			'kode_ujian' => $data->kode_ujian,
      			'nama' => $data->nama,
      			'jml_soal' => $data->jml_soal,
      			'jml_esai' => $data->jml_esai,
      			'tampil_pg' => $data->tampil_pg,
      			'tampil_esai' => $data->tampil_esai,
      			'bobot_pg' => $data->bobot_pg,
      			'bobot_esai' => $data->bobot_esai,
      			'opsi' => $data->opsi,
      			'lama_ujian' => $data->lama_ujian,
      			'tgl_ujian' => $data->tgl_ujian,
      			'tgl_selesai' => $data->tgl_selesai,
      			'waktu_ujian' => $data->waktu_ujian,
                //'selesai_ujian' => $data->selesai_ujian,
      			'level' => $data->level,
      			'kelas' => addslashes($data->kelas),
      			'siswa' => addslashes($data->siswa),
      			'sesi' => $data->sesi,
      			'acak' => $data->acak,
      			'token' => $data->token,
      			'status' => $data->status,
      			'hasil' => $data->hasil,
      			'kkm' => $data->kkm,
      			'ulang' => $data->ulang,
      			'tombol_selsai' => $data->tombol_selsai,
      			'acak_opsi' => $data->acak_opsi,
      			'history' => $data->history,
      			'status_reset' => $data->status_reset,
      			'jenisSoalUjian' => $data->jenisSoalUjian,
      			'soalAgama' => $data->soalAgama,
      			'soalAgamaList' => $data->soalAgamaList,

      		);
             // }
      		$exec = insert($koneksi,$tabel,$dataa);
      		$exec2 = mysqli_query($koneksi, "INSERT INTO jenis (id_jenis,nama,status) values ('$data->kode_ujian','$data->kode_ujian','aktif') ");
      		if ($exec=='OK') {
      			$masuk4++; 
      		} else {
      			$gagal4++;
      		}

      	}
      }
      	$sintable = 'sinkron';
      	$sindata = array(
      		'jumlah' => $masuk4,
      		'status_sinkron' =>1,
      		'tanggal' =>$datetime
      	);
      	$sinwhere = array(
      		'nama_data' =>$idtabel
      	);
      	$sinexec = update($koneksi,$sintable,$sindata,$sinwhere);

      	?>
      	<div class='row'>
      		<div class='col-md-12'>
      			<div class='box box-solid'>
      				<div class='box-header with-border bg-blue'>
      					<h5 class='box-title' style="color: white;">DATA YANG MASUK KE LOKAL</h5>
      				</div>
      				<div class='box-body'>
      					<table class='table table-striped'>
      						<th>Nama Data</th><th>Data Berhasil Masuk</th><th>Data Gagal</th>
      						<tr><td>Jadwal Ujian</td><td><i class='fa fa-check text-green'></i><?= $masuk4 ?></td><td><i class='fa fa-times text-red'></i><?= $gagal4 ?></td></tr>

      					</table>

      				</div><!-- /.box-body -->
      			</div><!-- /.box -->
      		</div>
      	</div>
      <?php }
    if ($data == 'SETTING') {
            //Tarik DATA SEKOLAH TABEL SETTING

      	$i = 1;
      	$sqlcek = mysqli_query($koneksipusat, "select * from  setting ");
      	$r = mysqli_fetch_array($sqlcek);
      	$sekolah = addslashes($r['sekolah']);
      	$sql = mysqli_query($koneksi, "UPDATE setting SET sekolah='$sekolah',
      		jenjang='$r[jenjang]',kepsek='$r[kepsek]',
      		nip='$r[nip]',alamat='$r[alamat]',kecamatan='$r[kecamatan]',kota='$r[kota]',
      		telp='$r[telp]',web='$r[web]',email='$r[email]' WHERE id_setting='1'");
      	if (!$sql) {
      		$gagal5++;
      	} else {
      		$masuk5++;
      	}
      	echo "$masuk5 file berhasil masuk";
      	$exec = mysqli_query($koneksi, "update sinkron set jumlah='$masuk5', status_sinkron='1',tanggal='$datetime' where nama_data='$data'");
      }

      if ($data == 'FILE_PENDUKUNG') {
      	function multiple_download($urls, $save_path = '../files')
      	{
      		$multi_handle = curl_multi_init();
      		$file_pointers = [];
      		$curl_handles = [];
                // Add curl multi handles, one per file we don't already have
      		foreach ($urls as $key => $url) {
      			$file = $save_path . '/' . basename($url);
      			if (!is_file($file)) {
      				$curl_handles[$key] = curl_init($url);
      				$file_pointers[$key] = fopen($file, "w");
      				curl_setopt($curl_handles[$key], CURLOPT_FILE, $file_pointers[$key]);
      				curl_setopt($curl_handles[$key], CURLOPT_HEADER, 0);
      				curl_setopt($curl_handles[$key], CURLOPT_CONNECTTIMEOUT, 60);
      				curl_multi_add_handle($multi_handle, $curl_handles[$key]);
      			}
      		}
                // Download the files
      		do {
      			curl_multi_exec($multi_handle, $running);
      		} while ($running > 0);
                // Free up objects
      		foreach ($urls as $key => $url) {
      			curl_multi_remove_handle($multi_handle, $curl_handles[$key]);
      			curl_close($curl_handles[$key]);
      			fclose($file_pointers[$key]);
      		}
      		curl_multi_close($multi_handle);
      	}
            // Files to download
      	$cekfile = mysqli_query($koneksipusat, "select * from file_pendukung");
      	$urls = [];
      	$i = 0;
      	if ($setting['db_folder'] == '' or $setting['db_folder'] == null) {
      		$folder = "";
      	} else {
      		$folder = "/" . $setting['db_folder'];
      	}
      	$homeurl_sinkron = $setting['url_host'];
      	while ($cek = mysqli_fetch_array($cekfile)) {

      		$urls[$i] = $homeurl_sinkron . $folder . "/files/" . $cek['nama_file'];
      		$i++;
      	}
      	echo "$i file berhasil masuk";
            // var_dump($urls);
            // die();
      	multiple_download($urls);
      	$exec = mysqli_query($koneksi, "update sinkron set jumlah='$i', status_sinkron='1',tanggal='$datetime' where nama_data='$data'");
      }
  } else {
  	echo "Server Pusat Belum Diaktifin";
  }
} else {
	?>
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid'>
				<div class='box-header with-border bg-red'>
					<h5 class='box-title' style="color: white;">SINKRONISASI GAGAL</h5>
				</div>
				<div class='box-body'>
					<ul>
						<li>Periksa Koneksi Internet</li>
						<li>Periksa Pengaturan Jaringan</li>
						<li>Pastikan Server dalam kondisi AKTIF</li>
					</ul>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
	<?php                 
}
