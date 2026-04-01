<!-- OPSI A -->
<tr>
  <td class="width_td">
    <label class="container">
      <input class="jawab" id="box-<?= $data->id_soal ?>-A" type="checkbox" value="A" name='jawab<?= $data->id_soal ?>' id='A'>
      <span class="checkmarkbox"></span>
    </label>
  </td>
  <td>
    <span class='soal'><?= $data->pilA ?></span>
    <?php $dataFileA = $data->fileA;
    if ($dataFileA <> '') :
      $ext = explode(".", $dataFileA);
      $ext = end($ext);
      if (in_array($ext, $image)) :
        echo "<a  data-id='$dataFileA' class='foto_click' href='#'' data-toggle='modal' data-target='#modalfoto' style='display:inline-block'><img src='$homeurl/files/$dataFileA' class='img-responsive' style='width:250px;'/></a>";
      elseif (in_array($ext, $audio)) :
        echo "<audio controls='controls' ><source src='$homeurl/files/$dataFileA' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
      else :
        echo "File tidak didukung!";
      endif;
    endif;
    ?>
  </td>
</tr>
<!-- OPSI B -->
<tr>
  <td class="width_td">
    <label class="container">
      <input class="jawab" id="box-<?= $data->id_soal ?>-B" type="checkbox" value="B" name='jawab<?= $data->id_soal ?>' id='B'>
      <span class="checkmarkbox"></span>
    </label>
  </td>
  <td>
    <span class='soal'><?= $data->pilB ?></span>
    <?php
    $dataFileB = $data->fileB;
    if ($dataFileB <> '') :
      $ext = explode(".", $dataFileB);
      $ext = end($ext);
      if (in_array($ext, $image)) :
        echo "<a  data-id='$dataFileB' class='foto_click' href='#'' data-toggle='modal' data-target='#modalfoto' style='display:inline-block'><img src='$homeurl/files/$dataFileB' class='img-responsive' style='width:250px;'/></a>";
      elseif (in_array($ext, $audio)) :
        echo "<audio controls='controls' ><source src='$homeurl/files/$dataFileB' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
      else :
        echo "File tidak didukung!";
      endif;
    endif;
    ?>
  </td>
</tr>
<!-- OPSI C -->
<tr>
  <td class="width_td">
    <label class="container">
      <input class="jawab" id="box-<?= $data->id_soal ?>-C" type="checkbox" value="C" name='jawab<?= $data->id_soal ?>' id='C'>
      <span class="checkmarkbox"></span>
    </label>
  </td>
  <td>
    <span class='soal'><?= $data->pilC ?></span>
    <?php
    $dataFileC = $data->fileC;
    if ($dataFileC <> '') :
      $ext = explode(".", $dataFileC);
      $ext = end($ext);
      if (in_array($ext, $image)) :
        echo "<a  data-id='$dataFileC' class='foto_click' href='#'' data-toggle='modal' data-target='#modalfoto' style='display:inline-block'><img src='$homeurl/files/$dataFileC' class='img-responsive' style='width:250px;'/></a>";
      elseif (in_array($ext, $audio)) :
        echo "<audio controls='controls' ><source src='$homeurl/files/$dataFileC' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
      else :
        echo "File tidak didukung!";
      endif;
    endif;
    ?>
  </td>
</tr>
<?php if ($opsi == 4 or $opsi == 5) { ?>
  <!-- OPSI D -->
  <tr>
    <td class="width_td">
      <label class="container">
        <input class="jawab" id="box-<?= $data->id_soal ?>-D" type="checkbox" value="D" name='jawab<?= $data->id_soal ?>' id='D'>
        <span class="checkmarkbox"></span>
      </label>
    </td>
    <td> <span class='soal'><?= $data->pilD ?></span>
      <?php
      $dataFileD = $data->fileD;
      if ($dataFileD <> '') :
        $ext = explode(".", $dataFileD);
        $ext = end($ext);
        if (in_array($ext, $image)) :
          echo "<a  data-id='$dataFileD' class='foto_click' href='#'' data-toggle='modal' data-target='#modalfoto' style='display:inline-block'><img src='$homeurl/files/$dataFileD' class='img-responsive' style='width:250px;'/></a>";
        elseif (in_array($ext, $audio)) :
          echo "<audio controls='controls' ><source src='$homeurl/files/$dataFileD' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
        else :
          echo "File tidak didukung!";
        endif;
      endif;
      ?>
    </td>
  </tr>
<?php }  ?>
<?php if ($opsi == 5) { ?>
  <!-- OPSI E -->
  <tr>
    <td class="width_td">
      <label class="container">
        <input class="jawab" id="box-<?= $data->id_soal ?>-E" type="checkbox" value="E" name='jawab<?= $data->id_soal ?>' id='E'>
        <span class="checkmarkbox"></span>
      </label>
    </td>
    <td> <span class='soal'><?= $data->pilE ?></span>
      <?php
      $dataFileE = $data->fileE;
      if ($dataFileE <> '') :
        $ext = explode(".", $dataFileE);
        $ext = end($ext);
        if (in_array($ext, $image)) :
          echo "<a  data-id='$dataFileE' class='foto_click' href='#'' data-toggle='modal' data-target='#modalfoto' style='display:inline-block'><img src='$homeurl/files/$dataFileE' class='img-responsive' style='width:250px;'/></a>";
        elseif (in_array($ext, $audio)) :
          echo "<audio controls='controls' ><source src='$homeurl/files/$dataFileE' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
        else :
          echo "File tidak didukung!";
        endif;
      endif;
      ?>
    </td>
  </tr>
<?php }  ?>

