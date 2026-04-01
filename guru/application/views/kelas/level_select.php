<div class="row">
	<div class="col-md-3">
		<select class="form-control select2 level" id="level" name="level">
			<option value=""> Pilih Kelas</option>
			<?php foreach ($v_level as $value) : ?>
				<option value="<?= $value->kode_level ?>"><?= $value->kode_level ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
