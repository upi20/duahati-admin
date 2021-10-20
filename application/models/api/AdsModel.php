<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdsModel extends Render_Model
{
  public function getData($id_user, $id_pertandingan)
  {
    $this->db->trans_start();
    $ads = $this->db->select('a.*, (
      select count(*) from iklan_member b where b.id_iklan = a.id
      ) as dilihat')
      ->from('iklan a')
      ->where('id_pertandingan', $id_pertandingan)
      ->where('status', 1)
      ->order_by('dilihat')
      ->get()->row_array();
    if ($ads == null) {
      return [
        'data' => null,
        'length' => 0
      ];
    }
    $data = [
      'id_pertandingan' => $id_pertandingan,
      'id_iklan' => $ads['id'],
      'id_member' => $id_user,
      'status' => 1,
      'created_at' => date("Y-m-d H:i:s"),
    ];
    $this->db->insert('iklan_member', $data);
    $this->db->trans_complete();

    return [
      'data' => $ads,
      'length' => 1
    ];
  }
}
