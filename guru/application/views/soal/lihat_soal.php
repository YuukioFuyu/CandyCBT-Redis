<style type="text/css">
	.td_pg{
		padding: 1px;width: 2%; vertical-align: text-top;
		font-weight: bold;
	}
	.td_pg1{
		padding: 3px; vertical-align: text-top;
	}
	.soal1{
		padding: 0px;vertical-align: text-top;
	}
	.nomor1{
		width: 5px;
		padding: 0px;vertical-align: text-top;font-weight: bold;
	}
	hr {
		height: 2px;
		margin-left: 0px;
		margin-bottom:-3px;
	}
	.hr-warning{
		background-image: -webkit-linear-gradient(left, rgba(210,105,30,.8), rgba(210,105,30,.6), rgba(0,0,0,0));
	}
	.hr-success{
		background-image: -webkit-linear-gradient(left, rgba(15,157,88,.8), rgba(15, 157, 88,.6), rgba(0,0,0,0));
	}
	.hr-primary{
		background-image: -webkit-linear-gradient(left, rgba(66,133,244,.8), rgba(66, 133, 244,.6), rgba(0,0,0,0));
	}
	.hr-danger{
		background-image: -webkit-linear-gradient(left, rgba(244,67,54,.8), rgba(244,67,54,.6), rgba(0,0,0,0));
	}

	.breadcrumb {
		background: rgba(245, 245, 245, 0); 
		border: 0px solid rgba(245, 245, 245, 1); 
		border-radius: 25px; 
		display: block;
	}

	.btn-bread{
		margin-top:10px;
		font-size: 12px;

		border-radius: 3px;
	}
