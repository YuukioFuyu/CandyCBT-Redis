  <div class='row'>
    <div class='col-md-12'>
      <div class='box box-solid'>
        <div class='box-header with-border'>
          <h3 class='box-title'><i class="fas fa-file-signature    "></i> Data Hasil Ujian</h3>
        </div><!-- /.box-header -->
        <div class='box-body'>
          <table id='example1' class='table table-bordered table-striped'>
            <thead>
              <tr>
                <th width='5px'>#</th>
                <th>Kode Tes</th>
                <th class='hidden-xs'>Ujian Selesai</th>
                <th class='hidden-xs'>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $nilai = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_siswa='$id_siswa' AND ujian_selesai <>'' ORDER BY ujian_selesai ASC "); 
              
              if(empty(mysqli_fetch_array($nilai))){
                $nilaix = mysqli_query($koneksi, "SELECT * FROM nilai_pindah WHERE id_siswa='$id_siswa' AND ujian_selesai <>'' ORDER BY ujian_selesai ASC "); 
              }
              else{
                $nilaix = $nilai;
              }

              ?>
              <?php while ($nilai = mysqli_fetch_array($nilaix)) : ?>
                <?php
                $no++;
                $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$nilai[id_mapel]'"));
                $namamapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mata_pelajaran WHERE kode_mapel='$mapel[nama]'"));
                ?>
                <tr>
                  <td><?= $no ?></td>
                  <td><?= $mapel['nama'] . '-' . $namamapel['nama_mapel'] ?></td>
                  <td class='hidden-xs'><?= $nilai['ujian_selesai'] ?></td>
                  <td class='hidden-xs'><label class='label label-primary'>Selesai</label></td>
                  <td>
                    <a href="<?= $homeurl . '/lihathasil/' . $nilai['id_ujian'] ?>"><button class='btn btn-sm btn-success'><i class='fa fa-search'></i> Lihat Hasil</button></a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
