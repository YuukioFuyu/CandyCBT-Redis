<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<?php if ($ac == '') : 
		$block = fetch($koneksi, 'tb_block');
	?>
	<div class='row'>
		<div class='col-md-3'></div>
		<div class='col-md-6'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Atur Informasi Block</h3>
					<div class='box-tools pull-right '>
						<button id="simpan_block" class='btn btn-sm btn-flat btn-primary' ><i class='fa fa-save'></i> Simpan</button>
					
						<a href='?pg=siswa' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					
					<div class='form-group'>
						<label> Judul </label>
								<input  value="<?= $block['judul_block']; ?>" type="text" id="judull" name="" class="form-control" placeholder="Judul Block">
					</div>
					<div class='form-group'>
						<label> Isi Pesan</label>
								<input  value="<?= $block['isi_block']; ?>" type="text" id="isi" name="" class="form-control" placeholder="isi block">
					</div>
					<div class='form-group'>
						<label>Footer</label>
								<input  value="<?= $block['footer_block']; ?>" type="text" id="footer" name="" class="form-control" placeholder="Footer Block">
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#simpan_block").click(function() {
				var a = $('#judull').val();
				var b = $('#isi').val();
				var c = $('#footer').val();
				var d = 'block';
				$.ajax({
					type: 'POST',
					url: 'simpanheader.php',
					data: 'judul='+a+'&isi='+b+'&footer='+c+'&aksi='+d,
					success: function(response) {
						location.reload();
						//alert(response);
					}
				});
			});
		});
	</script>
	
	<?php endif ?>