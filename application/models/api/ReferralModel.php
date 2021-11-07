<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReferralModel extends Render_Model
{
  public function profile($member_id)
  {
    $data = $this->db->select('a.nama, a.kode_referral, a.foto, b.nama as pengundang')
      ->from('member a')
      ->join('member b', 'a.parrent_id = b.id', 'left')
      ->where('a.id', $member_id)

      // data dipilih yang aktif
      ->where('a.status', 1)
      ->get()->row_array();

    $return = [
      'data' => $data,
      'length' => is_null($data) ? 0 : 1
    ];

    return $return;
  }

  public function reward($member_id)
  {
    // get dulu
    $data = $this->db->select('total_pendapatan, dicairkan, belum_dicairkan')
      ->from('referral a')
      ->where('a.member_id', $member_id)
      ->get()->row_array();

    // jika data tidak ada maka ditambah
    if (is_null($data)) {
      $data = [
        'total_pendapatan' => 0,
        'dicairkan' => 0,
        'belum_dicairkan' => 0
      ];

      $this->db->insert('referral', ['member_id' => $member_id]);
    }

    $return = [
      'data' => $data,
      'length' => is_null($data) ? 0 : 1
    ];
    return $return;
  }

  public function riwayat_pencairan($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null)
  {
    // select tabel
    $this->db->select("a.*, IF(a.status = '0' , 'Diajukan',
            IF(a.status = '1' , 'Dicairkan',
                IF(a.status = '2' , 'Ditolak', 'Tidak Diketahui')
            )
        ) as status_str, date(created_at) as tanggal");
    $this->db->from("referral_pencairan a");

    // order by
    if ($order['order'] != null) {
      $columns = $order['columns'];
      $dir = $order['order'][0]['dir'];
      $order = $order['order'][0]['column'];
      $columns = $columns[$order];

      $order_colum = $columns['data'];
      $this->db->order_by($order_colum, $dir);
    }

    // initial data table
    if ($draw == 1) {
      $this->db->limit(10, 0);
    }

    // filter
    if ($filter != null) {
      // by member
      if ($filter['member'] != '') {
        $this->db->where('a.member_id', $filter['member']);
      }
    }

    // pencarian
    if ($cari != null) {
      $this->db->where("(
              a.atas_nama LIKE '%$cari%' or
              a.nama_bank LIKE '%$cari%' or
              a.no_rekening LIKE '%$cari%' or
              a.jumlah_dana LIKE '%$cari%' or
              a.catatan LIKE '%$cari%' or
              IF(a.status = '0' , 'Diajukan',
                  IF(a.status = '1' , 'Diterima',
                      IF(a.status = '2' , 'Ditolak', 'Tidak Diketahui')
                  )
              ) LIKE '%$cari%'
          )");
    }

    // pagination
    if ($show != null && $start != null) {
      $this->db->limit($show, $start);
    }

    $result = $this->db->get();
    return $result;
  }

  public function riwayat_pendapatan($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null)
  {
    // select tabel
    $this->db->select("a.*, IF(a.jenis = '0' , 'Keluar',
            IF(a.jenis = '1' , 'Masuk', 'Tidak Diketahui')
        ) as jenis_str,");
    $this->db->from("referral_transaksi a");
    $this->db->where("a.jenis", 1);

    // order by
    if ($order['order'] != null) {
      $columns = $order['columns'];
      $dir = $order['order'][0]['dir'];
      $order = $order['order'][0]['column'];
      $columns = $columns[$order];

      $order_colum = $columns['data'];
      $this->db->order_by($order_colum, $dir);
    }

    // initial data table
    if ($draw == 1) {
      $this->db->limit(10, 0);
    }

    // filter
    if ($filter != null) {
      // by member
      if ($filter['member'] != '') {
        $this->db->where('a.member_id', $filter['member']);
      }
    }

    // pencarian
    if ($cari != null) {
      $this->db->where("(
              a.atas_nama LIKE '%$cari%' or
              a.nama_bank LIKE '%$cari%' or
              a.no_rekening LIKE '%$cari%' or
              a.jumlah_dana LIKE '%$cari%' or
              a.catatan LIKE '%$cari%' or
              IF(a.status = '0' , 'Diajukan',
                  IF(a.status = '1' , 'Diterima',
                      IF(a.status = '2' , 'Ditolak', 'Tidak Diketahui')
                  )
              ) LIKE '%$cari%'
          )");
    }

    // pagination
    if ($show != null && $start != null) {
      $this->db->limit($show, $start);
    }

    $result = $this->db->get();
    return $result;
  }

  public function mengundang($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null)
  {
    // select tabel
    $this->db->select("a.nama, date(created_at) as tanggal, a.foto");
    $this->db->from("member a");
    $this->db->where("a.status", 1);

    // order by
    if ($order['order'] != null) {
      $columns = $order['columns'];
      $dir = $order['order'][0]['dir'];
      $order = $order['order'][0]['column'];
      $columns = $columns[$order];

      $order_colum = $columns['data'];
      $this->db->order_by($order_colum, $dir);
    }

    // initial data table
    if ($draw == 1) {
      $this->db->limit(10, 0);
    }

    // filter
    if ($filter != null) {
      // by member
      if ($filter['member'] != '') {
        $this->db->where('a.parrent_id', $filter['member']);
      }
    }

    // pencarian
    if ($cari != null) {
      $this->db->where("(
              a.nama LIKE '%$cari%' or
              a.created_at LIKE '%$cari%'
          )");
    }

    // pagination
    if ($show != null && $start != null) {
      $this->db->limit($show, $start);
    }

    $result = $this->db->get();
    return $result;
  }

  function pencairan($member_id, $atas_nama, $nama_bank, $no_rekening, $jumlah_dana)
  {
    // cek dulu apakah sudah ada pencarian
    $cek = $this->db->select('count(*) as jumlah')
      ->from('referral_pencairan')
      ->where('member_id', $member_id)
      ->where('status', 0)
      ->get()->row();
    if ($cek->jumlah > 0) {
      return (object)[
        'status' => false,
        'data' => null,
        'message' => 'Maaf. Pengajuan pencairan sebelumnya belum selesai.',
        'code' => 200,
      ];
    }

    // cek apakah jumlah dana melebihi dana belum di cairkan
    $saldo = 0;
    try {
      $get = $this->reward($member_id);
      $saldo = (int)$get['data']['belum_dicairkan'];
    } catch (\Throwable $th) {
    }
    $saldo = $saldo ?? 0;

    if ((int)$jumlah_dana > $saldo) {
      return (object)[
        'status' => false,
        'data' => null,
        'message' => 'Maaf, Jumlah pengajuan dana yang dicarikan melebihi dana anda yang belum di cairkan.',
        'code' => 200,
      ];
    }
    // simpan
    $result = $this->db->insert('referral_pencairan', [
      'member_id' => $member_id,
      'atas_nama' => $atas_nama,
      'nama_bank' => $nama_bank,
      'no_rekening' => $no_rekening,
      'jumlah_dana' => $jumlah_dana,
    ]);

    return (object)[
      'status' => true,
      'data' => $result,
      'message' => 'Data Berhsil Disimpan',
      'code' => 200,
    ];
  }
}
