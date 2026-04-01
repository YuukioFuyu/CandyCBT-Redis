<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
/*-------------
$ac = aksi yang di perintah
aksi
  1.input -> inputsmk.php bagian edit soal atau input
  2.hapusbank
  3.lihat
  4.hapusfile
  5.importsoal
  6.dulikat 

  ------------*/
//setting up one redis-----------------------------------------


$pesan = '';
$value = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id'"));
$tgl_ujian = explode(' ', $value['tgl_ujian']);
if ($ac == '') :

  //myes tempat untuk edit bank soal tambah bank soal 

  //aksi untuk edi soal
  if (isset($_POST['editbanksoal'])) :
    $id = $_POST['idm'];
    $kode_bank = $_POST['kode_bank'];
    $KodeMapel = $_POST['nama'];
    // $nama = str_replace("'", "&#39;", $nama);
    if ($setting['jenjang'] == "SMK") {
      $idpk = $_POST['id_pk'];
    } else {
      if ($_POST['id_pk'] == 'khusus') {
        $idpk = "khusus";
      } else {
        $idpk = "semua";
      }
    }
    $jml_soal = $_POST['jml_soal'];
    $jml_esai = $_POST['jml_esai'];
    $bobot_pg = $_POST['bobot_pg'];
    $bobot_esai = $_POST['bobot_esai'];
    // $tampil_pg = $_POST['tampil_pg'];
    // $tampil_esai = $_POST['tampil_esai'];
    $tampil_pg = $_POST['jml_soal'];
    $tampil_esai = $_POST['jml_esai'];
    $level = $_POST['level'];
    $status = $_POST['status'];
    $opsi = $_POST['opsi'];
    $guru = $_POST['guru'];
    $jenisSoal = $_POST['jnSoal'];
    $soalagama = $_POST['soalagama'];
    $jenisagama = $_POST['jenisagama'];
    $paketsoal = $_POST['paketsoal'];

    $kelas = serialize($_POST['kelas']);
    //tampung siswa
    if ($_POST['siswa'] == null) {
      $siswa = null;
    } else {
      $siswa = serialize($_POST['siswa']);
    }

    if ($pengawas['level'] == 'admin') {
      $db->DelRedisAll();
      $data = array(
        'idpk' => $idpk,
        'nama' => $kode_bank,
        'level' => $level,
        'jml_soal' => $jml_soal,
        'jml_esai' => $jml_esai,
        'status' => $status,
        'idguru' => $guru,
        'bobot_pg' => $bobot_pg,
        'bobot_esai' => $bobot_esai,
        'tampil_pg' => $tampil_pg,
        'tampil_esai' => $tampil_esai,
        'kelas' => $kelas,
        'siswa' => $siswa,
        'opsi' => $opsi,
        'jenisSoalUjian' => $jenisSoal,
        'soalAgama' => $soalagama,
        'soalAgamaList' => $jenisagama,
        'soalPaket'    => $paketsoal,
      );
      $where = array(
        'id_mapel' => $id
      );
      $exec = $db->update('mapel', $data, $where);
      if ($exec == 1) {
        $info = info("Gagal menyimpan!", "NO");
      } else {
        jump("?pg=$pg");
      }
    } elseif ($pengawas['level'] == 'guru') {
      $db->DelRedisAll();
      $exec = mysqli_query($koneksi, "UPDATE mapel SET idpk='$idpk',nama='$kode_bank',level='$level',jml_soal='$jml_soal',jml_esai='$jml_esai',status='$status',bobot_pg='$bobot_pg',bobot_esai='$bobot_esai',tampil_pg='$tampil_pg',tampil_esai='$tampil_esai',kelas='$kelas',opsi='$opsi',siswa='$siswa',jenisSoalUjian=$jenisSoal,soalAgama='$soalagama',soalAgamaList='$jenisagama',soalPaket='$paketsoal' WHERE id_mapel='$id'");
      (!$exec) ? $info = info("Gagal menyimpan!", "NO") : jump("?pg=$pg");
    }
  endif;
  // aksi untuk tambah soal
  if (isset($_POST['tambahsoal'])) :
    $kode_bank = $_POST['kode_bank'];
    $KodeMapel = $_POST['nama'];
    // $nama = str_replace("'", "&#39;", $nama);
    if ($setting['jenjang'] == "SMK") {
      $id_pk = $_POST['id_pk'];
    } else {
      if ($_POST['id_pk'] == 'khusus') {
        $id_pk = "khusus";
      } else {
        $id_pk = "semua";
      }
    }
    $jml_esai = $_POST['jml_esai'];
    $jml_soal = $_POST['jml_soal'];
    $bobot_pg = $_POST['bobot_pg'];
    $bobot_esai = $_POST['bobot_esai'];
    // $tampil_pg = $_POST['tampil_pg'];
    // $tampil_esai = $_POST['tampil_esai'];
    $tampil_pg = $_POST['jml_soal'];
    $tampil_esai = $_POST['jml_esai'];
    $level = $_POST['level'];
    $status = $_POST['status'];
    $opsi = $_POST['opsi'];
    $jenisSoal = $_POST['jnSoal'];
    $soalagama = $_POST['soalagama'];
    $jenisagama = $_POST['jenisagama'];
    $paketsoal = $_POST['paketsoal'];

    $kelas = serialize($_POST['kelas']);
    if ($_POST['siswa'] == null) {
      $siswa = null;
    } else {
      $siswa = serialize($_POST['siswa']);
    }

    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mapel WHERE nama='$kode_bank' and level='$level' and kelas='$kelas'"));
    if ($pengawas['level'] == 'admin') {
      $guru = $_POST['guru'];
      if ($cek > 0) :
        $pesan = "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='icon fa fa-info'></i>Maaf Kode Mapel - Level - Kelas Soal Sudah ada !</div>";
      else :
        $db->DelRedisAll();

        $data = array(
          'idpk' => $id_pk,
          'nama' => $kode_bank,
          'KodeMapel' => $KodeMapel,
          'jml_soal' => $jml_soal,
          'jml_esai' => $jml_esai,
          'level' => $level,
          'status' => $status,
          'idguru' => $guru,
          'bobot_pg' => $bobot_pg,
          'bobot_esai' => $bobot_esai,
          'tampil_pg' => $tampil_pg,
          'tampil_esai' => $tampil_esai,
          'kelas' => $kelas,
          'opsi' => $opsi,
          'siswa' => $siswa,
          'jenisSoalUjian' => $jenisSoal,
          'soalAgama' => $soalagama,
          'soalAgamaList' => $jenisagama,
          'soalPaket'    => $paketsoal,
        );

        $exec = $db->insert('mapel', $data);

        if ($exec == 1) {
          $pesan = "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='icon fa fa-info'></i>Data Berhasil ditambahkan ..</div>";
        } else {
          $pesan = "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='icon fa fa-info'></i>Gagal Menyimpan Data ..</div>";
          //$pesan = $exec;
        }
      endif;
    } elseif ($pengawas['level'] == 'guru') {
      if ($cek > 0) :
        $pesan = "<div class='alert alert-warning alert-dismissible'>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
          <i class='icon fa fa-info'></i>
          Maaf Kode Mapel - Level - Kelas Sudah ada !
          </div>";
      else :
        $db->DelRedisAll();
        $data = array(
          'idpk' => $id_pk,
          'nama' => $kode_bank,
          'KodeMapel' => $KodeMapel,
          'jml_soal' => $jml_soal,
          'jml_esai' => $jml_esai,
          'level' => $level,
          'status' => $status,
          'idguru' => $id_pengawas,
          'bobot_pg' => $bobot_pg,
          'bobot_esai' => $bobot_esai,
          'tampil_pg' => $tampil_pg,
          'tampil_esai' => $tampil_esai,
          'kelas' => $kelas,
          'opsi' => $opsi,
          'siswa' => $siswa,
          'jenisSoalUjian' => $jenisSoal,
          'soalAgama' => $soalagama,
          'soalAgamaList' => $jenisagama,
          'soalPaket'    => $paketsoal,
        );

        $exec = $db->insert('mapel', $data);
        if ($exec == 1) {
          $pesan = "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='icon fa fa-info'></i>Data Berhasil ditambahkan ..</div>";
        } else {
          $pesan = "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='icon fa fa-info'></i>Gagal Menyimpan Data ..</div>";
        }
      endif;
    }
  endif;

