<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KursiBerhadiahModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null)
    {
        // select tabel
        $this->db->select("
        a.id,
        a.nomer_kursi,
        CONCAT(c.nama, ' vs ', d.nama) as pertandingan,
        e.nama as stadion,
        f.username as member,
        g.nama as kategori,
        IF(a.status = '2' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str
        ");
        $this->db->from("kursi a");
        $this->db->join('pertandingan b', 'a.id_pertandingan = b.id', 'left');
        $this->db->join('team c', 'b.id_team_1 = c.id', 'left');
        $this->db->join('team d', 'b.id_team_2 = d.id', 'left');
        $this->db->join('stadion e', 'b.id_stadion = e.id', 'left');
        $this->db->join('member f', 'a.id_member = f.id', 'left');
        $this->db->join('kategori g', 'a.id_kategori = g.id', 'left');
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
            $this->db->where("(
                CONCAT(c.nama, ' vs ', d.nama) LIKE '%$cari%' or
                f.username LIKE '%$cari%' or
                g.nama LIKE '%$cari%' or
                IF(a.status = '2' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) LIKE '%$cari%')");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function getKursiBerhadiah($id)
    {
        $result = $this->db->get_where("kursi", ['id' => $id])->row_array();
        return $result;
    }

    public function insert($pertandingan, $member, $kategori, $nomer_kursi, $status)
    {
        $result = $this->db->insert("kursi", [
            'id_pertandingan' => $pertandingan,
            'id_member' => $member,
            'id_kategori' => $kategori,
            'nomer_kursi' => $nomer_kursi,
            'status' => $status,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        return $result;
    }

    public function update($id, $pertandingan, $member, $kategori, $nomer_kursi, $status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('kursi', [
            'id_pertandingan' => $pertandingan,
            'id_member' => $member,
            'id_kategori' => $kategori,
            'nomer_kursi' => $nomer_kursi,
            'status' => $status,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        return $result;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('kursi', [
            'status' => 3,
            'updated_at' => date("Y-m-d H:i:s"),
            'deleted_at' => date("Y-m-d H:i:s")
        ]);
        return $result;
    }

    public function list_pertandingan()
    {
        $return = $this->db->select("a.id, CONCAT(c.nama, ' vs ', d.nama) as text")
            ->from('pertandingan a')
            ->join('team c', 'a.id_team_1 = c.id', 'left')
            ->join('team d', 'a.id_team_2 = d.id', 'left')
            ->where('a.status !=', '2')
            ->where('a.status !=', '3')
            ->get()
            ->result_array();
        return $return;
    }

    public function list_kategori()
    {
        $return = $this->db->select("a.id, CONCAT(a.nama, ' (', a.nomor_mulai, ' - ', a.nomor_akhir, ') ') as text")
            ->from('kategori a')
            ->where('a.status', '1')
            ->get()
            ->result_array();
        return $return;
    }

    public function list_member()
    {
        $return = $this->db->select('a.id, a.username as text')
            ->from('member a')
            ->where('status', '1')
            ->get()
            ->result_array();
        return $return;
    }

    // dipakai Registrasi
    public function cari($key)
    {
        $this->db->select('a.id as id, a.keterangan as text');
        $this->db->from('kursi a');
        $this->db->where("keterangan LIKE '%$key%' or keterangan LIKE '%$key%' or jumlah_klik LIKE '%$key%'");
        return $this->db->get()->result_array();
    }
}
