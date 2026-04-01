<?php 
// Create ZIP file Mryes
include("core/c_admin.php"); 

if($token == $token1) {
    if(isset($_GET['restorejson'])){
      if($_GET['restorejson'] == "yes"){
        
        $extensionList = array("json");
        $file_name = $_FILES['json']['name']; //ambil file
        $datetime = date('Y-m-d H:i:s');
        $path = 'upload_data/'; //lokasi di tempatkan   
        
        $location = $path .time().$file_name; //file di taruh
        $pecah = explode(".", $file_name);
        $ekstensi = $pecah[1];
        if(in_array($ekstensi, $extensionList)){
          if(move_uploaded_file($_FILES['json']['tmp_name'], $location))  
          {
            $json = file_get_contents($location);
            $getData = json_decode($json);


            if($getData->aksi == 'level'){
              $yes=0; $no=0;
                foreach ($getData->data as $val) {
                  $data_level = array(
                    'idlevel' =>$val->idlevel,
                    'kode_level' =>$val->kode_level,
                    'keterangan' =>$val->keterangan,
                  );
                  $where = array(
                    'kode_level' =>$val->kode_level,
                  );
                  $cekData = $db->fetch('level',$where);
                  if(count($cekData) > 0) {
                    $ex= $db->update('level',$data_level,$where);
                    $pesanAksi="Berhasil Update";
                  }
                  else{
                    $ex= $db->insert('level',$data_level);
                    $pesanAksi="Berhasil Tambah";
                  }
                  
                  if($ex){
                    $yes++;
                    //kirim aktivitas ke server --------------
                    $db->KirimLogSinkron('KELAS',$yes);
                    $sindata = array(
                      'jumlah' => $yes,
                      'jumlah_server' =>$getData->jumlah,
                      'status_sinkron' =>1,
                      'tanggal' =>$datetime 
                    );
                    $sinwhere = array(
                      'nama_data' =>'KELAS'
                    );
                    $db->update('sinkron',$sindata,$sinwhere);
                    //kirim aktivitas ke server --------------
                  }
                  else{
                    $no++;
                  }
                }
                $senddata = array(
                  'status' =>200,
                  'pesan' =>$pesanAksi,
                  'jumlah' =>$yes.' Level Kelas',
                );
                echo json_encode($senddata);
            }
            elseif($getData->aksi == 'mata_pelajaran'){
              $tabel='mata_pelajaran';
              $yes=0; $no=0;
              foreach ($getData->data as $data) {
                $nestedData = array();
                $nestedData['idmapel'] = $data->idmapel;
                $nestedData['kode_mapel'] = $data->kode_mapel;
                $nestedData['nama_mapel'] = $data->nama_mapel;
                //$nestedData['mata_pelajaran_id'] = $data->mata_pelajaran_id;
                if(!empty($data->kode_level)){ $nestedData['kode_level'] = $data->kode_level; }
               
                $where = array(
                  'kode_mapel' => $data->kode_mapel,
                );
                $cekData = $db->fetch($tabel,$where);
                if(count($cekData) > 0) {
                  $ex= $db->update($tabel,$nestedData,$where);
                  $pesanAksi="Berhasil Update";
                }
                else{
                  $ex= $db->insert($tabel,$nestedData);
                  $pesanAksi="Berhasil Tambah";
                }
                
                if($ex){
                  $yes++;
                  //kirim aktivitas ke server --------------
                  $db->KirimLogSinkron('MAPEL',$yes);
                  $sindata = array(
                      'jumlah' => $yes,
                      'jumlah_server' =>$getData->jumlah,
                      'status_sinkron' =>1,
                      'tanggal' =>$datetime 
                    );
                    $sinwhere = array(
                      'nama_data' =>'MAPEL'
                    );
                    $db->update('sinkron',$sindata,$sinwhere);
                    //kirim aktivitas ke server --------------
                  
                }
                else{
                  $no++;
                }
              } //end foreach
              
              $senddata = array(
                'status' =>200,
                'pesan' =>$pesanAksi,
                'jumlah' =>$yes.' Mata Pelajaran',
              );
              

              echo json_encode($senddata);
              
            }

            elseif($getData->aksi == 'mapel'){ //bank soal
              $tabel="mapel";
              $yes=0; $no=0;

              foreach ($getData->data as $data) {
                //cek guru -------------------------------------
                $where_pengawas = array(
                  'id_pengawas' => $data->id_pengawas,
                );
                $dataPengawas = array(
                  'id_pengawas'         =>$data->id_pengawas,
                  'nip'                 =>$data->nip,
                  'nama'                =>$data->nama,
                  'jabatan'             =>$data->jabatan,
                  'username'            =>$data->username,
                  'password'            =>$data->password,
                  'level'               =>$data->level,
                  'password2'           =>$data->password2,
                  'id_kls'              =>$data->id_kls,
                  'id_jrs'              =>$data->id_jrs,
                  'foto_pengawas'       =>$data->foto_pengawas,
                  'pengawas_created'    =>$data->pengawas_created,
                );

                $cekPengawas = $db->fetch('pengawas',$where_pengawas);
                if(count($cekPengawas) == 0 ){
                  $db->insert('pengawas',$dataPengawas);
                }


                $nestedData = array();
                $nestedData['id_mapel'] = $data->id_mapel;
                $nestedData['idpk'] = $data->idpk;
                $nestedData['idguru'] = $data->idguru;
                $nestedData['KodeMapel'] = $data->KodeMapel;
                $nestedData['nama'] = $data->nama_mapel;
                $nestedData['jml_soal'] = $data->jml_soal;
                $nestedData['jml_esai'] = $data->jml_esai;
                $nestedData['tampil_pg'] = $data->tampil_pg;
                $nestedData['tampil_esai'] = $data->tampil_esai;
                $nestedData['bobot_pg'] = $data->bobot_pg;
                $nestedData['bobot_esai'] = $data->bobot_esai;
                $nestedData['level'] = $data->level;
                $nestedData['opsi'] = $data->opsi;
                $nestedData['kelas'] = $data->kelas;
                $nestedData['siswa'] = $data->siswa;
                $nestedData['date'] = $data->date;
                $nestedData['status'] = $data->status;
                $nestedData['statusujian'] = $data->statusujian;
                $nestedData['jenisSoalUjian'] = $data->jenisSoalUjian;
                $nestedData['soalAgama'] = $data->soalAgama;
                $nestedData['soalAgamaList'] = $data->soalAgamaList;
                $nestedData['soalPaket'] = $data->soalPaket;

                
                $where = array(
                  'nama' =>$data->nama_mapel,
                );
                $cekData = $db->fetch($tabel,$where);
                if(count($cekData) > 0) {
                  $ex= $db->update($tabel,$nestedData,$where);
                  $pesanAksi="Berhasil Update";
                }
                else{
                  $ex= $db->insert($tabel,$nestedData);
                  $pesanAksi="Berhasil Tambah";
                }
                
                if($ex){
                  $yes++;
                  //kirim aktivitas ke server --------------
                    $db->KirimLogSinkron('BANK_SOAL',$yes);
                    $sindata = array(
                      'jumlah' => $yes,
                      'jumlah_server' =>$getData->jumlah,
                      'status_sinkron' =>1,
                      'tanggal' =>$datetime 
                    );
                    $sinwhere = array(
                      'nama_data' =>'BANK_SOAL'
                    );
                    $db->update('sinkron',$sindata,$sinwhere);
                    //kirim aktivitas ke server --------------
                }
                else{
                  $no++;
                }
              }
               $senddata = array(
                'status' =>200,
                'pesan' =>$pesanAksi,
                'jumlah' =>$yes.' Bank Soal',
              );
                echo json_encode($senddata);

            }

            elseif($getData->aksi == 'soal'){
              $tabel='soal';
              $yes=0; $no=0; $noIdMapel=0;
                foreach ($getData->data as $data) {
                  //cek apakah ada soalnya -------------------------
                  $cekIdMapelSoal =array(
                    'id_mapel'  =>$data->id_mapel,
                  );

                  $cekSoal = $db->fetch('mapel',$cekIdMapelSoal);
                  if(count($cekSoal) > 1){
                   
                    $data_soal = array(
                      'id_soal'   => $data->id_soal,
                      'id_mapel'  =>$data->id_mapel,
                      'nomor'     =>$data->nomor,
                      'soal'      =>addslashes($data->soal),
                      'jenis'     => $data->jenis,
                      'pilA'      =>addslashes($data->pilA),
                      'pilB'      =>addslashes($data->pilB),
                      'pilC'      =>addslashes($data->pilC),
                      'pilD'      =>addslashes($data->pilD),
                      'pilE'      =>addslashes($data->pilE),
                      'jawaban'   => $data->jawaban,
                      'file'      =>addslashes($data->file),
                      'file1'     =>addslashes($data->file1),
                      'fileA'     =>addslashes($data->fileA),
                      'fileB'     =>addslashes($data->fileB),
                      'fileC'     =>addslashes($data->fileC),
                      'fileD'     =>addslashes($data->fileD),
                      'fileE'     =>addslashes($data->fileE),
                    );
                    $where = array(
                      'id_soal' => $data->id_soal,
                    );
                    $cekData = $db->fetch($tabel,$where);
                    if(count($cekData) > 0) {
                      $ex= $db->update($tabel,$data_soal,$where);
                      $pesanAksi="Berhasil Update";
                    }
                    else{
                      $ex= $db->insert($tabel,$data_soal);
                      $pesanAksi="Berhasil Tambah";
                    }
                    
                    if($ex){
                      $yes++;
                      //kirim aktivitas ke server --------------
                      $db->KirimLogSinkron('SOAL',$yes);
                      $sindata = array(
                        'jumlah' => $yes,
                        'jumlah_server' =>$getData->jumlah,
                        'status_sinkron' =>1,
                        'tanggal' =>$datetime 
                      );
                      $sinwhere = array(
                        'nama_data' =>'SOAL'
                      );
                      $db->update('sinkron',$sindata,$sinwhere);
                      //kirim aktivitas ke server --------------
                    }
                    else{
                      $no++;
                    }
                  }
                  else{ //else cek id mapel
                    $noIdMapel++;
                  }
                }
                 $senddata = array(
                  'status' =>200,
                  'pesan' =>$pesanAksi,
                  'jumlah' =>$yes.' Soal | '.$noIdMapel . ' Soal Tidak Ada Bank Soalnya',
                );
                echo json_encode($senddata);

            }

            else{ //TIDAK ADA AKSI
              $senddata = array(
                'status' =>203,
                'pesan' =>'Cek Format File Json',
                );
               echo json_encode($senddata);
            }

            unlink($location);
          }
          else{ //FILE GAGAL DI PINDAH
             $senddata = array(
                'status' =>203,
                'pesan' =>'Gagal Move File Json',
                );
               echo json_encode($senddata);
          }
        }
        else{
          $senddata = array(
            'status' =>203,
            'pesan' =>'No Prosesss',
          );
         echo json_encode($senddata);
        }
        unlink($location);
      
      }//en if restor json

   }//end if isset restore
}

else{
  jump("$homeurl");
exit;
}


?>