?>
  <div class='row'>
    <div class='col-md-12'><?= $pesan ?>
      <div class='box box-solid '>
        <div class='box-header with-border '>
          <h3 class='box-title'><i class='fa fa-briefcase'></i> Data Bank Soal </h3>&nbsp;&nbsp;&nbsp;
          <!-- <a class='btn btn-sm btn-flat btn-primary' data-toggle='modal' data-backdrop='static' data-target='#infojadwal'><i class='glyphicon glyphicon-info-sign'></i> <span class='hidden-xs'>Info Bank Soal</span></a> -->
          <div class='box-tools pull-right '>
            <?php if ($setting['server'] == 'pusat') : ?>
              <button id='btnhapusbank' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> <span class='hidden-xs'>Hapus</span></button>
              <button class='btn btn-sm btn-success' data-toggle='modal' data-target='#tambahbanksoal'><i class='glyphicon glyphicon-plus'></i> <span class='hidden-xs'>Tambah Bank Soal</span></button>
            <?php endif ?>
          </div>
        </div><!-- /.box-header -->
        <div class='box-body'>
          <div class="row" style="padding-bottom: 20px;">
            <div class="col-md-3">
              <label>Ganti Status Bank Soal di Pilih</label><br>
              <select class="form-control select2" id="changestatus">
                <option>Pilih</option>
                <option value="1">AKTIF</option>
                <option value="0">TIDAK</option>
              </select>
            </div>
          </div>
          <span>Silahkan Nonaktifkan Bank Soal yang tidak terpakai atau tidak sesuai </span>
          <div class='row'>
            <div class='col-md-12'>
              <div class='box box-solid'>
                <ul class="nav nav-tabs">
                  <li class="jdwl1 "><a data-toggle="tab" href="#home"><b>Soal Aktif</b></a></li>
                  <li class="jdwl2 "><a data-toggle="tab" href="#menu1"><b>Soal Tidak Aktif</b></a></li>
                </ul>

                <div class="tab-content" style="padding-left: 20px;">
                  <div id="home" class="tab-pane fade in ">
                    <div class="row" style="padding-top: 10px;">
                      <div id='tablereset' class='table-responsive'>
                        <table id='tabel_soal' class='table table-bordered table-striped'>
                          <thead>
                            <tr>
                              <th width='5px'><input type='checkbox' id='ceksemua'></th>
                              <th width='5px'>#</th>
                              <th>Mata Pelajaran </th>
                              <th>Soal PG / BS / MC </th>
                              <th>Paket</th>
                              <th>Soal Esai / Singkat</th>
                              <th>Kelas</th>
                              <th>Guru</th>
                              <th>Status</th>
                              <?php if ($setting['server'] == 'pusat') : ?>
                                <th>Aksi</th>
                              <?php endif ?>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $mapelQ = $db->getBankSoal($pengawas['id_pengawas']);
                            foreach ($mapelQ as $mapels) {
                              if ($mapels->status == 0) {
                              } else {
                                $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$mapels->id_mapel'"));
                                $no++;
                            ?>
                                <tr>
                                  <td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-$no' value="<?= $mapels->id_mapel ?>"></td>
                                  <td><?= $no ?></td>
                                  <td>
                                    <?php
                                    if ($mapels->idpk == 'semua') :
                                      $jur = 'Semua';
                                    else :
                                      $jur = $mapels->idpk;
                                    endif;
                                    ?>
                                    <b><small class='label bg-purple'><?= $mapels->nama_mapel ?></small></b>
                                    <small class='label label-primary'><?= $mapels->mapel_level ?></small>
                                    <small class='label label-primary'><?= $jur ?></small>
                                    <b><small class='label bg-purple'><?= $mapels->nama_matapelajaran ?></small></b>
                                  </td>
                                  <td>
                                    <small class='label label-warning'><?= $mapels->tampil_pg ?>/<?= $mapels->jml_soal ?></small>
                                    <small class='label label-danger'><?= $mapels->bobot_pg ?> %</small>
                                    <small class='label label-danger'><?= $mapels->opsi ?> opsi</small>
                                  </td>
                                  <td><small class='label label-primary'>paket <?= $mapels->soalPaket ?></small></td>
                                  <td>
                                    <small class='label label-warning'><?= $mapels->tampil_esai ?>/<?= $mapels->jml_esai ?></small>
                                    <small class='label label-danger'><?= $mapels->bobot_esai ?> %</small>
                                  </td>
                                  <td>
                                    <?php
                                    $dataArray = unserialize($mapels->kelas);
                                    foreach ($dataArray as $key => $value) :
                                      echo "<small class='label label-success'>$value </small>&nbsp;";
                                    endforeach;
                                    ?>
                                  </td>
                                  <?php
                                  if ($cek <> 0) {
                                    if ($mapels->status == '0') :
                                      $status = '<label class="label label-danger">non aktif</label>';
                                    else :
                                      $status = '<label class="label label-success"> aktif </label>';
                                    endif;
                                  } else {
                                    $status = '<label class="label label-warning"> Soal Kosong </label>';
                                  }
                                  ?>
                                  <td>
                                    <small class='label label-primary'><?= $mapels->nama ?></small>
                                  </td>
                                  <td style="text-align:center">
                                    <?= $status ?>
                                  </td>
                                  <?php if ($setting['server'] == 'pusat') : ?>
                                    <td style="text-align:center">
                                      <div class=''>
                                        <a title="Lihat Soal" href='?pg=<?= $pg ?>&ac=lihat&id=<?= $mapels->id_mapel ?>'><button class='btn btn-flat btn-success btn-flat btn-xs'><i class='fa fa-search'></i></button></a>
                                        <a title="Upload Soal" href='?pg=<?= $pg ?>&ac=importsoal&id=<?= $mapels->id_mapel ?>'><button class='btn btn-info btn-flat btn-xs'><i class='fa fa-upload'></i></button></a>
                                        <!-- <button title="duplikat Soal" data-soal="<?= $mapels->id_mapel ?>" href="#" class='btn btn-danger btn-flat btn-xs duplikat'><i class='fa fa-copy '></i></button>
                                <button title="duplikat Bank Soal" data-soal1="<?= $mapels->id_mapel ?>" href="#" class='btn btn-success btn-flat btn-xs duplikat1'><i class='fa fa-file'></i></button> -->
                                        <a title="Edit Bank Soal"><button class='btn btn-warning btn-flat btn-xs' data-toggle='modal' data-target='#editbanksoal<?= $mapels->id_mapel ?>'><i class='fa fa-edit'></i></button></a>
                                      </div>
                                    </td>
                                  <?php endif ?>
                                  <!-- edit bang soal mryes -->
                                  <div class='modal fade' id='editbanksoal<?= $mapels->id_mapel ?>' style='display: none;'>
                                    <div class='modal-dialog'>
                                      <div class='modal-content'>
                                        <div class='modal-header bg-blue'>
                                          <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                                          <h3 class='modal-title'>Edit Bank Soal</h3>
                                        </div>
                                        <form action='' method='post'>
                                          <div class='modal-body'>
                                            <input type='hidden' id='idm' name='idm' value='<?= $mapels->id_mapel ?>' />
                                            <div class='form-group'>
                                              <label>Nama Mapel</label>
                                              <input disabled="disabled" value="<?= $mapels->nama_matapelajaran ?>" class='form-control'>
                                            </div>
                                            <div class='form-group'>
                                              <label>Kode Bank Soal | <i>Gunkan Huruf Kapital</i> | Buat Kode Seunik Mungkin dan jangan ada Spasi</label>
                                              <input value="<?= $mapels->nama_mapel ?>" placeholder="Misal: BINDO_XITK4 atau MTK_XAK2" type='text' id='kode_bank' name='kode_bank' class='form-control' required='true' />
                                            </div>


                                            <div class='form-group'>
                                              <div class='row'>
                                                <?php if ($setting['jenjang'] == 'SMK') : ?>
                                                  <div class='col-md-4'>
                                                    <label>Program Keahlian</label>
                                                    <select name='id_pk' class='form-control' required='true'>
                                                      <option value='semua'>Semua</option>
                                                      <?php
                                                      $pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
                                                      while ($pk = mysqli_fetch_array($pkQ)) : ($pk['id_pk'] == $mapels->idpk) ? $s = 'selected' : $s = '';
                                                        echo "<option value='$pk[id_pk]' $s>$pk[program_keahlian]</option>";
                                                      endwhile;
                                                      ?>
                                                    </select>
                                                  </div>
                                                <?php endif; ?>
                                                <div class='col-md-4'>
                                                  <label>Paket Soal</label>
                                                  <select name='paketsoal' class='form-control' required='true'>
                                                    <option <?php selectAktif($mapels->soalPaket, 'A') ?> value="A">PAKET A</option>
                                                    <option <?php selectAktif($mapels->soalPaket, 'B') ?> value="B">PAKET B</option>
                                                    <option <?php selectAktif($mapels->soalPaket, 'C') ?> value="C">PAKET C</option>
                                                    <option <?php selectAktif($mapels->soalPaket, 'D') ?> value="D">PAKET D</option>
                                                  </select>
                                                </div>
                                                <div class='col-md-4'>
                                                  <label>Jenis Soal</label>
                                                  <select name='jnSoal' class='form-control' required='true'>
                                                    <option <?php selectAktif($mapels->jenisSoalUjian, 1) ?> value="1">HANYA SOAL PG </option>
                                                    <option <?php selectAktif($mapels->jenisSoalUjian, 2) ?> value="2">HANYA SOAL ESAI</option>
                                                    <option <?php selectAktif($mapels->jenisSoalUjian, 3) ?> value="3">SOAL PG & ESAI </option>
                                                    <!-- <option <?php selectAktif($mapels->jenisSoalUjian, 0) ?> value="0">Opss Pilih Jenis Soal</option> -->
                                                  </select>
                                                </div>
                                              </div>
                                            </div>

                                            <div class='form-group'>
                                              <div class="row">
                                                <div class='col-md-6'>
                                                  <label>Kategori Soal</label>
                                                  <select name='soalagama' class='form-control' required='true'>
                                                    <option <?php selectAktif($mapels->soalAgama, 0) ?> value="0">Umum</option>
                                                    <option <?php selectAktif($mapels->soalAgama, 1) ?> value="1">Soal Agama</option>
                                                  </select>
                                                </div>
                                                <div class='col-md-6'>
                                                  <label>Pilih Agama</label>
                                                  <select name='jenisagama' class='form-control'>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "umum") ?> value="umum">Umum</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "islam") ?> value="islam">Islam</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "protestan") ?> value="protestan">Protestan</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "katolik") ?> value="katolik">Katolik</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "hindu") ?> value="hindu">Hindu</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "buddha") ?> value="buddha">Buddha</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "khonghucu") ?> value="khonghucu">Khonghucu</option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class='form-group'>
                                              <div class='row'>
                                                <div class='col-md-6'>
                                                  <label>Pilih Level</label>
                                                  <select name='level' class='form-control'>
                                                    <option value='semua'>Semua Level</option>
                                                    <?php
                                                    $lev = mysqli_query($koneksi, "SELECT * FROM level");
                                                    while ($level = mysqli_fetch_array($lev)) : ($level['kode_level'] == $mapels->level) ? $s = 'selected' : $s = '';
                                                      echo "<option value='$level[kode_level]' $s>$level[kode_level]</option>";
                                                    endwhile;
                                                    ?>
                                                  </select>
                                                </div>
                                                <div class='col-md-6'>
                                                  <label>Pilih Kelas</label><br>
                                                  <select name='kelas[]' class='form-control select2 ' style='width:100%' multiple required='true'>
                                                    <option value='semua'>Semua Kelas</option>
                                                    <option value='khusus'>Khusus</option>
                                                    <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
                                                    <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                                                      <?php if (in_array($kelas['id_kelas'], unserialize($mapels->kelas))) : ?>
                                                        <option value="<?= $kelas['id_kelas'] ?>" selected><?= $kelas['id_kelas'] ?></option>"
                                                      <?php else : ?>
                                                        <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
                                                      <?php endif; ?>
                                                    <?php endwhile ?>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class='form-group'>
                                              <div class='row'>
                                                <div class='col-md-12'>
                                                  <label>Pilih Siswa</label><br>
                                                  <select name='siswa[]' class='form-control select2 ' style='width:100%' multiple>
                                                    <option value='semua'>Semua Siswa</option>
                                                    <?php $lev = mysqli_query($koneksi, "SELECT * FROM siswa"); ?>
                                                    <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                                                      <?php if (in_array($kelas['id_siswa'], unserialize($mapels->siswa))) : ?>
                                                        <option value="<?= $kelas['id_siswa'] ?>" selected><?= $kelas['nama'] ?></option>"
                                                      <?php else : ?>
                                                        <option value="<?= $kelas['id_siswa'] ?>"><?= $kelas['nama'] ?></option>"
                                                      <?php endif; ?>
                                                    <?php endwhile ?>
                                                  </select>
                                                  <span style="color: red;">Jika Untuk Siswa Tertentu Pilih Program Keahli dan Level Pilih Semua, Kelas Pilih Khusus, Kemudia Silahkan Pilih Siswa, Bisa Ketik Langsung Namanya</span>
                                                </div>
                                              </div>
                                            </div>

                                            <div class='form-group'>
                                              <div class='row'>
                                                <div class='col-md-4'>
                                                  <label>Jumlah Soal PG</label>
                                                  <input type='number' name='jml_soal' class='form-control' value="<?= $mapels->jml_soal ?>" required='true' />
                                                </div>
                                                <div class='col-md-4'>
                                                  <label>Bobot Soal PG %</label>
                                                  <input type='number' name='bobot_pg' class='form-control' value="<?= $mapels->bobot_pg ?>" required='true' />
                                                </div>
                                                <div style="display: none;" class='col-md-4'>
                                                  <label>Soal Tampil</label>
                                                  <input type='number' name='tampil_pg' class='form-control' value="<?= $mapels->tampil_pg ?>" required='true' />
                                                </div>
                                                <div class='col-md-3'>
                                                  <label>Opsi</label>
                                                  <select name='opsi' class='form-control'>
                                                    <?php
                                                    $opsi = array("3", "4", "5");
                                                    for ($x = 0; $x < count($opsi); $x++) {
                                                      if ($mapels->opsi == $opsi[$x]) :
                                                        echo "<option value='$opsi[$x]' selected>$opsi[$x]</option>";
                                                      else :
                                                        echo "<option value='$opsi[$x]'>$opsi[$x]</option>";
                                                      endif;
                                                    }
                                                    ?>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class='form-group'>
                                              <div class='row'>
                                                <div class='col-md-6'>
                                                  <label>Jumlah Soal Essai</label>
                                                  <input type='number' name='jml_esai' class='form-control' value="<?= $mapels->jml_esai ?>" required='true' />
                                                </div>
                                                <div class='col-md-6'>
                                                  <label>Bobot Soal Essai %</label>
                                                  <input type='number' name='bobot_esai' class='form-control' value="<?= $mapels->bobot_esai ?>" required='true' />
                                                </div>
                                                <div style="display: none;" class='col-md-4'>
                                                  <label>Soal Tampil</label>
                                                  <input type='number' name='tampil_esai' class='form-control' value="<?= $mapels->tampil_esai ?>" required='true' />
                                                </div>
                                              </div>
                                            </div>
                                            <div class='form-group'>
                                              <div class='row'>
                                                <?php if ($pengawas['level'] == 'admin') : ?>
                                                  <div class='col-md-6'>
                                                    <label>Guru Pengampu</label>
                                                    <select name='guru' class='form-control' required='true'>
                                                      <?php
                                                      $guruku = mysqli_query($koneksi, "SELECT * FROM pengawas where level='guru' order by nama asc");
                                                      while ($guru = mysqli_fetch_array($guruku)) {
                                                        ($guru['id_pengawas'] == $mapels->idguru) ? $s = 'selected' : $s = '';
                                                        echo "<option value='$guru[id_pengawas]' $s>$guru[nama]</option>";
                                                      }
                                                      ?>
                                                    </select>
                                                  </div>
                                                <?php endif; ?>
                                                <div class='col-md-6'>
                                                  <label>Status Soal <?= $mapels->status ?></label>
                                                  <select name='status' class='form-control' required='true'>
                                                    <option <?php selected1($mapels->status) ?> value='1'>Aktif</option>
                                                    <option <?php selected0($mapels->status) ?> value='0'>Non Aktif</option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class='modal-footer'>
                                            <button type='submit' name='editbanksoal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </tr>
                            <?php
                              }
                            } //end foreach 
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div> <!-- /row -->
                  </div> <!-- /home -->

                  <!-- Jadwal Tidak Aktif -->
                  <div id="menu1" class="tab-pane fade ">
                    <div class="row" style="padding-top: 10px;">
                      <div id='tablereset2' class='table-responsive'>
                        <table id='tabel_soal2' class='table table-bordered table-striped'>
                          <thead>
                            <tr>
                              <th width='5px'><input type='checkbox' id='ceksemua2'></th>
                              <th width='5px'>#</th>
                              <th>Mata Pelajaran </th>
                              <th>Soal PG</th>
                              <th>Paket</th>
                              <th>Soal Esai</th>
                              <th>Kelas</th>
                              <th>Guru</th>
                              <th>Status</th>
                              <?php if ($setting['server'] == 'pusat') : ?>
                                <th>Aksi</th>
                              <?php endif ?>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            foreach ($mapelQ as $mapels) {
                              if ($mapels->status == 1) {
                              } else {
                                $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$mapels->id_mapel'"));
                                $no++;
                            ?>
                                <tr>
                                  <td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-$no' value="<?= $mapels->id_mapel ?>"></td>
                                  <td><?= $no ?></td>
                                  <td>
                                    <?php
                                    if ($mapels->idpk == 'semua') :
                                      $jur = 'Semua';
                                    else :
                                      $jur = $mapels->idpk;
                                    endif;
                                    ?>
                                    <b><small class='label bg-purple'><?= $mapels->nama_mapel ?></small></b>
                                    <small class='label label-primary'><?= $mapels->mapel_level ?></small>
                                    <small class='label label-primary'><?= $jur ?></small>
                                    <b><small class='label bg-purple'><?= $mapels->nama_matapelajaran ?></small></b>
                                  </td>
                                  <td>
                                    <small class='label label-warning'><?= $mapels->tampil_pg ?>/<?= $mapels->jml_soal ?></small>
                                    <small class='label label-danger'><?= $mapels->bobot_pg ?> %</small>
                                    <small class='label label-danger'><?= $mapels->opsi ?> opsi</small>
                                  </td>
                                  <td><small class='label label-primary'>paket <?= $mapels->soalPaket ?></small></td>
                                  <td>
                                    <small class='label label-warning'><?= $mapels->tampil_esai ?>/<?= $mapels->jml_esai ?></small>
                                    <small class='label label-danger'><?= $mapels->bobot_esai ?> %</small>
                                  </td>
                                  <td>
                                    <?php
                                    $dataArray = unserialize($mapels->kelas);
                                    foreach ($dataArray as $key => $value) :
                                      echo "<small class='label label-success'>$value </small>&nbsp;";
                                    endforeach;
                                    ?>
                                  </td>
                                  <?php
                                  if ($cek <> 0) {
                                    if ($mapels->status == '0') :
                                      $status = '<label class="label label-danger">non aktif</label>';
                                    else :
                                      $status = '<label class="label label-success"> aktif </label>';
                                    endif;
                                  } else {
                                    $status = '<label class="label label-warning"> Soal Kosong </label>';
                                  }
                                  ?>
                                  <td>
                                    <small class='label label-primary'><?= $mapels->nama ?></small>
                                  </td>
                                  <td style="text-align:center">
                                    <?= $status ?>
                                  </td>
                                  <?php if ($setting['server'] == 'pusat') : ?>
                                    <td style="text-align:center">
                                      <div class=''>
                                        <a title="Lihat Soal" href='?pg=<?= $pg ?>&ac=lihat&id=<?= $mapels->id_mapel ?>'><button class='btn btn-flat btn-success btn-flat btn-xs'><i class='fa fa-search'></i></button></a>
                                        <a title="Upload Soal" href='?pg=<?= $pg ?>&ac=importsoal&id=<?= $mapels->id_mapel ?>'><button class='btn btn-info btn-flat btn-xs'><i class='fa fa-upload'></i></button></a>
                                        <!-- <button title="duplikat Soal" data-soal="<?= $mapels->id_mapel ?>" href="#" class='btn btn-danger btn-flat btn-xs duplikat'><i class='fa fa-copy '></i></button>
                                <button title="duplikat Bank Soal" data-soal1="<?= $mapels->id_mapel ?>" href="#" class='btn btn-success btn-flat btn-xs duplikat1'><i class='fa fa-file'></i></button> -->
                                        <a title="Edit Bank Soal"><button class='btn btn-warning btn-flat btn-xs' data-toggle='modal' data-target='#editbanksoal<?= $mapels->id_mapel ?>'><i class='fa fa-edit'></i></button></a>
                                      </div>
                                    </td>
                                  <?php endif ?>
                                  <!-- edit bang soal mryes -->
                                  <div class='modal fade' id='editbanksoal<?= $mapels->id_mapel ?>' style='display: none;'>
                                    <div class='modal-dialog'>
                                      <div class='modal-content'>
                                        <div class='modal-header bg-blue'>
                                          <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                                          <h3 class='modal-title'>Edit Bank Soal</h3>
                                        </div>
                                        <form action='' method='post'>
                                          <div class='modal-body'>
                                            <input type='hidden' id='idm' name='idm' value='<?= $mapels->id_mapel ?>' />
                                            <div class='form-group'>
                                              <label>Nama Mapel</label>
                                              <input disabled="disabled" value="<?= $mapels->nama_matapelajaran ?>" class='form-control'>
                                            </div>
                                            <div class='form-group'>
                                              <label>Kode Bank Soal | <i>Gunkan Huruf Kapital</i> | Buat Kode Seunik Mungkin dan jangan ada Spasi</label>
                                              <input value="<?= $mapels->nama_mapel ?>" placeholder="Misal: BINDO_XITK4 atau MTK_XAK2" type='text' id='kode_bank' name='kode_bank' class='form-control' required='true' />
                                            </div>


                                            <div class='form-group'>
                                              <div class='row'>
                                                <?php if ($setting['jenjang'] == 'SMK') : ?>
                                                  <div class='col-md-4'>
                                                    <label>Program Keahlian</label>
                                                    <select name='id_pk' class='form-control' required='true'>
                                                      <option value='semua'>Semua</option>
                                                      <?php
                                                      $pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
                                                      while ($pk = mysqli_fetch_array($pkQ)) : ($pk['id_pk'] == $mapels->idpk) ? $s = 'selected' : $s = '';
                                                        echo "<option value='$pk[id_pk]' $s>$pk[program_keahlian]</option>";
                                                      endwhile;
                                                      ?>
                                                    </select>
                                                  </div>
                                                <?php endif; ?>
                                                <div class='col-md-4'>
                                                  <label>Paket Soal</label>
                                                  <select name='paketsoal' class='form-control' required='true'>
                                                    <option <?php selectAktif($mapels->soalPaket, 'A') ?> value="A">PAKET A</option>
                                                    <option <?php selectAktif($mapels->soalPaket, 'B') ?> value="B">PAKET B</option>
                                                    <option <?php selectAktif($mapels->soalPaket, 'C') ?> value="C">PAKET C</option>
                                                    <option <?php selectAktif($mapels->soalPaket, 'D') ?> value="D">PAKET D</option>
                                                  </select>
                                                </div>
                                                <div class='col-md-4'>
                                                  <label>Jenis Soal</label>
                                                  <select name='jnSoal' class='form-control' required='true'>
                                                    <option <?php selectAktif($mapels->jenisSoalUjian, 1) ?> value="1">HANYA SOAL PG </option>
                                                    <option <?php selectAktif($mapels->jenisSoalUjian, 2) ?> value="2">HANYA SOAL ESAI</option>
                                                    <option <?php selectAktif($mapels->jenisSoalUjian, 3) ?> value="3">SOAL PG & ESAI </option>
                                                    <!-- <option <?php selectAktif($mapels->jenisSoalUjian, 0) ?> value="0">Opss Pilih Jenis Soal</option> -->
                                                  </select>
                                                </div>
                                              </div>
                                            </div>

                                            <div class='form-group'>
                                              <div class="row">
                                                <div class='col-md-6'>
                                                  <label>Kategori Soal</label>
                                                  <select name='soalagama' class='form-control' required='true'>
                                                    <option <?php selectAktif($mapels->soalAgama, 0) ?> value="0">Umum</option>
                                                    <option <?php selectAktif($mapels->soalAgama, 1) ?> value="1">Soal Agama</option>
                                                  </select>
                                                </div>
                                                <div class='col-md-6'>
                                                  <label>Pilih Agama</label>
                                                  <select name='jenisagama' class='form-control'>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "umum") ?> value="umum">Umum</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "islam") ?> value="islam">Islam</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "protestan") ?> value="protestan">Protestan</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "katolik") ?> value="katolik">Katolik</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "hindu") ?> value="hindu">Hindu</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "buddha") ?> value="buddha">Buddha</option>
                                                    <option <?php selectAktif($mapels->soalAgamaList, "khonghucu") ?> value="khonghucu">Khonghucu</option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class='form-group'>
                                              <div class='row'>
                                                <div class='col-md-6'>
                                                  <label>Pilih Level</label>
                                                  <select name='level' class='form-control'>
                                                    <option value='semua'>Semua Level</option>
                                                    <?php
                                                    $lev = mysqli_query($koneksi, "SELECT * FROM level");
                                                    while ($level = mysqli_fetch_array($lev)) : ($level['kode_level'] == $mapels->level) ? $s = 'selected' : $s = '';
                                                      echo "<option value='$level[kode_level]' $s>$level[kode_level]</option>";
                                                    endwhile;
                                                    ?>
                                                  </select>
                                                </div>
                                                <div class='col-md-6'>
                                                  <label>Pilih Kelas</label><br>
                                                  <select name='kelas[]' class='form-control select2 ' style='width:100%' multiple required='true'>
                                                    <option value='semua'>Semua Kelas</option>
                                                    <option value='khusus'>Khusus</option>
                                                    <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
                                                    <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                                                      <?php if (in_array($kelas['id_kelas'], unserialize($mapels->kelas))) : ?>
                                                        <option value="<?= $kelas['id_kelas'] ?>" selected><?= $kelas['id_kelas'] ?></option>"
                                                      <?php else : ?>
                                                        <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
                                                      <?php endif; ?>
                                                    <?php endwhile ?>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class='form-group'>
                                              <div class='row'>
                                                <div class='col-md-12'>
                                                  <label>Pilih Siswa</label><br>
                                                  <select name='siswa[]' class='form-control select2 ' style='width:100%' multiple>
                                                    <option value='semua'>Semua Siswa</option>
                                                    <?php $lev = mysqli_query($koneksi, "SELECT * FROM siswa"); ?>
                                                    <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                                                      <?php if (in_array($kelas['id_siswa'], unserialize($mapels->siswa))) : ?>
                                                        <option value="<?= $kelas['id_siswa'] ?>" selected><?= $kelas['nama'] ?></option>"
                                                      <?php else : ?>
                                                        <option value="<?= $kelas['id_siswa'] ?>"><?= $kelas['nama'] ?></option>"
                                                      <?php endif; ?>
                                                    <?php endwhile ?>
                                                  </select>
                                                  <span style="color: red;">Jika Untuk Siswa Tertentu Pilih Program Keahli dan Level Pilih Semua, Kelas Pilih Khusus, Kemudia Silahkan Pilih Siswa, Bisa Ketik Langsung Namanya</span>
                                                </div>
                                              </div>
                                            </div>

                                            <div class='form-group'>
                                              <div class='row'>
                                                <div class='col-md-4'>
                                                  <label>Jumlah Soal PG</label>
                                                  <input type='number' name='jml_soal' class='form-control' value="<?= $mapels->jml_soal ?>" required='true' />
                                                </div>
                                                <div class='col-md-4'>
                                                  <label>Bobot Soal PG %</label>
                                                  <input type='number' name='bobot_pg' class='form-control' value="<?= $mapels->bobot_pg ?>" required='true' />
                                                </div>
                                                <div style="display: none;" class='col-md-4'>
                                                  <label>Soal Tampil</label>
                                                  <input type='number' name='tampil_pg' class='form-control' value="<?= $mapels->tampil_pg ?>" required='true' />
                                                </div>
                                                <div class='col-md-3'>
                                                  <label>Opsi</label>
                                                  <select name='opsi' class='form-control'>
                                                    <?php
                                                    $opsi = array("3", "4", "5");
                                                    for ($x = 0; $x < count($opsi); $x++) {
                                                      if ($mapels->opsi == $opsi[$x]) :
                                                        echo "<option value='$opsi[$x]' selected>$opsi[$x]</option>";
                                                      else :
                                                        echo "<option value='$opsi[$x]'>$opsi[$x]</option>";
                                                      endif;
                                                    }
                                                    ?>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            <div class='form-group'>
                                              <div class='row'>
                                                <div class='col-md-6'>
                                                  <label>Jumlah Soal Essai</label>
                                                  <input type='number' name='jml_esai' class='form-control' value="<?= $mapels->jml_esai ?>" required='true' />
                                                </div>
                                                <div class='col-md-6'>
                                                  <label>Bobot Soal Essai %</label>
                                                  <input type='number' name='bobot_esai' class='form-control' value="<?= $mapels->bobot_esai ?>" required='true' />
                                                </div>
                                                <div style="display: none;" class='col-md-4'>
                                                  <label>Soal Tampil</label>
                                                  <input type='number' name='tampil_esai' class='form-control' value="<?= $mapels->tampil_esai ?>" required='true' />
                                                </div>
                                              </div>
                                            </div>
                                            <div class='form-group'>
                                              <div class='row'>
                                                <?php if ($pengawas['level'] == 'admin') : ?>
                                                  <div class='col-md-6'>
                                                    <label>Guru Pengampu</label>
                                                    <select name='guru' class='form-control' required='true'>
                                                      <?php
                                                      $guruku = mysqli_query($koneksi, "SELECT * FROM pengawas where level='guru' order by nama asc");
                                                      while ($guru = mysqli_fetch_array($guruku)) {
                                                        ($guru['id_pengawas'] == $mapels->idguru) ? $s = 'selected' : $s = '';
                                                        echo "<option value='$guru[id_pengawas]' $s>$guru[nama]</option>";
                                                      }
                                                      ?>
                                                    </select>
                                                  </div>
                                                <?php endif; ?>
                                                <div class='col-md-6'>
                                                  <label>Status Soal <?= $mapels->status ?></label>
                                                  <select name='status' class='form-control' required='true'>
                                                    <option <?php selected1($mapels->status) ?> value='1'>Aktif</option>
                                                    <option <?php selected0($mapels->status) ?> value='0'>Non Aktif</option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class='modal-footer'>
                                            <button type='submit' name='editbanksoal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </tr>
                            <?php
                              }
                            } //end foreach 
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div> <!-- end row menu1 -->
                  </div>
                </div>
              </div> <!-- .box box-solid -->
            </div>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
    <div class='modal fade' id='infojadwal' style='display: none;'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header bg-maroon'>
            <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
            <h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Infromasi Jadwal</h4>
          </div>
          <!-- tambah jadwal mryes -->
          <div class='modal-body'>
            <p>
              Warna <span style="color: blue;">BIRU</span> untuk Jadwal Siswa Semua
              <br>Pilih Keahlian Semua, Level Semua, Kelas Semua, Siswa Kosong
              <hr>
              Warna <span style="color: red;">MERAH</span> untuk Jadwal Khusus Siswa Tertentu Tapi Semua (Global)
              <br>Pilih Keahlian Semua, Level Semua, Kelas Khusus, Siswa Pilih Siswa yang akan di tampilkan soal
              <hr>
              Warna <span style="color: blueviolet;">UNGU</span> untuk Jadwal Khusus Siswa Tertentu pada Kelas Tertentu
              <br>Pilih Keahlian Semua, Level Semua, Kelas Pilih Kelas yang di pilih, Siswa Pilih Siswa yang akan di tampilkan soal
              <hr>
              Warna <span style="color: green;">Hijau</span> untuk Jadwal Khusus Kelas Tertentu<br>
              Pilih Keahlian Semua, Level Semua, Kelas Pilih Kelas yang akan di tampilkan soal, Siswa Kosong
              <hr>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- maryes tambah bank soal -->
  <div class='modal fade' id='tambahbanksoal' style='display: none;'>
    <div class='modal-dialog'>
      <div class='modal-content'>
        <div class='modal-header bg-blue'>
          <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
          <h3 class='modal-title'>Tambah Bank Soal</h3>
        </div>
        <form action='' method='post'>
          <div class='modal-body'>
            <div class='form-group'>
              <div class='row'>
                <div class='col-md-6'>
                  <label>Kode Bank Soal | <i>Gunkan Huruf Kapital</i></label>
                  <input placeholder="Misal: BINDO_XITK4 atau MTK_XAK2" type='text' id='kode_bank' name='kode_bank' class='form-control' required='true' />
                  <label>Buat Kode Unik dan jangan ada Spasi</label>
                </div>
                <div class='col-md-6'>
                  <label>Jenis Soal</label>
                  <select name='jnSoal' class='form-control' required='true'>
                    <option value="1">HANYA SOAL PG </option>
                    <option value="2">HANYA SOAL ESAI</option>
                    <option value="3">SOAL PG & ESAI </option>
                    <option value="0">Opss Pilih Jenis Soal</option>
                  </select>
                </div>
              </div>
            </div>
            <div class='form-group'>
              <label>Mata Pelajaran</label>
              <select name='nama' class='form-control' required='true'>
                <option value=''></option>";
                <?php
                $pkQ = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran ORDER BY nama_mapel ASC");
                while ($pk = mysqli_fetch_array($pkQ)) {
                  echo "<option value='$pk[kode_mapel]'>$pk[nama_mapel]</option>";
                }
                ?>
              </select>
            </div>

            <div class='form-group'>
              <div class='row'>
                <?php if ($setting['jenjang'] == 'SMK') : ?>
                  <div class='col-md-3'>
                    <label>Program Keahlian</label>
                    <select name='id_pk' class='form-control' required='true'>
                      <option value='semua'>Semua</option>
                      <?php
                      $pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
                      while ($pk = mysqli_fetch_array($pkQ)) :
                        echo "<option value='$pk[id_pk]'>$pk[program_keahlian]</option>";
                      endwhile;
                      ?>
                    </select>
                  </div>
                <?php endif; ?>
                <div class='col-md-3'>
                  <label>Paket Soal</label>
                  <select name='paketsoal' class='form-control' required='true'>
                    <option value="A">PAKET A</option>
                    <option value="B">PAKET B</option>
                    <option value="C">PAKET C</option>
                    <option value="D">PAKET D</option>
                  </select>
                </div>
                <div class='col-md-3'>
                  <label>Paket Agama</label>
                  <select name='soalagama' class='form-control' required='true'>
                    <option value="0">Umum</option>
                    <option value="1">Soal Agama</option>
                  </select>
                </div>
                <div class='col-md-3'>
                  <label>Pilih Agama</label>
                  <select name='jenisagama' class='form-control'>
                    <option value="umum">Umum</option>
                    <option value="islam">Islam</option>
                    <option value="protestan">Protestan</option>
                    <option value="katolik">Katolik</option>
                    <option value="hindu">Hindu</option>
                    <option value="buddha">Buddha</option>
                    <option value="khonghucu">Khonghucu</option>
                  </select>
                </div>


              </div>
            </div>



            <div class='form-group'>
              <div class='row'>
                <div class='col-md-6'>
                  <label>Level Soal</label>
                  <select name='level' id='soallevel' class='form-control' required='true'>
                    <option value=''></option>
                    <option value='semua'>Semua</option>
                    <?php
                    $lev = mysqli_query($koneksi, "SELECT * FROM level");
                    while ($level = mysqli_fetch_array($lev)) {
                      echo "<option value='$level[kode_level]'>$level[kode_level]</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class='col-md-6'>
                  <label>Pilih Kelas</label><br>
                  <select name='kelas[]' id='soalkelas' class='form-control select2' multiple='multiple' style='width:100%' required='true'>
                  </select>
                </div>
              </div>
            </div>
            <div class='form-group'>
              <div class='row'>
                <div class='col-md-12'>
                  <label>Pilih Siswa</label><br>
                  <select name='siswa[]' class='form-control select2 ' style='width:100%' multiple>
                    <option value='semua'>Semua Siswa</option>
                    <?php $lev = mysqli_query($koneksi, "SELECT * FROM siswa"); ?>
                    <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                      <?php if (in_array($kelas['id_siswa'], unserialize($mapel['kelas']))) : ?>
                        <option value="<?= $kelas['id_siswa'] ?>" selected><?= $kelas['nama'] ?></option>"
                      <?php else : ?>
                        <option value="<?= $kelas['id_siswa'] ?>"><?= $kelas['nama'] ?></option>"
                      <?php endif; ?>
                    <?php endwhile ?>
                  </select>
                  <span style="color: red;">Jika Untuk Siswa Tertentu Pilih Program Keahli dan Level Pilih Semua, Kelas Pilih Khusus, Kemudia Silahkan Pilih Siswa, Bisa Ketik Langsung Namanya</span>
                </div>
              </div>
            </div>

            <div class='form-group'>
              <div class='row'>
                <div class='col-md-4'>
                  <label>Jumlah Soal PG</label>
                  <input type='number' id='soalpg' name='jml_soal' class='form-control' required='true' />
                </div>
                <div class='col-md-4'>
                  <label>Bobot Soal PG %</label>
                  <input type='number' name='bobot_pg' class='form-control' required='true' />
                </div>
                <div style="display: none;" class='col-md-4'>
                  <label>Soal Tampil</label>
                  <input type='number' id='tampilpg' name='tampil_pg' class='form-control' required='true' />
                </div>
                <div class='col-md-4'>
                  <label>Opsi</label>
                  <select name='opsi' class='form-control'>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>
                  </select>
                </div>
              </div>
            </div>
            <div class='form-group'>
              <div class='row'>
                <div class='col-md-6'>
                  <label>Jumlah Soal Essai</label>
                  <input type='number' id='soalesai' name='jml_esai' class='form-control' required='true' />
                </div>
                <div class='col-md-6'>
                  <label>Bobot Soal Essai %</label>
                  <input type='number' name='bobot_esai' class='form-control' required='true' />
                </div>
                <div style="display: none;" class='col-md-4'>
                  <label>Soal Tampil</label>
                  <input type='number' id='tampilesai' name='tampil_esai' class='form-control' required='true' />
                </div>
              </div>
            </div>
            <div class='form-group'>
              <div class='row'>
                <?php if ($pengawas['level'] == 'admin') : ?>
                  <div class='col-md-6'>
                    <label>Guru Pengampu</label>
                    <select name='guru' class='form-control' required='true'>
                      <?php
                      $guruku = mysqli_query($koneksi, "SELECT * FROM pengawas where level='guru' order by nama asc");
                      while ($guru = mysqli_fetch_array($guruku)) {
                        echo "<option value='$guru[id_pengawas]'>$guru[nama]</option>";
                      }
                      ?>
                    </select>
                  </div>
                <?php endif; ?>
                <div class='col-md-6'>
                  <label>Status Soal</label>
                  <select name='status' class='form-control' required='true'>
                    <option value='1'>Aktif</option>
                    <option value='0'>Non Aktif</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class='modal-footer'>
            <button type='submit' name='tambahsoal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php elseif ($ac == 'input') : 
  #jika jenis soal 3 (benar salah)
  $jenis = $_GET['jenis'];
  if ($jenis == 2 or $jenis == 1) {
    include 'inputsmk.php';
  } elseif ($jenis == 3 or $jenis == 4) {
    #mryes 02-01-2023
    #tambah soal benar salah -->
    include 'input_lampungTimur.php';
  } else {
    include 'inputsmk.php';
  }
  ?>
  <script>
    function addParam(currentUrl, key, val) {
      var url = new URL(currentUrl);
      url.searchParams.set(key, val);
      return url.href;
    }

    $("#jenissoal").change(function() {
      var id = $(this).val();
      var currentUrl = window.location.href;
      var key = "jenis";
      var val = id;
      var newUrl = addParam(currentUrl, key, val);
      window.location.href = newUrl;
      //console.log(url);
    });
  </script>

<?php elseif ($ac == 'hapusbank') : ?>
  <?php
  $exec = mysqli_query($koneksi, "DELETE FROM soal WHERE id_mapel='$_GET[id]'");
  $db->DelRedisAll();
  $gambar = mysqli_query($koneksi, "select * file_pendukung where id_mapel='$_GET[id]'");
  while ($file = mysqli_fetch_array($gambar)) {
    $path = $homeurl . "/files/" . $file['nama_file'];
    unlink($path);
  }
  $exec = mysqli_query($koneksi, "DELETE FROM file_pendukung WHERE id_mapel='$_GET[id]'");
  jump(" ?pg=$pg&ac=lihat&id=$_GET[id]");
  ?>
<?php elseif ($ac == 'lihat') : ?>
  <?php
  $id_mapel = $_GET['id'];
  if (isset($_REQUEST['tambah'])) {
    $sip = $_SERVER['SERVER_NAME'];
    $smax = mysqli_query($koneksi, "SELECT max(qid) AS maxi FROM savsoft_qbank");
    while ($hmax = mysqli_fetch_array($smax)) :
      $jumsoal = $hmax['maxi'];
    endwhile;
    $smaop = mysqli_query($koneksi, "SELECT max(oid) AS maxop FROM savsoft_options");
    while ($hmaop = mysqli_fetch_array($smaop)) {
      $jumop = $hmaop['maxop'];
    }

    $b_op = ($jumop != 0) ? ($jumop / $jumsoal) : 0;
    $no = 1;
    $noesai = 1;
    $sqlcek = mysqli_query($koneksi, "SELECT * FROM savsoft_qbank");
    while ($r = mysqli_fetch_array($sqlcek)) {
      $s_soal = mysqli_fetch_array(mysqli_query($koneksi, "select * from savsoft_qbank where qid='$no'"));
      $soal_tanya = $s_soal['question'];
      $l_soal = $s_soal['lid'];
      $c_id = $s_soal['cid'];
      $g_soal = $s_soal['description'];
      $g_soal = str_replace(" ", "", $g_soal);
      $smin = mysqli_query($koneksi, " select min(oid) as mini from savsoft_options where qid='$no'");
      while ($hmin = mysqli_fetch_array($smin)) {
        $min_op = $hmin['mini'];
      }
      $sqlopc = mysqli_query($koneksi, " select * from savsoft_options where qid='$no' and oid='$min_op'");
      $ropc = mysqli_fetch_array($sqlopc);
      $opj1 = $ropc['q_option'];
      $opj1 = str_replace(" &ndash;", "-", $opj1);
      $opj1 = str_replace(" &amp;lt;br&amp;gt;", "<br>", $opj1);
      $opj1 = str_replace("&amp;lt;br&amp;gt;", "<br>", $opj1);
      $opjs1 = $ropc['score'];
      $fileA = $ropc['q_option_match'];
      $fileA = str_replace(" ", "", $fileA);

      $dele = mysqli_query($koneksi, "DELETE FROM savsoft_options WHERE qid='$no' AND oid='$min_op'");

      $smin = mysqli_query($koneksi, " select min(oid) as mini from savsoft_options where qid='$no'");
      while ($hmin = mysqli_fetch_array($smin)) {
        $min_op = $hmin['mini'];
      }

      $sqlopc = mysqli_query($koneksi, " select * from savsoft_options where qid='$no' and oid='$min_op'");
      $rubah = mysqli_query($koneksi, " select * from savsoft_options where qid='$no'");
      $ck_jum = mysqli_num_rows($rubah);

      $ropc = mysqli_fetch_array($sqlopc);
      $opj2 = $ropc['q_option'];
      $opj2 = str_replace(" &ndash;", "-", $opj2);
      $opj2 = str_replace(" &amp;lt;br&amp;gt;", "<br>", $opj2);
      $opj2 = str_replace("&amp;lt;br&amp;gt;", "<br>", $opj2);
      $opjs2 = $ropc['score'];
      $fileB = $ropc['q_option_match'];
      $fileB = str_replace(" ", "", $fileB);
      $dele = mysqli_query($koneksi, " delete from savsoft_options where qid='$no' and oid='$min_op'");
      $smin = mysqli_query($koneksi, " select min(oid) as mini from savsoft_options where qid='$no'");
      while ($hmin = mysqli_fetch_array($smin)) {
        $min_op = $hmin['mini'];
      }
      $sqlopc = mysqli_query($koneksi, " select * from savsoft_options where qid='$no' and oid='$min_op'");
      $ropc = mysqli_fetch_array($sqlopc);
      $opj3 = $ropc['q_option'];
      $opj3 = str_replace(" &ndash;", "-", $opj3);
      $opj3 = str_replace(" &amp;lt;br&amp;gt;", "<br>", $opj3);
      $opj3 = str_replace("&amp;lt;br&amp;gt;", "<br>", $opj3);
      $opjs3 = $ropc['score'];
      $fileC = $ropc['q_option_match'];
      $fileC = str_replace(" ", "", $fileC);
      $dele = mysqli_query($koneksi, " delete from savsoft_options where qid='$no' and oid='$min_op'");
      $smin = mysqli_query($koneksi, " select min(oid) as mini from savsoft_options where qid='$no'");
      while ($hmin = mysqli_fetch_array($smin)) {
        $min_op = $hmin['mini'];
      }

      $sqlopc = mysqli_query($koneksi, " select * from savsoft_options where qid='$no' and oid='$min_op'");
      $ropc = mysqli_fetch_array($sqlopc);
      $opj4 = $ropc['q_option'];
      $opj4 = str_replace(" &ndash;", "-", $opj4);
      $opj4 = str_replace(" &amp;lt;br&amp;gt;", "<br>", $opj4);
      $opj4 = str_replace("&amp;lt;br&amp;gt;", "<br>", $opj4);
      $opjs4 = $ropc['score'];
      $fileD = $ropc['q_option_match'];
      $fileD = str_replace(" ", "", $fileD);
      $dele = mysqli_query($koneksi, " delete from savsoft_options where qid='$no' and oid='$min_op'");
      $smin = mysqli_query($koneksi, " select min(oid) as mini from savsoft_options where qid='$no'");
      while ($hmin = mysqli_fetch_array($smin)) {
        $min_op = $hmin['mini'];
      }

      $sqlopc = mysqli_query($koneksi, " select * from savsoft_options where qid='$no' and oid='$min_op'");
      $ropc = mysqli_fetch_array($sqlopc);
      $opj5 = $ropc['q_option'];
      $opj5 = str_replace(" &ndash;", "-", $opj5);
      $opj5 = str_replace(" &amp;lt;br&amp;gt;", "<br>", $opj5);
      $opj4 = str_replace("&amp;lt;br&amp;gt;", "<br>", $opj4);
      $opjs5 = $ropc['score'];
      $fileE = $ropc['q_option_match'];
      $fileE = str_replace(" ", "", $fileE);
      $dele = mysqli_query($koneksi, " delete from savsoft_options where qid='$no' and oid='$min_op'");
      if ($opjs1 == 1) {
        $kunci = "A";
      }
      if ($opjs2 == 1) {
        $kunci = "B";
      }
      if ($opjs3 == 1) {
        $kunci = "C";
      }
      if ($opjs4 == 1) {
        $kunci = "D";
      }
      if ($opjs5 == 1) {
        $kunci = "E";
      }
      if ($ck_jum !== 0) {
        $jns = "1";
      }
      if ($ck_jum == 0) {
        $jns = "2";
      }
      // $jwb522 = str_replace("&amp;lt;", "<", $jwb521);
      // $jwb422 = str_replace("&amp;lt;", "<", $jwb421);
      // $jwb322 = str_replace("&amp;lt;", "<", $jwb321);
      // $jwb222 = str_replace("&amp;lt;", "<", $jwb221);
      // $jwb122 = str_replace("&amp;lt;", "<", $jwb121);
      $soal_tanya = str_replace("&amp;lt;", "<", $soal_tanya);
      // $jwb52 = str_replace("&amp;gt;", ">", $jwb522);
      // $jwb42 = str_replace("&amp;gt;", ">", $jwb422);
      // $jwb32 = str_replace("&amp;gt;", ">", $jwb322);
      // $jwb22 = str_replace("&amp;gt;", ">", $jwb222);
      // $jwb12 = str_replace("&amp;gt;", ">", $jwb122);
      $soal_tanya = str_replace("&amp;gt;", ">", $soal_tanya);
      $soal_tanya = str_replace(" &amp;lt;br&amp;gt;", "<br>", $soal_tanya);
      $soal_tanya = str_replace("&amp;lt;br&amp;gt;", "<br>", $soal_tanya);
      //meryes ---- 4/4/21 ------
      if ($jns == 1) {
        $exec = mysqli_query($koneksi, "INSERT INTO soal (id_mapel,nomor,soal,pilA,pilB,pilC,pilD,pilE,jawaban,jenis,file1,fileA,fileB,fileC,fileD,fileE)
                    VALUES ('$id_mapel','$no','$soal_tanya','$opj1','$opj2','$opj3','$opj4','$opj5','$kunci','$jns','$g_soal','$fileA','$fileB','$fileC','$fileD','$fileE')");
      } else {
        $noesai1 = $noesai++;
        $exec = mysqli_query($koneksi, "INSERT INTO soal (id_mapel,nomor,soal,pilA,pilB,pilC,pilD,pilE,jawaban,jenis,file1,fileA,fileB,fileC,fileD,fileE) VALUES ('$id_mapel','$noesai1','$soal_tanya','$opj1','$opj2','$opj3','$opj4','$opj5','$kunci','$jns','$g_soal','$fileA','$fileB','$fileC','$fileD','$fileE')");
      }

      if ($g_soal <> "") {
        $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$g_soal','$id_mapel')");
      }
      if ($fileA <> "") {
        $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$fileA','$id_mapel')");
      }
      if ($fileB <> "") {
        $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$fileB','$id_mapel')");
      }
      if ($fileC <> "") {
        $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$fileC','$id_mapel')");
      }
      if ($fileD <> "") {
        $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$fileD','$id_mapel')");
      }
      if ($fileE <> "") {
        $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$fileE','$id_mapel')");
      }
      $no++;
    }
    $hasil2 = mysqli_query($koneksi, "TRUNCATE TABLE savsoft_qbank");
    $hasil2 = mysqli_query($koneksi, "TRUNCATE TABLE savsoft_options");
  }
  $namamapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id_mapel'"));
  if ($namamapel['jml_esai'] == 0) {
    $hide = 'hidden';
  } else {
    $hide = '';
  }
  ?>
  <div class='row'>
    <div class='col-md-12'>
      <div class='box box-solid'>
        <div class='box-header with-border '>
          <h3 class='box-title'>Daftar Soal <?= $namamapel['nama'] ?></h3>&nbsp;
          <a href="?pg=banksoal" class='btn btn-sm  btn-danger'><i class='fas fa-arrow-left'></i> Kembali</a>
          <div class='box-tools pull-right '>
            <a href='?pg=<?= $pg ?>&ac=input&id=<?= $id_mapel ?>&no=1&jenis=1' class='btn btn-sm btn-flat btn-success'><i class='fa fa-plus'></i><span class='hidden-xs'> Tambah</span></a>
            <a href='?pg=<?= $pg ?>&ac=input&id=<?= $id_mapel ?>&no=1&jenis=2' class='btn btn-sm btn-flat btn-warning <?= $hide ?>'><i class='fa fa-plus'></i><span class='hidden-xs'> Tambah</span> Essai</a>
            <a class='btn btn-sm btn-flat btn-info' href='soal_excel.php?m=<?= $id_mapel ?>'><i class='fa fa-file-excel-o'></i><span class='hidden-xs'> Excel</span></a>
			<button class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult'].print()"><i class='fa fa-print'></i><span class='hidden-xs'> Print Soal</span></button>
            <button class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult1'].print()"><i class='fa fa-print'></i><span class='hidden-xs'> Print Soal & Jawab</span></button>
            <a onclick="return confirm('Apakah Anda Yakin Akan menghapus Semua Soal ?')" href='?pg=<?= $pg ?>&ac=hapusbank&id=<?= $id_mapel ?>' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i><span class='hidden-xs'> Kosongkan </span></a>
            <iframe name='frameresult' src='cetaksoal.php?id=<?= $id_mapel ?>' style='border:none;width:1px;height:1px;'></iframe>
			<iframe name='frameresult1' src='cetaksoal._kunci.php?id=<?= $id_mapel ?>' style='border:none;width:1px;height:1px;'></iframe>
          </div>
        </div><!-- /.box-header -->
        <div class='box-body'>
          <div class='table-responsive'>
            <b>A. Soal Pilihan Ganda</b>
            <table class='table table-bordered table-striped'>
              <tbody>
                <?php $soalq = mysqli_query($koneksi, "SELECT * FROM soal where id_mapel='$id_mapel' and jenis='1' or jenis='3' or jenis='4' order by nomor "); ?>
                <?php while ($soal = mysqli_fetch_array($soalq)) : ?>
                  <tr>
                    <td style='width:30px'>
                      <?= $soal['nomor'] ?>
                    </td>
                    <td style="text-align:justify">
                      <?php
                      if ($soal['file'] <> '') :
                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                        $ext = explode(".", $soal['file']);
                        $ext = end($ext);
                        if (in_array($ext, $image)) {
                          echo "<p style='margin-bottom: 5px'><img src='$homeurl/files/$soal[file]' style='max-width:200px;'/></p>";
                        } elseif (in_array($ext, $audio)) {
                          echo "<p style='margin-bottom: 5px'><audio controls><source src='$homeurl/files/$soal[file]' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
                        } else {
                          echo "File tidak didukung!";
                        }
                      endif;
                      ?>
                      <?= $soal['soal']; ?>
                      <?php
                      if ($soal['file1'] <> '') :
                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                        $ext = explode(".", $soal['file1']);
                        $ext = end($ext);
                        if (in_array($ext, $image)) {
                          echo "<p style='margin-top: 5px'><img src='$homeurl/files/$soal[file1]' style='max-width:200px;' /></p>";
                        } elseif (in_array($ext, $audio)) {
                          echo "<p style='margin-top: 5px'><audio controls><source src='$homeurl/files/$soal[file1]' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
                        } else {
                          echo "File tidak didukung!";
                        }
                      endif;
                      ?>
                      <!-- opsi soal -->
                      <?php if ($soal['jenis'] == 3) : ?>
                        <table width="100%" >
                          <tr>
                          <td style="padding: 3px;width: 2%; vertical-align: text-top;">A.</td>
                          <td style="padding: 3px;width: 98%; vertical-align: text-top;">
                            <?php
                            if ($soal['pilA'] <> '') {
                              echo "$soal[pilA] ";
                            }
                            if ($soal['fileA'] <> '') {
                              $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                              $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                              $ext = explode(".", $soal['fileA']);
                              $ext = end($ext);
                              if (in_array($ext, $image)) {
                                echo "<img src='$homeurl/files/$soal[fileA]' style='max-width:100px;'/>";
                              } elseif (in_array($ext, $audio)) {
                                echo "<audio controls><source src='$homeurl/files/$soal[fileA]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                              } else {
                                echo "File tidak didukung!";
                              }
                            }
                            ?>
                          </td>
                          </tr>
                          <tr>
                          <td style="padding: 3px;width: 2%; vertical-align: text-top;">B.</td>
                          <td style="padding: 3px;width: 98%; vertical-align: text-top;">
                            <?php
                            if (!$soal['pilB'] == "") {
                              echo "$soal[pilB] ";
                            }
                            // if ($soal['jawaban'] == 'B') {
                            //  echo "<i class='fa fa-check fa-2x text-green'></i>";
                            // }
                            if ($soal['fileB'] <> '') {
                              $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                              $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                              $ext = explode(".", $soal['fileB']);
                              $ext = end($ext);
                              if (in_array($ext, $image)) {
                                echo "<img src='$homeurl/files/$soal[fileB]' style='max-width:100px;' />";
                              } elseif (in_array($ext, $audio)) {
                                echo "<audio controls><source src='$homeurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                              } else {
                                echo "File tidak didukung!";
                              }
                            }
                            ?>
                          </td>
                          </tr>
                        </table>
                      <?php endif; ?>
                      <?php if ($soal['jenis'] == 1 or $soal['jenis'] == 4) : ?>
                      <table width=100%>
                        <tr>
                          <td style="padding: 3px;width: 2%; vertical-align: text-top;">A.</td>
                          <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                            <?php
                            if ($soal['pilA'] <> '') {
                              echo "$soal[pilA] ";
                            }
                            // if ($soal['jawaban'] == 'A') {
                            //  echo "<i class='fa fa-check fa-2x text-green'></i>";
                            // }
                            if ($soal['fileA'] <> '') {
                              $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                              $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                              $ext = explode(".", $soal['fileA']);
                              $ext = end($ext);
                              if (in_array($ext, $image)) {
                                echo "<img src='$homeurl/files/$soal[fileA]' style='max-width:100px;'/>";
                              } elseif (in_array($ext, $audio)) {
                                echo "<audio controls><source src='$homeurl/files/$soal[fileA]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                              } else {
                                echo "File tidak didukung!";
                              }
                            }
                            ?>
                          </td>
                          <td style="padding: 3px;width: 2%; vertical-align: text-top;">C.</td>
                          <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                            <?php
                            if (!$soal['pilC'] == "") {
                              echo "$soal[pilC] ";
                            }
                            // if ($soal['jawaban'] == 'C') {
                            //  echo "<i class='fa fa-check fa-2x text-green'></i>";
                            // }
                            if ($soal['fileC'] <> '') {
                              $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                              $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                              $ext = explode(".", $soal['fileC']);
                              $ext = end($ext);
                              if (in_array($ext, $image)) {
                                echo "<img src='$homeurl/files/$soal[fileC]' style='max-width:100px;' />";
                              } elseif (in_array($ext, $audio)) {
                                echo "<audio controls><source src='$homeurl/files/$soal[fileC]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                              } else {
                                echo "File tidak didukung!";
                              }
                            }
                            ?>
                          </td>
                          <?php if ($namamapel['opsi'] == 5) : ?>
                            <td style="padding: 3px;width: 2%; vertical-align: text-top;">E.</td>
                            <td style="padding: 3px; vertical-align: text-top;">
                              <?php
                              if (!$soal['pilE'] == "") {
                                echo "$soal[pilE] ";
                              }
                              // if ($soal['jawaban'] == 'E') {
                              //  echo "<i class='fa fa-check fa-2x text-green'></i>";
                              // }
                              if ($soal['fileE'] <> '') {
                                $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                $ext = explode(".", $soal['fileE']);
                                $ext = end($ext);
                                if (in_array($ext, $image)) {
                                  echo "<img src='$homeurl/files/$soal[fileE]' style='max-width:100px;' />";
                                } elseif (in_array($ext, $audio)) {
                                  echo "<audio controls><source src='$homeurl/files/$soal[fileE]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                } else {
                                  echo "File tidak didukung!";
                                }
                              }
                              ?>
                            </td>
                          <?php endif; ?>
                        </tr>
                        <tr>
                          <td style="padding: 3px;width: 2%; vertical-align: text-top;">B.</td>
                          <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                            <?php
                            if (!$soal['pilB'] == "") {
                              echo "$soal[pilB] ";
                            }
                            // if ($soal['jawaban'] == 'B') {
                            //  echo "<i class='fa fa-check fa-2x text-green'></i>";
                            // }
                            if ($soal['fileB'] <> '') {
                              $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                              $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                              $ext = explode(".", $soal['fileB']);
                              $ext = end($ext);
                              if (in_array($ext, $image)) {
                                echo "<img src='$homeurl/files/$soal[fileB]' style='max-width:100px;' />";
                              } elseif (in_array($ext, $audio)) {
                                echo "<audio controls><source src='$homeurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                              } else {
                                echo "File tidak didukung!";
                              }
                            }
                            ?>
                          </td>
                          <?php if ($namamapel['opsi'] <> 3) : ?>
                            <td style="padding: 3px;width: 2%; vertical-align: text-top;">D.</td>
                            <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                              <?php
                              if (!$soal['pilD'] == "") {
                                echo "$soal[pilD] ";
                              }
                              // if ($soal['jawaban'] == 'D') {
                              //  echo "<i class='fa fa-check fa-2x text-green'></i>";
                              // }
                              if ($soal['fileD'] <> '') {
                                $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                $ext = explode(".", $soal['fileD']);
                                $ext = end($ext);
                                if (in_array($ext, $image)) {
                                  echo "<img src='$homeurl/files/$soal[fileD]' style='max-width:100px;' />";
                                } elseif (in_array($ext, $audio)) {
                                  echo "<audio controls><source src='$homeurl/files/$soal[fileD]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                } else {
                                  echo "File tidak didukung!";
                                }
                              }
                              ?>
                            </td>
                          <?php endif; ?>
                        </tr>

                      </table>
                      <?php endif; ?>

                      <!-- kunci jawaban -->
                      <table>
                        <tr>
                          <td>
                            <?php
                            
                              if ($soal['jawaban'] == 'A') {
                                echo "Kunci Jawaban : <b>A</b> <i class='fa fa-check fa-2x text-green'></i>";
                              } elseif ($soal['jawaban'] == 'B') {
                                echo "Kunci Jawaban : <b>B</b> <i class='fa fa-check fa-2x text-green'></i>";
                              } elseif ($soal['jawaban'] == 'C') {
                                echo "Kunci Jawaban : <b>C</b> <i class='fa fa-check fa-2x text-green'></i>";
                              } elseif ($soal['jawaban'] == 'D') {
                                echo "Kunci Jawaban : <b>D</b> <i class='fa fa-check fa-2x text-green'></i>";
                              } elseif ($soal['jawaban'] == 'E') {
                                echo "Kunci Jawaban : <b>E</b> <i class='fa fa-check fa-2x text-green'></i>";
                              } else {
                                if($soal['jenis'] ==4){
                                  echo "Kunci Jawaban : <b>".$soal['jawaban']."</b> <i class='fa fa-check fa-2x text-green'></i>";
                                }
                                else{
                                  echo "<b>Kunci Jawaban Tidak Ada</b>";
                                }
                                
                              }
                           
                            
                            ?>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td style='width:30px'>
                      <a><button class='btn bg-maroon btn-sm' data-toggle='modal' data-target="#hapus<?= $soal['id_soal'] ?>"><i class='fa fa-trash'></i></button></a>
                    </td>
                  </tr>
                  <?php
                  $info = info("Anda yakin akan menghapus soal ini ?");
                  if (isset($_POST['hapus'])) {
                    $exec = mysqli_query($koneksi, "DELETE FROM soal WHERE id_soal = '$_REQUEST[idu]'");
                    (!$exec) ? info("Gagal menyimpan", "NO") : jump("?pg=$pg&ac=$ac&id=$id_mapel");
                  }
                  ?>
                  <div class='modal fade' id="hapus<?= $soal['id_soal'] ?>" style='display: none;'>
                    <div class='modal-dialog'>
                      <div class='modal-content'>
                        <div class='modal-header bg-maroon'>
                          <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                          <h3 class='modal-title'>Hapus Soal</h3>
                        </div>
                        <div class='modal-body'>
                          <form action='' method='post'>
                            <input type='hidden' id='idu' name='idu' value="<?= $soal['id_soal'] ?>" />
                            <div class='callout '>
                              <h4><?= $info ?></h4>
                            </div>
                            <div class='modal-footer'>
                              <div class='box-tools pull-right '>
                                <button type='submit' name='hapus' class='btn btn-sm bg-maroon'><i class='fa fa-trash-o'></i> Hapus</button>
                                <button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endwhile; ?>
              </tbody>
            </table>
            <?php if ($namamapel['jml_esai'] != 0) : ?>
            <b>B. Soal Essai</b>
            <?php endif; ?>
            <table class='table table-bordered table-striped'>
              <tbody>
                <?php $soalq = mysqli_query($koneksi, "SELECT * FROM soal where id_mapel='$id_mapel' and jenis='2' order by nomor "); ?>
                <?php while ($soal = mysqli_fetch_array($soalq)) : ?>
                  <tr>
                    <td style='width:30px'>
                      <?= $soal['nomor'] ?>
                    </td>
                    <td style="text-align:justify">
                      <?php
                      if ($soal['file'] <> '') :
                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                        $ext = explode(".", $soal['file']);
                        $ext = end($ext);
                        if (in_array($ext, $image)) {
                          echo "<p style='margin-bottom: 5px'><img src='$homeurl/files/$soal[file]' style='max-width:200px;'/></p>";
                        } elseif (in_array($ext, $audio)) {
                          echo "<p style='margin-bottom: 5px'><audio controls><source src='$homeurl/files/$soal[file]' type='audio/$ext'>Your browser does not support the audio tag.</audio><br></p>";
                        } else {
                          echo "File tidak didukung!";
                        }
                      endif;
                      ?>
                      <?= $soal['soal']; ?>
                      <?php
                      if ($soal['file1'] <> '') :
                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                        $ext = explode(".", $soal['file1']);
                        $ext = end($ext);
                        if (in_array($ext, $image)) {
                          echo "<p style='margin-top: 5px'><img src='$homeurl/files/$soal[file1]' style='max-width:200px;' /></p>";
                        } elseif (in_array($ext, $audio)) {
                          echo "<p style='margin-top: 5px'><audio controls><source src='$homeurl/files/$soal[file1]' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
                        } else {
                          echo "File tidak didukung!";
                        }
                      endif;
                      ?>
                    </td>
                    <td style='width:30px'>
                      <a><button class='btn bg-maroon btn-sm' data-toggle='modal' data-target="#hapus<?= $soal['id_soal'] ?>"><i class='fa fa-trash'></i></button></a>
                    </td>
                  </tr>
                  <?php
                  $info = info("Anda yakin akan menghapus soal ini ?");
                  if (isset($_POST['hapus'])) {
                    $exec = mysqli_query($koneksi, "DELETE FROM soal WHERE id_soal = '$_REQUEST[idu]'");
                    (!$exec) ? info("Gagal menyimpan", "NO") : jump("?pg=$pg&ac=$ac&id=$id_mapel");
                  }
                  ?>
                  <div class='modal fade' id="hapus<?= $soal['id_soal'] ?>" style='display: none;'>
                    <div class='modal-dialog'>
                      <div class='modal-content'>
                        <div class='modal-header bg-maroon'>
                          <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                          <h3 class='modal-title'>Hapus Soal</h3>
                        </div>
                        <div class='modal-body'>
                          <form action='' method='post'>
                            <input type='hidden' id='idu' name='idu' value="<?= $soal['id_soal'] ?>" />
                            <div class='callout callout-warning'>
                              <h4><?= $info ?></h4>
                            </div>
                            <div class='modal-footer'>
                              <div class='box-tools pull-right '>
                                <button type='submit' name='hapus' class='btn btn-sm bg-maroon'><i class='fa fa-trash-o'></i> Hapus</button>
                                <button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
<?php elseif ($ac == 'hapusfile') : ?>
  <?php
  $jenis = $_GET['jenis'];
  $id = $_GET['id'];
  $file = $_GET['file'];
  $soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_soal='$id'"));
  (file_exists("../files/" . $soal[$file])) ? unlink("../files/" . $soal[$file]) : null;
  mysqli_query($koneksi, "UPDATE soal SET $file='' WHERE id_soal='$id'");
  jump("?pg=$pg&ac=input&paket=$soal[paket]&id=$soal[id_mapel]&no=$soal[nomor]&jenis=$jenis");
  ?>
<?php elseif ($ac == 'importsoal') : ?>
  <?php include "import_soal.php"; ?>
  <!-- 
<?php elseif ($ac == 'duplikat') : ?>
  <?php include "duplikasi_soal.php"; ?>
-->
<?php endif; ?>

<script type="text/javascript">
  $('#tabel_soal').dataTable({
    "pageLength": 25
  });
  $('#tabel_soal2').dataTable({
    "pageLength": 25
  });
  //jquery untuk proses duplikasi 
  $(document).on('click', '.duplikat', function() {
    var idmapel = $(this).data('soal');
    $.ajax({
      type: 'POST',
      url: 'duplikat_soal.php',
      data: 'id=' + idmapel,
      beforeSend: function() {
        $('.loader').css('display', 'block');
      },
      success: function(respon) {
        $('.loader').css('display', 'none');
        location.reload();
      }
    });

  });
  $(document).on('click', '.duplikat1', function() {
    var idmapel = $(this).data('soal1');
    $.ajax({
      type: 'POST',
      url: 'duplikat_banksoal.php',
      data: 'id=' + idmapel,
      beforeSend: function() {
        $('.loader').css('display', 'block');
      },
      success: function(respon) {
        $('.loader').css('display', 'none');
        location.reload();
      }
    });

  });
  $(document).on('change', '#changestatus', function() {
    var status = $(this).val();
    //-----------------------------------
    i = 0;
    id_array = new Array();
    $("input.cekpilih:checked").each(function() {
      id_array[i] = $(this).val();
      i++;
    });
    //-----------------------------------

    swal({
      title: 'Ganti Status Bank Soal ' + i,
      text: 'Apakah kamu yakin akan mengganti status bank soal',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Ganti!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: 'c_aksi.php?banksoal=status',
          data: {
            status: status,
            data: id_array
          },
          type: "POST",
          success: function(respon) {
            console.log(respon);
            if (respon == 1) {
              toastr.success('Berhasil Ganti Status');
              setTimeout(function() {
                location.reload(1);
              }, 1000);
            } else {
              toastr.error('Opsss Error');
            }
          }
        })
      }
    });


  });
  $(function() {
    $("#btnhapusbank").click(function() {
      i = 0;
      id_array = new Array();
      $("input.cekpilih:checked").each(function() {
        id_array[i] = $(this).val();
        i++;
      });
      swal({
        title: 'Bank Soal Terpilih ' + i,
        text: 'Apakah kamu yakin akan menghapus data bank soal yang sudah dipilih  ini ?? Karna Semua Data Soal, Data Ujian, Data Jawaban, Data Nilai Akan di Hapus !! Pastika Sudah Backup Database ',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: 'hapusbanksoal.php',
            data: "kode=" + id_array,
            type: "POST",
            success: function(respon) {
              console.log(respon);
              if (respon == 1 || respon == 11) {
                $("input.cekpilih:checked").each(function() {
                  $(this).parent().parent().remove('.cekpilih').animate({
                    opacity: "hide"
                  }, "slow");
                });
                toastr.success('Data Berhasil Di Hapus');
                setTimeout(function() {
                  location.reload(1);
                }, 1000);
              }
            }
          })
        }
      });
      return false;
    });
  });
  $(document).ready(function() {

    var get_jdwl = localStorage.getItem('jadwal');
    if (get_jdwl == 0) {
      $(".jdwl1").removeClass("active");
      $(".jdwl2").addClass("active");
      $("#menu1").addClass("active in");
    } else {
      $(".jdwl2").removeClass("active");
      $(".jdwl1").addClass("active");
      $("#home").addClass("active in");
    }

  });
</script>