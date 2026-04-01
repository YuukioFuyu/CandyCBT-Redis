
<div class='row'>
  <div class='col-md-12'>
    <div id="info">
    <?php $this->load->view('thema/pesan_data.php'); ?>
    </div>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'>Daftar Absen Mapel Detail</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <div class="form-group">
          <div class="row">
            <div class="col-md-2">
              <select class="form-control select2 level" id="kelas" name="kelas">
                <option value=""> Pilih Kelas</option>
                <?php foreach ($v_kelas2 as $value) : ?>
                  <option <?= selectAktif($value['idkls'],@$_GET['kelas']) ?> value="<?= $value['idkls'] ?>"><?= $value['id_kelas'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3">
              <select  id="mapel" class="form-control select2 ">
                <option value=""> Pilih Mapel</option>
                 <?php foreach ($absen_mapel as $value) : ?>
                  <option <?= selectAktif($value->amId,@$_GET['mapel']) ?> value="<?= $value->amId ?>"><?= $value->nama_mapel ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2">
              <select id="tahun" class="form-control select2 ">
                <option value=""> Pilih Tahun</option>
                <?php foreach ($getTahun as $th) : ?>
                  <option  <?= selectAktif($th->tahun,@$_GET['tahun']) ?> value="<?= $th->tahun ?>"><?= $th->tahun ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2">
              <select  id="bulan" class="form-control select2 ">
                <option value=""> Pilih Bulan</option>
                <?php for ($i=1; $i <=12 ; $i++) { ?>
                  <option <?= selectAktif($i,@$_GET['bulan']) ?> value="<?= $i ?>"><?= bulanIndo($i) ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-2">
              <button id="cari_absen" class="btn btn-info"> Cari Data Absen</button>
            </div>
          </div>
        </div>
        <?php //var_dump($getAbsenSiswaMapel) ?>
        <div  class='table-responsive' id='tabletugas2' style="">
          <table id='tabletugas' class='table table-bordered table-hover'>
            <thead class="title_bar_table">
              <tr>
                <th width='5px'>#</th>
                <th >Nama Siswa</th>
                <th >Kelas</th>
                <th >Mata Pelajaran</th>
                <th style="text-align: center;">Hari Mapel</th>
                <th style="text-align: center;">Tanggal</th>
                <th style="text-align: center;">Jam Absen</th>
                <th style="text-align: center;">Status</th>
               <!--  <th width='200px' style="text-align: center;">Aksi</th> -->
              </tr>
            </thead>
            <tbody>
             <?php $no=1; 
             if(empty($getAbsenSiswaMapel)){ }else{
             foreach ($getAbsenSiswaMapel as $abs) { 
              if($abs['tgl']=='-'){ $tgl='-'; }else{ $tgl = date('d-m-Y',strtotime($abs['tgl']));}
              
              ?>
               <tr>
                 <td><?= $no++; ?></td>
                 <td><?= $abs['nama_siswa'] ?></td>
                 <td><?= $abs['kelas'] ?></td>
                 <td><?= $abs['mapel'] ?></td>
                 <td><?= HariIndo($abs['hari'])?></td>
                 <td><?= $tgl ?></td>
                 <td align="center"><?= $abs['jamin'] ?></td>
                 <td align="center"><?= $abs['status'] ?></td>
                 
               </tr>
             <?php } } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', '#cari_absen', function() {
      var tahun = $('#tahun').val();
      var bulan = $('#bulan').val();
      var kelas = $('#kelas').val();
      var mapel = $('#mapel').val();
      location.replace("?tahun="+tahun+"&bulan="+bulan+"&kelas="+kelas+"&mapel="+mapel);
    });
    $('#tabletugas').DataTable({
      "lengthMenu": [[50, -1], [50, "All"]]
     });
  });
</script>


