<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Kursi extends RestController
{
  public function list_kursi_get()
  {
    $id = $this->get('id');
    $data = $this->model->list_kursi_detail($this->id, $id);
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
    $this->form_validation->set_rules('kategori', 'ID Kategori', 'trim|required|numeric');
    $this->form_validation->set_rules('kursi', 'ID Kursi', 'trim|required|numeric');
    if ($this->form_validation->run() == FALSE) {
      $this->response([
        'status' => false,
        'data' => null,
        'message' => validation_errors()
      ], 400);
    } else {

      $pertandingan = $this->input->post('pertandingan');
      $kategori = $this->input->post('kategori');
      $kursi = $this->input->post('kursi');
      $result = $this->model->simpan($this->id, $pertandingan, $kategori, $kursi);

      $this->response($result, $result['code']);
    }
  }

  public function list_kursi_detail_get()
  {
    $id_pertandingan = $this->get('id_pertandingan');
    $id_kategori = $this->get('id_kategori');
    $data = $this->model->list_kursi_detail_by_kursi($this->id, $id_pertandingan, $id_kategori);
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
    $this->load->model('api/KursiModel', 'model');
    $this->check_cors = true;
  }
}
