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

  public function get_mentor_by_member($member_id)
  {
    $data = $this->db
      ->select('b.user_nama as nama,	b.user_phone as no_whatsapp, b.user_foto as foto')
      ->from('member a')
      ->join('users b', 'a.mentor_id = b.user_id', 'left')
      ->where('a.id', $member_id)
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

  public function kelas_head($member_id, $kelas_id)
  {
    $selesai = $this->db->select('count(*) as jumlah')
      ->from('member_materi_tonton')
      ->where('status', 1)
      ->where('kelas_id', $kelas_id)
      ->where('member_id', $member_id)
      ->get()
      ->row_array();

    $total = $this->db->select('count(*) as jumlah')
      ->from('kelas_materi')
      ->where('status', 1)
      ->where('kelas_id', $kelas_id)
      ->get()
      ->row_array();

    $data = $this->db
      ->select("a.foto, b.nama as kategori_nama, a.nama, a.keterangan")
      ->from('kelas a')
      ->join('kelas_kategori b', 'a.kategori_id = b.id', 'left')
      ->where('a.id', $kelas_id)
      ->get()->row_array();

    $mentor = $this->db
      ->select('b.user_nama as nama, b.user_phone as no_whatsapp, b.user_foto as foto')
      ->from('member a')
      ->join('users b', 'a.mentor_id = b.user_id', 'left')
      ->where('a.id', $member_id)
      ->get()->row_array();

    $return = [
      'data' => [
        'kelas' => $data,
        'selesai' => $selesai['jumlah'],
        'total' => $total['jumlah'],
        'mentor' => $mentor,
      ],
      'length' => 3,
    ];
    return $return;
  }

  public function kelas_body_list($member_id, $kelas_id)
  {
    $data =  $this->db
      ->select("a.id, a.nama, (
        select count(*) from member_materi_tonton as z where z.member_id = '$member_id' and z.kelas_id = '$kelas_id' and z.kelas_materi_id = a.id and z.status = 1
      ) selesai")
      ->from('kelas_materi a')
      ->where('a.kelas_id', $kelas_id)
      ->where('a.status', 1)
      ->get();
    $return = [
      'data' => $data->result_array(),
      'length' => $data->num_rows(),
    ];
    return $return;
  }
}
