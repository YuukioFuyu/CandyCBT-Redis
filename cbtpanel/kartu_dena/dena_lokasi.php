<?php if ($ac == '') : ?>
	<div class='row'>
		<div class='col-md-3'></div>
		<div class='col-md-6'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Cetak Dena Lokasi Ujian</h3>
					<div class='box-tools pull-right '>
						<button class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult'].print()"><i class='fa fa-print'></i> Print</button>
						<a href='?pg=siswa' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<select class='select2 form-control' name="sesi" id="sesi" onchange=dena_lokasi();>
						<option value="">SESI</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
					<br><br>
					<select class='select2 form-control' name="ruang" id="ruang" onchange=dena_lokasi();>
						<option value="">Ruang</option>
						<option value="R1">R1</option>
						<option value="R2">R2</option>
						<option value="R3">R3</option>
						<option value="R4">R4</option>
					</select>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
	<iframe id='loaddena' name='frameresult' src='' style='border:none;width:1px;height:1px;'></iframe>
	<?php endif ?>