<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item">
      <h3 class="text-header text-info text-bold my-auto ml-2"> SEKOLAH DASAR KARITAS NANDAN</h3>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item d-none d-sm-inline-block">
    <?php if ($this->session->userdata('role') == 4) { ?>
        <a href="<?= base_url('auth/logout_peserta') ?>" class="nav-link"><i class="fas fa-arrow-circle-right nav-icon"></i> Logout</a>
    <?php }else{ ?>
      <a href="<?= base_url('front/auth/logout') ?>" class="nav-link"><i class="fas fa-arrow-circle-right nav-icon"></i> Logout</a>
    <?php } ?>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="" class="brand-link mx-auto">
    <img style="margin-left: 35%;" src="<?=base_url('assets/images/logo_sd.png')?>" height="50" alt="">
  </a>

  <!-- <a href="" class="brand-link mx-auto">
    <span style="margin-left: 30%;" class="brand-text font-weight-light font-weight-bolder text-nowrap" id="clock"></span>
  </a> -->

  <?php

  $id = $this->session->userdata('username');

  $cek_hak = $this->db->get_where('tenaga_kependidikan', ['nip' => $id, 'hak_akses' => 'wali kelas'])->num_rows();

  if($cek_hak > 0){
    $role = 'Wali Kelas';
  }else{
    $role = ucwords($this->session->userdata('nama_role'));
  }
  ?>
 
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <?php if (!empty($this->session->userdata('foto'))) { ?>
          <img src="<?= base_url('assets/img/user/' . $this->session->userdata('foto')) ?>" class="img-circle elevation-2 mt-2" alt="User Image">
        <?php }else{ ?>
          <img src="<?= base_url('assets/img/user/default.png') ?>" class="img-circle elevation-2 mt-2" alt="User Image">
        <?php } ?>
      </div>
      <div class="info">
        <h5 class="text-nowrap d-block text-header text-white"><?= ucwords($this->session->userdata('nama')) ?></h5>
        <span><small class="d-block text-muted"><?= $role?></small></span>


      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
   
        <?php if ($this->session->userdata('role') == 1) { ?>
          <li class="nav-item">
            <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= active('dashboard')?>">
              <i class="nav-icon fa fa-home"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger"><i class="fa fa-cog"></i></span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('admin/Tenaga_pendidik') ?>" class="nav-link <?= active('Tenaga_pendidik')?>">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Data Guru
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('admin/pegawai') ?>" class="nav-link <?= active('pegawai')?>">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Data Pegawai
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('admin/mengajar') ?>" class="nav-link <?= active('mengajar')?>">
              <i class="nav-icon fa fa-check"></i>
              <p>
                Guru Mengajar
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('admin/tahun_ajaran') ?>" class="nav-link <?= active('tahun_ajaran')?>">
              <i class="nav-icon fa fa-exclamation-circle"></i>
              <p>
                Tahun Ajaran
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('admin/kkm') ?>" class="nav-link <?= active('kkm')?>">
              <i class="nav-icon fa fa-book"></i>
              <p>
                Data KKM
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('admin/kelas') ?>" class="nav-link <?= active('kelas')?>">
              <i class="nav-icon fa fa-building"></i>
              <p>
                Data Kelas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('admin/mapel') ?>" class="nav-link <?= active('mapel')?>">
              <i class="nav-icon fa fa-book"></i>
              <p>
                Data Mapel
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('admin/pengguna') ?>" class="nav-link <?= active('pengguna')?>">
              <i class="nav-icon fa fa-user"></i>
              <p>
                Pengguna
              </p>
            </a>
          </li>
          <li class="nav-item">
                <a href="<?= base_url('front/auth/logout') ?>" class="nav-link">
                  <i class="fas fa-arrow-circle-right nav-icon"></i>
                  <p>Keluar</p>
                </a>
              </li>
        <?php } else if ($this->session->userdata('role') == 2) { ?>
          <li class="nav-item">
            <a href="<?= base_url('guru/dashboard') ?>" class="nav-link <?= active('dashboard')?>">
              <i class="nav-icon fa fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php if($role == 'Wali Kelas') :?>
          <li class="nav-item">
            <a href="<?= base_url('guru/siswa') ?>" class="nav-link <?= active('siswa')?>">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Data Siswa
              </p>
            </a>
          </li>
        <?php endif;?>
          <li class="nav-item">
            <a href="<?= base_url('guru/nilai') ?>" class="nav-link <?= active('nilai')?>">
              <i class="nav-icon fa fa-check"></i>
              <p>
                Nilai Siswa
              </p>
            </a>
          </li>
          <?php if($role == 'Wali Kelas') :?>
            <li class="nav-item">
            <a href="<?= base_url('guru/naik_kelas') ?>" class="nav-link <?= active('naik_kelas')?>">
              <i class="nav-icon fa fa-arrow-up"></i>
              <p>
                Naik Kelas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('guru/raport') ?>" class="nav-link <?= active('raport')?>">
              <i class="nav-icon fa fa-check"></i>
              <p>
                Raport Siswa
              </p>
            </a>
          </li>
          <?php endif; ?>
          <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Setting Akun
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="<?=base_url('guru/setting/profil')?>" class="nav-link <?= active('setting')?>">
                  <i class="far fa-user nav-icon"></i>
                  <p>Profil</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="<?=base_url('guru/setting/password')?>" class="nav-link">
                  <i class="fas fa-key nav-icon"></i>
                  <p>Ubah Password</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('front/auth/logout') ?>" class="nav-link">
                  <i class="fas fa-arrow-circle-right nav-icon"></i>
                  <p>Keluar</p>
                </a>
              </li>
            </ul>
          </li> -->
        <?php }else{ ?>
          <li class="nav-item">
            <a href="<?= base_url('pegawai/dashboard') ?>" class="nav-link <?= active('dashboard')?>">
              <i class="nav-icon fa fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('pegawai/siswa') ?>" class="nav-link <?= active('siswa')?>">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Pendaftaran Siswa
              </p>
            </a>
          </li>

          <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Setting Akun
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="<?=base_url('pegawai/setting/profil')?>" class="nav-link <?= active('setting')?>">
                  <i class="far fa-user nav-icon"></i>
                  <p>Profil</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="<?=base_url('pegawai/setting/password')?>" class="nav-link <?= active('setting')?>" >
                  <i class="fas fa-key nav-icon"></i>
                  <p>Ubah Password</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('front/auth/logout') ?>" class="nav-link">
                  <i class="fas fa-arrow-circle-right nav-icon"></i>
                  <p>Keluar</p>
                </a>
              </li>
            </ul>
          </li> -->
        <?php } ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>