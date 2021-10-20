<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MotModel extends Render_Model
{
  public function getData($id_member, $id_pertandingan)
  {
    $current = $this->db->select('id_pemain, status')
      ->from('tebak_mot')
      ->where('id_member', $id_member)
      ->where('id_pertandingan', $id_pertandingan)
      ->get();
    if ($current->num_rows() > 0) {
      $current = $current->row_array();
    } else {
      $current = [
        'id_pemain' => 0,
        'status' => 0,
      ];
      $this->db->insert('tebak_mot', array_merge([
        'id_member' => $id_member,
        'id_pertandingan' => $id_pertandingan
      ], $current));
    }
    $current = $this->db->select("id,
      nama,
      photo as foto, if(id = '{$current['id_pemain']}', 1, 0) taken,
      '{$current['status']}' as is_taken,
      (
        select count(*) from tebak_mot where tebak_mot.status = 1 and tebak_mot.id_pemain = pemain.id and tebak_mot.id_pertandingan = '$id_pertandingan'
      )as vote")
      ->from('pemain')
      ->where('status', 1)
      ->order_by('vote', 'desc')
      // ->order_by('nama')
      ->get()
      ->result_array();


    $return = [
      'data' => $current,
      'length' => 2
    ];
    return $return;
  }

  public function simpan($id_member, $id_pertandingan, $id_pemain)
  {
    $this->db->where('id_member', $id_member)
      ->where('id_pertandingan', $id_pertandingan);

    return $this->db->update('tebak_mot', [
      'id_pemain' => $id_pemain,
      'status' => 1,
      'updated_at' => Date('Y-m-d h:i:s')
    ]);
  }
}
