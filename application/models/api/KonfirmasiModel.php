<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KonfirmasiModel extends Render_Model
{
  public function get_member($token)
  {
    $data = $this->db->select("id, nama, no_telepon, email, biaya_pendaftaran")
      ->from('member')->where('token', $token);
    $data = $data->get();
    $return = [
      'data' => $data->row_array(),
      'length' => $data->num_rows()
    ];
    return $return;
  }


  public function simpan($id_member, $bank_nama, $no_rekening, $atas_nama, $nominal, $tanggal, $foto)
  {
    $data = [
      'member_id' => $id_member,
      'bank_nama' => $bank_nama,
      'no_rekening' => $no_rekening,
      'atas_nama' => $atas_nama,
      'jumlah_pembayaran' => $nominal,
      'tanggal' => $tanggal,
      'foto' => $foto,
      'jenis' => 1, //pembayaran pendaftaran
      'tipe' => 1, //Transfer Bank
      'status' => 0, //diajukan
    ];

    $result = $this->db->insert('pembayaran', $data);
    return (object)[
      'code' => 200,
      'status' => true,
      'data' => $result,
      'message' => 'success',
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
