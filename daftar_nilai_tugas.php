<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit "></i> Daftar Nilai Tugas Siswa</h3>
      </div><!-- /.box-header -->
      <div class='box-body'>
        <div style="padding-bottom: 10px;" >
         <a class="btn btn-warning" href='<?= $homeurl ?>/tugassiswa' ><i class="fa fa-arrow-left"></i> Kembali Lihat Tugas</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="tableabsen">
            <thead style="background-color: #337ab7;border-color:#337ab7;color:#fff;">
              <tr>
                <th>NO</th>
                <th>NILAI</th>
                <th>CATATAN SISWA</th>
                <th>JUDUL TUGAS</th>
                <th>MAPEL</th>
                <th>TANGGAL DI KERJAKAN </th>
                <!-- <th>TANGGAL MULAI</th>
                <th>TANGGAL AKHIR</th> -->
                
              </tr>
            </thead>
            <tbody>
             <?php $no=1; foreach ($dbb->DaftarNilaiTugas($_SESSION['id_siswa']) as $data): ?>
              <tr>
                <td><?= $no++;?></td>
                <td><?= $data['nilai'];?></td>
                <td>
                  <?php if(!empty($data['catatanGuru'])): ?>
                      <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalcatatan<?= $no ?>">Klik Untuk Lihat Catatan</button>
                     <!-- Modal -->
                      <div class="modal fade" id="modalcatatan<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <p><?= $data['catatanGuru'] ?></p>
                                  </div>
                                </div>
                                
                              </div>
                          
                          </div>
                        </div>
                      </div><!-- end modal -->
                      <?php endif ?>
                </td>
                <td><?= $data['judul'];?></td>
                <td><?= $data['mapel'];?></td>
                <td><?= $data['tgl_dikerjakan'];?></td>

               <!--  <td><?= $data['tgl_mulai'];?></td>
                <td><?= $data['tgl_selesai'];?></td> -->
                
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