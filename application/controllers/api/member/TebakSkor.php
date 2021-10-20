<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class TebakSkor extends RestController
{
  public function index_get()
  {
    $id = $this->get('id');
    $data = $this->model->getData($this->id, $id);
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
    $this->form_validation->set_rules('team_1', 'Goal Team 1', 'trim|required|numeric');
    $this->form_validation->set_rules('team_2', 'Goal Team 1', 'trim|required|numeric');
    if ($this->form_validation->run() == FALSE) {
      $this->response([
        'status' => false,
        'data' => null,
        'message' => validation_errors()
      ], 400);
    } else {

      $pertandingan = $this->input->post('pertandingan');
      $team_1 = $this->input->post('team_1');
      $team_2 = $this->input->post('team_2');
      $result = $this->model->simpan($this->id, $pertandingan, $team_1, $team_2);

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
    $this->load->model('api/TebakSkorModel', 'model');
    $this->check_cors = true;
  }
}
