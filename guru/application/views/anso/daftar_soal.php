<section class='content' >
	<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid '>
				<div class='box-header with-border '>
					<h3 class='box-title'><i class='fa fa-briefcase'></i> Daftar Soal</h3>
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
</section>
<script type="text/javascript">
	let status_siswa=$('#daftar_soal').DataTable({
			"aLengthMenu": [[50,100,150,200,250,300,-1], [50,100,150,200,250,300,"All"]],
			"ajax": "<?= base_url('anso/v_daftar_soal_json'); ?>",
			processing: true,
			deferLoading:0,

		});
</script>
