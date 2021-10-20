<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IklanModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null)
    {
        // select tabel
        $this->db->select("a.*,concat(c.nama, ' vs ', d.nama, '(',b.tanggal_main,')') as pertandingan,
         IF(a.status = '2' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str,
         IF(a.status = '1' , 'Gambar', IF(a.status = '2' , 'Video Youtube', 'Tidak Diketahui')) as jenis_str,
         (
            select count(*) from iklan_member z where z.id_iklan = a.id and z.status = 1
         )as dilihat
         ");
        $this->db->from("iklan a");
        $this->db->join("pertandingan b", 'a.id_pertandingan = b.id');
        $this->db->join("team c", 'b.id_team_1 = c.id');
        $this->db->join("team d", 'b.id_team_2 = d.id');
        $this->db->where('a.status <>', 3);

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

        // pencarian
        if ($cari != null) {
            $this->db->where("(nama LIKE '%$cari%' or IF(a.status = '0' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) LIKE '%$cari%')");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function getTeam($id)
    {
        $result = $this->db->get_where("team", ['id' => $id])->row_array();
        return $result;
    }

    public function insert($nama, $pertandingan, $gambar, $url, $durasi, $status, $jenis)
    {
        $result = $this->db->insert("iklan", [
            'nama' => $nama,
            'url' => $url,
            'jenis' => $jenis,
            'gambar' => $gambar,
            'durasi' => $durasi,
            'id_pertandingan' => $pertandingan,
            'status' => $status,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        return $result;
    }

    public function update($id, $nama, $pertandingan, $gambar, $url, $durasi, $status, $jenis)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('iklan', [
            'nama' => $nama,
            'url' => $url,
            'jenis' => $jenis,
            'durasi' => $durasi,
            'gambar' => $gambar,
            'id_pertandingan' => $pertandingan,
            'status' => $status,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        return $result;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('iklan', [
            'status' => 3,
            'updated_at' => date("Y-m-d H:i:s"),
            'deleted_at' => date("Y-m-d H:i:s")
        ]);
        return $result;
    }

    // dipakai Registrasi
    public function cari($key)
    {
        $this->db->select('a.id as id, a.keterangan as text');
        $this->db->from('team a');
        $this->db->where("keterangan LIKE '%$key%' or keterangan LIKE '%$key%' or jumlah_klik LIKE '%$key%'");
        return $this->db->get()->result_array();
    }

    public function getPertandingan()
    {
        return $this->db
            ->select("a.id, (concat(a.tanggal_main, ' ', c.nama, ' vs ', d.nama)) as text")
            ->from('pertandingan a')
            ->join('team c', 'a.id_team_1 = c.id', 'left')
            ->join('team d', 'a.id_team_2 = d.id', 'left')
            ->where('a.status <>', 4)
            ->order_by('a.tanggal_main', 'desc')
            ->get()->result_array();
    }
}
