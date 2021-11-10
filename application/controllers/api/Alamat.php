<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Alamat extends RestController
{

  public function provinsi_get()
  {
    $key = $this->input->get('q');
    // jika inputan ada
    if ($key) {
      $result = $this->model->provinsi($key);
      $this->response([
        'status' => true,
        'length' => 1,
        'results' =>  $result['results'],
      ], 200);
    } else {
      $this->response([
        'status' => false,
        'length' => 0,
        'results' => [],
      ], 200);
    }
  }

  public function provinsi_post()
  {
    $key = $this->input->post('q');
    // jika inputan ada
    if ($key) {
      $result = $this->model->provinsi($key);
      $this->response([
        'status' => true,
        'length' => 1,
        'results' =>  $result['results'],
      ], 200);
    } else {
      $this->response([
        'status' => false,
        'length' => 0,
        'results' => [],
      ], 200);
    }
  }

  public function provinsi_all_get()
  {
    $result = $this->model->provinsi_all();
    $this->response([
      'status' => true,
      'length' => 1,
      'results' =>  $result['results'],
    ], 200);
  }

  public function provinsi_all_post()
  {
    $result = $this->model->provinsi_all();
    $this->response([
      'status' => true,
      'length' => 1,
      'results' =>  $result['results'],
    ], 200);
  }

  public function kabupaten_kota_get()
  {
    $id_provinsi = $this->input->get('id_provinsi');
    $key = $this->input->get('q');
    // jika inputan ada
    if ($key && $id_provinsi) {
      $result = $this->model->kabupaten_kota($id_provinsi, $key);
      $this->response([
        'status' => true,
        'length' => 1,
        'results' =>  $result['results'],
      ], 200);
    } else {
      $this->response([
        'status' => false,
        'length' => 0,
        'results' => [],
      ], 200);
    }
  }

  public function kabupaten_kota_post()
  {
    $id_provinsi = $this->input->post('id_provinsi');
    $key = $this->input->post('q');
    // jika inputan ada
    if ($key && $id_provinsi) {
      $result = $this->model->kabupaten_kota($id_provinsi, $key);
      $this->response([
        'status' => true,
        'length' => 1,
        'results' =>  $result['results'],
      ], 200);
    } else {
      $this->response([
        'status' => false,
        'length' => 0,
        'results' => [],
      ], 200);
    }
  }

  public function kecamatan_get()
  {
    $id_kabupaten_kota = $this->input->get('id_kabupaten_kota');
    $key = $this->input->get('q');
    // jika inputan ada
    if ($key && $id_kabupaten_kota) {
      $result = $this->model->kecamatan($id_kabupaten_kota, $key);
      $this->response([
        'status' => true,
        'length' => 1,
        'results' =>  $result['results'],
      ], 200);
    } else {
      $this->response([
        'status' => false,
        'length' => 0,
        'results' => [],
      ], 200);
    }
  }

  public function kecamatan_post()
  {
    $id_kabupaten_kota = $this->input->post('id_kabupaten_kota');
    $key = $this->input->post('q');
    // jika inputan ada
    if ($key && $id_kabupaten_kota) {
      $result = $this->model->kecamatan($id_kabupaten_kota, $key);
      $this->response([
        'status' => true,
        'length' => 1,
        'results' =>  $result['results'],
      ], 200);
    } else {
      $this->response([
        'status' => false,
        'length' => 0,
        'results' => [],
      ], 200);
    }
  }

  public function desa_kelurahan_get()
  {
    $id_kecamatan = $this->input->get('id_kecamatan');
    $key = $this->input->get('q');
    // jika inputan ada
    if ($key && $id_kecamatan) {
      $result = $this->model->desa_kelurahan($id_kecamatan, $key);
      $this->response([
        'status' => true,
        'length' => 1,
        'results' =>  $result['results'],
      ], 200);
    } else {
      $this->response([
        'status' => false,
        'length' => 0,
        'results' => [],
      ], 200);
    }
  }

  public function desa_kelurahan_post()
  {
    $id_kecamatan = $this->input->post('id_kecamatan');
    $key = $this->input->post('q');
    // jika inputan ada
    if ($key && $id_kecamatan) {
      $result = $this->model->desa_kelurahan($id_kecamatan, $key);
      $this->response([
        'status' => true,
        'length' => 1,
        'results' =>  $result['results'],
      ], 200);
    } else {
      $this->response([
        'status' => false,
        'length' => 0,
        'results' => [],
      ], 200);
    }
  }


  function __construct()
  {

    parent::__construct();
    $this->load->model('api/AlamatModel', 'model');
  }
}
