<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class Naik_kelas extends CI_controller
{
    /**
     * Constructs a new instance.
     */
    function __construct()
    {
        parent::__construct();
        //login cek and authentication
        getAuthGuru();
        $this->load->helper('cektahun');
        $this->load->model("m_gtk");
    }

    public function index()
    {
        $id_tahun =  getIdTahun(getTahun());
        $nip = $this->session->userdata('username');
        $data['title'] = 'Naik Kelas';
        $data['kelas_pilih'] = $this->db->query("SELECT * FROM `guru_kelas` JOIN kelas ON kelas.id_kelas=guru_kelas.id_kelas JOIN tenaga_kependidikan AS gtk ON gtk.id_tenaga_kependidikan=guru_kelas.id_gtk WHERE gtk.nip = $nip")->result_array();
        // $data['kelas'] = $this->db->query("SELECT kelas.id_kelas, kelas.nama_kelas FROM `guru_kelas` JOIN tenaga_kependidikan AS gtk ON gtk.id_tenaga_kependidikan=guru_kelas.id_gtk JOIN kelas ON kelas.id_kelas=guru_kelas.id_kelas WHERE gtk.nip = $nip ")->result_array();
      //  $data['kelas'] =  $this->db->query("SELECT kelas.id_kelas, kelas.nama_kelas FROM `guru_mengajar` JOIN tenaga_kependidikan AS gtk ON gtk.id_tenaga_kependidikan=guru_mengajar.id_guru JOIN kelas ON kelas.id_kelas=guru_mengajar.id_kelas WHERE gtk.nip = $nip ")->result_array();
        $data['kelas'] = $this->db->get('kelas')->result_array();
        $data['tahun_ajaran'] = $this->db->get_where('tahun_ajaran', ['id_tahun_ajaran' => getIdTahun(getTahun())])->row_array();

        if(isset($_GET['kelas']) && !empty($_GET['kelas'])){
            $data['siswa'] = $this->m_gtk->getSiswaNaikKelas($_GET['kelas']);
        }

        getViews($data, 'v_guru/v_naik_kelas');
    }

    public function proses(){
        
        $naik  = $_POST['naik'];

        if(count($naik) == 0){
            $this->session->set_flashdata('msg_failed', 'Maaf Siswa Belum dipilih');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $nisn = $this->input->post('naik');
            $kelas = $this->input->post('kelas');
            $naik_tidak = $this->input->post('naik_tidak');
            $flag = true;

            if(!empty($nisn)){
                for($i = 0; $i<count($nisn); $i++){
                    //get kelas siswa sekarang 
                    $kelas_lama = $this->db->get_where('siswa', ['id_siswa' => $nisn[$i]])->row_array();
                    $kelas_lama = $kelas_lama['id_kelas'];

                    if ($naik_tidak[$i]) {
                        //kelas baru
                        $kelas_baru = $this->db->query("SELECT * FROM `kelas` WHERE `id_kelas` > $kelas_lama LIMIT 1")->row_array();
                        $kelas_baru = $kelas_baru['id_kelas'];
                    }else{
                        $kelas_baru = $kelas_lama;
                    }

                    //insert ke riwayat kelas
                    $data_riwayat = [
                        'id_siswa' => $nisn[$i],
                        'id_kelas' => $kelas_lama,
                        'id_tahun_ajaran' => getIdTahun(getTahun())
                    ];
    
                    $insert_riwayat = $this->db->insert('riwayat_kelas', $data_riwayat);
    
                    if($insert_riwayat){  
                         //update kelas siswa
                         $data = [
                             'id_kelas' => $kelas_baru
                         ];
    
                         $update = $this->db->update('siswa', $data, ['id_siswa' => $nisn[$i]]);
    
                         if($update){
                            $flag = true;
                         }else{
                             $flag = false;
                         }
                    }else{
                        $flag = false;
                    }
    
                    if($flag){
                        $this->session->set_flashdata('msg_success', 'Selamat, Berhasil Konfirmasi naik kelas');
                        redirect($_SERVER['HTTP_REFERER']);
                    }else{
                        $this->session->set_flashdata('msg_failed', 'Maaf gagal konfirmasi naik kelas');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            }else{
                $this->session->set_flashdata('msg_failed', 'Maaf belum ada siswa yang dipilih');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}