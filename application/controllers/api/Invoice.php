<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends RestController
{
  public function index_get()
  {
    try {
      $data = $this->model->member($this->id);
      $code = $data['data'] == null ?
        RestController::HTTP_NOT_FOUND
        : RestController::HTTP_OK;
      $status = $data['data'] != null;
      $this->response([
        'status' => $status,
        'length' => $data['length'],
        'data' => $data['data']
      ], $code);
    } catch (\Throwable $th) {
      $this->response([
        'status' => false,
        'length' => 0,
        'data' => null,
        'message' => 'Internal Server Error'
      ], 500);
    }
  }

  public function rekening_get()
  {
    $data = $this->model->get_list_rekening();
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
    $this->load->model('api/InvoiceModel', 'model');
    $this->check_cors = true;
  }
}
