<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid '>
				<div class='box-header with-border '>
					<h3 class='box-title'><i class='fa fa-briefcase'></i> Absensi Detail </h3>
					<div class='box-tools pull-right '>
						
					</div>
				</div><!-- /.box-header -->

				<div class='box-body'>
					<label>Di Sarankan Untuk Filter Data Tanggal di Pilih</label><br>

					<small id="fileHelpId" class="form-text text-muted">Silhakan Pilih Tahun, Bulan Dan Kelas untuk mencari data Absensi Kehadiran</small>
					<div class="row" style="padding-bottom: 10px">
						<div class="col-md-2" style="padding-bottom: 3px">
							<select id="kelas" class="form-control select2 kelas">
								<?php $kelas = $db->v_kelas(); ?>
									<option value=""> Pilih Kelas</option>
									<?php foreach ($kelas as $value) : ?>
										<option <?= selectAktif($value['idkls'],$_GET['kelas']) ?> value="<?= $value['idkls'] ?>"><?= $value['nama'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-2" style="padding-bottom: 3px">
							<select id="tahun" class="form-control select2 ">
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
							<select id="tgl" class="form-control select2 ">
									<option value="null"> Pilih Tanggal</option>
									<?php for ($i=1; $i <=31 ; $i++) { ?>
										<option <?= selectAktif($i,$_GET['tgl']) ?> value="<?= $i ?>"><?= $i ?></option>
								<?php } ?>
							</select>
						</div>
						
						<div class="col-md-2" style="padding-bottom: 3px">
							<select id="siswa" class="form-control select2 siswa">
								<option value="null">Pilih Siswa</option>
							</select>
						</div>
					</div>
					<div class="row" style="padding-bottom: 10px">
						<div class="col-md-6">
							<button id="cari_absen" class="btn btn-info"> Cari Data Absen</button>
							<?php 
							if(!empty($_GET['kelas'])){ ?>
							<button id="down_excel" class="btn btn-warning"><i class="fa fa-download"></i> Download Excel </button>
							<button class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult'].print()"><i class='fa fa-print'></i> Print</button>
						<?php } ?>
						</div>
					</div>
					<div id='tablereload' class='table-responsive'>
						<table id='tableabsen' class='table table-bordered table-striped'>
							<thead>
								<tr>
									<th width='5px'><input type='checkbox' id='ceksemua'></th>
									<th width='5px'>#</th>
									<?php if($setting['izi_foto_absen'] ==1){ ?>
									<th>FOTO</th>
									<?php } ?>
									<th>NAMA SISWA</th>
									<th>KELAS</th>
									<th>TANGGAL</th>
									<th>JAM MASUK</th>
									<th>JAM PULANG</th>
									<th>STATUS ABSEN</th>
									<th>AKSI</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$absen = $db->getAbsenDetail();
							$no=1;
							foreach ($absen as $abs ) { ?>
								<tr>
									<td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-$no' value="<?= $abs['absIdSiswa'] ?>"></td>
									<td><?= $no++;?></td>
									<?php if($setting['izi_foto_absen'] ==1){ ?>
									<td>
										<?php if(empty($abs['absUrlFoto'])){ ?>
											<img width="50" src="<?= $homeurl.'/foto/avatar.jpg'?>" class="img-thumbnail img-responsive" alt="Foto Tidak Ada">
										<?php }else{

										?>
										<a href="<?= $homeurl.'/'.$abs['absUrlFoto'] ?>" target="_blank"><img width="50" src="<?= $homeurl.'/'.$abs['absUrlFoto'].'?date='.time(); ?>" class="img-thumbnail img-responsive" alt="Foto Tidak Ada"></a>
										<?php } ?>
									</td>
									<?php } ?>
									<td><?= $abs['namasiswa'] ?></td>
									<td><?= $abs['nama'] ?></td>
									<td><?= date('d-m-Y',strtotime($abs['absTgl'])) ?></td>
									<td><?= JamNull($abs['absJamIn']) ?></td>
									<td><?= JamNull($abs['absJamOut']) ?></td>
									<td><?= $abs['absStatus'] ?></td>
									<td><button data-idsiswa="<?= $abs['absId'] ?>" class='btn btn-warning btn-flat btn-xs editabsen' data-toggle='modal' data-target='#edit'><i class='fa fa-edit'></i></button>
										<button data-idabsen="<?= $abs['absId'] ?>" class='btn btn-danger btn-flat btn-xs hapusabsen' ><i class='fa fa-trash'></i></button></td>
								</tr>
							<?php } ?>
								
							</tbody>
						</table>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
</div>

<iframe id='loadframe' name='frameresult' src="cetak_absen_detail.php?tahun=<?= $_GET['tahun']; ?>&bulan=<?= $_GET['bulan']; ?>&kelas=<?= $_GET['kelas']; ?>&tgl=<?= $_GET['tgl']; ?>&siswa=<?= $_GET['siswa']; ?>" style='border:none;width:1px;height:1px;'></iframe>
<div class='modal fade' id='edit' style='display: none;'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header bg-blue'>
				<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
				<h3 class='modal-title'>Edit Absen Kehadiran Siswa</h3>
			</div>
				<div class='modal-body'>
					Silihakan Pilih Status Absen 
					<div class="row" style="padding-bottom: 10px;">
						<div class="col-md-8">
							<input id="idsiswae" type="hidden" name="idsiswa" value="">
							<select id="status_absen" class="form-control select2 " style="width: 100px">
									<option value="">Status</option>
									<option value="H" >Hadir</option>
									<option value="S">Sakit</option>
									<option value="I">Izin</option>
									<option value="T">Terlambat</option>
									<option value="B">Bolos</option>
									<option value="A">Alpha</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<button id="edit_absen" class="btn btn-info"> Edit Absen</button>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
<script type="text/javascript">
	$(document).on('click', '.editabsen', function() {
		var idsiswa = $(this).data('idsiswa');
		$("#idsiswae").val(idsiswa);
		
	});
	$(document).on('click', '.hapusabsen', function() {
    var idabsen = $(this).data('idabsen');
    $.ajax({
				url: 'c_aksi.php?absen=delabsen',
				method : "POST",
				data : {idabsen:idabsen},
				beforeSend:function(){
     				return confirm("Apakah Yakin Akan di Hapus Absen Ini ?");
				},
				success: function(response){
					console.log(response);
					if(response ==1){
            toastr.success('Absensi Berhasil Di Hapus ');
            location.reload();
	        }
	        else if(response ==0){
	          toastr.error('Upss Gagal Hapus Absen');
	        }
	        else{
	          toastr.warning('eror sistem');
	        }
				}

			});
	});
	$(document).on('click', '#edit_absen', function() {
		var status_absen = $('#status_absen').val();
    var idsiswa = $('#idsiswae').val();
    $.ajax({
				url: 'c_aksi.php?absen=upabsen',
				method : "POST",
				data : {status_absen: status_absen,idsiswa:idsiswa},
				success: function(response){
					//console.log(data);
					if(response ==1){
            toastr.success('Absensi Berhasil Di Edit ');
            // $("#tablereload").load(" #tablereload > *");
            location.reload();
	        }
	        else if(response ==0){
	          toastr.error('Upss Gagal Edit Absen');
	        }
	        else{
	          toastr.warning('eror sistem');
	        }
				}

			});
	});
	$(document).on('click', '#cari_absen', function() {
    var tahun = $('#tahun').val();
    var bulan = $('#bulan').val();
    var kelas = $('#kelas').val();
    var tgl = $('#tgl').val();
    var siswa = $('#siswa').val();
    
    location.replace("?pg=absen_detail&tahun="+tahun+"&bulan="+bulan+"&kelas="+kelas+"&tgl="+tgl+"&siswa="+siswa);
  });
  var tabel = $('#tableabsen').dataTable({
  	"aLengthMenu": [[10,50,100,200,300,-1], [10,50,100,200,300,"All"]],
  });
  $(document).on('click','#down_excel',function(){
		$("#tableabsen").table2excel({
        filename: "data_absen_detail.xls",
        fileext: ".xls",
        //preserveColors: preserveColors,
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
       // preserveColors:true

      });
 
	});
	$('#kelas').change(function(){
			var id=$(this).val();
			//alert(id);
			$.ajax({
				url: 'c_aksi.php?absen=getsiswa',
				method : "POST",
				data : {id: id},
				async : false,
				dataType : 'json',
				success: function(data){
					//console.log(data);
					var html = '';
					var i;
					html +='<option value="null">Pilih Siswa</option>';
					for(i=0; i<data.length; i++){
						html += '<option value='+data[i].idsiswa+'>'+data[i].namasiswa+'</option>';
					}
					$('#siswa').html(html);
				}

			});
			return false;

		});
</script>
	