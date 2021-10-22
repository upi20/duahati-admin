<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelasModel extends Render_Model
{
  public function get_list_kelas($id = null)
  {
    $data = $this->db->select("b.id, b.nama, b.keterangan, b.foto, c.nama as kategori_nama, a.id as member_kelas_id, b.tipe, (if(b.tipe = 2,(
      select count(*) from member_kelas as z where z.status = 1 and z.member_id = '$id' and z.kelas_id = b.id
    ), 1)) taken, b.status")
      ->from('kelas b')
      ->join('member_kelas a', '((a.kelas_id = b.id) and (a.status <> 3))', 'left')
      ->join('kelas_kategori c', 'b.kategori_id = c.id', 'left')
      ->where('b.status', 1)
      ->order_by('taken');

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

    $mentor = $this->get_mentor_by_member($member_id)['data'];

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

  public function get_materi($member_id, $materi_id)
  {
    $materi  = $this->db->select('a.id, a.no_urut, a.nama, a.keterangan, a.url, a.kelas_id, (
      select id from kelas_materi as z where no_urut < a.no_urut and z.kelas_id = a.kelas_id order by no_urut desc limit 1
      ) as sebelumnya, (
        select id from kelas_materi as z where no_urut > a.no_urut and z.kelas_id = a.kelas_id limit 1
      ) as selanjutnya
    ')
      ->from('kelas_materi a')
      ->where('a.id', $materi_id)
      ->where('a.status', 1)
      ->get()->row_array();

    $tonton = $this->db->select('id, materi_feedback_nilai, materi_feedback_keterangan, mentor_feedback_nilai, mentor_feedback_keterangan')
      ->from('member_materi_tonton')
      ->where('member_id', $member_id)
      ->where('kelas_materi_id', $materi_id)
      ->where('status', 1)
      ->get()->row_array();
    $return = [
      'data' => [
        'materi' => $materi,
        'tonton' => $tonton,
      ],
      'length' => 2,
    ];
    return $return;
  }

  public function feedback(
    $member_id,
    $kelas_id,
    $keterangan_materi,
    $keterangan_mentor,
    $materi_id,
    $nilai_materi,
    $nilai_mentor,
    $tonton_id
  ) {
    if ($tonton_id == 0) {
      $data = [
        'member_id' => $member_id,
        'kelas_id' => $kelas_id,
        'kelas_materi_id' => $materi_id,
        'materi_feedback_nilai' => $nilai_materi,
        'materi_feedback_keterangan' => $keterangan_materi,
        'mentor_feedback_nilai' => $nilai_mentor,
        'mentor_feedback_keterangan' => $keterangan_mentor,
        'status' => 1,
        // 'created_by' => $member_id,
      ];
      $this->db->insert('member_materi_tonton', $data);
      return [
        'status' => true,
        'id' => $this->db->insert_id(),
      ];
    } else {
      $data = [
        'materi_feedback_nilai' => $nilai_materi,
        'materi_feedback_keterangan' => $keterangan_materi,
        'mentor_feedback_nilai' => $nilai_mentor,
        'mentor_feedback_keterangan' => $keterangan_mentor,
        // 'updated_by' => $member_id,
      ];

      $this->db->where('id', $tonton_id)->update('member_materi_tonton', $data);
      return [
        'status' => true,
        'id' => $tonton_id,
      ];
    }
  }
}
