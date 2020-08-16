<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class Siswa extends CI_controller
{
    /**
     * Constructs a new instance.
     */
    function __construct()
    {
        parent::__construct();
        //login cek and authentication
        getAuthPegawai();
        $this->load->helper('cektahun');
    }

    public function index()
    {
        $id_tahun =  getIdTahun(getTahun());
        $data['title'] = 'Pendaftaran Siswa';
        $total_pendaftar = $this->db->get_where('pendaftaran', ['id_tahun_ajaran' => $id_tahun])->num_rows();
        $total_terima = $this->db->get_where('pendaftaran', ['status' => 'terima', 'id_tahun_ajaran' => $id_tahun])->num_rows();
        $total_tolak = $this->db->get_where('pendaftaran', ['status' => 'tolak', 'id_tahun_ajaran' => $id_tahun])->num_rows();
        $total_proses = $this->db->get_where('pendaftaran', ['status' => 'menunggu', 'id_tahun_ajaran' => $id_tahun])->num_rows();
        $data['total'] = [$total_pendaftar, $total_terima, $total_tolak, $total_proses];
        $data['tahun_ajaran'] = $this->db->get_where('tahun_ajaran', ['id_tahun_ajaran' => getIdTahun(getTahun())])->row_array();
        $data['siswa'] = $this->db->query("SELECT * FROM `siswa` JOIN pendaftaran ON pendaftaran.id_siswa=siswa.id_siswa JOIN tahun_ajaran ON tahun_ajaran.id_tahun_ajaran=pendaftaran.id_tahun_ajaran JOIN kelas ON kelas.id_kelas=siswa.id_kelas WHERE pendaftaran.status != 'menunggu' AND pendaftaran.id_tahun_ajaran = $id_tahun")->result_array();
        getViews($data, 'v_pegawai/v_list_siswa');
    }

    public function get_peserta(){
        $id_tahun =  getIdTahun(getTahun());

        $data = $this->db->query("SELECT pendaftaran.id_pendaftaran, siswa.nama_siswa, siswa.nisn, siswa.jenis_kelamin, pendaftaran.kode_pendaftaran FROM `pendaftaran` JOIN siswa ON siswa.id_siswa=pendaftaran.id_siswa WHERE pendaftaran.id_tahun_ajaran = $id_tahun AND pendaftaran.status = 'menunggu' ORDER BY siswa.nisn DESC")->result_array();

        echo json_encode($data);
    }

    public function edit($id_siswa){
        $data = [
            "title" => "Perbarui Siswa",
            'kelas' => $this->db->get('kelas')->result_array(),
            'siswa' => $this->db->get_where('siswa', ['id_siswa' => $id_siswa])->row_array()
        ];

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim', ['required' => '{field} tidak boleh kosong']);
		$this->form_validation->set_rules('nisn', 'NISN', 'required|trim|numeric', ['required' => '{field} tidak boleh kosong', 'numeric' => '{field} hanya berupa angka']);
		$this->form_validation->set_rules('agama', 'Agama', 'required|trim', ['required' => '{field} tidak boleh kosong']);
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim', ['required' => '{field} tidak boleh kosong']);
		$this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim', ['required' => '{field} tidak boleh kosong']);
		$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required|trim', ['required' => '{field} tidak boleh kosong']);
		$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', ['required' => '{field} tidak boleh kosong']);
		$this->form_validation->set_rules('nama_ortu', 'Nama Orang Tua', 'required|trim', ['required' => '{field} tidak boleh kosong']);
		$this->form_validation->set_rules('telp_ortu', 'Telepon Ortu', 'required|trim', ['required' => '{field} tidak boleh kosong']);
		$this->form_validation->set_rules('pekerjaan_ortu', 'Pekerjaan', 'required|trim', ['required' => '{field} tidak boleh kosong']);
		$this->form_validation->set_rules('penghasilan_ortu', 'Penghasilan Ortu', 'required|trim', ['required' => '{field} tidak boleh kosong']);
		$this->form_validation->set_rules('alamat_ortu', 'Alamat Orang Ortu', 'required|trim', ['required' => '{field} tidak boleh kosong']);

        if($this->form_validation->run() == FALSE){
            getViews($data, 'v_pegawai/v_edit_siswa');
        }else{
            $tgl_lahir = DateTime::createFromFormat('m/d/Y', $this->input->post('tgl_lahir'))->format('Y-m-d');

            $data_diri = [
				'nisn' => $this->input->post('nisn', true),
				'nama_siswa' => $this->input->post('nama', true),
				'jenis_kelamin' => $this->input->post('gender'),
				'id_kelas' => $this->input->post('kelas'),
				'tempat_lahir' => $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $tgl_lahir,
				'agama' => $this->input->post('agama'),
				'alamat' => $this->input->post('alamat', true),
				'nama_ortu' => $this->input->post('nama_ortu', true),
				'telepon_ortu' => $this->input->post('telp_ortu', true),
				'alamat_ortu' => $this->input->post('alamat_ortu', true),
				'pekerjaan_ortu' => $this->input->post('pekerjaan_ortu'),
				'penghasilan_ortu' => $this->input->post('penghasilan_ortu')
            ];
            
            if($this->db->update('siswa', $data_diri, ['id_siswa' => $id_siswa])){
                $this->session->set_flashdata('msg_success', 'Selamat, Data siswa berhasil diperbarui');
				redirect('pegawai/siswa');
            }else{
                $this->session->set_flashdata('msg_failed', 'Maaf, Data siswa belum berhasil diperbarui');
				redirect('pegawai/siswa');
            }
        }
    }

    public function detail(){
        if(isset($_POST['nisn']) && !empty($_POST['nisn'])){
            $id_siswa = $this->input->post('nisn');

            $siswa = $this->db->query("SELECT * FROM `siswa` JOIN kelas ON kelas.id_kelas=siswa.id_kelas WHERE siswa.id_siswa = $id_siswa")->row_array();
            if(!empty($siswa['jenis_kelamin'])){
                switch($siswa['jenis_kelamin']){
                    case 'L' :
                        $gender = 'Laki - Laki';
                    break;

                    case 'P' :
                        $gender  = 'Perempuan';
                    break;
                }
            }
            $data = [
                'nisn' => $siswa['nisn'],
                'nama' => $siswa['nama_siswa'],
                'jenis_kelamin' => $gender,
                'kelas' => $siswa['nama_kelas'],
                'tempat_lahir' => $siswa['tempat_lahir'],
                'tgl_lahir' => DateTime::createFromFormat('Y-m-d', $siswa['tanggal_lahir'])->format('d F Y'),
                'agama' => $siswa['agama'],
                'alamat' => $siswa['alamat'],
                'nama_ortu' => $siswa['nama_ortu'],
                'telepon_ortu' => $siswa['telepon_ortu'],
                'alamat_ortu' => $siswa['alamat_ortu'],
                'pekerjaan_ortu' => $siswa['pekerjaan_ortu'],
                'penghasilan' => $siswa['penghasilan_ortu']
            ];

            echo json_encode($data);
        }else{}
    }

    public function penerimaan(){
        if(isset($_POST['simpan'])){
            $terima = $_POST['terima'];
            $total = count($terima);

            $flag = true;
            foreach ($terima as $t) {
                $id_pendaftaran = $_POST['id_pendaftaran' . $t];

                $this->db->set('status', 'terima');
                $this->db->where('id_pendaftaran', $id_pendaftaran);
                $proses = $this->db->update('pendaftaran');

                if($proses){
                    $flag = true;
                }else{
                    $flag = false;
                }
            }

            if ($flag) {
                $this->session->set_flashdata('msg_success', 'Selamt, berhasil melakukan penerimaan peserta');
                redirect('pegawai/siswa');
            } else {
                $this->session->set_flashdata('msg_failed', 'Maaf, gagal melakukan penerimaan peserta');
                redirect('pegawai/siswa');
            }
        }elseif(isset($_POST['tolak']) && $_POST['tolak'] == 'true'){
            $terima = $_POST['terima'];
            $total = count($terima);

            $flag = true;
            foreach ($terima as $t) {
                $id_pendaftaran = $_POST['id_pendaftaran' . $t];

                $this->db->set('status', 'tolak');
                $this->db->where('id_pendaftaran', $id_pendaftaran);
                $proses = $this->db->update('pendaftaran');

                if($proses){
                    $flag = true;
                }else{
                    $flag = false;
                }
            }

            if ($flag) {
                $this->session->set_flashdata('msg_success', 'Selamt, berhasil melakukan penolakan peserta');
                redirect('pegawai/siswa');
            } else {
                $this->session->set_flashdata('msg_failed', 'Maaf, gagal melakukan penolakan peserta');
                redirect('pegawai/siswa');
            }
        }
    }

    public function laporan(){
    
        if(!empty($this->input->post('status'))){
            if($this->input->post('status') == 'terima'){
                $where = "status = 'terima'";
            }else{
                $where = "status = 'tolak'";
            }
        }else{
            //semua pendaftar
            $where = 1;
        }

        $id_tahun = getIdTahun(getTahun());

        $query = $this->db->query("SELECT * FROM `pendaftaran` JOIN siswa ON siswa.id_siswa=pendaftaran.id_siswa WHERE $where AND id_tahun_ajaran = $id_tahun AND pendaftaran.status = 'terima' ORDER BY pendaftaran.`id_siswa`");
        $data['pendaftar'] = $query->result_array();
        $data['tahun_ajaran'] = $this->db->get_where('tahun_ajaran', ['id_tahun_ajaran' => $id_tahun])->row_array();

        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan_pendaftaran.pdf";
        $this->pdf->load_view('v_pegawai/v_laporan_siswa', $data);
    }

    public function edit_status(){
        if(isset($_POST['nisn'])){
            //get status sebelumnya
            $status = $this->db->get_where('pendaftaran', ['id_siswa' => $this->input->post('nisn')])->row_array();

            if($status['status'] == 'terima'){
                //ubah statusnya
                $data = [
                    'status' => 'tolak'
                ];
            }else{
                $data = [
                    'status' => 'terima'
                ];
            }

            $update = $this->db->update('pendaftaran', $data, ['id_siswa' => $this->input->post('nisn')]);

            if($update){
                $this->session->set_flashdata('msg_success', 'Selamat, data siswa berhasil diubah');
    		    http_response_code(200);
            }else{
                $this->session->set_flashdata('msg_failed', 'Maaf, data siswa gagal diubah');
    		    http_response_code(400);
            }
        }
    }

    public function delete($id){
        $delete = $this->db->delete('pendaftaran', ['id_siswa'=> $id]);

        if ($delete) {
            $siswa =  $this->db->delete('siswa', ['id_siswa'=> $id]);
            if ($siswa) {
                $this->session->set_flashdata('msg_success', 'Selamat, data berhasil dihapus');
                http_response_code(200);
            }else{
                $this->session->set_flashdata('msg_failed', 'Selamat, data gagal dihapus');
                http_response_code(404);
            }
           
        }else{
            $this->session->set_flashdata('msg_failed', 'Selamat, data gagal dihapus');
            http_response_code(404);
        }
    }

}
