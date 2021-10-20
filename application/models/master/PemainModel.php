<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PemainModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null)
    {
        // select tabel
        $this->db->select("a.*, b.nama as team, c.nama as posisi, IF(a.status = '2' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str");
        $this->db->from("pemain a");
        $this->db->join('team b', 'a.id_team = b.id', 'left');
        $this->db->join('posisi c', 'a.id_posisi = c.id', 'left');
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
            $this->db->where("(a.nama LIKE '%$cari%' or b.nama LIKE '%$cari%' or c.nama LIKE '%$cari%' or IF(a.status = '0' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) LIKE '%$cari%')");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function getPemain($id)
    {
        $result = $this->db->get_where("pemain", ['id' => $id])->row_array();
        return $result;
    }

    public function insert($team, $posisi, $nama, $photo, $status)
    {
        $result = $this->db->insert("pemain", [
            'id_team' => $team,
            'id_posisi' => $posisi,
            'nama' => $nama,
            'photo' => $photo,
            'status' => $status,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        return $result;
    }

    public function update($id, $team, $posisi, $nama, $photo, $status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('pemain', [
            'id_team' => $team,
            'id_posisi' => $posisi,
            'nama' => $nama,
            'photo' => $photo,
            'status' => $status,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        return $result;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('pemain', [
            'status' => 3,
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

    public function list_posisi()
    {
        $return = $this->db->select('a.id, a.nama as text')
            ->from('posisi a')
            ->where('status', '1')
            ->get()
            ->result_array();
        return $return;
    }

    // dipakai Registrasi
    public function cari($key)
    {
        $this->db->select('a.id as id, a.keterangan as text');
        $this->db->from('pemain a');
        $this->db->where("keterangan LIKE '%$key%' or keterangan LIKE '%$key%' or jumlah_klik LIKE '%$key%'");
        return $this->db->get()->result_array();
    }
}
