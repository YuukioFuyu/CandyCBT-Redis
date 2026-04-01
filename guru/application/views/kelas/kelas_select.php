<div class="row">
	<div class="col-md-6">
		<select class="form-control select2 kelas" id="kelas" name="kelas">
			<option value=""> Pilih Kelas</option>
			<?php foreach ($v_kelas as $value) : ?>
				<option value="<?= $value->id_kelas ?>"><?= $value->nama ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
