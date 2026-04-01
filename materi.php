    <style type="text/css">
      .clear {
    clear:both;    
}
.btn-info {
    margin-right:15px;
    text-transform:uppercase;
    padding:10px;
    display:block;
    float:left;
}
.btn-info a {
    display:block;
    text-decoration:none;
    width:100%;
    height:100%;
    color:#fff;
}
.more.label {
    float:right;    
}
    </style>
<?php
if($_GET['pg']==''){ ?>
<div class='row'>
  <div class="col-md-12"> 
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit"></i>Materi</h3>
      </div>
      <div class='box-body'>
        <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active">
          Silahkan Piih Mata Pelajaran 
        </a>
        <?php
        $guru_materi = $dbb->getMapelList($level);
        $no=1;
        $level2 = enkripsi($level);
        foreach ($guru_materi as $value) { 
          $jml = $dbb->get_materi_count($_SESSION['id_kelas'],$level, $value['kode_mapel']);
          $idmapel = enkripsi($value['kode_mapel']);
          if($jml['total_materi'] > 0){
        ?>
		      <a href="?pg=guru&level=<?= $level2; ?>&idmapel=<?= $idmapel; ?>&page=1" class="list-group-item list-group-item-action"><?= $value['nama_mapel']; ?> <?= $value['kodelevel']; ?><span class="badge " style="background-color:#3c8dbc"> <?= $jml['total_materi'] ?> Materi
        	</span></a>
		      <?php 
		    	}
          else{

          }
          }?>
        </div>
      </div>
        
    </div>
  </div>
</div>

<?php
}
elseif ($_GET['pg']=='guru') { ?>
<div class='row'>
  <div class="col-md-12"> 
    <?php
    $getguru =$_GET['id'];
    $getlevel =$_GET['level'];
    $getidmapel =$_GET['idmapel'];

    $guru = dekripsi($getguru);
    $level3 = dekripsi($getlevel);
    $idmapel3 = dekripsi($getidmapel); //Kode Mapel
    
    $halaman = $dbb->halaman(); //2
    $mulai= $dbb->mulai($halaman); //0
    $artikel = $dbb->get_materi($mulai,$halaman,$_SESSION['id_kelas'],$guru, $level3,$idmapel3);
    ?>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit"></i>Materi &nbsp; <a class="btn btn-primary" href="<?= $homeurl ?>/materi/"><i class="fas fa-arrow-left"></i> Kembali Pilih Mapel </a> 
        </h3>
      </div>
      <div class='box-body'>
        <?php
        //$no=$mulai+1;
        foreach ($artikel as $value) {
          $idguruu = enkripsi($value['id_guru']);
          $idmaterii = enkripsi($value['materi2_id']);
          $materi2_mapel = enkripsi($value['materi2_mapel']);
          $kodelv = enkripsi($value['kodelv']);
        ?>
        <div class="span8">
          <h3><?= $value['materi2_judul']; ?></h3>
          <p><?= date('d-m-Y H:s',strtotime($value['materi2_tgl'])); ?></p>
          <p>Mapel <?= $value['nama_mapel']; ?></p>
          <div>
            <!-- <div class="more label"><a href="<?= $homeurl ?>/materi/?pg=baca&idmateri=<?= $value['materi2_id']?>">Read more</a></div>  -->
            <div class="tags">
              <?php  if($value['materi2_file']==null or $value['materi2_file']==""){ }
              else{ ?>
                <span style="background-color: #20B2AA;"  class="btn-info"><a class="viewer" data-id="<?= $value['materi2_id']; ?>" data-jenis="2" href="<?= $homeurl ?>/guru/berkas2/<?= $value['id_guru'] ?>/<?= $value['materi2_file'] ?>" download ><i class="fa fa-download"></i> Unduh File</a></span>
              <?php }?>
                <span class="btn-info"><a class="viewer" data-id="<?= $value['materi2_id']; ?>" data-jenis="1" href="<?= $homeurl ?>/materi/?pg=baca&id=<?= $idguruu; ?>&idmateri=<?= $idmaterii?>"><i class="fa fa-book"></i> Baca Materi</a></span>
              <?php
              //jika link google drive tidak kosong
              if ($value['url_gdrive'] !=null or $value['url_gdrive'] !=""): ?>
                <a class="btn btn-success" target="_blank" href="<?= $value[url_gdrive] ?>" ><i class="fa fa-link"></i> Link Materi</a>
              <?php endif?>

              <?php if(!empty($value['url_embed']) or !empty($value['url_youtube'])){ ?>
                <span style="background-color: #000080;" class="btn-info"><a class="viewer" data-id="<?= $value['materi2_id']; ?>" data-jenis="3" href="<?= $homeurl ?>/materi/?pg=video&id=<?= $idguruu; ?>&idvideo=<?= $idmaterii?>"><i class="fa fa-play"></i> Video</a></span>
              <?php }?>
            </div>    
          </div> 
        <div class="clear"></div>

        <hr/>
        
        </div>
        <?php }?>
      </div>
        <div class="text-center">
         <ul class="pagination">
          <?php 
          $pangging = $dbb->paging($halaman, dekripsi($materi2_mapel),dekripsi($kodelv));
          for ($i=1; $i<=$pangging ; $i++){ 
            if($_GET["page"] == $i){ $aktif = 'class="active"';}else{ $aktif =''; }
          ?>
            <li <?= $aktif; ?>><a  href="?pg=guru&idmapel=<?= $materi2_mapel ?>&level=<?= $kodelv ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
          <?php } ?>
         </ul>
        </div>
    </div>
  </div>
</div>

<?php
}
elseif($_GET['pg']=='baca'){ ?>
<div class='row'>
  <div class='col-md-12' >
    <div class='box box-solid' id="box-baca">
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit "></i> Membaca Materi</h3>
      </div>
      <div class='box-body' >
        <div class="row"> 
          <div class="col-md-4">
            <!-- <a href="<?= $homeurl ?>/materi/" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a> -->
            <a class="btn btn-default" href = "javascript:history.back()"><i class="fas fa-arrow-left"></i> Kembali Pilih Materi</a>
            <div class="row">
              <div class="col-md-12">
                <div class="theme-switch-wrapper">
                  <label class="theme-switch" for="checkbox">
                    <input type="checkbox" id="checkbox" />
                    <div class="slider round"></div>
                  </label>
                  <em id="modeag">Aktifkan Dark Mode atau Mode Terang!</em>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row" style="padding-right: 0px; padding-left: 0px;"> 
          <div class="col-md-12" >
          <?php  
            $da2=$dbb->baca_materi();
             foreach ($da2 as $value) { ?>
              <h2 style="color: #3c8dbc;" ><?= $value->materi2_judul; ?></h2>
              <hr>
              <p class="text-justify" >
                <?= $value->materi2_isi; ?>
              </p>
              <hr>
              <br>
              <blockquote class="blockquote">
                <p class="mb-0"><?= $value->nama_mapel; ?> </p>
                <footer class="blockquote-footer"><?= $value->materi2_tgl; ?>
                <cite title="Source Title">&nbsp;&nbsp;<?= $value->nama; ?></cite></footer>
              </blockquote>
            <?php  } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <a class="btn btn-success" href = "javascript:history.back()"><i class="fas fa-arrow-left"></i> Kembali Pilih Materi</a>
            <!-- <?php 
            $next = $_GET['idmateri']+1;
            $prev = $_GET['idmateri']-1;
            $next2=$dbb->next_materi();
            $prev2=$dbb->prev_materi();
            ?>
            <?php if($_GET['idmateri'] == $prev2['min']){ }else{ ?>
            <a href="<?= $homeurl ?>/materi/?pg=baca&idmateri=<?= $prev ?>" class="btn btn-primary pull-left"><i class="fas fa-arrow-left"></i> Previous </a>
            <?php } ?>
            <?php if($_GET['idmateri'] == $next2['max']){ }else{ ?>
            <a href="<?= $homeurl ?>/materi/?pg=baca&idmateri=<?= $next ?>" class="btn btn-primary pull-right"> NEXT <i class="fas fa-arrow-right"></i></a>
            <?php }  ?> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    //Agar Video Summoner editor responsif
        jQuery('.note-video-clip').each(function(){
            var tmp = jQuery(this).wrap('<p/>').parent().html();
            jQuery(this).parent().html('<div class="embed-responsive embed-responsive-16by9">'+tmp+'</div>');
          });
    var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
    function switchTheme(e) {
      if (e.target.checked) {
        localStorage.setItem('theme',1); 
        $("#box-baca").css("background-color","rgb(53, 54, 58)");
        $("#box-baca").css("color","rgb(232, 234, 237)");
      }
      else {
        localStorage.setItem('theme',0); 
        $("#box-baca").css("background-color","#ffffff");
        $("#box-baca").css("color","black");
      }    
    }
    toggleSwitch.addEventListener('change', switchTheme, false);

    var get_thema = localStorage.getItem('theme');
    if (get_thema==1) {
      toggleSwitch.checked = true;
      $("#box-baca").css("background-color","rgb(53, 54, 58)");
      $("#box-baca").css("color","rgb(232, 234, 237)");

    }
    else {
      $("#box-baca").css("background-color","#ffffff");
      $("#box-baca").css("color","black");
      toggleSwitch.checked = false;
    }   
  });
