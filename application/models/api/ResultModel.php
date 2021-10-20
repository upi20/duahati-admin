<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ResultModel extends Render_Model
{
  public function getData($id_pertandingan)
  {
    $mot = $this->db->select("a.menang, ifnull(a.menang, 9999) as menang_sort, b.username as nama, c.nama as result")
      ->from('tebak_mot a')
      ->join('member b', 'a.id_member = b.id')
      ->join('pemain c', 'a.id_pemain = c.id')
      ->where('a.status', 1)
      ->where('a.id_pertandingan', $id_pertandingan)
      ->order_by('menang_sort')
      ->order_by('b.username')
      ->get()
      ->result_array();

    $score = $this->db->select("a.menang, ifnull(a.menang, 9999) as menang_sort, b.username as nama, concat(a.score_team_1, ' vs ', a.score_team_1) result")
      ->from('tebak_score a')
      ->join('member b', 'a.id_member = b.id')
      ->where('a.status', 1)
      ->where('a.id_pertandingan', $id_pertandingan)
      ->order_by('menang_sort')
      ->order_by('b.username')
      ->get()
      ->result_array();

    $kursi = $this->db->select("a.menang, ifnull(a.menang, 9999) as menang_sort, b.username as nama, concat(c.nama, ' ', a.nomer_kursi) as result")
      ->from('kursi a')
      ->join('member b', 'a.id_member = b.id')
      ->join('kategori c', 'a.id_kategori = c.id')
      ->where('a.status', 1)
      ->where('a.id_pertandingan', $id_pertandingan)
      ->order_by('menang_sort')
      ->order_by('b.username')
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
}
