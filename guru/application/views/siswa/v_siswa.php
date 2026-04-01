<section class='content' >
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-header with-border ">
					<h3 class="box-title"><i class="fas fa-user-friends fa-fw "></i> Peserta Ujian</h3>
					<div class="box-tools pull-right"></div>
				</div>
				<div class="box-body">
					<div class="row"  style="padding-bottom: 15px;">
						<div class="col-md-3">
						<select class="form-control select2 " id="kelas">
							<option value=""> Pilih Kelas</option>
							<?php foreach ($v_kelas as $value) : ?>
								<option value="<?= $value->id_kelas ?>"><?= $value->nama ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					</div>
					<div class="table-responsive">         
					  <table id="v_siswa" class="table table-hover table-bordered">
					    <thead>
					      <tr>
					      	<th>No</th>
					        <th>Nama</th>
					        <th>Level</th>
					        <th>Kelas</th>
					        <th>Jurusan</th>
					        <th>Sesi</th>
					        <th>Ruang</th>
					        <th>Username</th>
					        <th>Password</th>
					        <th>Server</th>
					      </tr>
					    </thead>
					    <tbody>
					     <!--  <?php $no=1; foreach ($v_siswa as $data) { ?>
					      	<tr>
					      		<td><?= $no++; ?></td>
					      		<td><?= $data->nama; ?></td>
					      		<td><?= $data->level; ?></td>
					      		<td><?= $data->id_kelas;?></td>
					      		<td><?= $data->idpk; ?></td>
					      		<td><?= $data->sesi; ?></td>
					      		<td><?= $data->ruang; ?></td>
					      		<td><?= $data->username; ?></td>
					      		<td><?= $data->password; ?></td>
					      		<td><?= $data->server; ?></td>
					      	</tr>
					      <?php } ?> -->
					    </tbody>
					  </table>
					</div>
				</div><!-- /.box-body -->
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready( function () {
		$('.select2').select2();
			$("#kelas").change(function(){
				var id =$(this).val();
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url('admin/siswa_json'); ?>',
					data:{idkls:id},
					dataType : 'json',
					success: function(data){
						var data2 = JSON.stringify(data);
						localStorage.setItem('datasiswa', data2);
						location.reload();
					}
				});
			});
			<?php /*-------Localstorage--------*/ ?>
			var dataSet;
			try{
				dataSet = JSON.parse(localStorage.getItem('datasiswa')) || [];
			} catch (err) {
				dataSet = [];
			}
			var dataSiswa = [];
			var no=1;
			$.each(dataSet, function(index, objek){
				var urut = no++;
				var option =
				'<tr><td>'+urut+
				'</td><td>'+objek.nama+'</td><td>'+objek.level+'</td><td>'+objek.id_kelas+'</td><td>'+objek.idpk+'</td><td>'+objek.sesi+'</td><td>'+objek.ruang+'</td><td>'+objek.username+'</td><td>'+objek.password+'</td><td>'+objek.server+'</td></tr>';
				dataSiswa.push(option);
			});
			$('#v_siswa').append(dataSiswa);
			$('#v_siswa').DataTable();
			<?php /*-------Localstorage--------*/ ?>
		
} );
</script>