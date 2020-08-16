<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class Tenaga_pendidik extends CI_controller
{

    function __construct()
    {
        parent::__construct();
        //login cek and authentication
        getAuthAdmin();
        $this->load->model('m_gtk');
    }

    public function index(){
    	$data = [
            'title' => 'Daftar Tenaga Pendidik',
            'gtk' => $this->m_gtk->getAllGuru()
    	];

    	getViews($data,'v_admin/v_guru');
    }

    public function tambah(){
        $data = [
            'title' => 'Tambah Tenaga Pendidik'
        ];

    	$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim|callback_cekHuruf', ['required' => 'Nama tidak boleh kosong', 'cekHuruf' => '{field} hanya berupa huruf']);
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim|numeric|callback_CekNIP', ['numeric' => '{field} harus berupa angka', 'CekNIP' => '{field} sudah digunakan']);
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|numeric|callback_CekNIK', ['numeric' => '{field} harus berupa angka', 'CekNIK' => '{field} sudah digunakan']);
        $this->form_validation->set_rules('telp', 'No Telp', 'numeric|trim', ['numeric' => '{field} harus berupa angka']);
        $this->form_validation->set_rules('status', 'Status Guru', 'required|trim', ['required' => '{field} tidak boleh kosong']);
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required|trim', ['required' => '{field} tidak boleh kosong']);
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim|alpha|callback_cekHuruf', ['required' => '{field} tidak boleh kosong', 'cekHuruf' => '{field} hanya berupa huruf']);
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim|callback_cekHuruf', ['required' => '{field} tidak boleh kosong', 'cekHuruf' => '{field} hanya berupa huruf']);
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim', ['required' => '{field} tidak boleh kosong']);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', ['required' => '{field} tidak boleh kosong']);
        $this->form_validation->set_rules('password', 'Password' , 'required|callback_cekPassword', ['required' => '{field} tidak boleh kosong', 'cekPassword' => '{field} terlalu pendek']);
		$this->form_validation->set_rules('password1', 'Konfirmasi Password', 'required|matches[password]', ['required' => '{field} tidak boleh kosong', 'matches' => '{field} tidak sama']);

    	if ($this->form_validation->run() == FALSE) {
    		getViews($data,'v_admin/v_add_guru');
    	}else{
            $tgl = $this->input->post('tgl_lahir', true);
            $tgl = DateTime::createFromFormat('m/d/Y', $tgl)->format('Y-m-d');

            if (!empty($_FILES['foto']['name'])) {
    			$file = $this->_uploadFile();
    		}else{
    			$file = 'default.png';
            }
            
    		$data = [
                'nama' => $this->input->post('nama', true),
                'foto' => $file,
                'nip' => $this->input->post('nip', true),
                'nik' => $this->input->post('nik', true),
                'kelamin' => $this->input->post('gender', true),
                'tempat_lahir' => $this->input->post('tempat_lahir', true),
                'tanggal_lahir' => $tgl,
                'agama' => $this->input->post('agama', true),
                'alamat' => $this->input->post('alamat', true),
                'telepon' => $this->input->post('telp', true),
                'hak_akses' => $this->input->post('status', true),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT)
    		];

    		if (insertData('tenaga_kependidikan', $data)) {
    			$this->session->set_flashdata('msg_success', 'Selamat, data berhasil ditambahkan');
                redirect('admin/tenaga_pendidik');
    		}else{
    			$this->session->set_flashdata('msg_failed', 'Maaf, data gagal ditambahkan');
                redirect('admin/tenaga_pendidik/tambah');
    		}
    	}
    }

    public function update(){
        $id = $this->uri->segment(4);

        //cek valid id
        if($this->db->get_where('tenaga_kependidikan', ['id_tenaga_kependidikan' => $id])->num_rows() == 0){
            $this->session->set_flashdata('msg_failed', 'Maaf, data tidak cocok');
            redirect('admin/tenaga_pendidik');
        }else{
            $data = [
                'title' => 'Perbarui Tenaga Kependidikan',
                'gtk' => $this->db->get_where('tenaga_kependidikan', ['id_tenaga_kependidikan' => $id])->row_array()
            ];
            
            $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim|callback_cekHuruf', ['required' => 'Nama tidak boleh kosong', 'cekHuruf' => '{field} hanya berupa huruf']);
            $this->form_validation->set_rules('nip', 'NIP', 'required|trim|numeric', ['numeric' => '{field} harus berupa angka', 'CekNIP' => '{field} sudah digunakan']);
            $this->form_validation->set_rules('nik', 'NIK', 'required|trim|numeric', ['numeric' => '{field} harus berupa angka', 'CekNIK' => '{field} sudah digunakan']);
            $this->form_validation->set_rules('telp', 'No Telp', 'numeric|trim', ['numeric' => '{field} harus berupa angka']);
            //$this->form_validation->set_rules('status', 'Status Guru', 'required|trim', ['required' => '{field} tidak boleh kosong']);
            $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required|trim', ['required' => '{field} tidak boleh kosong']);
            $this->form_validation->set_rules('agama', 'Agama', 'required|trim|callback_cekHuruf', ['required' => '{field} tidak boleh kosong','cekHuruf' => '{field} hanya berupa huruf']);
            $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim|callback_cekHuruf', ['required' => '{field} tidak boleh kosong', 'cekHuruf' => '{field} hanya berupa huruf']);
            $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim', ['required' => '{field} tidak boleh kosong']);
            $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', ['required' => '{field} tidak boleh kosong']);

            if(!empty($this->input->post('password'))){
                $this->form_validation->set_rules('password', 'Password' , 'required|callback_cekPassword', ['required' => '{field} tidak boleh kosong', 'cekPassword' => '{field} terlalu pendek']);
                $this->form_validation->set_rules('password1', 'Konfirmasi Password', 'required|matches[password]', ['required' => '{field} tidak boleh kosong', 'matches' => '{field} tidak sama']);
            }

            if ($this->form_validation->run() == FALSE) {
                getViews($data,'v_admin/v_edit_guru');
            }else{

                if (!empty($_FILES['foto']['name'])) {
                    //do upload for new image
                    $foto = $this->_uploadFile();

                    //deleting old image
                    if ($foto && $data['gtk']['foto'] !== 'default.png') {
                        unlink('assets/img/user/' . $data['gtk']['foto']);
                    }
                } else {
                    $foto = $data['gtk']['foto'];
                }

                $tgl = $this->input->post('tgl_lahir');
                if(!empty($tgl)){
                    $tgl = DateTime::createFromFormat('m/d/Y', $tgl)->format('Y-m-d');
                }

                if(!empty($this->input->post('password1'))){
                    $data = [
                        'nama' => $this->input->post('nama', true),
                        'foto' => $foto,
                        'nip' => $this->input->post('nip', true),
                        'nik' => $this->input->post('nik', true),
                        'kelamin' => $this->input->post('gender', true),
                        'tempat_lahir' => $this->input->post('tempat_lahir', true),
                        'tanggal_lahir' => $tgl,
                        'agama' => $this->input->post('agama', true),
                        'alamat' => $this->input->post('alamat', true),
                        'telepon' => $this->input->post('telp', true),
                        'hak_akses' => $this->input->post('status', true),
                        'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT)
                    ];
                }else{
                    $data = [
                        'nama' => $this->input->post('nama', true),
                        'foto' => $foto,
                        'nip' => $this->input->post('nip', true),
                        'nik' => $this->input->post('nik', true),
                        'kelamin' => $this->input->post('gender', true),
                        'tempat_lahir' => $this->input->post('tempat_lahir', true),
                        'tanggal_lahir' => $tgl,
                        'agama' => $this->input->post('agama', true),
                        'alamat' => $this->input->post('alamat', true),
                        'telepon' => $this->input->post('telp', true),
                        'hak_akses' => $this->input->post('status', true)
                    ];
                }

                if ($this->db->update('tenaga_kependidikan', $data, ['id_tenaga_kependidikan' => $id])) {
                    $this->session->set_flashdata('msg_success', 'Selamat, data berhasil diperbarui');
                    redirect('admin/tenaga_pendidik');
                }else{
                    $this->session->set_flashdata('msg_failed', 'Maaf, data gagal diperbarui');
                    redirect('admin/tenaga_pendidik');
                }
            }
        }
    }

    public function delete_wali($id){
        $delete = $this->db->delete('guru_kelas', ['id_gtk' => $id]);

        if ($delete) {
            $this->session->set_flashdata('msg_success', 'Selamat, data berhasil dihapus');
            http_response_code(200);
        }else{
            $this->session->set_flashdata('msg_failed', 'Selamat, data gagal dihapus');
            http_response_code(404);
        }

    }

    public function delete($id){
    	$delete = $this->db->delete('tenaga_kependidikan', ['id_tenaga_kependidikan'=> $id]);

    	if ($delete) {
    		$this->session->set_flashdata('msg_success', 'Selamat, data berhasil dihapus');
    		http_response_code(200);
    	}else{
    		$this->session->set_flashdata('msg_failed', 'Selamat, data gagal dihapus');
    		http_response_code(404);
    	}
    }

    public function guru_kelas(){


        $data = [
            'title' => 'Konfigurasi Wali Kelas',
            'gurus' => $this->db->get_where('tenaga_kependidikan', ['hak_akses' => 'wali kelas'])->result_array(),
            'kelas_list' => $this->db->get('kelas')->result_array(),
            'list' => $this->db->query("SELECT guru_kelas.id_guru_kelas, guru_kelas.id_gtk, guru.id_tenaga_kependidikan, guru.nama, guru.nip, GROUP_CONCAT(kelas.nama_kelas) AS kelas FROM `guru_kelas` JOIN tenaga_kependidikan AS guru ON guru.id_tenaga_kependidikan=guru_kelas.id_gtk JOIN kelas ON kelas.id_kelas=guru_kelas.id_kelas GROUP BY guru.id_tenaga_kependidikan")->result_array()
        ];

        $this->form_validation->set_rules('guru', 'Guru', 'required|trim', ['required' => '{field} tidak boleh kosong']);

        if($this->form_validation->run() == FALSE){
            getViews($data,'v_admin/v_guru_kelas');
        }else{
            $kelas = $this->input->post('kelas');
            $id_gtk = $this->input->post('guru');
            $flag = true;
            for($i=0; $i<count($kelas); $i++){
                //cek duplikat data
                $cekData = $this->db->query("SELECT * FROM `guru_kelas` WHERE `id_kelas` = $kelas[$i]")->num_rows();
                if ($cekData > 0) {
                    $flag = false;
                }else{
                    $data = [
                        'id_gtk' => $this->input->post('guru'),
                        'id_kelas' => $kelas[$i]
                    ];

                    if(!$this->db->insert('guru_kelas', $data)){
                        $flag = false;
                    }
                }
            }

            if($flag){
                $this->session->set_flashdata('msg_success', 'Selamat, data berhasil diperbarui');
                redirect('admin/tenaga_pendidik/guru_kelas');
            }else{
                $this->session->set_flashdata('msg_failed', 'Maaf, data gagal diperbarui');
                redirect('admin/tenaga_pendidik/guru_kelas');
            }
        }
        
    }

    public function update_guru_kelas(){
        if(isset($_POST['id_get_update'])){
            $data_kelas = $this->db->get_where('guru_kelas', ['id_gtk' => $this->input->post('id_get_update')])->result_array();

            foreach($data_kelas AS $kelas){
                $id_kelas[] = $kelas['id_kelas'];
            }

            $data = [
                'id_gtk' => $data_kelas[0]['id_gtk'],
                'id_kelas' => $id_kelas
            ];

            echo json_encode($data);
        }elseif(isset($_POST['perbarui'])){
            $delete = $this->db->delete('guru_kelas', ['id_gtk' => $this->input->post('id_gtk')]);

            if($delete){
                $kelas = $this->input->post('kelas');
                $flag = true;
                for($i=0; $i<count($kelas); $i++){
                    $data = [
                        'id_gtk' => $this->input->post('id_gtk'),
                        'id_kelas' => $kelas[$i]
                    ];
    
                    if(!$this->db->insert('guru_kelas', $data)){
                        $flag = false;
                    }
                }
    
                if($flag){
                    $this->session->set_flashdata('msg_success', 'Selamat, data berhasil diperbarui');
                    redirect('admin/tenaga_pendidik/guru_kelas');
                }else{
                    $this->session->set_flashdata('msg_failed', 'Maaf, data gagal diperbarui');
                    redirect('admin/tenaga_pendidik/guru_kelas');
                }
            }else{
                $this->session->set_flashdata('msg_failed', 'Maaf, data gagal diperbarui');
                redirect('admin/tenaga_pendidik/guru_kelas');
            }
        }
    }

    public function cekHuruf($str){
		return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
	}

    public function cekPassword($str){
		$cek = strlen($str);
		if ($cek <= 6) {
			return false;
		}else{
			return true;
		}
    }

    public function CekNIP($nip)
    {
        $dataNIP = $this->db->get_where('tenaga_kependidikan', ['nip' => $nip])->row_array();

        if (!empty($dataNIP['nip']) && $this->db->get_where('tenaga_kependidikan', ['nip' => $nip])->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function CekNIK($nik)
    {
        $dataNIK = $this->db->get_where('tenaga_kependidikan', ['niK' => $nik])->row_array();
        if (!empty($dataNIK['nik']) && $this->db->get_where('tenaga_kependidikan', ['nik' => $nik])->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }
    
    private function _uploadFile()
    {
        $config['upload_path']          = './assets/img/user/';
        $config['allowed_types']        = 'jpg|png';
        $config['encrypt_name']         = TRUE;
        $config['overwrite']            = true;
        $config['max_size']             = 2048; //2mb

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto')) {
            return false;
        } else {
            return $this->upload->data('file_name');
        }
    }

    public function laporan(){

        $data['gtk'] = $this->db->query("SELECT * FROM `tenaga_kependidikan` WHERE hak_akses = 'guru' OR hak_akses = 'wali kelas'")->result_array();

        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan_pendaftaran.pdf";
        $this->pdf->load_view('v_admin/v_laporan_gtk', $data);
    }

}