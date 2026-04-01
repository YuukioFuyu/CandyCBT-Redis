<section class='content' >
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-header with-border ">
					<h3 class="box-title"><i class="fas fa-user-friends fa-fw "></i> Status Peserta Ujian</h3>
					<div class="box-tools pull-right"></div>
				</div>
				<div class="box-body">
					<div class="row"  style="padding-bottom: 15px;">
						<div class="col-md-3">
							Pilih Kelas Dulu
						<select class="form-control select2 " id="kelas">
							<option value=""> Pilih Kelas</option>
							<?php foreach ($v_kelas as $value) : ?>
								<option value="<?= encrypt_url($value->id_kelas); ?>"><?= $value->nama ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					</div>
					<div class='row'>
							<div class='col-md-12'>
								<div class='box box-solid'>
									<div class='box-header with-border'>
										<h3 class='box-title'>Status Peserta </h3>
										<div class='box-tools pull-right '>
										</div>
									</div><!-- /.box-header -->
									<div class='modal fade' id='infostatus' style='display: none;'>
										<div class='modal-dialog'>
											<div class='modal-content'>
												<div class='modal-header bg-maroon'>
													<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
													<h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Infromasi Status Peserta</h4>
												</div>
											</div>
										</div>
									</div>
									<div class='box-body'>
										<div style="padding-bottom: 10px;"><button class="btn btn-info" onclick="location.reload();"><i class="fa fa-spinner fa-spin "></i> Klik Untuk Refres</button></div>
										<div class='table-responsive'>
											<table id='tablestatus2' class='table table-bordered table-striped'>
												<thead>
													<tr>
														<th width='5px'>No</th>
														<th>STATUS</th>
														<th>Nama</th>
														<th>Kelas</th>
														<th>Lama Ujian</th>
														<th width="200">Mapel</th>
														<th>Jawaban</th>
														<th>Nilai</th>
														<th>Ip Address</th>
														<th>NIS</th>
													</tr>
												</thead>
												<tbody id='divstatus2'>
												</tbody>
											</table>
										</div>
										<div style="padding-top: 10px;"><button class="btn btn-info" onclick="location.reload();"><i class="fa fa-spinner fa-spin "></i> Klik Untuk Refres</button></div>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
						</div>
				</div><!-- /.box-body -->
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$("#kelas").change(function(){
		var id =$(this).val();
		location.replace("?idkelas="+id);
	});
	let status_siswa=$('#tablestatus2').DataTable({
			"aLengthMenu": [[50,100,150,200,250,300,-1], [50,100,150,200,250,300,"All"]],
			"ajax": "<?= base_url('status_peserta?idkelas='.$_GET[idkelas])?>",
			processing: true,
			deferLoading:0,

		});

	// setInterval(function() {
	// 		status_siswa.ajax.reload(null, false);
	// 	}, 1000);
</script>
