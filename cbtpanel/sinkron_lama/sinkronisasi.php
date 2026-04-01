<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');


// if(@$token == @$token1) {

$banksoalx = mysqli_num_rows(mysqli_query($koneksi, "select * from mapel where status='1'"));
$soalx = mysqli_num_rows(mysqli_query($koneksi, 'select * from soal'));
$siswax = mysqli_num_rows(mysqli_query($koneksi, "select * from siswa "));
$ujianx = mysqli_num_rows(mysqli_query($koneksi, "select * from ujian ")); ?>
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class='fa fa-download'></i> Tarik Data</h3>
      </div><!-- /.box-header -->
      <div class='box-body'>
        <div class='box box-solid'>
          <div class='box-header with-border'>
            <h5 class='box-title'><i class='fa fa-feed'></i> CEK STATUS DATA </h5>
          </div>
          <div class='box-body'>
            <center><button class='btn btn-primary' id='btnstatus' data-toggle='modal' data-target='#cekstatus'><i class='fas fa-check'></i>&nbsp;Cek Status Data</button>
              <button class='btn btn-danger' id='btnreset' data-toggle='modal' data-target='#resetsinkron'><i class='fa fa-times-circle'></i>&nbsp;Reset Sinkroniasi</button>
              <a id="cache_jadwal"  class='btn btn-sm btn-flat btn-warning'><i class='fa fa-trash'></i> Hapus Cache Lokal</a>
              <a id="cache_jadwal2"  class='btn btn-sm btn-flat btn-success'><i class='fa fa-trash'></i> Hapus Cache Server</a>
            </center>
          </div>
        </div>
        <div class='box box-solid'>
          <div class='box-header with-border'>

            <h5 class='box-title'><i class='fa fa-spinner fa-spin'></i> STATUS SINKRONISASI | PASTIKA SINKRON BERURUTAN </h5>

          </div>
          <div class='box-body' id='resethasil'>
            <div id='progressbox'>
            </div>
            <div id='hasilsinkron'>
              <center><img id='loading-image2' src='ajax-loader.gif' style='display:none; width:50px;' />
                <center>
                </div>
              <div class="table-responsive">
                <table class='table table-striped' id='tablestatus'>
                  <thead>
                    <th>No</th>
                    <th>Nama Data</th>
                    <th>Jumlah</th>
                    <th>Update Terakhir</th>
                    <th>Status Sinkron</th>
                    <th>Proses Sinkron</th>
                  </thead>
                  <tbody>
                    <?php $no = 0;
                    $dataq = mysqli_query($koneksi, "SELECT * FROM sinkron ORDER BY id_singkron ASC");
                    while ($data = mysqli_fetch_array($dataq)) {
                      if ($data['status_sinkron'] <> 0) {
                        $status = "<label class='label bg-green'>sudah sinkron</label>";
                        $button = "<button data-id='$data[nama_data]' class='sinkron btn bg-yellow'><i class='fa fa-recycle'></i> Ulang Sinkron</button>";
                      } else {
                        $status = "<label class='label bg-red'>belum sinkron</label>";
                        $button = "<button data-id='$data[nama_data]' class='sinkron btn bg-purple'><i class='fa fa-play'></i> Mulai Sinkron</button>";
                      }
                      if ($data['tanggal'] <> null) {
                        $update = "<button class='btn btn-flat bg-blue'>$data[tanggal]</button>";
                      } else {
                        $update = "<button class='btn btn-flat bg-blue'>BELUM ADA</button>";
                      }

                      $no++; ?>

                      <tr>
                        <td><?= $no ?></td>
                        <td><?= $data['nama_data'] ?></td>
                        <td><?= $data['jumlah'] ?></td>
                        <td><?= $update ?></td>
                        <td><?= $status ?></td>
                        <td><?= $button ?></td>
                      </tr>
                    <?php    } ?>

                  </tbody>
                </table>
              </div>

              </div>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
    </div>
    <div class='modal fade' id='cekstatus' style='display: none;'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header bg-blue'>
            <h3 class='modal-title'>Status Data Server</h3>
          </div>
          <div class='modal-body' id='bodystatus'>
            <center><img id='loading-image' src='../dist/img/ajax-loader.gif' style='display:none; width:50px;' />
              <center>
              </div>

            </div>
          </div>
        </div>
        <!-- <span>Penjelas Fungsi DATA</span>
        <table class="table">
          <thead>
            <tr>
              <th>DATA</th>
              <th>FUNGSI</th>
              <tr>
              </thead>
              <tbody>
                <tr>
                  <td>DATA 1</td>
                  <td>Tarik Data Siswa</td>
                </tr>
                <tr>
                  <td>DATA 2</td>
                  <td>Tarik Data Bank Soal dan Mata_Pelajaran</td>
                </tr>
                <tr>
                  <td>DATA 3</td>
                  <td>Tarik Data Soal</td>
                </tr>
                <tr>
                  <td>DATA 4</td>
                  <td>Tarik Data Ujian Atau Jadwal</td>
                </tr>
                <tr>
                  <td>DATA 5</td>
                  <td>Tarik Data Setting atau Sekolah</td>
                </tr>
                <tr>
                  <td>DATA 6</td>
                  <td>Tarik Data File Pendukung Foto / Sound</td>
                </tr>
              </tbody>
            </table> -->
            <div class='modal fade' id='resetsinkron' style='display: none;'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header bg-blue'>
                    <h3 class='modal-title'>Reset Sinkronisasi</h3>
                  </div>
                  <div class='modal-body' id='bodystatus'>
                    <center>Aksi ini akan menyebabkan semua data yang telah masuk terhapus, dan harus sinkronisasi ulang, apa anda yakin akan melanjutkan ??</center>
                  </div>
                  <div class='modal-footer'>

                    <center>
                      <button class='btn btn-danger' name='reset' id='btnresetsinkron'><i class='fa fa-close'></i> IYA, Reset Sinkronisasi</button>
                    </center>

                  </div>
                </div>
              </div>
            </div>

            <script>
              $('#btnstatus').click(function() {
                $.ajax({
                  type: 'POST',
                  url: 'sinkronstatus.php',
                  beforeSend: function() {
                    $('#loading-image').show();
                  },
                  success: function(response) {
                    $('#bodystatus').html(response);

                    $('#mulaitarik').removeAttr('disabled');

                  },
                  complete: function() {
                    $('#loading-image').hide();
                  },
                });

              });
              $('#btnresetsinkron').click(function() {
                $.ajax({
                  type: 'POST',
                  url: 'sinkronreset.php',
                  beforeSend: function() {
                    $('.loader').css('display', 'block');
                  },
                  success: function(response) {
                    $('.loader').css('display', 'none');
                    $('#resetsinkron').modal('hide');
                    $('#tablestatus').load(location.href + ' #tablestatus');
                  }
                });

              });
              $(document).on('click', '.sinkron', function() {
                var dataid = $(this).data('id');
                console.log(dataid);
                swal({
                  title: 'Apakah kamu yakin?',
                  text: 'Berfungsi melakukan sinkronisasi dan mengulang sinkronisasi',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'YES!'
                }).then((result) => {
                  if (result.value) {
                    $.ajax({
                      type: 'POST',
                      url: 'sinkron.php',
                      data: 'data=' + dataid,
                      beforeSend: function() {
                        $(this).attr('disabled', 'disabled');
                        $('.loader').css('display', 'block');

                      },
                      success: function(response) {
                        $('.loader').css('display', 'none');
                        $('#hasilsinkron').html(response);
                        $('#tablestatus').load(location.href + ' #tablestatus');
                      }
                    });
                  }
                })
              });
              $(document).on('click', '#cache_jadwal', function() {
                $.ajax({
                  url: '<?= $homeurl; ?>/<?= $serverApiKu; ?>/index.php/Cache',
                  success: function(data) {
                  if(data.status == true){
                    alert("Horee Cache Berhasil Di Bersihkan")
                    }
                  }
                });
              });
              $(document).on('click', '#cache_jadwal2', function() {
                $.ajax({
                  url: '<?= $setting['url_host']; ?>/<?= $serverApiKu; ?>/index.php/Cache',
                  success: function(data) {
                  if(data.status == true){
                    alert("Horee Cache Berhasil Di Bersihkan")
                    }
                  }
                });
              });
            </script>
            <?php 
// }

// else{
//   jump("$homeurl");
// exit;
// }

            ?>