<script type="text/javascript">
  var cekbox = document.querySelectorAll('input[type=checkbox][name="jawab<?= $data->id_soal ?>"]');

  function changeHandler(event) {
    var checked = this.checked;
    var opsi = this.value;
    //console.log(opsi);

    var id_soal = $("#id_soal<?= $data->id_soal ?>").val();
    var id_mapel = $("#id_mapel").val();
    var id_siswa = $("#id_siswa").val();
    var id_ujian = $("#id_ujian").val();
    var jenis_soal = $("#jenis_soal<?= $data->id_soal ?>").val();
    var no_urut = $("#no_urut").val();
    var jwb = getPanjang('jwbs');
    var jwbs = get('jwbs');
    var jawaban = [];
    var jawaban1 = [];
    var array_jawab = [];

    if (checked == true) {
      if (jwb > 0) {
        var arr_r =opsi;
        array_jawab.push(arr_r);
        $.each(jwbs, function(index, obj) { //load jawaban dari localstorage
          if (obj.idsoal == id_soal) {
            $.each(obj.jawaban, function(index, objek) {
              // console.log();
              var arr = objek;
              array_jawab.push(arr);
            });
          }
          else{
            var arr1 = obj;
                    jawaban1.push(arr1);
          }

        });
        //console.log(array_jawab);
        var arr = [{"idsoal": id_soal,"no_urut": no_urut,"jawaban": array_jawab,"status": 0,"idsiswa": id_siswa,
          "idmapel": id_mapel,"idujian": id_ujian,"jenissoal": jenis_soal}];
        var angkaBaru = jawaban1.concat(arr);
        localStorage.setItem('jwbs', JSON.stringify(angkaBaru));
      } else {
        //jika jawban tidak ada di localstorage
        array_jawab = [opsi];
        var arr = {"idsoal": id_soal,"no_urut": no_urut,"jawaban": array_jawab,"status": 0,"idsiswa": id_siswa,
          "idmapel": id_mapel,"idujian": id_ujian,"jenissoal": jenis_soal};
        jawaban.push(arr);
        localStorage.setItem('jwbs', JSON.stringify(jawaban));
      }
    } else {
      $.each(jwbs, function(index, obj) { //load jawaban dari localstorage
        if (obj.idsoal == id_soal) {
          // const indexnya = obj.jawaban.findIndex(jawabnya => jawabnya === opsi);
          // obj.jawaban.splice(obj, indexnya);
          // //console.log(obj.jawaban);
          // array_jawab = obj.jawaban;
          $.each(obj.jawaban, function(index, objek) {
            if(objek != opsi){
              var arr = objek;
              array_jawab.push(arr);
            }
          });
          
        }
        else{
          var arr1 = obj;
                  jawaban1.push(arr1);
        }

      });
      //console.log(array_jawab);

      var arr = {"idsoal": id_soal,"no_urut": no_urut,"jawaban": array_jawab,"status": 0,"idsiswa": id_siswa,
          "idmapel": id_mapel,"idujian": id_ujian,"jenissoal": jenis_soal};
          var angkaBaru = jawaban1.concat(arr);
      
      localStorage.setItem('jwbs', JSON.stringify(angkaBaru));
      
    }

  }
  Array.prototype.forEach.call(cekbox, function(box) {
    box.addEventListener('click', changeHandler);

  });

  <?php //-------load jawaban saat refres atau ganti soal ---------------- ?>
    var jawabox = JSON.parse(localStorage.getItem("jwbs"));
        var idsoalbox = "<?= $data->id_soal ?>";
    $.each(jawabox, function(index, obj){
      if(idsoalbox == obj.idsoal){
        $.each(obj.jawaban, function(index, objek) {
          $("#box-"+obj.idsoal+"-"+objek).prop("checked",true);
        });
      }
    });
  <?php //-------load jawaban saat refres atau ganti soal ---------------- ?>
</script>