<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Leardboard extends RestController
{
  public function index_get()
  {
    $id = $this->get('id');
    $data = $this->model->getData($id);
    $code = $data['data'] == null ?
      RestController::HTTP_NOT_FOUND
      : RestController::HTTP_OK;
    $status = $data['data'] != null;

    // send response
    $this->response([
      'status' => $status,
      'length' => $data['length'],
      'data' => $data['data']
    ], $code);
  }

  public function simpan_post()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('pertandingan', 'ID Pertandingan', 'trim|required|numeric');
    $this->form_validation->set_rules('id_pemain', 'ID Pemain', 'trim|required|numeric');
    if ($this->form_validation->run() == FALSE) {
      $this->response([
        'status' => false,
        'data' => null,
        'message' => validation_errors()
      ], 400);
    } else {

      $pertandingan = $this->input->post('pertandingan');
      $id_pemain = $this->input->post('id_pemain');
      $result = $this->model->simpan($this->id, $pertandingan, $id_pemain);

      $code = $result ? RestController::HTTP_OK : 409;
      $status = $result;
      $this->response([
        'status' => $status,
        'length' => 1,
        'data' =>  $result,
        'message' => $result ? 'Data berhasil disimpan' : 'Data gagal disimpan'
      ], $code);
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
    $this->load->model('api/LeardboardModel', 'model');
    $this->check_cors = true;
  }
}
