<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InvoiceModel extends Render_Model
{
  public function get_list_rekening($id = null)
  {
    $data = $this->db->select("nama_bank, no_rekening, atas_nama")
      ->from('rekening')->where('status', 1);
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

  public function member($member_id)
  {
    $return = $this->db->select('nama, 	no_telepon, email, biaya_pendaftaran')
      ->from('member')
      ->where('id', $member_id)
      ->get()
      ->row_array();
    return [
      'length' => is_null($return) ? 0 : 4,
      'data' => $return
    ];
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
