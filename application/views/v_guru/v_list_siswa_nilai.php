<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?= ucwords($title) ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('guru/dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active"><?= ucwords($title) ?></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

        <!-- /.row -->
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-default ">
            <div class="card-header">
              <h3 class="card-title"><i class="far fa-dollar"></i> Data Siswa</h3>
                <div class="form-group">
                <select name="kelas" class="form-control float-right ml-3" style="width: 200px;" id="kelas">
                <?php
                    foreach($kelas AS $k){
                        echo '<option value="'.$k['id_kelas'].'">'.$k['nama_kelas'].'</option>';
                    }
                ?>
                </select>
                </div>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <div class="card-body">
              <table id="example1" class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-nowrap" style="width: 5%">No</th>
                    <th class="text-nowrap" style="width: 10%">NISN</th>
                    <th class="text-nowrap" style="width: 20%">Nama</th>
                    <th class="text-nowrap" style="width: 20%">Kelas</th>

                    <th class="text-nowrap" style="width: 10%">Jenis Kelamin</th>
                    <th style="width: 20%">Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-peserta">

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>

      <div class="modal fade" id="modal-detail">
        <div class="modal-dialog modal-lg">
          <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-primary">
                <h3 class="widget-user-username"><span id="nama"></span></h3>
                <h5 class="widget-user-desc">NISN : <span id="nisn_detail"></span> | Kelas : <span id="jurusan"></span></h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" style="height:100px; width:100px;" src="<?=base_url()?>assets/img/user/default.png" id="foto" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-6 border-right">
                    <div class="description-block">
                      <h4 class="description-header">Data Diri</h4>
                      <hr style="width:30%; border:1px solid #eaeaea;">
                    </div>
                    <table class="table table-borderless">
                      <tr>
                        <th style="width: 35%">Tanggal Lahir</th>
                        <td>: <span id="tanggal_lahir"></span></td>
                      </tr>
                      <tr>
                        <th style="width: 35%">Tempat Lahir</th>
                        <td>: <span id="tempat_lahir"></span></td>
                      </tr>
                      
                      <tr>
                        <th style="width: 35%">Jenis Kelamin</th>
                        <td>: <span id="jenis_kelamin"></span></td>
                      </tr>
                      <tr>
                        <th style="width: 35%">Agama</th>
                        <td>: <span id="agama"></span></td>
                      </tr>
                      <tr>
                        <th style="width: 35%">Alamat</th>
                        <td>: <span id="alamat"></span></td>
                      </tr>
                    </table>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                    <div class="description-block">
                      <h4 class="description-header">Data Orang Tua</h4>
                      <hr style="width:30%; border:1px solid #eaeaea;">
                    </div>
                    <table class="table table-borderless">
                      <tr>
                        <th style="width: 35%">Nama Ortu</th>
                        <td>: <span id="nama_ortu"></span></td>
                      </tr>
                      <tr>
                        <th style="width: 35%">telepon Ortu</th>
                        <td>: <span id="telepon"></span></td>
                      </tr>
                      <tr>
                        <th style="width: 35%">Pekerjaan Ortu</th>
                        <td>: <span id="pekerjaan"></span></td>
                      </tr>
                      <tr>
                        <th style="width: 35%">Penghasilan Ortu</th>
                        <td>: <span id="penghasilan"></span></td>
                      </tr>
                      <tr>
                        <th style="width: 35%">Alamat Ortu</th>
                        <td>: <span id="alamat_ortu"></span></td>
                      </tr>
                    </table>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

    </div>
  </section>
</div>
<!-- /.content-wrapper -->

<?php $this->load->view('templates/cdn_admin'); ?>

<script>
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
  </script>

<script>
  $(function() {
    $("#example1").DataTable({});
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });

  function detail(nisn){
        $.ajax({
      type : "post",
      url : "<?=base_url()?>guru/siswa/detail",
      data : {'nisn' : nisn},
      dataType : "json",
      success : function(res){
        $('#nama_ortu').text(res.nama_ortu);
        $('#agama').text(res.agama);
        $('#jenis_kelamin').text(res.jenis_kelamin);
        $('#pekerjaan').text(res.pekerjaan_ortu);
        $('#telepon').text(res.telepon_ortu);
        $('#telepon').text(res.telepon);
        $('#tempat_lahir').text(res.tempat_lahir);
        $('#tanggal_lahir').text(res.tgl_lahir);
        $('#alamat').text(res.alamat);
        $('#penghasilan').text(res.penghasilan);
        $('#telepon').text(res.telepon_ortu);
        $('#nama').text(res.nama);
        $('#nisn_detail').text(res.nisn);
        $('#jurusan').text(res.kelas);
        $('#alamat_ortu').text(res.alamat_ortu);
        $('#foto').attr('src', res.foto);

      }
    });
      }

  $(document).ready(function(){
    var id_kelas = $('#kelas').val();
    $.ajax({
        type: 'POST',
        url: "<?= base_url('/guru/siswa/get_siswa') ?>",
        data : {'kelas' : id_kelas},
        dataType: "json",
        success: function(data) {
            var html = '';
            var i;
            var no = 1;

            if (data.length != 0) {
              for (i = 0; i < data.length; i++) {
                if(data[i].jenis_kelamin == 'P'){
                  var gender = 'Perempuan';
                }else{
                  var gender = 'Laki - Laki';
                }

                if(data[i].status == true){
                  var link = 'guru/nilai/edit/';
                  var text = 'Perbarui';
                  var tombol = 'btn-success';
                }else{
                  var link = 'guru/nilai/input/';
                  var text = 'Input';
                  var tombol = 'btn-primary';
                }

                  html += '<tr><td>'+no+'</td><td>' + data[i].nisn + '</td><td>' + data[i].nama_siswa + '</td><td>' + data[i].nama_kelas + '</td><td>'+ gender +'</td><td><a href="<?=base_url()?>'+ link + data[i].id_siswa +'" class="btn btn-sm '+tombol+' mr-1 detail"><i class="fa fa-edit"></i> '+text+' Nilai</a><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-detail" onclick="detail('+data[i].nisn+')" class="btn btn-sm btn-primary mr-1 detail"><i class="fa fa-eye"></i> Detail</a></td></tr>'
                no++;
              }
            } else {
                html += '<tr><td colspan="6" class="text-center">-- Belum Ada Data Siswa --</td></tr>'
            }
            $('.table-peserta').html(html);
        }
    });
  });

  $('#kelas').on('change', function(){
    var id_kelas = $('#kelas').val();
    $.ajax({
        type: 'POST',
        url: "<?= base_url('/guru/siswa/get_siswa') ?>",
        data : {'kelas' : id_kelas},
        dataType: "json",
        success: function(data) {
            var html = '';
            var i;
            var no = 1;

            if (data.length != 0) {
              for (i = 0; i < data.length; i++) {
                if(data[i].jenis_kelamin == 'P'){
                  var gender = 'Perempuan';
                }else{
                  var gender = 'Laki - Laki';
                }

                if(data[i].status == true){
                  var link = 'guru/nilai/edit/';
                  var text = 'Perbarui';
                  var tombol = 'btn-success';
                }else{
                  var link = 'guru/nilai/input/';
                  var text = 'Input';
                  var tombol = 'btn-primary';
                }

                  html += '<tr><td>'+no+'</td><td>' + data[i].nisn + '</td><td>' + data[i].nama_siswa + '</td><td>' + data[i].nama_kelas + '</td><td>'+ gender +'</td><td><a href="<?=base_url()?>'+ link + data[i].id_siswa +'" class="btn btn-sm '+tombol+' mr-1 detail"><i class="fa fa-edit"></i> '+text+' Nilai</a><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-detail" onclick="detail('+data[i].nisn+')" class="btn btn-sm btn-primary mr-1 detail"><i class="fa fa-eye"></i> Detail</a></td></tr>'
                no++;
              }
            } else {
                html += '<tr><td colspan="6" class="text-center">-- Belum Ada Data Siswa --</td></tr>'
            }
            $('.table-peserta').html(html);
        }
    });
  })
</script>