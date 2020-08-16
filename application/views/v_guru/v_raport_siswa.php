<?php
$path = base_url().'assets/images/logo_sd.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

//cek siswa naik kelas atau tidak
$id_siswa = $siswa['id_siswa'];
$id_kelas = $siswa['id_kelas'];
$cek_naik = $this->db->query("SELECT * FROM `riwayat_kelas` WHERE `id_siswa` = $id_siswa AND `id_kelas` != $id_kelas AND `id_tahun_ajaran` =".$tahun['id_tahun_ajaran'])->num_rows();
if($cek_naik > 0){
  $naik = "Naik Kelas";
}else{
  $naik = "Tinggal Kelas";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Raport Siswa</title>
  <style type="text/css">
    .table-me{
      font-size: 14px;
      width: 100%;
      text-align: center;
    }

    .table-me thead{
      border-bottom: 2px solid #000; 
      margin-bottom: 5px;
    }

    .table-nilai{
      font-size: 14px;
      width: 100%;
      text-align: center;
      border: 1px solid #000;
    }

    .header .header-text{
      text-align: center;
    }

    .header .header-text small{
      font-size: 12px;
      color: #333 ;
    }

    .table-me tbody{
      border-bottom: 2px solid #000 !important;
    }

    .ket{
      text-align: justify;
    }

    .hormat{
      float: right;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div id="outtable">
    <div class="header">
      <table border="0" width="100%">
        <tr>
          <td width="10">
            <div class="header-img">
              <img style="width: 100px; height: 100px; border-radius: 5px;" src="<?=$base64?>">
            </div>
          </td>
          <td width="100%">
            <div class="header-text">
              <h2>Raport Siswa<br> SD Karitas Nandan </h2>
              <small>Jalan Nandan, Sariharjo, Ngaglik, Sleman, Yogyakarta.</small>
            </div>
          </td>
        </tr>
      </table>
    </div>
      <hr>
      <div style="overflow-x:auto;">
      <table border="0" cellpadding="3">
        <tr>
          <td>Nama</td>
          <td style="width: 5%;">:</td>
          <td><?=$siswa['nama_siswa']?></td>
        </tr>
        <tr>
          <td>NISN</td>
          <td style="width: 5%;">:</td>
          <td><?=$siswa['nisn']?></td>
        </tr>
        <tr>
          <td>Kelas</td>
          <td style="width: 5%;">:</td>
          <td><?=$kelas_ampas['nama_kelas']?></td>
        </tr>
        <tr>
          <td>Tahun Ajaran</td>
          <td style="width: 5%;">:</td>
          <td><?=$tahun['tahun_mulai']?> - <?=$tahun['tahun_akhir']?></td>
        </tr>
      </table>
      <br>
      <br>
      <table class="table-nilai" border="1" cellpadding="3" cellspacing="0">
        <thead>
          <tr>
            <th style="width: 3%">No</th>
            <th>Mata Pelajaran</th>
            <th style="width: 10%">KKM</th>
            <th style="width: 10%">Nilai Siswa</th>
            <th style="width: 10%">Nilai Sikap</th>
            <th style="width: 40%">Keterangan</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $jumlah_mapel = count($mapel);
          foreach($mapel AS $m):
            //get nilai
            $kode = $m['kode_mapel'];
            $nilai = $this->db->query("SELECT `nilai_total`, nilai_sikap, keterangan FROM `nilai` WHERE `id_siswa` = ".$siswa['id_siswa']." AND `id_kelas` = ".$kelas_ampas['id_kelas']." AND `kode_mapel` = '$kode'")->row_array();
            if(!empty($nilai)){
              $total = $nilai['nilai_total'];
            }else{
              $total = "Kososng";
            }

            $kkm = $this->db->query("SELECT `kkm` FROM `kkm_mapel` WHERE `id_kelas` = ".$kelas_ampas['id_kelas']." AND `kode_mapel` = '$kode' AND `id_tahun_pelajaran` = $id_tahun")->row_array();
            if(!empty($kkm)){
              $kkm_nilai = $kkm['kkm'];
            }else{
              $kkm_nilai = "Belum Diatur";
            }

            //hitung rata-rata
            $nilaiTotal = $this->db->query("SELECT SUM(`nilai_total`) AS total FROM `nilai` WHERE `id_siswa` = ".$siswa['id_siswa']." AND id_tahun_ajaran = $id_tahun")->row_array();
            $rata2 = $nilaiTotal['total'] / $jumlah_mapel;

            
          ?>
          <tr>
            <td><?=$no++?></td>
            <td><?=ucwords($m['nama_mapel'])?></td>
            <td><?=$kkm_nilai?></td>
            <td><?=$total?></td>
            <td><?=!empty($nilai['nilai_sikap'])?$nilai['nilai_sikap']:'-'?></td>
            <td><?=!empty($nilai['keterangan'])?$nilai['keterangan']:'-'?></td>
          </tr>
          
          <?php
            endforeach;
          ?>
          <tr>
            <td></td>
            <td>Rata - Rata Nilai Siswa</td>
            <td colspan="4"><?=$rata2?></td>
          </tr>
        </tbody>   
      </table>
    </div>
    <div class="ket" style="margin-top: 20px;">
      <p>Sesuai dengan hasil yang dicapai, maka siswa dinyatakan <b><?=$naik?></b>.</p>
      <br>
      <p>Table Keterangan Nilai</p>
      <table>
        <tr>
          <td>A</td>
          <td>:</td>
          <td>80 - 100</td>
        </tr>
        <tr>
          <td>B</td>
          <td>:</td>
          <td>60 - 80</td>
        </tr>
        <tr>
          <td>C</td>
          <td>:</td>
          <td>40 - 60</td>
        </tr>
        <tr>
          <td>D</td>
          <td>:</td>
          <td>20 - 40</td>
        </tr>
      </table>
    </div>

    <div class="hormat">
      <p style="margin-left: 65px;">Kepala Sekolah,</p>
      <p style="margin-left: 65px; margin-top: 60px;">Nama Kepala Sekolah</p>
    </div>
   </div>
</body>
</html>