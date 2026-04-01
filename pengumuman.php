<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-bullhorn"></i> Pengumuman</h3>
      </div><!-- /.box-header -->
      <div class='box-body'>
        <div id='pengumuman'>
          <ul class='timeline'>
            <li class='time-label'><span class='bg-blue'>- Terbaru -</span></li>
            <?php
             foreach ($dbb->getPengumuman($_SESSION['id_kelas']) as $value){ 
              ?>
            <li><i class='fa fa-envelope bg-blue'></i>
              <div class='timeline-item'>
                <span class='time'> <i class='fa fa-calendar'></i> <?= buat_tanggal('d-m-Y', $value->date)?> <i class='fa fa-clock-o'></i> <?= buat_tanggal('h:i', $value->date) ?></span>
                <h3 class='timeline-header' style='background-color:#f9f0d5'><a class='$color' href='#'><?= $value->judul?></a> <small> <?= $value->nama ?></small></h3>
                <div class='timeline-body'>
                  <?= $value->text ?>
                </div>
              </div>
            </li>
            <?php } ?>
            
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>