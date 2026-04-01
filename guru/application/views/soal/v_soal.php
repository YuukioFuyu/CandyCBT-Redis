<section class='content' >
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid '>
				<div class='box-header with-border '>
					<h3 class='box-title'><i class='fa fa-briefcase'></i> Daftar Soal</h3>
					<div class='box-tools pull-right '>
						<button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahbanksoal'><i class='glyphicon glyphicon-plus'></i> <span class='hidden-xs'>Tambah Bank Soal</span></button>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<div id='tablereset' class='table-responsive'>
						<table id='daftar_soal' class='table table-bordered table-striped'>
							<thead>
								<tr>
									<th width='5px'>#</th>
									<th>Mata Pelajaran</th>
									<th>Soal PG</th>
									<th>Soal Esai</th>
									<th>Kelas</th>
									<th>Status</th>
									<th>Guru</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
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
				<form action='' method='post' id="tambah_bank_soal">
					<div class='modal-body'>
						<div class='form-group'>
							<label>Mata Pelajaran</label>
							<select name='nama' class='form-control' required='true'>
								<option value=''></option>
								<?php foreach ($mapel_ujian as $mapel) { ?> 
									<option value='<?= $mapel->kode_mapel ?>'><?= $mapel->nama_mapel ?></option>
								<?php } ?>
							</select>
						</div>
						<?php if ($setting['jenjang'] == 'SMK') : ?>
							<div class='form-group'>
								<label>Program Keahlian</label>
								<select name='id_pk' class='form-control' required='true'>
									<option value='semua'>Semua</option>
									<?php foreach ($pk as $pk1) { ?> 
										<option value='<?= $pk1->id_pk ?>'><?= $pk1->program_keahlian ?></option>
									<?php } ?>
								</select>
							</div>
						<?php endif; ?>
						<div class='form-group'>
							<div class='row'>
								<div class='col-md-6'>
									<label>Level Soal</label>
									<select name='level' id='level' class='form-control' required='true'>
										<option></option>
										<option value='semua'>Semua</option>
										<?php foreach ($level as $level1) { ?> 
											<option value='<?= $level1->kode_level ?>'><?= $level1->kode_level ?></option>
										<?php } ?>
									</select>
								</div>
								
								<div class='col-md-6'>
									<label>Pilih Kelas</label><br>
									<select name='kelas[]' id='kelas' class='form-control select2' multiple='multiple' style='width:100%' required='true'>
										
									</select>
								</div>
							</div>
						</div>
						<div class='form-group'>
							<div class='row'>
								<div class='col-md-12'>
									<label>Pilih Siswa</label><br>
									<select name='siswa[]'  id="siswa" class='form-control select2 ' style='width:100%' multiple >
										</select>
										<span style="color: red;">Jika Untuk Siswa Tertentu Pilih Program Keahli dan Level Pilih Semua, Kelas Pilih Khusus, Kemudia Silahkan Pilih Siswa, Bisa Ketik Langsung Namanya</span>
									</div>
								</div>
							</div>

							<div class='form-group'>
								<div class='row'>
									<div class='col-md-3'>
										<label>Jumlah Soal PG</label>
										<input type='number' id='soalpg' name='jml_soal' class='form-control' required='true' />
									</div>
									<div class='col-md-3'>
										<label>Bobot Soal PG %</label>
										<input type='number' name='bobot_pg' class='form-control' required='true' />
									</div>
									<div class='col-md-3'>
										<label>Soal Tampil</label>
										<input type='number' id='tampilpg' name='tampil_pg' class='form-control' required='true' />
									</div>
									<div class='col-md-3'>
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
									<div class='col-md-4'>
										<label>Jumlah Soal Essai</label>
										<input type='number' id='soalesai' name='jml_esai' class='form-control' required='true' />
									</div>
									<div class='col-md-4'>
										<label>Bobot Soal Essai %</label>
										<input type='number' name='bobot_esai' class='form-control' required='true' />
									</div>
									<div class='col-md-4'>
										<label>Soal Tampil</label>
										<input type='number' id='tampilesai' name='tampil_esai' class='form-control' required='true' />
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
	</section>
	<script type="text/javascript">
		let status_siswa=$('#daftar_soal').DataTable({
			"aLengthMenu": [[50,100,150,200,250,300,-1], [50,100,150,200,250,300,"All"]],
			"ajax": "<?= base_url('soal/v_daftar_soal_json'); ?>",
			processing: true,
			deferLoading:0,

		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#soalpg").keyup(function() {
				var pg  = $("#soalpg").val();
				$("#tampilpg").val(pg);
			});
			$("#soalesai").keyup(function() {
				var pg  = $("#soalesai").val();
				$("#tampilesai").val(pg);
			});
			$( ".hapus_banksoal" ).click( function(){
				var id  = $(this).data('id');
				var tanya = confirm("Apakah Yakin Akan Menghapus Soal Ini ?");
				if(tanya==true){
					$.ajax({
				  	url: '<?= base_url('soal/hapus_banksoal_id') ?>',
				  	type: 'post',
				  	data: {id:id},
				  	success: function(data) {
				  		if(data == 1){
				  			toastr.success('Bank Soal Berhasil Di Hapus','Berhasil');
				  			setInterval(function(){ window.location.reload(); }, 1000);
				  		}
				  		else{
				  			toastr.error('Gagal Hapus Bank Soal','Gagal');
				  		}
				  		console.log(data);
				  	}
			  	});
				}
				else{
					alert('error');
				}
			});
				
			$( "#tambah_bank_soal" ).submit(function( event ) {
			  event.preventDefault();
			  $.ajax({
			  	url: '<?= base_url('mapel_jadwal/add_bank_soal') ?>',
			  	type: 'post',
			  	data: $('#tambah_bank_soal').serialize(),
			  	success: function(data) {
			  		if(data == 1){
			  			toastr.success('Bank Soal Berhasil Di Tambah','Berhasil');
			  			setInterval(function(){ window.location.reload(); }, 1000);
			  		}
			  		else{
			  			toastr.error('Gagal Tambah Bank Soal','Gagal');
			  		}
			  		// console.log(data);
			  	}
			  });

			});
		});
	</script>
	<script type="text/javascript">
		$('#level').change(function(){
			var idlevel = $(this).val();
			var dataKelas = [];
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('soal/get_kelas_by') ?>",
				data: {idlevel:idlevel},
				success: function(data){
					$.each(JSON.parse(data), function(index, objek){

						var option1 = '<option value="'+objek+'">'+objek+'</option>';
						dataKelas.push(option1);
					});
					$('#kelas').empty();
					$('#kelas').append(dataKelas);
					//console.log(dataKelas);
				},

			});
		});
		$('#level').change(function(){
			var idlevel = $(this).val();
			var dataSiswa = [];
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('soal/get_siswa_by') ?>",
				data: {idlevel:idlevel},
				success: function(data){
					$.each(JSON.parse(data), function(index, objek){
						var option1 = '<option value="'+objek.id_siswa+'">'+objek.nama+'</option>';
						dataSiswa.push(option1);
					});
					$('#siswa').empty();
					$('#siswa').append(dataSiswa);
					//console.log(dataSiswa);
				},
				
			});
		});

	</script>
