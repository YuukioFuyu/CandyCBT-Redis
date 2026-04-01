<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');

?>
<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid '>
				<div class='box-header with-border '>
					<h3 class='box-title'><i class='fa fa-briefcase'></i> Absensi</h3>
					<div class='box-tools pull-right '>
						<button class='btn btn-sm btn-flat btn-primary' data-toggle='modal' data-backdrop='static' data-target='#infojadwal'><i class='glyphicon glyphicon-info-sign'></i> <span class='hidden-xs'>Informasi Baca Dulu</span></button>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<div class="row" style="padding-bottom: 10px">
						<div class="col-md-2" style="padding-bottom: 3px">
							<select id="tahun" class="form-control select2 kelas">
								<?php $kelas = $db->getTahun(); ?>
									<option value=""> Pilih Tahun</option>
									<?php foreach ($kelas as $value) : ?>
										<option <?= selectAktif($value['thKode'],$_GET['tahun']) ?> value="<?= $value['thKode'] ?>"><?= $value['thKode'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-2" style="padding-bottom: 3px">
							<select id="bulan" class="form-control select2 ">
									<option value=""> Pilih Bulan</option>
									<?php for ($i=1; $i <=12 ; $i++) { ?>
										<option <?= selectAktif($i,$_GET['bulan']) ?> value="<?= $i ?>"><?= bulanIndo($i) ?></option>
										<?php } ?>
							</select>
						</div>
						<div class="col-md-2" style="padding-bottom: 3px">
							<select id="kelas" class="form-control select2 kelas">
								<?php $kelas = $db->v_kelas(); ?>
									<option value=""> Pilih Kelas</option>
									<?php foreach ($kelas as $value) : ?>
										<option <?= selectAktif($value['idkls'],$_GET['kelas']) ?> value="<?= $value['idkls'] ?>"><?= $value['nama'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-6">
							<button id="cari_absen" class="btn btn-info"> Cari Data Absen</button>
							<?php 
						if(!empty($_GET['kelas'])){ ?>
							<button id="down_excel" class="btn btn-warning"><i class="fa fa-download"></i> Download Excel </button>
							<button class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult'].print()"><i class='fa fa-print'></i> Print</button>
						<?php } ?>
						</div>
					</div>
					<div id='tablereset' class='table-responsive'>
						<table id='tableabsen' class='table table-bordered table-striped'>
							<thead>
								<tr>
									<th width='5px'><input type='checkbox' id='ceksemua'></th>
									<th width='5px'>#</th>
									<th>Nama Siswa</th>
									<th>Kelas</th>
									<th>H</th>
									<th>A</th>
									<th>B</th>
									<th>I</th>
									<th>S</th>
									<th>T</th>
									<th>TOTAL</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$absen = $db->getAbsen();
							$no=1;
							foreach ($absen as $abs ) {
								$total = $abs['hadir']+$abs['alpa']+$abs['bolos']+$abs['izin']+$abs['sakit']+$abs['terlambat'];
							//while ($abs = mysqli_fetch_array($absen)){ ?>
								<tr>
									<td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-$no' value="<?= $abs['absIdsiswa'] ?>"></td>
									<td><?= $no++;?></td>
									<td><?= $abs['namasiswa'] ?></td>
									<td><?= $abs['nama'] ?></td>
									<td><?= $abs['hadir'] ?></td>
									<td><?= $abs['alpa'] ?></td>
									<td><?= $abs['bolos'] ?></td>
									<td><?= $abs['izin'] ?></td>
									<td><?= $abs['sakit'] ?></td>
									<td><?= $abs['terlambat'] ?></td>
									<td><?= $total ?></td>
								</tr>
							<?php } ?>
								
							</tbody>
						</table>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
</div>
<div class='modal fade bd-example-modal-md' id='infojadwal' style='display: none;' tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md"  style="width: 700px;">
		<div class='modal-content'>
			<div class='modal-header bg-maroon'>
				<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
				<h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Infromasi Absen</h4>
			</div>

			<div class='modal-body'>
				<p>
					<div class="row">
						<div class="col-md-12">
								<legend style="font-weight: bold;">Informasi Untuk Sistem Absensi</legend>
								<legend style="font-weight: bold;">Absen Hanya Berjalan untuk 1 Pintu yaitu Absen Masuk Saja, Tidak dengan Absen Pulang (Absen Pulang Otomatis Oleh Sistem)</legend>
								Alur Pada Absensi Siswa yang berjalan : <br>
								Siswa Melakukan Absen Jam Masuk di Portal Siswa dan Upload Foto untuk data tambahan Absen, Tidak Upload Foto Juga bisa <br><br>
								Nanti Waktu Absen otomatis akan hitung berdasarkan jam masuk pada sekolah yang sudahd setting di database <br><br>
								Secara otomatis akan mendeteksi Siswa terlambat absen
					</div>

				</p>
			</div>
		</div>
	</div>
</div>
<iframe id='loadframe' name='frameresult' src="cetak_absen.php?tahun=<?= $_GET['tahun']; ?>&bulan=<?= $_GET['bulan']; ?>&kelas=<?= $_GET['kelas']; ?>" style='border:none;width:1px;height:1px;'></iframe>
<script type="text/javascript">
		
	$(document).on('click', '#cari_absen', function() {
    var tahun = $('#tahun').val();
    var bulan = $('#bulan').val();
    var kelas = $('#kelas').val();
    //location="&tahun="+tahun+"&bulan="+bulan+"&kelas="+kelas"";
    location.replace("?pg=absen_total&tahun="+tahun+"&bulan="+bulan+"&kelas="+kelas);
    // $.ajax({
    //   type: 'POST',
    //   url: 'c_aksi.php?absen=getabsen',
    //   data: 'tahun='+tahun+'&bulan='+bulan+'&kelas='+kelas,
    //   success: function(response) {
    //     console.log(response);
        
    //   }
    // });

  });
  $('#tableabsen').dataTable({
  	"aLengthMenu": [[50,100,150,200,250,300,-1], [50,100,150,200,250,300,"All"]],
  });
  $(document).on('click','#down_excel',function(){
		$("#tableabsen").table2excel({
        filename: "data_absen.xls",
        fileext: ".xls",
        //preserveColors: preserveColors,
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
       // preserveColors:true

      });
 
	});
</script>
	