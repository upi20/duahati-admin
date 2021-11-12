<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Kelas extends RestController
{
  public function list_kelas_vip_get()
  {
    $data = $this->model->get_list_kelas_vip($this->id);
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
  public function list_kelas_get()
  {
    $data = $this->model->get_list_kelas();
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

  public function get_mentor_get()
  {
    $data = $this->model->get_mentor_by_member($this->id);
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

  public function kelas_head_get()
  {
    $kelas_id = $this->input->get('kelas_id');
    $data = $this->model->kelas_head($this->id, $kelas_id);
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

  public function kelas_body_list_get()
  {
    $kelas_id = $this->input->get('kelas_id');
    $data = $this->model->kelas_body_list($this->id, $kelas_id);
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

  public function get_materi_get()
  {
    $materi_id = $this->input->get('materi_id');
    $data = $this->model->get_materi($this->id, $materi_id);
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

  public function feedback_post()
  {
    $kelas_id = $this->input->post('kelas_id');
    $keterangan_materi = $this->input->post('keterangan_materi');
    $keterangan_mentor = $this->input->post('keterangan_mentor');
    $materi_id = $this->input->post('materi_id');
    $nilai_materi = $this->input->post('nilai_materi');
    $nilai_mentor = $this->input->post('nilai_mentor');
    $tonton_id = $this->input->post('tonton_id');
    $return = $this->model->feedback(
      $this->id,
      $kelas_id,
      $keterangan_materi,
      $keterangan_mentor,
      $materi_id,
      $nilai_materi,
      $nilai_mentor,
      $tonton_id
    );
    $this->response($return, 200);
  }


  // sub materi
  public function get_materi_sub_get()
  {
    $materi_id = $this->input->get('materi_id');
    $data = $this->model->get_materi_sub($this->id, $materi_id);
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
  public function get_materi_sub_detail_get()
  {
    $materi_sub_id = $this->input->get('materi_sub_id');
    $data = $this->model->get_materi_sub_detail($this->id, $materi_sub_id);
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


  public function feedback_sub_post()
  {
    $kelas_id = $this->input->post('kelas_id');
    $keterangan_materi = $this->input->post('keterangan_materi');
    $keterangan_mentor = $this->input->post('keterangan_mentor');
    $materi_sub_id = $this->input->post('materi_sub_id');
    $nilai_materi = $this->input->post('nilai_materi');
    $nilai_mentor = $this->input->post('nilai_mentor');
    $tonton_id = $this->input->post('tonton_id');
    $materi_id = $this->input->post('materi_id');
    $finish = $this->input->post('finish');
    $return = $this->model->feedback_sub(
      $this->id,
      $kelas_id,
      $materi_id,
      $keterangan_materi,
      $keterangan_mentor,
      $materi_sub_id,
      $nilai_materi,
      $nilai_mentor,
      $tonton_id,
      $finish
    );
    $this->response($return, 200);
  }

  public function kelas_head_sub_get()
  {
    $materi_id = $this->input->get('materi_id');
    $data = $this->model->materi_sub_head($this->id, $materi_id);
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
    $this->load->model('api/KelasModel', 'model');
    $this->check_cors = true;
  }
}
