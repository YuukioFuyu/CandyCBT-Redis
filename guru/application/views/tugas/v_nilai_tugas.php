<div class='row'>
  <div class='col-md-12'>
    <div id="info">
    <?php $this->load->view('thema/pesan_data.php'); ?>
    </div>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'> Daftar Jawaban Siswa</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body' id="tablejawaban">
        <div class="row" style="margin-bottom: 10px;">
          <div class="col-md-12 ">
            <?php $id=$_GET['aksi']; ?>
          <a href="tugas" class="btn btn-warning mb-5" style="margin-bottom: 5px;"><i class="fas fa-arrow-left"></i> Kembali</a>
          <a style="margin-bottom: 5px;" href="<?= base_url('export_excel/excel_nilai_tugas/'.$id);?>" class="btn btn-primary mb-5"><i class="fa fa fa-download"></i> Download Nilai Excel</a>
          <a onclick="return confirm('Apakah Kamu Yakin Akan Menghapus Nilai ini ?');" style="margin-bottom: 5px;" href="<?= base_url('admin/h_nilai_tugas/'.$id);?>" class="btn btn-danger mb-5"><i class="fas fa-trash-alt" ></i> Hapus Semua Nilai Tugas ini </a>
          </div>
        </div>
        <table class="table table-hover" id="v_nilai_tugas">
          <thead class="title_bar_table">
            <tr>
              <th>No</th>
              <th>Nama Siswa</th>
              <th>Kelas</th>
              <th>File</th>
              <th>Nilai</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
           <?php $no=1; foreach ($v_nilai_tugas as $data) { ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $data->nama; ?></td>
              <td><?= $data->id_kelas; ?></td>
              <td><a target="_blank" class="btn btn-success" href="<?= base_url('tugas_siswa/'.$data->id_guru.'/'.$data->id_tugas.'/'.$data->file); ?>"><i class="fa fa-download"></i></a></td>
              <td><?= $data->nilai; ?></td>
              <td>
                <button type="button" id="edit-data" data-id="<?= encrypt_url($data->id_tugas); ?>" 
                  data-id-siswa="<?= encrypt_url($data->id_siswa); ?>"
                  data-toggle="modal" data-target="#myModal" data-placement="top" title="Input Nilai" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Nilai</button>

                <a href="h_nilai_tugas/<?= encrypt_url($data->id_tugas); ?>/<?= encrypt_url($data->id_siswa); ?>" data-toggle="tooltip"  data-placement="top" title="Hapus Data" data-id="" class="hapus btn btn-danger btn-sm" onclick="return confirm('Apakah Kamu Yakin Akan Menghapus Nilai ini ?');"><i class="fas fa-trash-alt"></i></a>
              </td>
            </tr>
           <?php } ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <form id="sv_form">
        <div class="modal-body">
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){

    //$("#info").hide(5000);
     
     $('#v_nilai_tugas').DataTable({
      "lengthMenu": [[50, -1], [50, "All"]]
     });

    <?php // untuk menampilkan hasil ke pop out modal siswa ?>
    $(document).on("click", "#edit-data", function (a){ 
      a.preventDefault();
      $.post('input_nilai_tugas',{ 
          id:$(this).attr('data-id'),
          id_siswa:$(this).attr('data-id-siswa'),
        },
          function(cek){
          $(".modal-body").html(cek);
          //console.log(cek);
      });
    });
    $('#sv_form').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var pesan ="Nilai";
       $.ajax({
          type: 'POST',
          url: '<?php echo base_url('admin/up_nilai_tugas') ?>',
          enctype: 'multipart/form-data',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            //console.log(data);
            if (data == 'add') {
              toastr.success(pesan+" Berhasil Disimpan");
              setTimeout(function(){
               window.location.reload(1);
              }, 1000);
            } 
            else {
              toastr.error(pesan+" Gagal Disimpan");
            }
          }
        });
        return false;

    }); 

  });
</script>

