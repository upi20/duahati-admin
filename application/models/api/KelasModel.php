<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelasModel extends Render_Model
{
  public function get_list_kelas($id = null)
  {
    $data = $this->db->select("b.id, b.nama, b.keterangan, b.foto, c.nama as kategori_nama")
      ->from('member_kelas a')
      ->join('kelas b', 'a.kelas_id = b.id', 'left')
      ->join('kelas_kategori c', 'b.kategori_id = c.id', 'left')
      ->where('a.member_id', $id)
      ->where('b.status', 1)
      ->where('a.status', 1);
    $data = $data->get()->result_array();
    $return = [
      'data' => $data,
      'length' => $data == null ? 0 : 1
    ];
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
}
