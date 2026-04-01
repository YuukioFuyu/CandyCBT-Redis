
<?php

$post = $_POST;
// print_r($post);
?>
<div class="row">
	<div class="col-md-12">
		<div class='form-group'>
			<div class='row' style="padding-bottom: 20px;">
				<input type="hidden" id="id_siswa" name="" class="form-control" value="<?= $post['id']?>">
				<input type="hidden" id="id_mapel" name="" class="form-control" value="<?= $post['id_mapel']?>">
				<input type="hidden" id="id_nilai" name="" class="form-control" value="<?= $post['id_nilai']?>">
				<div class='col-md-4'>
					<legend>Nilai PG</legend>
					<input type="number" id="pg" name="" class="form-control" value="<?= $post['skor']?>">
				</div>
				<div class='col-md-4'>
					<legend>Nilai ESAI</legend>
					<input type="number" id="esai" name="" class="form-control" value="<?= $post['esai']?>">
				</div>
				
				<div class='col-md-4'>
					<legend>Total Nilai</legend>
					<input type="number" id="total" name="" class="form-control" value="">
				</div>

			</div>
			<div class='row'>
				<div class='col-md-6'>
					<button id="edit_nilaii" class="btn btn-info"><i class="fa fa-save"></i>Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on("click", "#edit_nilaii", function(){
		var pg = $("#pg").val();
		var esai = $("#esai").val();

		var id_siswa = $("#id_siswa").val();
		var id_mapel = $("#id_mapel").val();
		var id_nilai = $("#id_nilai").val();
		
		$.ajax({
			type: 'POST',
			url: 'c_aksi.php?nilai=remidi',
			data: {pg:pg,esai:esai,id_mapel:id_mapel,id_siswa:id_siswa,id_nilai:id_nilai},
			success: function(data) {
				//alert(data);
				// console.log(data);
				if (data == 1) {
					toastr.success("Nilai Berhasil Di Ubah");
				} else {
					toastr.error("Gagal");
				}
				
				location.reload();
			}
		});

  });
	$(document).ready(function() {
		$("#pg, #esai").keyup(function() {
			var pg  = $("#pg").val();
			var esai = $("#esai").val();
			var total = parseInt(pg) + parseInt(esai);
			$("#total").val(total);
		});

	});
</script>