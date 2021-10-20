<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LeardboardModel extends Render_Model
{
  public function getData($id_pertandingan)
  {
    $mot = $this->db->select('a.menang, b.username as nama')
      ->from('tebak_mot a')
      ->join('member b', 'a.id_member = b.id')
      ->where('a.menang <>', null)
      ->where('a.status', 1)
      ->where('a.id_pertandingan', $id_pertandingan)
      ->order_by('a.menang')
      ->get()
      ->result_array();

    $score = $this->db->select('a.menang, b.username as nama')
      ->from('tebak_score a')
      ->join('member b', 'a.id_member = b.id')
      ->where('a.menang <>', null)
      ->where('a.status', 1)
      ->where('a.id_pertandingan', $id_pertandingan)
      ->order_by('a.menang')
      ->get()
      ->result_array();

    $kursi = $this->db->select('a.menang, b.username as nama')
      ->from('kursi a')
      ->join('member b', 'a.id_member = b.id')
      ->where('a.menang <>', null)
      ->where('a.status', 1)
      ->where('a.id_pertandingan', $id_pertandingan)
      ->order_by('a.menang')
      ->get()
      ->result_array();

    $return = [
      'data' => [
        'mot' => $mot,
        'score' => $score,
        'kursi' => $kursi,
      ],
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
