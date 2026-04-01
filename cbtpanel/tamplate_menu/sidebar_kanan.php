<!-- slide menu -->
<div class='navs-slide' style='z-index: 1000;'>
			<!-- <div class='btn-slide' style="color:#0520e2;" >
				<i class="fa fa-cog fa-lg "></i><img class="fas fa-edit fa-fw fa-lg "> 
			</div>-->
			<div class="btn-slide" style="color:white;" ></div>
			<div class='navs-body'>
				<div class='head-slide' style="background-color: #0d7fa0;">Menu ^_^</div>
				<div class='body-slide'>
					<div  id="popup_pg"  style='overflow-y:auto; max-height:250px'>
						<?php if($_SESSION['level']=="admin"){ ?>
						<div class="row" style="padding-left: 20px; padding-bottom: 20px;">
							<div class='col-md-12'>
								<span>Yakin Ingin Hapus Tabel Histori Jawaban</span><br>
								<button id="hapus_history" class="btn btn-danger">Hapus History Jawaban</button>
							</div>
						</div>
						<?php } ?>
						<label style="padding-left: 20px;">Tombol Menu</label>
						<div class="row">
							<div class='col-md-12'>
								<ul class='nav navbar-nav'>
									<?php if($_SESSION['level']=="admin"){ ?>
									<li><a href='prober.php' target='blank'><img src='../dist/img/svg/statistics.svg' width='20'> &nbsp; System</a></li>
									<li><a href='phpinfo.php' target='blank'><img src='../dist/img/svg/info.svg' width='20'> &nbsp; Info PHP</a></li>
									<?php } ?>
									<li><a href='?pg=informasi'><i class="fas fa-comment-dots fa-lg  "></i> &nbsp; Info Candy</a></li>
								</ul>
							</div>
						</div>

						<!-- <label style="padding-left: 20px;">Status Koneksi Cache Redis</label>
						<div class="row" style="padding-left: 20px;">
							<div class='col-md-12' >
								<?php 
								// try {
								// 	    $Redis->ping();
								// 	    echo('<span class="label label-success" style="font-size:15px;">Server Cache Redis Sudah Aktif</span>');
								// 	} catch (Exception $e) {
								// 	    if($e->getMessage()){
								// 	      echo('<span class="label label-danger" style="font-size:15px;">Server Cache Redis Tidak Aktif</span>');
								// 	    }
								// 	} 

								?>
								<br><br>
								<i style="padding-top: 2px;" class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Jika Cache Redis tidak Aktif, Cek Apakah Penyedia Hosting menyediakan Cache Redis dan Server Redis Sudah Aktif. Jika Offline Cek Server Cache Redis Apakah Sudah Aktif "></i>
							</div>
						</div> -->
						<br><br>
					</div>
				</div>
			</div>
		</div>