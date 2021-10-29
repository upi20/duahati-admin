<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Rekening extends RestController
{
  public function index_get()
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
    // import model
    $this->load->model('api/RekeningModel', 'model');
    $this->check_cors = true;
  }
}
