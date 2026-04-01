<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>

<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Siswa Tidak Mengikuti Ujian Per Mata Pelajaran</h3>
				<div class='box-tools pull-right '>
					<a href="?pg=status2" class='btn btn-sm  btn-success' ><i class='fas fa-users'></i> <span class='hidden-xs'>Status Peserta Ujian</span></a>
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<?= $info ?>
				<div class="row" style="padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
				<div class="col-md-3">
					<select class="form-control select2 jurusan">
						<?php $jurusan = $db->v_jurusan(); ?>
						<option value=""> Pilih Jurusan</option>
						<?php foreach ($jurusan as $jrs) : ?>
							<option <?php if($idjrs==$jrs['id_pk']){ echo "selected";}else{} ?> value="<?= $jrs['id_pk'] ?>"><?= $jrs['id_pk'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-md-3">
					<select class="form-control select2 kelas">
						<?php $kelas = $db->v_kelas(); ?>
						<option value=""> Pilih Kelas</option>
						<?php foreach ($kelas as $value) : ?>
							<option <?php if($idkls==$value['id_kelas']){ echo "selected";}else{} ?>  value="<?= $value['id_kelas'] ?>"><?= $value['nama'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<!-- <div class="col-md-3">
					<select class="form-control select2 ujian">
						<?php $ujian = $db->v_jadwal(); ?>
						<option> Pilih Jadwal</option>
						<?php foreach ($ujian as $uj) : ?>
							<option <?php if($id==$uj['id_mapel']){ echo "selected";}else{} ?> value="<?= $uj['id_mapel'] ?>"><?= $uj['nama'] ?></option>
						<?php endforeach; ?>
					</select>
				</div> -->
				<div class="col-md-3">
					<select class="form-control select2 ujian">
						<?php $ujian = $db->v_mata_pelajaran(); ?>
						<option> Pilih Mapel</option>
						<?php foreach ($ujian as $uj) : ?>
							<option  value="<?= $uj['kode_mapel'] ?>"><?= $uj['nama_mapel'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-md-3">
					<button id="cari_nilai" class="btn btn-info"><i class="fa fa-search"></i> Cari Data</button>
				</div>
			</div>
					<div id='tablereset' class='table-responsive'>
						<div id='tablereset' class='table-responsive'>
							<table id='tabel_noujian' class='table table-bordered table-striped'>
								<thead>
									<tr>
											<th>User Name</th>
											<th>Nama Peserta</th>
											<th>Kelas</th>
											<th>Sesi</th>
											<th>Ruang</th>
											<th>Server</th>
											<th>Agama</th>
											<th>Paket Soal</th>
											<th>Status Peserta</th>
											<th>Keterangan</th>
										</tr>
									</thead>
									<tbody id="tb_cek">
									
									</tbody>
								</table>
							</div>
						</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$(document).on('click','#btn_kelas',function(){ // tamabah id dana
				var nm=1;
			//alert(nm);

			$.ajax({
					//url:'koneksi/cekadm.php?adm=t_dana',
					url:'../config/c_admin.php?adm=sv_cek',
					data:'nm='+nm,
					type:'post',
					success: function(cek){
						alert(cek);//console.log(data);
					}
				});

		}); 

		}); 

		$(document).ready(function() {
			$(document).on('click','#cari_nilai',function(){
				var kelas = $('.kelas').val();
				var ujian = $('.ujian').val();
				var jrs = $('.jurusan').val();
				$.ajax({
					type: 'POST',
					url: 'c_aksi.php?adm=cek_siswa',
					data:{kelas:kelas,ujian:ujian,jrs:jrs},
					dataType : 'json',
					success: function(data){
						var data2 = JSON.stringify(data);
						localStorage.setItem('tidakujian', data2);
						location.reload();

					}
				});
			});
		});
		var dataSet;
		try{
			dataSet = JSON.parse(localStorage.getItem('tidakujian')) || [];
		} catch (err) {
			dataSet = [];
		}
		var dataMapel = [];
		$.each(dataSet, function(index, objek){
			if(objek.status==1){ var status="Belum Ujian" }
			var option = '<tr><td>'+objek.username+'</td><td>'+objek.nama_siswa+
			'</td><td>'+objek.kelas+'</td>'+
			'<td>'+objek.sesi+'</td>'
			+'<td>'+objek.ruang+'</td>'
			+'<td>'+objek.server+'</td>'
			+'<td>'+objek.agama+'</td>'
			+'<td>'+objek.paket+'</td>'
			+'<td>'+objek.statusSiswa+'</td>'
			+'<td><span class="label label-danger">'+status+'</span></td>'+
			+'</tr>';
			dataMapel.push(option);
		});
		$('#tabel_noujian').append(dataMapel);
		$('#tabel_noujian').dataTable({
			"lengthMenu": [[25, 50, -1], [25, 50, "All"]]
		});
	</script>		
