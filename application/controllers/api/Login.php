<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Login extends RestController
{
  public function index_post()
  {
    $username   = $this->input->post('email');
    $password   = $this->input->post('password');
    $login     = $this->login->cekLogin($username, $password);
    switch ($login['status']) {
      case 0: // user found
        switch ($login['data'][0]['status']) {
          case 0: // akun nonaktif
            $this->response([
              'status' => false,
              'message' => 'Akun di nonaktifkan'
            ], 400);
            break;

          case 1: // oke
            $data = [
              'key' => $login['data'][0]['token'],
              'id' => $login['data'][0]['id'],
              'nama' => $login['data'][0]['nama'],
              'email' => $login['data'][0]['email'],
              'foto' => $login['data'][0]['foto'],
            ];
            $this->response([
              'status' => true,
              'message' => 'Login berhasil',
              'data' => $data
            ], 200);
            break;

          case 0: // akun nonaktif
            $this->response([
              'status' => false,
              'message' => 'Akun di nonaktifkan'
            ], 400);
            break;

          case 2: // belum bayar
            $this->response([
              'status' => false,
              'message' => 'Pembayaran belum dilakukan'
            ], 400);
            break;

          default: // default
            $this->response([
              'status' => false,
              'message' => 'Server error'
            ], 500);
            break;
        }
        break;

      case 1: // Passwor Salah
        $this->response([
          'status' => false,
          'message' => 'Password salah'
        ], 400);
        break;

      default: // default
        $this->response([
          'status' => false,
          'message' => 'Akun tidak ditemukan'
        ], 400);
        break;
    }
  }

  public function registrasi_post()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('telepon', 'No Whatsapp', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');
    if ($this->form_validation->run() == FALSE) {
      $this->response([
        'status' => false,
        'data' => null,
        'message' => validation_errors()
      ], 400);
    } else {
      try {
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $telepon = $this->input->post('telepon');
        $password = $this->input->post('password');
        $referral = $this->input->post('referral');
        $result = $this->login->registrasi($nama, $email, $telepon, $password, $referral, 2);
        $this->response([
          'status' => $result->status,
          'length' => 1,
          'data' =>  $result->data,
          'message' => $result->message,
        ], $result->code);
      } catch (\Throwable $th) {
        $this->response([
          'status' => false,
          'length' => 0,
          'data' =>  null,
          'message' => 'Internal Server error',
        ], 500);
      }
    }
  }

  function __construct()
  {
    parent::__construct();
    $this->load->model('api/LoginModel', 'login');
    $this->check_cors = true;
  }
}
