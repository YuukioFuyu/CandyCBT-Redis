<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
cek_session_admin();
$pesan = '';
if (isset($_POST['simpanmapel'])) {
	$kode = str_replace(' ', '', $_POST['kodemapel']);
	$nama = addslashes($_POST['namamapel']);
	$level = $_POST['level_kls'];
	$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mata_pelajaran WHERE kode_mapel='$kode'"));
	if ($cek == 0) {
		$exec = mysqli_query($koneksi, "INSERT INTO mata_pelajaran (kode_mapel,nama_mapel,kode_level)value('$kode','$nama','$level')");
		$pesan = "<div class='alert alert-success alert-dismissible'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
		<i class='icon fa fa-info'></i>
		Data Berhasil ditambahkan ..</div>";
	} else {
		$pesan = "<div class='alert alert-warning alert-dismissible'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
		<i class='icon fa fa-info'></i>
		Maaf Kode Mapel Sudah ada !</div>";
	}
	$db->RedisDelKey('mata_pelajaran'.$db->KodeSekolah());
}
if (isset($_POST['importmapel'])) {
	$file = $_FILES['file']['name'];
	$temp = $_FILES['file']['tmp_name'];
	$ext = explode('.', $file);
	$ext = end($ext);
	if ($ext <> 'xls') {
		$info = info('Gunakan file Ms. Excel 93-2007 Workbook (.xls)', 'NO');
	} else {
		$data = new Spreadsheet_Excel_Reader($temp);
		$hasildata = $data->rowcount($sheet_index = 0);
		$sukses = $gagal = 0;
		for ($i = 2; $i <= $hasildata; $i++) {
			$kode = addslashes($data->val($i, 2));
			$nama = addslashes($data->val($i, 3));
			$level = addslashes($data->val($i, 4));
			$kode = str_replace(' ', '', $kode);
			$nama = addslashes($nama);
			$cek = mysqli_num_rows(mysqli_query($koneksi, "select * from mata_pelajaran where kode_mapel='$kode'"));
			if ($kode <> '' and $nama <> '') {
				if ($cek == 0) {
					$exec = mysqli_query($koneksi, "INSERT INTO mata_pelajaran (kode_mapel,nama_mapel,kode_level) VALUES ('$kode','$nama','$level')");
					($exec) ? $sukses++ : $gagal++;
				}
			} else {
				$gagal++;
			}
		}
		$db->RedisDelKey('mata_pelajaran'.$db->KodeSekolah());
		$total = $hasildata - 1;
		$info = info("Berhasil: $sukses | Gagal: $gagal | Dari: $total", 'OK');
	}
}
?>
<div class='row'>
	<div class='col-md-12'><?= $pesan ?></div>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Mata Pelajaran</h3>
				<div class='box-tools pull-right '>
					<button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahmapel'><i class='fa fa-check'></i> Tambah Mapel</button>
					<button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#importmapel'><i class='fa fa-upload'></i> Import Mapel</button>
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<div class='table-responsive'>
					<table id='tb_mapel' class='table table-bordered table-striped'>
						<thead>
							<tr>
								<th width='5px'>#</th>
								<th>Kode Mapel</th>
								<th>Mata Pelajaran</th>
								<th>Level Kelas</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $mapelQ = $db->getMataPelajaran(); ?>
							<?php foreach ($mapelQ as $mapel) : ?>
								<?php $no++; ?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $mapel->kode_mapel ?></td>
									<td><?= $mapel->nama_mapel ?></td>
									<td><?= $mapel->kode_level ?></td>
									<td><button data-id="<?= $mapel->idmapel ?>"  class="btn btn-danger delete"><i class="fa fa-trash"></i></button></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
	<div class='modal fade' id='tambahmapel' style='display: none;'>
		<div class='modal-dialog'>
			<div class='modal-content'>
				<div class='modal-header bg-blue'>
					<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
					<h3 class='modal-title'>Tambah Mata Pelajaran</h3>
				</div>
				<div class='modal-body'>
					<form action='' method='post'>
						<div class='form-group'>
							<label>Kode Mapel</label>
							<input type='text' name='kodemapel' class='form-control' required='true' />
						</div>
						<div class='form-group'>
							<label>Nama Pelajaran</label>
							<input type='text' name='namamapel' class='form-control' required='true' />
						</div>
						<div class='form-group'>
							<label>Level Kelas</label>
							<select class="form-control select2" name="level_kls">
							<?php $db2 = $db->v_level(); 
							foreach ($db2 as $value) { ?>
									<option value="<?= $value['kode_level'];?>"><?= $value['kode_level'];?></option>
							<?php } ?>
							</select>
						</div>
						<div class='modal-footer'>
							<div class='box-tools pull-right '>
								<button type='submit' name='simpanmapel' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
								<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class='modal fade' id='importmapel' style='display: none;'>
		<div class='modal-dialog'>
			<div class='modal-content'>
				<div class='modal-header bg-blue'>
					<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
					<h3 class='modal-title'>Tambah Mata Pelajaran</h3>
				</div>
				<div class='modal-body'>
					<form action='' method='post' enctype='multipart/form-data'>
						<div class='form-group'>
							<label>Pilih File</label>
							<input type='file' name='file' class='form-control' required='true' />
						</div>
						<p>
							Sebelum meng-import pastikan file yang akan anda import sudah dalam bentuk Ms. Excel 97-2003 Workbook (.xls) dan format penulisan harus sesuai dengan yang telah ditentukan. <br />
						</p>

						<a href='importdatamapel.xls'><i class='fa fa-file-excel-o'></i> Download Format</a>

						<div class='modal-footer'>
							<div class='box-tools pull-right '>
								<button type='submit' name='importmapel' class='btn btn-sm btn-flat btn-success'><i class='fa fa-upload'></i> Simpan</button>
								<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#tb_mapel').DataTable({
		"lengthMenu": [[25, 50, -1], [25, 50, "All"]]
	});
	$(document).on('click', '.delete', function() {
		let idmapel = $(this).data('id');
		var cek = confirm("Apakah Anda Yakin Akan Menghapus Mapel Ini ? Setiap Mapel Di Hapus Akan Berpengaruh Pada Data Soal, Ujian, Jadwal Dll");
		if(!cek==true){ }
		else{
	  	$.ajax({
				type: 'POST',
				url: 'c_aksi.php?mapel_pelajaran=delete',
				data: 'idmapel='+idmapel,
				beforeSend: function() {
						$("#pesanku").text("Proses...");
						$('.loader').show();
				},
				success: function(respon) {
					console.log(respon);
					if(respon==1){
						location.reload();
					} 
					else{
						$('.loader').hide();
						toastr.error('Gagal Di Hapus');
					}
				}
			});
	  }
	});
</script>