</style>
<div class='row'>
	<div class='col-md-12'>
		
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Tampil Soal</h3>
				<div class='box-tools pull-right btn-group'>
					
					<!-- <a  href="anso_excel.php?idmapel=<?= $id_mapel; ?>"  class='btn btn-sm btn-success' ><i class='fa fa-file-excel'></i> Excel</a> -->
					<a class='btn btn-sm btn-danger' onclick="window.history.back()"><i class='fa fa-times'></i> Keluar</a>
				</div>
			</div>
			<div class='box-body' id="tbsoal" >
				<div class='table-responsive'>
					<table class='table table-bordered table-hover table-striped' id="tb_soal">
						<tbody style="text-align:justify">
							<?php
							$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
							$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP'); 
							$no=1;
							foreach ($select_soal as $value) {
								//-------Load Gambar Soal-----------
								if ($value->file !="") { 
									$ext = explode(".", $value->file);
									$ext = end($ext);
									if (in_array($ext, $image)) {
										$gambar = "<p><img src='../../files/".$value->file."' class='img-responsive' style='max-width:150px;'/><p>";
									}
									elseif (in_array($ext, $audio)) {
										$gambar ="<p style='margin-bottom: 5px'><audio controls><source src='../../files/".$value->file."' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
									} 
									else { $gambar ="<b style='color:red'>File tidak didukung!</b>";}
								}
								else{
									$gambar="";
								}

								if ($value->file1 !="") { 
									$ext = explode(".", $value->file1);
									$ext = end($ext);
									if (in_array($ext, $image)) {
										$gambar2 = "<p><img src='../../files/".$value->file1."' class='img-responsive' style='max-width:150px;'/><p>";
									}
									elseif (in_array($ext, $audio)) {
										$gambar2 ="<p style='margin-bottom: 5px'><audio controls><source src='../../files/".$value->file1."' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
									} 
									else { $gambar2 ="<b style='color:red'>File tidak didukung!<b>";}
								}
								else{
									$gambar2="";
								}
							//------- end Load Gambar Soal-----------
							// ------ Load Gambar PG ---------------
								if($value->fileA !=""){ //Gambar PG A
									$filee=$value->fileA;
									$ext = explode(".", $filee);
									$ext = end($ext);
									if (in_array($ext, $image)) {
										$gambara = "<p><img src='../../files/".$filee."' class='img-responsive' style='max-width:150px;'/><p>";
									}
									elseif (in_array($ext, $audio)) {
										$gambara ="<p style='margin-bottom: 5px'><audio controls><source src='../../files/".$filee."' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
									} 
									else { $gambara ="<b style='color:red'>File tidak didukung!<b>";}
								}
								else{ $gambara="";}

								if($value->fileB !=""){ //Gambar PG B
									$filee=$value->fileB;
									$ext = explode(".", $filee);
									$ext = end($ext);
									if (in_array($ext, $image)) {
										$gambarb = "<p><img src='../../files/".$filee."' class='img-responsive' style='max-width:150px;'/><p>";
									}
									elseif (in_array($ext, $audio)) {
										$gambarb ="<p style='margin-bottom: 5px'><audio controls><source src='../../files/".$filee."' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
									} 
									else { $gambarb ="<b style='color:red'>File tidak didukung!<b>";}
								}else{ $gambarb="";}

								if($value->fileC !=""){ //Gambar PG C
									$filee=$value->fileC;
									$ext = explode(".", $filee);
									$ext = end($ext);
									if (in_array($ext, $image)) {
										$gambarc = "<p><img src='../../files/".$filee."' class='img-responsive' style='max-width:150px;'/><p>";
									}
									elseif (in_array($ext, $audio)) {
										$gambarc ="<p style='margin-bottom: 5px'><audio controls><source src='../../files/".$filee."' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
									} 
									else { $gambarc ="<b style='color:red'>File tidak didukung!<b>";}
								}else{ $gambarc="";}
								if($value->fileD !=""){ //Gambar PG D
									$filee=$value->fileD;
									$ext = explode(".", $filee);
									$ext = end($ext);
									if (in_array($ext, $image)) {
										$gambard = "<p><img src='../../files/".$filee."' class='img-responsive' style='max-width:150px;'/><p>";
									}
									elseif (in_array($ext, $audio)) {
										$gambard ="<p style='margin-bottom: 5px'><audio controls><source src='../../files/".$filee."' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
									} 
									else { $gambard ="<b style='color:red'>File tidak didukung!<b>";}
								}else{ $gambard="";}
								if($value->fileE !=""){ //Gambar PG E
									$filee=$value->fileE;
									$ext = explode(".", $filee);
									$ext = end($ext);
									if (in_array($ext, $image)) {
										$gambare = "<p><img src='../../files/".$filee."' class='img-responsive' style='max-width:150px;'/><p>";
									}
									elseif (in_array($ext, $audio)) {
										$gambare ="<p style='margin-bottom: 5px'><audio controls><source src='../../files/".$filee."' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
									} 
									else { $gambare ="<b style='color:red'>File tidak didukung!<b>";}
								}else{ $gambare="";}
							// ------ END Load Gambar PG ---------------
								?>
								<tr>
									<td class="nomor1"><?= $value->nomor ?></td>
									<td class="soal1"><?= $gambar ?><br /><p><?= $value->soal ?></p><br /><?= $gambar2; ?>
									<hr class="hr-primary" />
									<table >
										<tr>
											<td class="td_pg">A.</td>
											<td class="td_pg1">
												<?= $value->pilA ?>
												<?= $gambara ?>
											</td>
										</tr>
										<tr>
											<td class="td_pg">B.</td>
											<td class="td_pg1">
												<?= $value->pilB ?>
												<?= $gambarb ?>
											</td>
										</tr>
										<tr>
											<td class="td_pg">C.</td>
											<td class="td_pg1">
												<?= $value->pilC ?>
												<?= $gambarc ?>
											</td>
										</tr>
										<tr>
											<td class="td_pg">D.</td>
											<td class="td_pg1">
												<?= $value->pilD ?>
												<?= $gambard ?>
											</td>
										</tr>
										<tr>
											<td class="td_pg">E.</td>
											<td class="td_pg1">
												<?= $value->pilE ?>
												<?= $gambare ?>
											</td>
										</tr>
									</table>
									<table>
										<tr><td>Kunci Jawaban : <b style="color:red; font-size: 17px;"><?= $value->jawaban ?></b></td></tr>
									</table>

								</td>
								<td style='width:30px'>
									<button data-mapel="<?= $_GET['idmapel'] ?>" data-id="<?= $value->id_soal ?>" class='btn bg-maroon btn-sm hapus'><i class='fa fa-trash'></i></button>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div></div></div>
<script type="text/javascript">
	$(".hapus").click(function(){
		let id = $(this).data("id");
		let mapel = $(this).data("mapel");
		$.ajax({
			type: 'POST',
			url: '<?= base_url('soal/hapus_soal_id');?>',
			data: {id:id,mapel:mapel},
			success: function(response) {
				if(response ==1){ 
					window.location.reload();
				}
				else{
					alert("Gagal Hapus");
				}
			}
		});
	});

</script>
<script type="text/javascript">
	$(document).ready(function() {
		//toastr.success('The process has been saved.', );	
		<?php if($this->session->flashdata('success')){ ?>
			toastr.success("<?php echo $this->session->flashdata('success'); ?>",'Success');
		<?php } ?>
		setInterval(function(){ <?php unset($_SESSION['success']); ?> }, 3000);
	});


</script>