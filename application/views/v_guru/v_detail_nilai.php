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
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title"><i class="far fa-dollar"></i> Data Siswa</h3>
            </div>
                <div class="card-body">
                <table class="table table-borderless">
                      <tr>
                        <th style="width: 15%">NISN</th>
                        <td>: <?=$siswa['nisn']?></td>
                      </tr>
                      <tr>
                        <th style="width: 15%">Nama Siswa</th>
                        <td>: <?=ucwords($siswa['nama_siswa'])?></td>
                      </tr>
                      
                      <tr>
                        <th style="width: 15%">Jenis Kelamin</th>
                        <td>: <?php if($siswa['jenis_kelamin'] == 'P'){ echo 'Prempuan';}else{echo 'Laki - Laki';}?></td>
                      </tr>
                      <tr>
                        <th style="width: 15%">Kelas</th>
                        <td>: <?=ucwords($siswa['nama_kelas'])?></td>
                      </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!-- /.row -->
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <?php
          $flag = 1;
          array_unique($kelas);
          foreach($kelas AS $k) :
            $nisn = $this->uri->segment(4);
            $id_tahun_ajaran = getIdTahun(getTahun());
            $getNilai = $this->db->query("SELECT * FROM `nilai` JOIN mata_pelajaran ON mata_pelajaran.kode_mapel=nilai.kode_mapel WHERE `id_siswa` = $nisn  AND `id_kelas` = $k AND id_tahun_ajaran = $id_tahun_ajaran")->result_array();
            $namaKelas = $this->db->get_where('kelas', ['id_kelas' => $k])->row_array();

         ?>
          <div class="card card-default ">
          <div class="card-header">
              <h3 class="card-title"><i class="fa fa-dollar"></i> <?php echo ucwords($namaKelas['nama_kelas'])?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <div class="card-body">
              <table id="example<?=$flag++?>" class="table table-striped table-responsive" style="width: 100%;">
                <thead>
                  <tr>
                    <th class="text-nowrap" style="width: 5%">No</th>
                    <th class="text-nowrap" style="width: 15%">Mata Pelajaran</th>
                    <th class="text-nowrap" style="width: 15%">Nilai Tugas</th>
                    <th class="text-nowrap" style="width: 15%">Nilai UTS</th>
                    <th class="text-nowrap" style="width: 15%">Nilai UAS</th>
                    <th class="text-nowrap" style="width: 15%">Nilai Total</th>
                    <th class="text-nowrap" style="width: 15%">Nilai Sikap</th>
                  </tr>
                </thead>
                
                <tbody>
                    <?php
                      $no = 1;
                      if(!empty($getNilai)) :

                        foreach($getNilai AS $nilai) :
                    ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=ucwords($nilai['nama_mapel'])?></td>
                        <td><?=$nilai['nilai_harian']?></td>
                        <td><?=$nilai['nilai_uts']?></td>
                        <td><?=$nilai['nilai_uas']?></td>
                        <td><?=$nilai['nilai_total']?></td>
                        <td><?=$nilai['nilai_sikap']?></td>
                        <!-- <td><input type="text" name="total[]" class="form-control" placeholder="Nilai Total"></td> -->
                    </tr>
                    <?php 
                      endforeach;
                      else :
                    ?>
                    <?php endif?>
                    
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <?php
          endforeach;
          ?>
        </div>
      </div>

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


<?php
  $flag = 1;
  for($i=0; $i< count($kelas); $i++) :
?>
<script>
  $(function() {
    $("#example<?=$flag++?>").DataTable({
      "language": {
        "emptyTable": "Belum Ada Penilaian Pada Kelas Ini"
      }
    });
    $('#example0').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      
    });
  });
</script>
<?php
endfor;
?>

