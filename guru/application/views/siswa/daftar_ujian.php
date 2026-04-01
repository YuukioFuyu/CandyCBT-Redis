<section class='content' >
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-header with-border ">
					<h3 class="box-title"><i class="fas fa-user-friends fa-fw "></i>Download Nilai Ujian</h3>
					<div class="box-tools pull-right"></div>
				</div>
				<div class="box-body">
					<div class="table-responsive">         
					  <table id="v_siswa" class="table table-hover table-bordered">
					    <thead>
					      <tr>
					      	<th>No</th>
					      	<th>Nama Mapel</th>
					      	<th>Download Nilai Per Mapel</th>
					      </tr>
					    </thead>
					    <tbody>
					    	<?php $no=1; foreach ($get_ujian as $data) { ?>
					    		<tr>
					    			<td><?= $no++; ?></td>
					    			<td><?= $data->nama ?></td>
					    			<td><a href="<?php echo base_url('export_excel/excel_nilai/'.encrypt_url($data->id_ujian).'') ?>" class="btn btn-info"><i class="fa fa-download"></i> Download </a></td>
					    		</tr>
					 			<?php }?>
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
    $('#v_siswa').DataTable();
} );
</script>