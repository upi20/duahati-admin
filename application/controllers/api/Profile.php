<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Profile extends RestController
{
  private $id;
  public function info_get()
  {
    $data = $this->model->info($this->id);
    $kode = $data == null ? 404 : 200;
    $length = $data == null ? 0 : 1;
    $status = $data != null;

    if ($data != null) {
      $bulan_array = [
        1 => 'Januari',
        2 => 'February',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
      ];
      if ($data['since']) {
        $p = explode('-', $data['since']);
        $data['since_str'] = $p[2] . ' ' . $bulan_array[(int)$p[1]] . ' ' . $p[0];
      }
    }

    $this->response([
      'status' => $status,
      'length' => $length,
      'data' => $data,
    ], $kode);
  }

  public function update_post()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('telepon', 'No Whatsapp', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim');
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

      // revisi v2
      $nama_panggilan = $this->input->post('nama_panggilan');
      $tanggal_lahir = $this->input->post('tanggal_lahir');
      $jenis_kelamin = $this->input->post('jenis_kelamin');
      $status = $this->input->post('status');
      $alamat_provinsi = $this->input->post('alamat_provinsi');
      $alamat_kabupaten_kota = $this->input->post('alamat_kabupaten_kota');
      $alamat_kecamatan = $this->input->post('alamat_kecamatan');
      $alamat_desa_kelurahan = $this->input->post('alamat_desa_kelurahan');
      $detail_lainnya = $this->input->post('detail_lainnya');

      $result = $this->model->UpdateProfile(
        $this->id,
        $nama,
        $email,
        $telepon,
        $password,
        $nama_panggilan,
        $tanggal_lahir,
        $jenis_kelamin,
        $status,
        $alamat_provinsi,
        $alamat_kabupaten_kota,
        $alamat_kecamatan,
        $alamat_desa_kelurahan,
        $detail_lainnya
      );

      $code = $result['code'] != 1 ?
        409
        : RestController::HTTP_OK;
      $status = $result['code'] != 0;
      $this->response([
        'status' => $status,
        'length' => 1,
        'data' =>  $result,
        'message' => $code == 200 ? 'Data berhasil diubah' : 'Email sudah terdaftar'
      ], $code);
    }
  }

  public function index_get()
  {
    $profile = $this->model->getProfileBody($this->id);
    $penjualan = $this->model->getSumPenjualanThisMonth($this->id);

    $this->response([
      'status' => true,
      'length' => 2,
      'data' => [
        'profile' => $profile,
        'warung' => [
          'warung' => $this->model->getSumWarung($this->id),
          'karton' => $penjualan['karton'],
          'renceng' => $penjualan['renceng'],
          'start_date' => $penjualan['start_date'],
          'end_date' => $penjualan['end_date'],
        ]
      ],
    ], RestController::HTTP_OK);
  }


  function __construct()
  {
    parent::__construct();
    $key = $this->input->get('key');
    $key = $key ?? $this->input->post('key');
    $this->key = $key;
    if ($key == null) {
      $this->response([
        'status' => false,
        'message' => 'Key Tidak Valid'
      ], RestController::HTTP_UNAUTHORIZED);
      exit();
    }

    // cek level
    // Get data
    $userdata = $this->sesion->cek_userdata_api_member($key);
    if ($userdata == null) {
      $this->response([
        'status' => false,
        'message' => 'Key Tidak Valid'
      ], RestController::HTTP_UNAUTHORIZED);
      exit();
    }
    $this->id = $userdata['id'];

    // import model
    $this->load->model('api/ProfileModel', 'model');
  }
}
