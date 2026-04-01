<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit "></i> Tugas Siswa</h3>
      </div><!-- /.box-header -->
      <div class='box-body'>
        <div style="padding-bottom: 10px;" >
          <a href="<?= $homeurl . '/daftarnilaitugas/' . enkripsi($mapel['id_tugas']) ?>" class="btn btn-primary">Daftar Nilai Tugas</a>
          <button onclick="location.reload();" class="btn btn-warning"><i class="fa fa-spinner fa-spin "></i> Refres Tugas</button>
        </div>
         
        
        <?php

        header("Cache-Control: no-cache, must-revalidate");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        $mapelQ = mysqli_query($koneksi, "SELECT * FROM tugas where status=1");
         $no=1; 
       
        foreach ($mapelQ as $mapel){
            $datakelas = unserialize($mapel['kelas']);
            $guru = fetch($koneksi, 'pengawas', ['id_pengawas' => $mapel['id_guru']]);
            if (in_array($_SESSION['id_kelas'], $datakelas) or in_array('semua', $datakelas)){
                $selesaitgl = strtotime($mapel['tgl_selesai']); 
                $sekarang = strtotime(date("Y-m-d H:i:s"));
                if($sekarang > $selesaitgl ){ }
                else{  $array[] = $mapel;  }
            };
        
         
         };
         
         
          
        
        ?>
        <div class="table-responsive">
          <table class="table table-bordered" id="tableabsen">
            <thead>
              <tr>
                <th>NO</th>
                <th>STATUS</th>
                <th>MAPEL</th>
                <th>JUDUL</th>
                <th>MULAI</th>
                <th>SELESAI</th>
                <th>NAMA GURU</th>
              </tr>
            </thead>
            <tbody>
             <?php foreach ($array as $mapel) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                     <td>
                      <?php if ($mapel['tgl_mulai'] > date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) { ?>
                        <span class="badge"> BELUM MULAI</span>
                      <?php } elseif ($mapel['tgl_mulai'] < date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) { ?>
                        <a href="<?= $homeurl . '/lihattugas/' . enkripsi($mapel['id_tugas']) ?>" class="btn btn-primary">
                          <i class="fa fa-edit"></i> Lihat Tugas
                        </a>
                      <?php } else { ?>
                       <span class="badge bg-red"> DI TUTUP</span>
                      <?php } ?>
                    </td>
                    <td><?= $mapel['mapel'] ?></td>
                    <td><?= $mapel['judul'] ?></td>
                    <td> 
                      <span class="pull-right badge bg-green"><?= $mapel['tgl_mulai'] ?></span>
                   </td>
                    <td>
                      <span class="pull-right badge bg-red"><?= $mapel['tgl_selesai'] ?></span>
                   </td>
                    <td><?= $guru['nama'] ?></td>
                   
                  </tr>
             <?php endforeach?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var tabel = $('#tableabsen').dataTable();
</script>