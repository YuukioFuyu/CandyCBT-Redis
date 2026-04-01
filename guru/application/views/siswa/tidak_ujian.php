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
						<div class="col-md-3" style="margin-bottom: 5px;">
						<select class="form-control select2 " id="kelas">
							<option value=""> Pilih Kelas</option>
							<?php foreach ($get_kelas as $value) : ?>
								<option value="<?= encrypt_url($value->id_kelas); ?>"><?= $value->nama ?></option>
							<?php endforeach; ?>
						</select>
						</div>
						<div class="col-md-3" style="margin-bottom: 5px;">
						<select class="form-control select2 " id="mapel">
							<option value=""> Pilih Mapel</option>
							<?php foreach ($get_ujian as $value) : ?>
								<option value="<?= encrypt_url($value->id_ujian); ?>"><?= $value->nama ?></option>
							<?php endforeach; ?>
						</select>
						</div>
						<div class="col-md-3">
							<button id="cari" class="btn btn-info">Cari Data</button>
						</div>
					</div>
					<div class="table-responsive">         
					  <table id="v_siswa" class="table table-hover table-bordered">
					    <thead>
					      <tr>
					      	<th>User Name</th>
											<th>Nama Siswa</th>
											<th>Kelas</th>
											<th>Jurusan</th>
											<th>Status</th>
					      </tr>
					    </thead>
					    <tbody id="data_no">
					     
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
  $("#cari").click(function(){
		var ujian = $('#mapel').val();
		var kelas = $('#kelas').val();
		var rout = '<?php echo base_url('admin/cek_siswa_noujian'); ?>';
		$.ajax({
			type: 'POST',
			url: rout,
			data:{kelas:kelas,ujian:ujian},
			dataType : 'json',
			success: function(data){
				var data2 = JSON.stringify(data);
				localStorage.setItem('tidakujian', data2);
				location.reload();
				//console.log(objek);
			}
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
  	if(objek.status==1){ var status="Tidak Ikut Ujian" }
  		var option = '<tr><td>'+objek.username+'</td><td>'+objek.nama_siswa+'</td><td>'+objek.kelas+'</td><td>'+objek.jurusan+'</td><td><span class="label label-danger">'+status+'</span></td></tr>';
  	dataMapel.push(option);

  });
  $('#v_siswa').append(dataMapel);
  $('#v_siswa').DataTable({
  	"lengthMenu": [[25, 50, -1], [25, 50, "All"]]
  });
  
	
});
</script>