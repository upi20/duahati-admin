<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KursiModel extends Render_Model
{
  public function list_pertandingan_detail($id_member)
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
      ->where('a.status <>', 3)
      ->get();
    $return = [
      'data' => $data->result_array(),
      'length' => $data->num_rows()
    ];
    return $return;
  }

  public function list_kursi_detail($id_member, $id)
  {
    $taken = $this->getkursi($id_member, $id);
    $is_taken = $taken == null ? 0 : 1;
    $taken_kategori = $taken == null ? 0 : $taken['id_kategori'];
    $data = $this->db->select("id, nama,
    (
      ((nomor_akhir - nomor_mulai) + 1) - ifnull((
        select count(*) from kursi where kursi.id_pertandingan = '$id' and id_kategori = kategori.id
      ) ,0)
      ) as kursi,
      '$is_taken' as is_taken,
      if(id = '$taken_kategori', 1, 0) as taken")
      ->from('kategori')
      ->where('status', 1)
      ->get();

    $return = [
      'data' => $data->result_array(),
      'length' => $data->num_rows()
    ];
    return $return;
  }

  public function simpan($id_member, $id_pertandingan, $id_kategori, $id_kursi)
  {
    $return = $this->db->select('id')->from('kursi')->where([
      'id_pertandingan' => $id_pertandingan,
      'id_kategori' => $id_kategori,
      'nomer_kursi' => $id_kursi,
    ])->get()->row_array();

    if ($return != null) {
      return [
        'data' => null,
        'status' => false,
        'message' => 'Kursi Sudah Dipilih',
        'code' => 409
      ];
    }

    $return = $this->db->insert('kursi', [
      'id_member' => $id_member,
      'id_pertandingan' => $id_pertandingan,
      'id_kategori' => $id_kategori,
      'nomer_kursi' => $id_kursi,
      'status' => 1
    ]);

    return [
      'data' => $return,
      'status' => $return,
      'message' => 'Kursi Berhasil dipilih',
      'code' => 200
    ];
  }

  public function list_kursi_detail_by_kursi($id_member, $id_pertandingan, $id_kategori)
  {
    $taken = $this->getkursi($id_member, $id_pertandingan);
    $is_taken = $taken == null ? 0 : 1;
    $nomor = $taken == null ? 0 : $taken['nomer_kursi'];


    $return = [];
    $data = $this->db->select(' id, nama, ((nomor_akhir - nomor_mulai) + 1) as kursi, nomor_mulai as start, nomor_akhir as end')
      ->from('kategori')
      ->where('status', 1)
      ->where('id', $id_kategori)
      ->get()->row_array();

    $fills = $this->db->select('nomer_kursi as no, id_member as member')
      ->from('kursi')
      ->where('id_kategori', $id_kategori)
      ->where('id_pertandingan', $id_pertandingan)
      ->get()
      ->result_array();
    $terisi = [];
    foreach ($fills as $fill) {
      $terisi[] = $fill['no'];
    }

    for ($i = $data['start']; $i <= $data['end']; $i++) {
      $return[] = [
        'id' => $i,
        'name' => substr(($data['nama']), 0, 1) . $i,
        'available' => in_array($i, $terisi),
        'is_taken' => $is_taken,
        'taken' => $nomor == $i ? 1 : 0
      ];
    }

    return [
      'data' => $return,
      'length' => $data['kursi']
    ];
  }

  private function getkursi($id_member, $id_pertandingan, $id_kategori = null)
  {
    $data = [
      'id_member' => $id_member,
      'id_pertandingan' => $id_pertandingan,
    ];
    if ($id_kategori) {
      $data['id_kategori'] = $id_kategori;
    }
    return $this->db->get_where('kursi', $data)->row_array();
  }
}
