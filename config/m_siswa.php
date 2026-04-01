<?php
error_reporting(0);
session_cache_expire(0);
session_cache_limiter(0);
session_start();
set_time_limit(0);

(isset($_SESSION['id_user'])) ? $id_user = $_SESSION['id_user'] : $id_user = 0;
//cek validasi tokenya untuk upload dan import
(isset($_SESSION['token'])) ? $token = $_SESSION['token'] : $token = 1;

(isset($_SESSION['token1'])) ? $token1 = $_SESSION['token1'] : $token1 = 2;

include 'setting_url.php';


define("KEY", "76310EEFF2B5D3C887F238976A421B638CFEB0942AB8249CD0A29B125C91B3E5");

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape')) {
  $browser = 'Netscape';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
  $browser = 'Firefox';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
  $browser = 'Chrome';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
  $browser = 'Opera';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
  $browser = 'Internet Explorer';
} else $browser = 'Other';

//setting up one redis-----------------------------------------
require "vendor/autoload.php";

use RedisClient\RedisClient;
use RedisClient\Client\Version\RedisClient2x6;
use RedisClient\ClientFactory;

$Redis = new RedisClient();

//setting up one redis-----------------------------------------

class Siswa extends Db
{

  public $redis;
  //--cache redis------------
  function RedisKoneksi()
  {

    return $this->redis   = new RedisClient();
  }
  // function KodeSekolah()
  // {
  //   $sql = "SELECT kode_sekolah FROM setting";
  //   $log = $this->con->query($sql) or die($this->con->error);
  //   $setting = mysqli_fetch_array($log);
  //   return $setting['kode_sekolah'];
  // }
  
  function WaktuLamaCache()
  {
    return 3600; //dalam detik
    //1 jam 3600
    // 30 menit = 1800
    //10 menit=600
  }
  function getDataRedis($key, $sql)
  {
    //get data sql query ke data redis jiak server aktif
    //jika tidak aktif maka mengembalikan data sql query 
    try { //jika tidak errir redus
      if ($this->RedisKoneksi()->exists($key)) {
        $array = json_decode($this->RedisKoneksi()->get($key));
        return $array; //get data redis jika ada
      } else {
        $log = $this->con->query($sql) or die($this->con->error);
        foreach ($log as $value) {
          $array[] = $value;
        }
        $data_json = json_encode($array);
        $this->RedisKoneksi()->set($key, $data_json);
        $this->RedisKoneksi()->expire($key, $this->WaktuLamaCache());
        return json_decode($data_json);
        //get data dan buat cache redis
      }
    } catch (Exception $e) {
      $log = $this->con->query($sql) or die($this->con->error);
      foreach ($log as $value) {
        $array[] = $value;
      }
      $data_json = json_encode($array);
      return json_decode($data_json);
      //get data kerna Server Cache Redis Tidak Aktif
    }
  }
  function RedisDelKey($key){
    try { $this->RedisKoneksi()->del($key); }catch (Exception $e) { } 
  }
  //end cache redis -----------------------
  function KodeSekolah()
  {
    $sql = "SELECT kode_sekolah FROM setting";
    //$log = $this->con->query($sql) or die($this->con->error);
    // $setting = mysqli_fetch_array($log);
    // return $setting['kode_sekolah'];
    $log = $this->getDataRedis('kodesekolah'.$this->kode_redis, $sql);
    
    return $log[0]->kode_sekolah;
    
  }
  
  function fetch($table, $where = null)
  {
    $command = 'SELECT * FROM ' . $table;
    if ($where != null) {
      $value = null;
      foreach ($where as $f => $v) {
        $value .= "#" . $f . "='" . $v . "'";
      }
      $command .= ' WHERE ' . substr($value, 1);
      $command = str_replace('#', ' AND ', $command);
    }
    $sql = $this->con->query($command) or die($this->con->error);
    $exec = mysqli_fetch_array($sql);
    return $exec;
  }
  function rowcount($table, $where = null)
  {
    $command = 'SELECT * FROM ' . $table;
    if ($where != null) {
      $value = null;
      foreach ($where as $f => $v) {
        $value .= "#" . $f . "='" . $v . "'";
      }
      $command .= ' WHERE ' . substr($value, 1);
      $command = str_replace('#', ' AND ', $command);
    }
    $sql = $this->con->query($command) or die($this->con->error);
    $exec = mysqli_num_rows($sql);
    return $exec;
  }
  /*
    -&materi
  */
  private function idsiswa()
  {
    $idsiswa = $_SESSION['id_siswa'];
    return $idsiswa;
  }
  private function idkelas()
  {
    $idkelas = $_SESSION['id_kelas'];
    return $idkelas;
  }

