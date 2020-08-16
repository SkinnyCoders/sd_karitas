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
                      <!-- general form elements -->
                      <div class="card card-default ">
                          <!-- /.card-header -->
                          <div class="card-body">
                            <label for="kelas">Pilih Kelas</label>
                            <form action="">
                              <select name="kelas" class="form-control select2bs4" data-placeholder="Pilih kelas">
                                  <option></option>
                                  <?php
                                foreach($kelas_pilih AS $k) :
                                  ?>
                                  <option value="<?=$k['id_kelas']?>"><?=ucwords($k['nama_kelas'])?></option>
                                  <?php
                                  endforeach;
                                  ?>
                              </select>
                              <button type="submit" class="btn btn-primary mt-4 float-right">Tampilkan</button>
                              </form>
                          </div>
                      </div>
                </div>
                  <!-- left column -->
                  <?php
                if(!empty($siswa)):
                  ?>
                  <div class="col-md-12">
                      <!-- general form elements -->
                      <div class="card card-default ">
                          <div class="card-header">
                              <h3 class="card-title"><i class="far fa-dollar"></i>Data Siswa Naik Kelas</h3> <br>
                              <small>Pilih siswa dibawah ini untuk naik kelas</small>
                          </div>
                          <!-- /.card-header -->
                          <!-- form start -->
                        <form action="<?=base_url()?>guru/naik_kelas/proses" method="post">
                          <div class="card-body">
                            <table id="example1" class="table table-striped">
                             <thead>
                               <tr>
                                 <th class="text-nowrap" style="width: 5%">Pilih</th>
                                 <th class="text-nowrap">Nama</th>
                                 <th class="text-nowrap">NISN</th>
                                 <th class="text-nowrap">Jenis Kelamin</th>
                                 <th class="text-nowrap">Nilai Rata</th>
                               </tr>
                             </thead>
                             <tbody>
                                 <?php
                                 $no = 0;
                                    foreach($siswa AS $s) :

                                        switch($s['kelamin']){
                                            case 'L':
                                                $gender = 'Laki - Laki';
                                            break;

                                            case 'P':
                                                $gender = 'Perempuan';
                                            break;
                                        }

                                        if($s['rata'] !== false){
                                          if ($s['naik_tidak']) {
                                            $label = '<label class="btn btn-sm btn-success">Nilai Mencukupi</label>';
                                            $disable = '';
                                            $v = true;
                                          }else{
                                            $label = '<label class="btn btn-sm btn-danger">Nilai Dibawah</label>';
                                            $disable = '';
                                            $v = false;
                                          }
                                        }else{
                                            $label = '<label class="btn btn-sm btn-warning">Nilai Masih Kurang</label>';
                                            $disable = 'disabled';
                                        }
                                 ?>
                                <tr>
                                  <td><input type="checkbox" class="form-control" name="naik[]" id="siswa<?=$no?>" value="<?=$s['id_siswa']?>" style="width: 20px;" <?=$disable?>>
                                    <input type="hidden" name="naik_tidak[]" value="<?=$v?>">
                                  </td>
                                  <td><?=ucwords($s['nama'])?></td>
                                  <td><?=$s['nisn']?></td>
                                  <td><?=$gender?></td>
                                  <td><?=$label?></td>
                                </tr>
                                <?php
                                endforeach;
                                ?>
                             </tbody>
                            </table>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <!-- <label for="kelas">Pilih Kelas</label>
                              <select name="kelas" id="" class="form-control select2bs4" data-placeholder="Pilih kelas untuk kenaikan">
                                  <option></option>
                                  <?php
                                foreach($kelas AS $k) :
                                  ?>
                                  <option value="<?=$k['id_kelas']?>"><?=ucwords($k['nama_kelas'])?></option>
                                  <?php
                                  endforeach;
                                  ?>
                              </select> -->
                              <button name="simpan" type="submit" class="btn btn-primary mt-4 float-right">Simpan</button>
                          </div>
                         </div>
                        </form>
                      <!-- /.card -->
                  </div>
                                <?php endif;?>
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