</script>
<?php }
elseif($_GET['pg']=='video'){ ?>
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit"></i> Video Materi</h3>
      </div>
      <div class='box-body'>
        <div class="row" style="padding-bottom: 20px;"> 
          <div class="col-md-4">
            <a href="<?= $homeurl ?>/materi/" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <?php $getguru =$_GET['id']; 
            $da3=$dbb->video_materi($getguru);
           if ($da3['url_youtube'] !=null or $da3['url_youtube'] !="") { ?>
           <a class="btn btn-primary" target="_blank" href="<?= $da3[url_youtube] ?>" >Klik Link Video Materi</a>
           <br>
           <?php }
            if ($da3['url_gdrive'] !=null or $da3['url_gdrive'] !="") { ?>
            <a class="btn btn-success" target="_blank" href="<?= $da3[url_gdrive] ?>" >Klik Link Google Drive Materi</a>
            <br>
            <?php  } 
            if($da3['url_embed'] !=null or $da3['url_embed'] !=""){
            ?>
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?= $da3[url_embed] ?>?rel=0" allowfullscreen></iframe>
            </div>
           <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
}
else{

}
?>
<script type="text/javascript">
  $(document).ready( function () {
    $('#tb_materi').DataTable({
      "pageLength": 25
    });
    $(document).on('click', '.viewer', function() {
      let id = $(this).data('id');
      let jenis = $(this).data('jenis');
      let idsiswa = '<?= $_SESSION['id_siswa']; ?>';

      $.ajax({
        type: 'POST',
        url:'../c_jawaban.php?materi=viewer',
        data: {
          idmateri:id,jenis:jenis,idsiswa:idsiswa,
        },
        success: function(response) {
          console.log(response);
        }
      });
    });
  });
</script>