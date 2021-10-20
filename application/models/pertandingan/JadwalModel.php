<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JadwalModel extends Render_Model
{
    private $status_deleted = 5;
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null, $id_pertandingan = null)
    {
        // select tabel
        $this->db->select("a.*, b.nama as team_1, c.nama as team_2, d.nama as stadion, e.nama as motm,
        IF(a.status = '0' , 'Akan Datang',
            IF(a.status = '1' , 'Tampilkan',
                IF(a.status = '2' , 'Berlangsung',
                    IF(a.status = '3' , 'Selesai',
                        IF(a.status = '4' , 'Nonaktif', 'Tidak Diketahui')
                    )
                )
            )
        ) as status_str, concat(b.nama, ' VS ', c.nama)  as vs,
        (
            select count(*) from tebak_mot where tebak_mot.status = 1 and tebak_mot.id_pemain = a.man_of_the_match and tebak_mot.id_pertandingan = a.id
        )as vote
        ");
        $this->db->from("pertandingan a");
        $this->db->join('team b', 'a.id_team_1 = b.id', 'left');
        $this->db->join('team c', 'a.id_team_2 = c.id', 'left');
        $this->db->join('stadion d', 'a.id_stadion = d.id', 'left');
        $this->db->join('pemain e', 'a.man_of_the_match = e.id', 'left');
        $this->db->where('a.status <>', $this->status_deleted);

        // order by
        $order = isset($order['order']) ? $order : ['order' => null];
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
            // filter date
            if ($filter['date']['start'] != null && $filter['date']['end'] != null) {
                $this->db->where("(DATE(a.tanggal_main) BETWEEN '{$filter['date']['start']}' AND  '{$filter['date']['end']}')");
            }

            // by team_1
            if ($filter['team_1'] != '') {
                $this->db->or_where('a.id_team_1', $filter['team_1']);
            }

            // by team_2
            if ($filter['team_2'] != '') {
                $this->db->or_where('a.id_team_2', $filter['team_2']);
            }

            // by stadion
            if ($filter['stadion'] != '') {
                $this->db->where('a.id_stadion', $filter['stadion']);
            }
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
                IF(a.status = '0' , 'Akan Datang', IF(a.status = '1' , 'Berlangsung', IF(a.status = '2' , 'Selesai', 'Tidak Diketahui'))) LIKE '%$cari%')");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }


    public function list_kursi($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null, $id_pertandingan = null)
    {
        // select tabel
        $this->db->select("a.id, a.menang, b.username as nama, concat(c.nama, ' ', a.nomer_kursi) as result, a.created_at as waktu")
            ->from('kursi a')
            ->join('member b', 'a.id_member = b.id')
            ->join('kategori c', 'a.id_kategori = c.id')
            ->where('a.status', 1);

        // order by
        $order = isset($order['order']) ? $order : ['order' => null];
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
            // by stadion
            if ($filter['id'] != '') {
                $this->db->where('a.id_pertandingan', $filter['id']);
            }
        }

        // pencarian
        if ($cari != null) {
            $this->db->where("(
                b.username LIKE '%$cari%' or
                c.nama LIKE '%$cari%' or
                a.nomer_kursi LIKE '%$cari%' or
                concat(c.nama, ' ', a.nomer_kursi) LIKE '%$cari%')");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function simpan_kursi($id, $menang)
    {
        $menang = $menang == '' ? null : $menang;
        $this->db->where('id', $id);
        return $this->db->update('kursi', ['menang' => $menang]);
    }

    public function list_mot($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null, $id_pertandingan = null)
    {
        // select tabel
        $this->db->select('a.id, a.menang, b.username as nama, c.nama as result,
        (
            select count(*) from tebak_mot where tebak_mot.status = 1 and tebak_mot.id_pemain = a.id_pemain and tebak_mot.id_pertandingan = a.id_pertandingan
        )as vote, a.created_at as waktu
        ')
            ->from('tebak_mot a')
            ->join('member b', 'a.id_member = b.id')
            ->join('pemain c', 'a.id_pemain = c.id');

        // order by
        $order = isset($order['order']) ? $order : ['order' => null];
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

            if ($filter['id'] != '') {
                $this->db->where('a.id_pertandingan', $filter['id']);
            }

            if ($filter['id_pemain'] != '') {
                $this->db->where('a.id_pemain', $filter['id_pemain']);
            }
        }

        // pencarian
        if ($cari != null) {
            $this->db->where("(
                b.username LIKE '%$cari%' or
                c.nama LIKE '%$cari%' or
                a.nomer_mot LIKE '%$cari%' or
                concat(c.nama, ' ', a.nomer_mot) LIKE '%$cari%')");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function simpan_mot($id, $menang)
    {
        $menang = $menang == '' ? null : $menang;
        $this->db->where('id', $id);
        return $this->db->update('tebak_mot', ['menang' => $menang]);
    }

    public function list_skor($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null, $id_pertandingan = null)
    {
        // select tabel
        $this->db->select("a.id, a.menang, b.username as nama, concat(a.score_team_1, ' vs ', a.score_team_2) result, a.created_at as waktu")
            ->from('tebak_score a')
            ->join('member b', 'a.id_member = b.id');

        // order by
        $order = isset($order['order']) ? $order : ['order' => null];
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

            if ($filter['id'] != '') {
                $this->db->where('a.id_pertandingan', $filter['id']);
            }

            if ($filter['skor_1'] != '') {
                $this->db->where('a.score_team_1', $filter['skor_1']);
            }

            if ($filter['skor_2'] != '') {
                $this->db->where('a.score_team_2', $filter['skor_2']);
            }
        }

        // pencarian
        if ($cari != null) {
            $this->db->where("(
                b.username LIKE '%$cari%' or
                c.nama LIKE '%$cari%' or
                a.nomer_skor LIKE '%$cari%' or
                concat(c.nama, ' ', a.nomer_skor) LIKE '%$cari%')");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function simpan_skor($id, $menang)
    {
        $menang = $menang == '' ? null : $menang;
        $this->db->where('id', $id);
        return $this->db->update('tebak_score', ['menang' => $menang]);
    }

    public function getJadwal($id)
    {
        $result = $this->db->get_where("pertandingan", ['id' => $id])->row_array();
        return $result;
    }

    public function insert($team_1, $team_2, $stadion, $tanggal_main, $jam_main,  $status)
    {
        $result = $this->db->insert("pertandingan", [
            'id_team_1' => $team_1,
            'id_team_2' => $team_2,
            'id_stadion' => $stadion,
            'tanggal_main' => $tanggal_main,
            'jam_main' => $jam_main,
            'status' => $status,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        return $result;
    }

    public function update($id, $team_1, $team_2, $stadion, $tanggal_main, $jam_main, $status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('pertandingan', [
            'id_team_1' => $team_1,
            'id_team_2' => $team_2,
            'id_stadion' => $stadion,
            'tanggal_main' => $tanggal_main,
            'jam_main' => $jam_main,
            'status' => $status,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        return $result;
    }

    public function hasil_pertandingan($id, $hasil_team_1, $hasil_team_2, $man_of_the_match)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('pertandingan', [
            'hasil_team_1' => $hasil_team_1,
            'hasil_team_2' => $hasil_team_2,
            'man_of_the_match' => $man_of_the_match,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        return $result;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('pertandingan', [
            'status' => $this->status_deleted,
            'updated_at' => date("Y-m-d H:i:s"),
            'deleted_at' => date("Y-m-d H:i:s")
        ]);
        return $result;
    }

    public function list_team()
    {
        $return = $this->db->select('a.id, a.nama as text')
            ->from('team a')
            ->where('status', '1')
            ->get()
            ->result_array();
        return $return;
    }

    public function list_stadion()
    {
        $return = $this->db->select('a.id, a.nama as text')
            ->from('stadion a')
            ->where('status', '1')
            ->get()
            ->result_array();
        return $return;
    }

    public function list_pemain()
    {
        $return = $this->db->select('a.id, a.nama as text')
            ->from('pemain a')
            ->where('status', '1')
            ->get()
            ->result_array();
        return $return;
    }

    // dipakai Registrasi
    public function cari($key)
    {
        $this->db->select('a.id as id, a.keterangan as text');
        $this->db->from('pertandingan a');
        $this->db->where("keterangan LIKE '%$key%' or keterangan LIKE '%$key%' or jumlah_klik LIKE '%$key%'");
        return $this->db->get()->result_array();
    }

    public function getDetailMotm($id_pertandingan)
    {
        return $this->db->select("id,
        nama, (
          select count(*) from tebak_mot where tebak_mot.status = 1 and tebak_mot.id_pemain = pemain.id and tebak_mot.id_pertandingan = '$id_pertandingan'
        )as vote")
            ->from('pemain')
            // ->where('status', 1)
            ->order_by('vote', 'desc')
            ->order_by('nama')
            ->get()
            ->result_array();
    }
}
