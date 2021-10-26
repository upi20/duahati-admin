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
    if ($login['status'] == 0) {
      // Set session value
      // akun aktif
      if ($login['data'][0]['status'] == 1) {
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
      }
      // akun di nonaktifkan
      else if ($login['data'][0]['status'] == 0) {
        $this->response([
          'status' => false,
          'message' => 'Akun di nonaktifkan'
        ], 400);
      }
      // menunggu dikonfirmasi
      else if ($login['data'][0]['status'] == 2) {
        $this->response([
          'status' => false,
          'message' => 'Akun di nonaktifkan'
        ], 400);
      }
      // erorr
      else {
        $this->response([
          'status' => false,
          'message' => 'Server error'
        ], 500);
      }
    } else if ($login['status'] == 1) {
      $this->response([
        'status' => false,
        'message' => 'Password salah'
      ], 400);
    } else {
      $this->response([
        'status' => false,
        'message' => 'Akun tidak ditemukan'
      ], 400);
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
      $nama = $this->input->post('nama');
      $email = $this->input->post('email');
      $telepon = $this->input->post('telepon');
      $password = $this->input->post('password');
      $result = $this->login->registrasi($nama, $email, $telepon, $password);

      $code = $result == null ?
        400
        : RestController::HTTP_OK;
      $status = $result != null;
      $this->response([
        'status' => $status,
        'length' => 1,
        'data' =>  $result
      ], $code);
    }
  }

  function __construct()
  {
    parent::__construct();
    $this->load->model('api/LoginModel', 'login');
    $this->check_cors = true;
  }
}
// uniqid("distribusi".Date('Ymdhis'), false); uuid generator
/* End of file Login.php */
/* Location: ./application/controllers/Login.php */