  //bagian siswa index.php
  function Status_sudah_ujian($id_siswa, $id_mapel, $id_ujian)
  {
    $sql = "SELECT selesai FROM nilai WHERE id_ujian='$id_ujian' AND id_mapel='$id_mapel' AND id_siswa='$id_siswa'";
    $log = $this->con->query($sql) or die($this->con->error);
    while ($data = $log->fetch_array()) {
      $hasil = $data['selesai'];
    }
    return $hasil;
  }
  function Testing()
  {
    echo "1";
  }
  //&materi-----------------------------
  function v_siswa()
  {
    $id = $this->idsiswa();
    $sql = "SELECT * FROM siswa WHERE id_siswa='$id'";
    $log = $this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  function v_siswa2()
  {
    $sql = "SELECT id_siswa,id_kelas,idpk,level,ruang,sesi FROM siswa WHERE status_siswa=1 ";
    $log = $this->con->query($sql) or die($this->con->error);
    return $log;
  }
  //----------------Pangging Materi----------------------
  function paging($halaman, $materi2_mapel, $kodelv)
  {
    $kelas = $_SESSION['id_kelas'];
    $result = $this->con->query("SELECT * FROM materi2 where materi2_mapel='$materi2_mapel' AND kode_level='$kodelv' ") or die($this->con->error);
    foreach ($result as $value) {
      $datakelas = unserialize($value['kelas']);
      if (in_array($kelas, $datakelas) or in_array('semua', $datakelas)) {
        $array[] = $value;
      }
    }
    $total = count($array);
    $pages = ceil($total / $halaman);
    return  $pages;
  }
  function halaman()
  {
    $halaman = 5;
    return $halaman;
  }
  function mulai($halaman)
  {
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $halaman;
    return $start;
  }
  function get_materi($mulai, $halaman, $kelas, $guru, $level3, $idmapel3)
  { //DAFTAR MATERI
    $tglnow = strtotime(date("Y-m-d H:i:s"));
    $sql = "SELECT *,materi2.kode_level AS kodelv FROM materi2 
    INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel 
    WHERE materi2.kode_level='$level3' AND materi2_mapel='$idmapel3' ORDER BY materi2_tgl DESC LIMIT $mulai, $halaman";
    $query = $this->con->query($sql) or die($this->con->error);
    foreach ($query as $value) {
      $rilis = strtotime($value['materi2_tgl_rilis']);
      if ($tglnow >= $rilis) {
        $datakelas = unserialize($value['kelas']);
        if (in_array($kelas, $datakelas) or in_array('semua', $datakelas)) {
          $array[] = $value;
        }
      }
    }
    return  $array;
  }

  //---------------- / Pangging Materi----------------------
  // function get_materi2($guru,$level,$idmapel2){ //untuk menjumlhakan materi
  //   $sql="SELECT COUNT(materi2_id) AS jml FROM materi2 
  //   WHERE id_guru=$guru AND kode_level='$level' AND materi2_mapel='$idmapel2'";
  //   $query = $this->con->query($sql) or die($this->con->error);
  //   $exec =$query->fetch_array();
  //   return $exec;
  // }
  function getMapelList($level)
  {
    $sql = "SELECT * FROM mata_pelajaran WHERE kode_level='$level'";
    $query = $this->con->query($sql) or die($this->con->error);
    return  $query;
  }

  function get_materi_count($kelas, $level, $idmapel)
  { //DAFTAR MATERI
    $no = 1;
    $tglnow = strtotime(date("Y-m-d H:i:s"));
    $sql = "SELECT *,materi2.kode_level AS kodelv FROM materi2 
    INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel 
    WHERE materi2.kode_level='$level' AND materi2_mapel='$idmapel' ORDER BY materi2_tgl";
    $query = $this->con->query($sql) or die($this->con->error);

    foreach ($query as $value) {
      $rilis = strtotime($value['materi2_tgl_rilis']);
      if ($tglnow >= $rilis) {
        $datakelas = unserialize($value['kelas']);
        if (in_array($kelas, $datakelas) or in_array('semua', $datakelas)) {
          $arrayJml['total_materi'] = $no++;
        }
      }
    }
    return  $arrayJml;
  }


  function guru_materi($level)
  {
    $sql = "SELECT nama,id_guru,kelas,materi2.kode_level as kodelevel,materi2.materi2_mapel as idmapel2,nama_mapel FROM pengawas 
    INNER JOIN materi2 ON materi2.id_guru = pengawas.id_pengawas 
    INNER JOIN mata_pelajaran ON mata_pelajaran.kode_mapel = materi2.materi2_mapel 
    WHERE materi2.kode_level='$level' 
    GROUP BY materi2.materi2_mapel,id_guru";
    $query = $this->con->query($sql) or die($this->con->error);
    // foreach ($query as $value) {
    //   $datakelas = unserialize($value['kelas']);
    //   if (in_array($this->idkelas(), $datakelas) or in_array('semua', $datakelas)){
    //     $array[]=$value;
    //     echo'asd';
    //   }
    // }

    return  $query;
  }
  function baca_materi()
  {
    $id = $_GET['id'];
    $guru = dekripsi($id);
    $idm = $_GET['idmateri'];
    $idmateri = dekripsi($idm);

    try {
      //echo $this->RedisKoneksi()->ping();
      $sql = "SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas WHERE materi2_id='$idmateri' and materi2.id_guru=$guru ";
      $log = $this->con->query($sql) or die($this->con->error);

      //proses cache ------------------------------------------------------------
      if ($this->RedisKoneksi()->exists("baca_materi" . $this->KodeSekolah() . $idmateri)) {
        $array = json_decode($this->RedisKoneksi()->get("baca_materi" . $this->KodeSekolah() . $idmateri));
        return $array;
      } else {
        $array = array();
        foreach ($log as $value) {
          $array[] = $value;
        }
        $data_json = json_encode($array);

        $this->RedisKoneksi()->set("baca_materi" . $this->KodeSekolah() . $idmateri, $data_json);
        $this->RedisKoneksi()->expire("baca_materi" . $this->KodeSekolah() . $idmateri, $this->WaktuLamaCache());
        //var_dump($array);

        return json_decode($data_json);
      }
      //proses cache ------------------------------------------------------------
    } catch (Exception $e) {
      $sql = "SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas WHERE materi2_id='$idmateri' and materi2.id_guru=$guru ";
      $log = $this->con->query($sql) or die($this->con->error);
      $array = array();
      foreach ($log as $value) {
        $array[] = $value;
      }
      $data_json = json_encode($array);
      return json_decode($data_json);
    }
  }
  function video_materi($guru2)
  {
    if (empty($_GET['idvideo'])) {
      $id2 = null;
    } else {
      $id2 = $_GET['idvideo'];
    }
    $id = dekripsi($id2);
    $guru = dekripsi($guru2);
    $sql = "SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas WHERE materi2_id='$id' and materi2.id_guru=$guru ";
    $log = $this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  function next_materi()
  {
    $sql = "SELECT MAX(materi2_id)as max FROM materi2";
    $log = $this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  function prev_materi()
  {
    $sql = "SELECT MIN(materi2_id) as min FROM materi2";
    $log = $this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  //asbensi ---------------------------------------------- 
  function getJamSekolah()
  {
    $sql = "SELECT * FROM jam_skl";
    $log = $this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  //untuk ambil tahun di opsi pilihan
  function getTahun()
  {
    $sql = "SELECT DISTINCT YEAR(absTgl) AS tahun FROM absensi";
    $log = $this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function getAbsenDetail()
  {
    @$tahun = $_GET['tahun'];
    @$bulan = $_GET['bulan'];
    @$idsiswa = $_GET['siswa'];


    if (!empty($tahun)) {
      $sql = "SELECT absId,absFoto,absUrlFoto,absIdSiswa,absTgl,absJamIn,absJamOut,absStatus,siswa.nama AS namasiswa,kelas.nama 
       FROM absensi 
       INNER JOIN siswa ON siswa.id_siswa=absensi.absIdSiswa
       INNER JOIN kelas ON kelas.idkls=absensi.absIdKelas 
       WHERE MONTH(absTgl)=$bulan AND YEAR(absTgl)=$tahun AND absIdSiswa=$idsiswa";

      $log = $this->con->query($sql) or die($this->con->error);
      return $log;
    }
  }
  // //untuk cek absen cronjob
  // function getAbsenCronJob($idsiswa,$tgl)
  // {

  //   $sql ="SELECT * FROM absensi WHERE MONTH(absTgl)=$bulan AND YEAR(absTgl)=$tahun AND absIdSiswa=$idsiswa";
  //   $log=$this->con->query($sql) or die($this->con->error);
  //   return $log;
  //   }  
  // }
  //asbensi Per Mapel ----------------------------------------
  function getAbsenMapel($idkelas = null, $hari = null)
  {
    if (empty($hari)) {
      $where = " WHERE amKelas=$idkelas ";
    } else {
      $where = " WHERE amKelas=$idkelas AND amHari='$hari' ";
    }

    $sql = "SELECT * FROM absensi_mapel 
        INNER JOIN mata_pelajaran ON absensi_mapel.amIdMapel=mata_pelajaran.idmapel
        INNER JOIN pengawas ON absensi_mapel.amIdGuru=pengawas.id_pengawas
        INNER JOIN telegram_bot ON tlIdGuru=pengawas.id_pengawas
        $where ";
    $log = $this->con->query($sql) or die($this->con->error);

    return  $log;
  }
  function getAbsenMapel_by_siswa()
  {
    @$tahun = $_GET['tahun'];
    @$bulan = $_GET['bulan'];
    @$idsiswa = $_GET['siswa'];
    @$mapel = $_GET['mapel'];
    //INNER JOIN mata_pelajaran ON mata_pelajaran.idmapel=absensi_mapel_anggota.amaIdMapel
    if (!empty($tahun)) {
      $sql = "SELECT * FROM absensi_mapel_anggota
       INNER JOIN siswa ON siswa.id_siswa=absensi_mapel_anggota.amaIdSiswa
       WHERE MONTH(amaTgl)=$bulan AND YEAR(amaTgl)=$tahun AND amaIdSiswa=$idsiswa AND amaIdAbsenMapel=$mapel";
      $log = $this->con->query($sql) or die($this->con->error);
      return $log;
    }
  }
  //Pengumuman --------------------------------
  function getPengumuman($kelas)
  {

    $sql = "SELECT * FROM pengumuman INNER JOIN pengawas ON pengawas.id_pengawas=pengumuman.user
    where type='eksternal' ORDER BY date DESC ";
    $log = $this->getDataRedis('pengumuman' . $this->KodeSekolah(), $sql);
    foreach ($log as $value) {
      $datakelas = unserialize($value->pnKelas);
      if (in_array($kelas, $datakelas) or in_array('semua', $datakelas)) {
        $array[] = $value;
      }
    }
    return $array;
  }
  //Bot Telegram --------------------------------
  //----send to bot telegram absensi ---------------
  function KirimAbsenTelegram($pesan, $idbot, $idgrub, $nama2, $kelas2, $sekolah2, $nama_mapel)
  {
    //silahakan modifikasi di bagian ini
    $nama = $nama2;
    $kelas = $kelas2;
    $date = date("d-m-Y");
    $jam = date("H:i:s");
    $title = $pesan;
    $sekolah = $sekolah2;

    //silahakan modifikasi di bagian ini
    //-----------------------------------------
    $message = "<b><i>" . $title . "</i></b>%0A";
    $message .= "<b>" . $sekolah . "</b>%0A";
    $message .= "Mapel : <b>" . $nama_mapel . "</b>%0A";
    $message .= "Nama : <b>" . $nama . "</b>%0A";
    $message .= "Kelas : <b>" . $kelas . "</b>%0A";
    $message .= "Tgl : " . $date . "%0A";
    $message .= "Jam : " . $jam . "%0A";
    //-----------------------------------------

    //----------------------No Edit------------------------------------------------------
    $api = 'https://api.telegram.org/bot' . $idbot . '/sendMessage?chat_id=' . $idgrub . '&text=' . $message . '&parse_mode=HTML';

    $ch = curl_init($api); //inisialisasi awal curl
    curl_setopt($ch, CURLOPT_HEADER, false); // set url 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return the transfer as a string 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch); // $output contains the output string 
    curl_close($ch);
    //----------------------No Edit------------------------------------------------------

    return $api;
  }
  function KirimAbsenTelegram2($pesan, $idbot, $idgrub, $nama2, $kelas2, $sekolah2)
  {
    //silahakan modifikasi di bagian ini
    $nama = $nama2;
    $kelas = $kelas2;
    $date = date("d-m-Y");
    $jam = date("H:i:s");
    $title = $pesan;
    $sekolah = $sekolah2;
    $status = 'Hadir';

    //silahakan modifikasi di bagian ini
    //-----------------------------------------
    $message = "<b><i>" . $title . "</i></b>%0A";
    $message .= "<b>" . $sekolah . "</b>%0A";
    $message .= "Nama : <b>" . $nama . "</b>%0A";
    $message .= "Kelas : <b>" . $kelas . "</b>%0A";
    $message .= "Status : <b>" . $status . "</b>%0A";
    $message .= "Tgl : " . $date . "%0A";
    $message .= "Jam : " . $jam . "%0A";
    //-----------------------------------------

    //----------------------No Edit------------------------------------------------------
    $api = 'https://api.telegram.org/bot' . $idbot . '/sendMessage?chat_id=' . $idgrub . '&text=' . $message . '&parse_mode=HTML';

    $ch = curl_init($api);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    //----------------------No Edit------------------------------------------------------

    return $api;
  }
  function CekAktifSend()
  {
    $sql = "SELECT * FROM bot_telegram WHERE botId=1";
    $log = $this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  function DaftarNilaiTugas($id)
  {
    $sql = "SELECT mapel,judul,tgl_mulai,tgl_selesai,nilai,catatanGuru,tgl_dikerjakan FROM jawaban_tugas INNER JOIN tugas ON tugas.id_tugas=jawaban_tugas.id_tugas WHERE id_siswa=$id";
    $log = $this->con->query($sql) or die($this->con->error);
    return $log;
  }
  //Jadwal Ujian --------------------------------
  function JadwalUjian($idpk = null, $level, $idsesi, $id_siswa, $agamaSiswa = null, $dataidkelas, $paketSoalSiswa)
  {
    $tanggalSekarang = date('Y-m-d');
    if (empty($idpk)) {
      $sql = "SELECT * FROM ujian WHERE DATE(tgl_ujian) = '$tanggalSekarang' AND (level='$level' or level='semua') AND sesi='$idsesi' AND status='1' ORDER BY tgl_ujian";
    } else {
      $sql = "SELECT * FROM ujian WHERE DATE(tgl_ujian) = '$tanggalSekarang' AND (id_pk='$idpk' or id_pk='semua') AND (level='$level' or level='semua') AND sesi='$idsesi' AND status='1' ORDER BY tgl_ujian";
    }
    $log = $this->con->query($sql) or die($this->con->error);

    foreach ($log as $mapelx) {
      if (date('Y-m-d', strtotime($mapelx['tgl_ujian'])) <= $tanggalSekarang and date('Y-m-d', strtotime($mapelx['tgl_selesai'])) >= $tanggalSekarang) {
        $datakelas = unserialize($mapelx['kelas']);
        $dataidsiswa = unserialize($mapelx['siswa']);

        //kondisi cek nilai siswa ada atau tidak--------------------------------------------
        $where = array(
          'id_ujian' => $mapelx['id_ujian'],
          'id_mapel' => $mapelx['id_mapel'],
          'id_siswa' => $id_siswa,
          'kode_ujian' => $mapelx['kode_ujian']
        );
        $nilai = $this->fetch('nilai', $where);
        $ceknilai = $this->rowcount('nilai', $where);
        $nilai_pindah = $this->fetch('nilai_pindah', $where);
        $ceknilai_pindah = $this->rowcount('nilai_pindah', $where);

        if ($nilai['blok'] == 1 AND $nilai['blokBukaAdmin']== 0) {
          #cek blokir siswa
          $btntest = "<button class='btn btn-block btn-danger btn-sm disabled'>Blokir Hubungi Admin</button>";
        } else {
          if ($ceknilai == '0' and $ceknilai_pindah == 0) {
            if (strtotime($mapelx['tgl_ujian']) <= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
              $status = '<label class="label label-success">Tersedia </label>';
              $btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-primary'><i class='fa fa-edit'></i> MULAI</button>";
            elseif (strtotime($mapelx['tgl_ujian']) >= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
              $status = '<label class="label label-danger">Belum Waktunya</label>';
              $btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> BELUM UJIAN</button>";
            else :
              $status = '<label class="label label-danger">Telat Ujian</label>';
              $btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> Telat Ujian</button>";
            endif;
          } else {
            if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] == '') :
              if ($nilai['online'] == 0) {
                $status = '<label class="label label-warning">Berlangsung</label>';
                $btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-success'><i class='fas fa-edit'></i> LANJUTKAN</button>";
              } else {
                $status = '<label class="label label-warning">Siswa sedang aktif</label>';
                $btntest = "<button  class=' btn btn-block btn-sm btn-success' disabled><i class='fas fa-edit'></i> LANJUTKAN</button>";
              }
            else :
              if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] <> '') {
                $status = '<label class="label label-primary">Selesai</label>';
                $btntest = "<button class='btn btn-block btn-success btn-sm disabled'> Sudah Ujian</button>";
              } elseif ($nilai_pindah['ujian_mulai'] <> '' and $nilai_pindah['ujian_berlangsung'] <> '' and $nilai_pindah['ujian_selesai'] <> '') {
                $status = '<label class="label label-primary">Selesai</label>';
                $btntest = "<button class='btn btn-block btn-success btn-sm disabled'> Sudah Ujian</button>";
              } else {
                $btntest = "<button class='btn btn-block btn-danger btn-sm disabled'> Reset Hubungi Admin</button>";
              }
            endif;
          } //strtoupper

        }
        $array_agama = array(
          'ISLAM', 'PROTESTAN', 'KATOLIK', 'HINDU', 'BUDDHA', 'KHONGHUCU',
          'Islam', 'Protestan', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu',
          'Katholik', 'Kristen', 'Budha'
        );

        //end kondisi cek nilai siswa ada atau tidak-------------------------------------------
        if ($mapelx['soalAgama'] == 1 and $mapelx['soalPaket'] == $paketSoalSiswa) { //cek paket soal agama
          if ($agamaSiswa == $mapelx['soalAgamaList'] or in_array($agamaSiswa, $array_agama)) {
            $dataUjian[] = array(
              'id_ujian' => $mapelx['id_ujian'],
              'kode_ujian' => $mapelx['kode_ujian'],
              'nama' => $mapelx['nama'],
              'slagNama' => $mapelx['slagNama'],
              'tgl_ujian' => $mapelx['tgl_ujian'],
              'tgl_selesai' => $mapelx['tgl_selesai'],
              'tombol' => $btntest,
              'paket' => $mapelx['soalPaket'],
            );
          }
        } else {
          //filter jadwal berdasarakn kondisi--------------------------------------------------
          /*----jika id_siswa dan kelas sesuai maka tampilkan jadwal yang ada kelas dan id_siswanya--*/
          if (in_array($id_siswa, $dataidsiswa) and in_array($dataidkelas, $datakelas) and $mapelx['soalPaket'] == $paketSoalSiswa) {
            $dataUjian[] = array(
              'id_ujian' => $mapelx['id_ujian'],
              'kode_ujian' => $mapelx['kode_ujian'],
              'nama' => $mapelx['nama'],
              'slagNama' => $mapelx['slagNama'],
              'tgl_ujian' => $mapelx['tgl_ujian'],
              'tgl_selesai' => $mapelx['tgl_selesai'],
              'tombol' => $btntest,
              'paket' => $mapelx['soalPaket'],
            );
          }
          /*----jika data siswa khusu kosong, tampilkan ujian yang hanya kelas saja--*/
          /*----untuk ujian berdasarkan kelas--*/ elseif (empty($dataidsiswa) and in_array($dataidkelas, $datakelas) and $mapelx['soalPaket'] == $paketSoalSiswa) {
            $dataUjian[] = array(
              'id_ujian' => $mapelx['id_ujian'],
              'kode_ujian' => $mapelx['kode_ujian'],
              'nama' => $mapelx['nama'],
              'slagNama' => $mapelx['slagNama'],
              'tgl_ujian' => $mapelx['tgl_ujian'],
              'tgl_selesai' => $mapelx['tgl_selesai'],
              'tombol' => $btntest,
              'paket' => $mapelx['soalPaket'],
            );
          }
          /*----Jika id Siswa ada dan Status Kelas Khusu maka tampil Jadwal Khusu untuk siswa  (untuk siswa khusus)--*/ elseif (in_array($id_siswa, $dataidsiswa) and in_array('khusus', $datakelas) and $mapelx['soalPaket'] == $paketSoalSiswa) {
            $dataUjian[] = array(
              'id_ujian' => $mapelx['id_ujian'],
              'kode_ujian' => $mapelx['kode_ujian'],
              'nama' => $mapelx['nama'],
              'slagNama' => $mapelx['slagNama'],
              'tgl_ujian' => $mapelx['tgl_ujian'],
              'tgl_selesai' => $mapelx['tgl_selesai'],
              'tombol' => $btntest,
              'paket' => $mapelx['soalPaket'],
            );
          }
          /*----untuk ujian berdasarkan semua kelas--*/ elseif (in_array('semua', $datakelas) and $mapelx['soalPaket'] == $paketSoalSiswa) {
            $dataUjian[] = array(
              'id_ujian' => $mapelx['id_ujian'],
              'kode_ujian' => $mapelx['kode_ujian'],
              'nama' => $mapelx['nama'],
              'slagNama' => $mapelx['slagNama'],
              'tgl_ujian' => $mapelx['tgl_ujian'],
              'tgl_selesai' => $mapelx['tgl_selesai'],
              'tombol' => $btntest,
              'paket' => $mapelx['soalPaket'],
              'agama' => $mapelx['soalAgama'],

            );
          } else {
          }
          //end filter jadwal berdasarakn kondisi--------------------------------------------------
        } //end if agama

      } //end if cek time
      //$dataUjian2[] = $dataUjian;
    } //end foreach
    $dataUjian2 = $dataUjian;
    $arrayUjian = $dataUjian2;
    //$arrayUjian = array_filter($dataUjian2);
    return $arrayUjian;
  }
  //bagian ujian soal ----------------------------- 
  function getSoalUjianId($id_mapel, $id_soal)
  {
    $sql = "SELECT * FROM soal WHERE id_mapel=$id_mapel AND id_soal=$id_soal";
    $log = $this->getDataRedis('soal' . $this->KodeSekolah() . $id_mapel . $id_soal, $sql);
    return $log;
  }
  function getSoalUjian($id_mapel, $jenis)
  {
    $sql = "SELECT id_soal,nomor FROM soal WHERE id_mapel=$id_mapel AND jenis=$jenis";
    $log = $this->getDataRedis('soalall' . $this->KodeSekolah() . $id_mapel, $sql);
    return $log;
  }
  function getPegacakSoalId($idmapel, $idsiswa, $idujian)
  {
    $sql = "SELECT * FROM pengacak WHERE id_siswa=$idsiswa AND id_mapel=$idmapel";
    $log = $this->getDataRedis('pengacak' . $this->KodeSekolah() . $idujian . $idmapel . $idsiswa, $sql);
    return $log;
  }
  /**
   * 01-01-2023
   * fitur cek blokir siswa
   */
  function getCekBlokir($nilaiId, $idsiswa)
  {
    $sql = "SELECT blok FROM nilai WHERE id_nilai=$nilaiId";
    $log = $this->getDataRedis('blok' . $this->KodeSekolah() . $nilaiId . $idsiswa, $sql);
    return $log;
  }
  /**
   * hapus redis blok user
   */
  function delRedisBlok($nilaiId, $idsiswa)
  {
    $this->RedisDelKey('blok' . $this->KodeSekolah() . $nilaiId . $idsiswa);
    $sql = "SELECT blok FROM nilai WHERE id_nilai=$nilaiId";
    $this->getDataRedis('blok' . $this->KodeSekolah() . $nilaiId . $idsiswa, $sql);
  }
}
?>
<?php
include 'm_nilai.php';
?>