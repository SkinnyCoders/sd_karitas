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
            <li class="breadcrumb-item"><a href="<?= base_url('pegawai/dashboard') ?>">Dashboard</a></li>
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
      <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <h3><?=$total[0]?></h3>

                <p>Siswa Mendaftar</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?=$total[1]?></h3>

                <p> DIterima</p>
              </div>
              <div class="icon">
                <i class="ion ion-checkmark"></i>
              </div>
             
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?=$total[3]?></h3>

                <p> Belum Dikonfirmasi</p>
              </div>
              <div class="icon">
                <i class="ion ion-bookmark"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?=$total[2]?></h3>

                <p> Tidak Diterima</p>
              </div>
              <div class="icon">
                <i class="ion ion-close"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
        </div>

      <!-- <div class="row">
        <div class="col-md-12">
          <div class="alert alert-primary alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-download"></i> Download Rekap</h4>
                Download rekap peserta PPDB SMK Muhammadiyah Mlati
                <a href="<?=base_url('operator/pendaftar/rekap')?>" style="color: #000; text-decoration: none;" class="btn btn-default ml-3">Download</a>
          </div>
        </div>
      </div> -->

        <!-- /.row -->
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-default ">
            <div class="card-header">
              <h3 class="card-title"><i class="far fa-dollar"></i> Data berhasil melakukan pendaftaran tahun ajaran <?=$tahun_ajaran['tahun_mulai']?>/<?=$tahun_ajaran['tahun_akhir']?></h3>
              <a class="btn btn-sm btn-primary float-right ml-3 terima" data-toggle="modal" data-target="#modal-lg" href="javascript:void(0)"><i class="fa fa-cog"></i> Terima Siswa</a>
              <a class="btn btn-sm btn-info float-right ml-3" data-toggle="modal" data-target="#modal-laporan" href="javascript:void(0)"><i class="fa fa-download"></i> Download Laporan Pendaftaran Siswa</a>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <div class="card-body">
              <table id="example1" class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-nowrap" style="width: 5%">No</th>
                    <th class="text-nowrap" style="width: 10%">No.Pendaftaran</th>
                    <th class="text-nowrap" style="width: 20%">Nama</th>
                    <th class="text-nowrap" style="width: 20%">Kelas</th>

                    <th class="text-nowrap" style="width: 10%">Tahun Ajaran</th>
                    <th class="text-nowrap" style="width: 10%">Status</th>
                    <th style="width: 14%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach($siswa AS $s) :
                  ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?=$s['kode_pendaftaran']?></td>
                      <td><?=ucwords($s['nama_siswa'])?></td>
                      <td><?=$s['nama_kelas']?></td>
                      <td><?=$s['tahun_mulai']?>/<?=$s['tahun_akhir']?></td>
                      <td>
                        
                        <?php

                        if ($s['status'] == 'terima') {
                          echo '<a href="javascript:void(0)" id="'.$s['id_siswa'].'" class="btn btn-sm btn-success edit-terima">Diterima</a>';
                        } elseif ($s['status'] == 'tolak') {
                          echo '<a href="javascript:void(0)" id="'.$s['id_siswa'].'" class="btn btn-sm btn-danger edit-tolak">Ditolak</a>';
                        } elseif ($s['status'] == 'menunggu') {
                          echo '<label class="btn btn-sm btn-default">Proses</label>';
                        }
                        ?>

                      </td>
                      <td><a href="javascript:void(0)" data-toggle="modal" data-target="#modal-detail" id="<?=$s['id_siswa']?>" class="btn btn-sm btn-primary mr-1 detail"><i class="fa fa-eye"></i> Detail</a>
                      <a href="<?= base_url('pegawai/siswa/edit/'.$s['id_siswa']) ?>" target="_blank" id="" class="btn btn-sm btn-success mr-1 update"><i class="fa fa-edit"></i></a>

                      <a href="javascript:void(0)" target="_blank" id="<?=$s['id_siswa']?>" class="btn btn-sm btn-danger mr-1 delete"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php
                  endforeach; 
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>

      <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Penerimaan Siswa tahun ajaran <?=$tahun_ajaran['tahun_mulai']?>/<?=$tahun_ajaran['tahun_akhir']?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                          <!-- form start -->
                          <form id="frm_input_srt" action="<?=base_url('pegawai/siswa/penerimaan')?>" method="post" role="form">
                          <input type="hidden" name="tolak" id="tolak-val">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive" id="penerimaan">
                                        <table id="table-penerimaan" class="table table-hover" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap" style="width: 5%">Terima</th>
                                                    <th class="text-nowrap" style="width: 10%">No.Pendaftaran</th>
                                                    <th class="text-nowrap" style="width: 25%">Nama Peserta</th>
                                                    <th class="text-nowrap" style="width: 20%">Jenis Kelamin</th>
                                                    <!-- <th class="text-nowrap">Nilai Seleksi</th> -->
                                                </tr>
                                            </thead>
                                            <tbody class="table-peserta">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer content-right">
                    <button type="submit" name="simpan" class="btn btn-primary terima-peserta">Terima Peserta</button>
                    <button type="submit" class="btn btn-danger tolak-peserta">Tolak Peserta</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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


      <div class="modal fade" id="modal-laporan">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Download Laporan Pendaftaran Siswa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?=base_url()?>pegawai/siswa/laporan" method="post">
                        <div class="form-group">
                            <label for="">Status Pendaftaran</label>
                            <select name="status" class="form-control select2bs4" data-placeholder="Pilih Status Pendaftaran (Kosongkan Jika ingin pilih semua)" id="">
                                <option></option>
                                <option value="terima">Diterima</option>
                                <option value="tolak">Ditolak</option>
                            </select>
                        </div>
                  
                        <div class="form-group">
                            <button type="submit" name="download" class="btn btn-success btn-block">Download Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modal end -->
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
  });

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

  $('.detail').click(function(){
    var nisn = this.id;

    $.ajax({
      type : "post",
      url : "<?=base_url()?>pegawai/siswa/detail",
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
    })
  });


  $('.terima').on('click',function(){
    $.ajax({
        type: 'POST',
        url: "<?= base_url('/pegawai/siswa/get_peserta') ?>",
        dataType: "json",
        success: function(data) {
            var html = '';
            var i;

            if (data.length != 0) {
              for (i = 0; i < data.length; i++) {
                if(data[i].jenis_kelamin == 'P'){
                  var gender = 'Perempuan';
                }else{
                  var gender = 'Laki - Laki';
                }


                  html += '<tr><td><div class="icheck-danger"><input type="checkbox" class="form-control" name="terima[]" id="terima' + i + '" value="' + i + '"><label for="terima' + i + '"></label><input type="hidden" name="id_pendaftaran' + i + '" value="' + data[i].id_pendaftaran + '"></div></td><td>' + data[i].kode_pendaftaran + '</td><td>' + data[i].nama_siswa + '</td><td>'+ gender +'</td></tr>'
              }
            } else {
                html += '<tr><td colspan="4" class="text-center">-- Belum Ada Data Siswa Mendaftar --</td></tr>'
            }
            $('.table-peserta').html(html);
        }
    });
  });

  $('.tolak-peserta').on('click',function(e){
        e.preventDefault();
         Swal.fire({
           title: 'Konfirmasi Tolak Penerimaan',
           text: "Apakah anda yakin ingin mengkonfirmasi tolak penerimaan peserta?, pastikan anda sudah memilih peserta yang ingin ditolak!",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Ya, Tolak!'
         }).then(
           function(isConfirm){
            if (isConfirm.value){
                $('#tolak-val').val('true');
                $('#frm_input_srt').submit();
            }else{
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            };
        });
    });

    $('.edit-terima').click(function(e){ 
      var nisn = this.id;
      e.preventDefault();
        
      Swal.fire({
      title: 'Siswa Dinyatakan Diterima',
      text: "Apakah anda yakin ingin mengubah status menjadi ditolak?",
      type: "success",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Tolak!'
      }).then(
      function(isConfirm) {
          if (isConfirm.value) {
          $.ajax({
              type: "post",
              url: "<?= base_url() ?>pegawai/siswa/edit_status",
              data: {'nisn' : nisn},
              success: function(respone) {
              window.location.href = "<?= base_url('pegawai/siswa/') ?>";
              },
              error: function(request, error) {
              window.location.href = "<?= base_url('pegawai/siswa/') ?>";
              },
          });
          } else {
          swal("Cancelled", "Your imaginary file is safe :)", "error");
          }
      });
    })

    $('.edit-tolak').on('click', function(e){
      var nisn = this.id;
      e.preventDefault();
        
        Swal.fire({
        title: 'Siswa Dinyatakan Ditolak',
        text: "Apakah anda yakin ingin menerimanya",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Terima Siswa!'
        }).then(
        function(isConfirm) {
            if (isConfirm.value) {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>pegawai/siswa/edit_status",
                data: {'nisn' : nisn},
                success: function(respone) {
                window.location.href = "<?= base_url('pegawai/siswa/') ?>";
                },
                error: function(request, error) {
                window.location.href = "<?= base_url('pegawai/siswa/') ?>";
                },
            });
            } else {
            swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
    });

    $('.delete').on('click', function(e) {
     e.preventDefault();
     var dataId = this.id;
     Swal.fire({
       title: 'Hapus Data Siswa',
       text: "Apakah anda yakin ingin menghapus data siswa?",
       type: "warning",
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Ya, Hapus!'
     }).then(
       function(isConfirm) {
         if (isConfirm.value) {
           $.ajax({
             type: "post",
             url: "<?= base_url() ?>pegawai/siswa/delete/" + dataId,
             data: {
               'id_kelas': dataId
             },
             success: function(respone) {
               window.location.href = "<?= base_url('pegawai/siswa') ?>";
             },
             error: function(request, error) {
               window.location.href = "<?= base_url('pegawai/siswa') ?>";
             },
           });
         } else {
           swal("Cancelled", "Your imaginary file is safe :)", "error");
         }
       });
   });
</script>