<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class Auth extends CI_controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_auth');
    }

    public function login()
    {
        $this->form_validation->set_rules('username', 'Email Atau Username', 'required|trim', ['required' => 'Maaf, Email belum diisi!']);
        $this->form_validation->set_rules('password', 'Password', 'required', ['required' => 'Maaf, Password belum diisi!']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('v_guru/v_login');
        } else {
            //cek data for guru
            $user = $this->m_auth->cekUserGuru($this->input->post('username', TRUE));
            
            if (!empty($user)) {
                if (password_verify($this->input->post('password'), $user['password'])) {

                    $data = [
                        'is_login' => 'mangga',
                        'nama' => $user['nama'],
                        'username' => $user['nip'],
                        'nama_role' => 'Guru',
                        'foto' => $user['foto'],
                        'role' => 2
                    ];

                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('msg_success', 'Selamat, Anda berhasil login');
                    redirect('guru/dashboard');
                } else {
                    $this->session->set_flashdata('msg_failed', 'Ups!, Password anda salah!');
                    redirect('guru');
                }
            } else {
                $this->session->set_flashdata('msg_failed', 'Ups!, Akun anda belum terdaftar!');
                redirect('guru');
            }
        }
    }

    /*public function logout()
    {
        $this->session->unset_userdata('is_login');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('foto');
        $this->session->unset_userdata('nama_role');
        $this->session->set_flashdata('msg_success', 'Selamat, Anda berhasil logut');
        redirect('/');
    }

    public function logout_sistem()
    {

        //update login status
            $this->session->unset_userdata('is_login');
            $this->session->unset_userdata('nama');
            $this->session->set_flashdata('msg_success', 'Selamat, Anda berhasil logut');
            redirect('?p=login');
    }*/
}
