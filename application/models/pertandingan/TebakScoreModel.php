<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TebakScoreModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null)
    {
        // select tabel
        $this->db->select("
        a.id,
        a.score_team_1,
        a.score_team_2,
        CONCAT(c.nama, ' vs ', d.nama) as pertandingan,
        e.nama as stadion,
        e.nama as stadion,
        f.username as member,
        IF(a.status = '2' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str
        ");
        $this->db->from("tebak_score a");
        $this->db->join('pertandingan b', 'a.id_pertandingan = b.id', 'left');
        $this->db->join('team c', 'b.id_team_1 = c.id', 'left');
        $this->db->join('team d', 'b.id_team_2 = d.id', 'left');
        $this->db->join('stadion e', 'b.id_stadion = e.id', 'left');
        $this->db->join('member f', 'a.id_member = f.id', 'left');
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
                b.nama LIKE '%$cari%' or
                c.nama LIKE '%$cari%' or
                d.nama LIKE '%$cari%' or
                a.tanggal_main LIKE '%$cari%' or
                a.jam_main LIKE '%$cari%' or
                a.hasil_team_1 LIKE '%$cari%' or
                a.hasil_team_2 LIKE '%$cari%' or
                e.nama LIKE '%$cari%' or
                IF(a.status = '2' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) LIKE '%$cari%')");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function getTebakScore($id)
    {
        $result = $this->db->get_where("tebak_score", ['id' => $id])->row_array();
        return $result;
    }

    public function insert($pertandingan, $member, $score_team_1, $score_team_2, $status)
    {
        $result = $this->db->insert("tebak_score", [
            'id_pertandingan' => $pertandingan,
            'id_member' => $member,
            'score_team_1' => $score_team_1,
            'score_team_2' => $score_team_2,
            'status' => $status,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        return $result;
    }

    public function update($id, $pertandingan, $member, $score_team_1, $score_team_2, $status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('tebak_score', [
            'id_pertandingan' => $pertandingan,
            'id_member' => $member,
            'score_team_1' => $score_team_1,
            'score_team_2' => $score_team_2,
            'status' => $status,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        return $result;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('tebak_score', [
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
        $this->db->from('tebak_score a');
        $this->db->where("keterangan LIKE '%$key%' or keterangan LIKE '%$key%' or jumlah_klik LIKE '%$key%'");
        return $this->db->get()->result_array();
    }
}
