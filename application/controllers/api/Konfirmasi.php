<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Konfirmasi extends RestController
{
  public function index_post()
  {
    $token = $this->input->post('token');
    $data = $this->model->get_member($token);
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

  public function send_post()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('id_member', 'Id Member', 'trim|required|numeric');
    $this->form_validation->set_rules('nominal', 'Nominal Pembayaran', 'trim|required|numeric');
    $this->form_validation->set_rules('bank_nama', 'Nama Bank', 'trim|required');
    $this->form_validation->set_rules('no_rekening', 'Nomor Rekening', 'trim|required|numeric');
    $this->form_validation->set_rules('atas_nama', 'Atas Nama', 'trim|required');
    $this->form_validation->set_rules('tanggal', 'Atas Nama', 'trim|required');
    if ($this->form_validation->run() == FALSE) {
      $this->response([
        'status' => false,
        'data' => null,
        'message' => validation_errors()
      ], 400);
    } else {
      $foto = '';
      if ($_FILES['file']['name'] != '') {
        $foto = $this->uploadImage('file');
        $foto = $foto['data'];
      }

      $id_member = $this->input->post('id_member');
      $bank_nama = $this->input->post('bank_nama');
      $no_rekening = $this->input->post('no_rekening');
      $atas_nama = $this->input->post('atas_nama');
      $tanggal = $this->input->post('tanggal');
      $nominal = $this->input->post('nominal');
      $result = $this->model->simpan($id_member, $bank_nama, $no_rekening, $atas_nama, $nominal, $tanggal, $foto);
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
    // import model
    $this->photo_path = './files/bukti_pembayaran/';
    $this->load->model('api/KonfirmasiModel', 'model');
    $this->check_cors = true;
  }
}
