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

  public function get_mentor_by_member($id_member)
  {
    $data = $this->db
      ->select('b.user_nama as nama,	b.user_phone as no_whatsapp, b.user_foto as foto')
      ->from('member a')
      ->join('users b', 'a.mentor_id = b.user_id', 'left')
      ->where('a.id', $id_member)
      ->get();
    $return = [
      'data' => $data->row_array(),
      'length' => $data->num_rows(),
    ];
    return $return;
  }

  public function get_list_slider()
  {
    $data = $this->db->select('id, nama, keterangan, foto')
      ->from('home_slider')
      ->where('status', 1)
      ->get();
    $return = [
      'data' => $data->result_array(),
      'length' => $data->num_rows(),
    ];
    return $return;
  }

  public function get_list_berita()
  {
    $data = $this->db->select('id, judul, foto')
      ->from('news')
      ->where('status', 2)
      ->order_by('tanggal_terbit', 'desc')
      ->limit(4)
      ->get();
    $return = [
      'data' => $data->result_array(),
      'length' => $data->num_rows(),
    ];
    return $return;
  }

  public function get_list_berita_full()
  {
    $data = $this->db->select('id, judul, foto')
      ->from('news')
      ->where('status', 2)
      ->order_by('tanggal_terbit', 'desc')
      ->get();
    $return = [
      'data' => $data->result_array(),
      'length' => $data->num_rows(),
    ];
    return $return;
  }

  public function get_berita($id)
  {
    $data = $this->db->select('*')
      ->from('news')
      ->where('status', 2)
      ->where('id', $id)
      ->order_by('tanggal_terbit', 'desc')
      ->get();
    $return = [
      'data' => $data->row_array(),
      'length' => $data->num_rows(),
    ];
    return $return;
  }
}
