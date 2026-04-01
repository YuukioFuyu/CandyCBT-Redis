<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');

?>
<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid '>
				<div class='box-header with-border '>
					<h3 class='box-title'><i class='fa fa-briefcase'></i> Tahun Absensi</h3>
					
				</div><!-- /.box-header style="display: none;"-->
				<div class='box-body'>
					<div id="tambahtahun" style="display: none;">
						<button id="back" class="btn btn-default mb-5" ><i class="fas fa-arrow-left"></i> Kembali</button>
					<legend>Tamabah Tahun</legend>
					<form id='formjawaban'>
					  <div class="form-group">
					    <label for="email">KODE TAHUN</label>
					    <input placeholder="2021" type='text' name='kodetahun' class='form-control' required='true' />
					  </div>
					  <div class="form-group">
					    <label for="pwd">NAMA TAHUN</label>
					    <input placeholder="2021" type='text' name='namatahun' class='form-control' required='true' />
					  </div>
					  <button class="btn btn-info"><i class="fa fa-paper-plane"></i> Simpan</button>
					</form>
					</div>
					<div id="tabeltahun" style="padding-top: 10px;">
						<button id="add" class="btn btn-primary" ><i class="fa fa-plus"></i> Tambah Tahun</button>
						<div class="table-responsive" style="padding-top: 10px;">
						  <table id='tableabsen' class='table table-bordered table-striped'>
						  	<thead>
						      <tr>
						      	<th>#</th>
						        <th>KODE TAHUN</th>
						        <th>NAMA TAHUN</th>
						        <th>STATUS</th>
						        <th>AKSI</th>
						      </tr>
						    </thead>
						    <tbody>
						    	<?php 
						    	$no=1;
						    	foreach($db->getTahun2() as $value) { ?>
						      <tr>
						        <td><?= $no++; ?></td>
						        <td><?= $value['thKode']; ?></td>
						        <td><?= $value['thNama']; ?></td>
						        <td>
						        	<?php
						        	if($value['thAktif']==1){
						        		echo'<span class="label label-primary">Aktif</span>';
						        	}
						        	else{
						        		echo'<span class="label label-danger">Tidak Aktif</span>';
						        	} 
						        	?>
						        </td>
						        <td>
						        	<button 
						        	data-kode="<?= $value['thKode']; ?>"
						        	data-status="<?= $value['thAktif']; ?>"
						        	data-nama="<?= $value['thNama']; ?>"
						        	data-id="<?= $value['thId']; ?>"
						        	data-toggle="modal" data-target="#myModal"
						        	class="btn btn-sm btn-primary edittahun" ><i class="fa fa-edit"></i></button>
						        	<button class="btn btn-sm btn-danger hapustahun" data-id="<?= $value['thId']; ?>"><i class="fa fa-trash"></i></button>
						        </td>
						      </tr>
						     	<?php } ?>
						  </table>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Tahun</h4>
      </div>
      <div class="modal-body">
        <form id="formtugas2">
          <div class='form-group'>
              <label>KODE TAHUN</label>
              <input id="kode" type='text' name='kode' style="width: 300px" class='form-control'  required='true' />
          </div>
            <div class='form-group'>
              <input id="id" type='hidden' name='id' class='form-control' required='true' />
              <label>NAMA TAHUN</label>
              <input id="nama" type='text' name='nama' style="width: 300px" class='timer form-control' autocomplete='off' required='true' />
          </div>
           <div class='form-group'>
              <label>STATUS</label><br>
           	 <select id="status" name="status" class="form-control select2" style="width: 300px" required>
           	 	<option>Pilih Status</option>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
           	 </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          
        </form>
      </div>
    </div>  
  </div>
</div>
<script type="text/javascript">
	$('.edittahun').click(function() {
		var id = $(this).data('id');
		var nama = $(this).data('nama');
		var kode = $(this).data('kode');
		var status = $(this).data('status');
		$('#id').val(id);
		$('#kode').val(kode);
		$('#nama').val(nama);
		$('#status').val(status).change();
	});
$('#tableabsen').dataTable();
$(document).on('click', '#add', function() {
  $('#tambahtahun').removeAttr("style")
  $("#tabeltahun").css("display","none");
  $("#tabeltahun").css("display","none");
  
});
$(document).on('click', '#back', function() {
  $('#tabeltahun').removeAttr("style")
  $("#tambahtahun").css("display","none");
  $("#tambahtahun").css("display","none");
  
});
$('#formjawaban').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
      $.ajax({
        type: 'POST',
        url: 'c_aksi.php?absen=tahunabsen',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);
          if (data == 1) {
            toastr.success("Berhasil Tambah Tahun");
            setTimeout(function () { location.reload(1); }, 1000);
          } 
          else {
            toastr.error("Upss Gagal");
          }
       	}
      });
      //return false;
    });
$('#formtugas2').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: 'c_aksi.php?absen=updatetahun',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Update Tahun');
              setTimeout(function () { location.reload(1); }, 1000);
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
        return false;
    });
$('.hapustahun').click(function() {
      var id = $(this).data('id');
      if (confirm("Yakin Akan Di Hapus Ini Tahun Ini ? ")) {
      $.ajax({
          type: 'POST',
           url: 'c_aksi.php?absen=deletetahun',
          data: {id:id},
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Hapus Tahun');
              setTimeout(function () { location.reload(1); }, 1000);
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
      }
    });
</script>
	