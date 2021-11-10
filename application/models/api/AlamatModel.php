<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlamatModel extends Render_Model
{
  public function provinsi(String $key): array
  {
    $data = $this->db->select('id, name as text')
      ->from('address_provinces')
      ->where("name like '%$key%'")
      ->limit(10)
      ->get();

    $return  = [
      'length' => $data->num_rows(),
      'results' => $data->result_array()
    ];
    return $return;
  }

  public function kabupaten_kota($id_provinsi, String $key): array
  {
    $data = $this->db->select('id, name as text')
      ->from('address_regencies')
      ->where("province_id", $id_provinsi)
      ->where("(name like '%$key%')")
      ->limit(10)
      ->get();

    $return  = [
      'length' => $data->num_rows(),
      'results' => $data->result_array()
    ];
    return $return;
  }

  public function kecamatan($id_kabupaten_kota, String $key): array
  {
    $data = $this->db->select('id, name as text')
      ->from('address_districts')
      ->where("regency_id", $id_kabupaten_kota)
      ->where("(name like '%$key%')")
      ->limit(10)
      ->get();

    $return  = [
      'length' => $data->num_rows(),
      'results' => $data->result_array()
    ];
    return $return;
  }

  public function desa_kelurahan($id_kecamatan, String $key): array
  {
    $data = $this->db->select('id, name as text')
      ->from('address_villages')
      ->where("district_id", $id_kecamatan)
      ->where("(name like '%$key%')")
      ->limit(10)
      ->get();

    $return  = [
      'length' => $data->num_rows(),
      'results' => $data->result_array()
    ];
    return $return;
  }
}
