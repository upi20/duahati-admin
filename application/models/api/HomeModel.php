<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeModel extends Render_Model
{
  public function list_pertandingan_detail($id = null)
  {
    $data = $this->db->select("
    a.id,
    a.tanggal_main as date,
    d.nama as stadion,
    '' as kota,
    a.jam_main as kick,
    '' as stream,
    b.nama as tim_1,
    b.logo as tim_1_foto,
    c.nama as tim_2,
    c.logo as tim_2_foto,
    a.status
    ")
      ->from('pertandingan a')
      ->join('team b', 'a.id_team_1 = b.id')
      ->join('team c', 'a.id_team_2 = c.id')
      ->join('stadion d', 'a.id_stadion = d.id')
      ->where('(a.status between 1 and 3)');
    if ($id) {
      $data->where('a.id', $id);
      $data = $data->get()->row_array();
      $return = [
        'data' => $data,
        'length' => $data == null ? 0 : 1
      ];
    } else {
      $data = $data->get();
      $return = [
        'data' => $data->result_array(),
        'length' => $data->num_rows()
      ];
    }
    return $return;
  }
}
