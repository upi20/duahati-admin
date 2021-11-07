<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Referral extends RestController
{
  public function profile_get()
  {
    $data = $this->model->profile($this->id);
    $code = $data['data'] == null ?
      RestController::HTTP_NOT_FOUND
      : RestController::HTTP_OK;
    $status = $data['data'] != null;

    $this->response([
      'status' => $status,
      'length' => $data['length'],
      'data' => $data['data']
    ], $code);
  }

  public function reward_get()
  {
    $data = $this->model->reward($this->id);
    $code = $data['data'] == null ?
      RestController::HTTP_NOT_FOUND
      : RestController::HTTP_OK;
    $status = $data['data'] != null;

    $this->response([
      'status' => $status,
      'length' => $data['length'],
      'data' => $data['data']
    ], $code);
  }

  public function riwayat_pencairan_post()
  {
    $order = ['order' => $this->input->post('order'), 'columns' => $this->input->post('columns')];
    $start = $this->input->post('start');
    $draw = $this->input->post('draw');
    $draw = $draw == null ? 1 : $draw;
    $length = $this->input->post('length');
    $cari = $this->input->post('search');

    if (isset($cari['value'])) {
      $_cari = $cari['value'];
    } else {
      $_cari = null;
    }

    $news = $this->input->post('news');
    $member = $this->id;
    $filter = [
      'news' => $news,
      'member' => $member,
    ];

    $data = $this->model->riwayat_pencairan($draw, $length, $start, $_cari, $order, $filter)->result_array();
    $count = $this->model->riwayat_pencairan(null, null, null, $_cari, $order, $filter)->num_rows();
    $this->response(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data], 200);
  }

  public function riwayat_pendapatan_post()
  {
    $order = ['order' => $this->input->post('order'), 'columns' => $this->input->post('columns')];
    $start = $this->input->post('start');
    $draw = $this->input->post('draw');
    $draw = $draw == null ? 1 : $draw;
    $length = $this->input->post('length');
    $cari = $this->input->post('search');

    if (isset($cari['value'])) {
      $_cari = $cari['value'];
    } else {
      $_cari = null;
    }

    $news = $this->input->post('news');
    $member = $this->id;
    $filter = [
      'news' => $news,
      'member' => $member,
    ];

    $data = $this->model->riwayat_pendapatan($draw, $length, $start, $_cari, $order, $filter)->result_array();
    $count = $this->model->riwayat_pendapatan(null, null, null, $_cari, $order, $filter)->num_rows();
    $this->response(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data], 200);
  }

  public function mengundang_post()
  {
    $order = ['order' => $this->input->post('order'), 'columns' => $this->input->post('columns')];
    $start = $this->input->post('start');
    $draw = $this->input->post('draw');
    $draw = $draw == null ? 1 : $draw;
    $length = $this->input->post('length');
    $cari = $this->input->post('search');

    if (isset($cari['value'])) {
      $_cari = $cari['value'];
    } else {
      $_cari = null;
    }

    $news = $this->input->post('news');
    $member = $this->id;
    $filter = [
      'news' => $news,
      'member' => $member,
    ];

    $data = $this->model->mengundang($draw, $length, $start, $_cari, $order, $filter)->result_array();
    $count = $this->model->mengundang(null, null, null, $_cari, $order, $filter)->num_rows();
    $this->response(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data], 200);
  }

  public function pencairan_post()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('atas_nama', 'Atas Nama', 'trim|required');
    $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'trim|required');
    $this->form_validation->set_rules('no_rekening', 'No Rekening', 'trim|required|numeric');
    $this->form_validation->set_rules('jumlah_dana', 'Jumlah Dana', 'trim|required|numeric');
    if ($this->form_validation->run() == FALSE) {
      $this->response([
        'status' => false,
        'data' => null,
        'message' => validation_errors()
      ], 400);
    } else {
      $atas_nama = $this->input->post('atas_nama');
      $nama_bank = $this->input->post('nama_bank');
      $no_rekening = $this->input->post('no_rekening');
      $jumlah_dana = $this->input->post('jumlah_dana');
      $result = $this->model->pencairan($this->id, $atas_nama, $nama_bank, $no_rekening, $jumlah_dana);
      $this->response([
        'status' => $result->status,
        'length' => 1,
        'data' =>  $result->data,
        'message' => $result->message,
      ], $result->code);
    }
  }


  public function uploadImage($name)
  {
    $config['upload_path']          = $this->photo_path;
    $config['allowed_types']        = 'jpg|png|jpeg|JPG|PNG|JPEG';
    $config['file_name']            = md5(uniqid("duahati", true));
    $config['overwrite']            = true;
    $config['max_size']             = 8024;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if ($this->upload->do_upload($name)) {
      return [
        'status' => true,
        'data' => $this->upload->data("file_name"),
        'message' => 'Success'
      ];
    } else {
      return [
        'status' => false,
        'data' => null,
        'message' => $this->upload->display_errors('', '')
      ];
    }
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
    $this->load->model('api/ReferralModel', 'model');
    $this->check_cors = true;
  }
}
