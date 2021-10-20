<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TeamModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null)
    {
        // select tabel
        $this->db->select("*, IF(team.status = '2' , 'Tidak Aktif', IF(team.status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str");
        $this->db->from("team");
        $this->db->where('status <>', 3);

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
            $this->db->where("(nama LIKE '%$cari%' or IF(team.status = '0' , 'Tidak Aktif', IF(team.status = '1' , 'Aktif', 'Tidak Diketahui')) LIKE '%$cari%')");
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

    public function insert($nama, $logo, $status)
    {
        $result = $this->db->insert("team", [
            'nama' => $nama,
            'logo' => $logo,
            'status' => $status,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        return $result;
    }

    public function update($id, $nama, $logo, $status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('team', [
            'nama' => $nama,
            'logo' => $logo,
            'status' => $status,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        return $result;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('team', [
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
}
