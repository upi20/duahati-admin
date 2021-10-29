<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MasterModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null)
    {
        $level = $this->config->item('level_mentor');
        // select tabel
        $this->db->select("a.*,
        IF(a.status = '0' , 'Dibuat', IF(a.status = '1' , 'Disimpan', IF(a.status = '2' , 'Diterbitkan', IF(a.status = '3' , 'Tidak Aktif', 'Tidak Diketahui')))) as status_str
        ");
        $this->db->from("news a");
        $this->db->where('a.status <>', 0);
        $this->db->where('a.status <>', 99);

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
                a.judul LIKE '%$cari%' or
                b.deskripsi LIKE '%$cari%' or
                a.tanggal_terbit LIKE '%$cari%' or
                IF(a.status = '0' , 'Dibuat', IF(a.status = '1' , 'Disimpan', IF(a.status = '2' , 'Diterbitkan', IF(a.status = '3' , 'Tidak Aktif', 'Tidak Diketahui')))) LIKE '%$cari%'
            )");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function cekNewId()
    {
        $cek = $this->db->get_where('news', ['status' => 0]);
        if ($cek->num_rows() > 0) {
            $id = $cek = $cek->result_array()[0]['id'];
        } else {
            $this->db->insert('news', ['status' => 0]);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    public function updatePublish($id, $st, $user_id)
    {
        $data = [
            'status' => $st == 2 ? 3 : 2,
            'publisher' => $user_id,
            'updated_by' => $user_id,
            'updated_at' => date("Y-m-d H:i:s", time()),
        ];

        // Update users
        $execute = $this->db->where('id', $id);
        $execute = $this->db->update('news', $data);
        return  $execute;
    }

    public function update($id, $user_id, $judul, $deskripsi, $foto, $tanggal_terbit, $status)
    {
        if ($status == 0) {
            $data = [
                'judul' => $judul,
                'foto' => $foto,
                'deskripsi' => $deskripsi,
                'status' => 1,
                'foto' => $foto,
                'tanggal_terbit' => $tanggal_terbit,
                'publisher' => $user_id,
                'created_by' => $user_id,
                'created_at' => date("Y-m-d H:i:s", time()),
            ];
        } else {
            $data = [
                'judul' => $judul,
                'foto' => $foto,
                'deskripsi' => $deskripsi,
                'status' => $status,
                'foto' => $foto,
                'tanggal_terbit' => $tanggal_terbit,
                'publisher' => $user_id,
                'updated_by' => $user_id,
                'updated_at' => date("Y-m-d H:i:s", time()),
            ];
        }

        // Update users
        $execute = $this->db->where('id', $id);
        $execute = $this->db->update('news', $data);
        return  $execute;
    }

    public function delete($user_id, $id)
    {
        // Delete users
        $exe = $this->db->where('id', $id)->update('news', [
            'status' => 99,
            'deleted_by' => $user_id,
            'deleted_at' => Date("Y-m-d H:i:s", time())
        ]);
        return $exe;
    }

    public function getDeskripsi($id)
    {
        return $this->db->select('deskripsi')->from('news')->where('id', $id)->get()->result_array();
    }

    public function getList()
    {
        return $this->db->select('id, judul as text')->from('news')->where('status <>', 99)->get()->result_array();
    }
}
