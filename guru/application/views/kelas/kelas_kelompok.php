
<select name='k_kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
	<option value='semua'>Semua</option>
	<?php foreach ($v_kelas as $value) : ?>
		<option value="<?= $value->id_kelas ?>"><?= $value->nama ?></option>
	<?php endforeach; ?>
</select>
