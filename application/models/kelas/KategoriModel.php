<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KategoriModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null)
    {
        $level = $this->config->item('level_mentor');
        // select tabel
        $this->db->select("a.*,
        IF(a.status = '2' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str,
        ( select count(*) from kelas z where z.kategori_id = a.id and z.status = 1 ) as jumlah_kelas
        ");
        $this->db->from("kelas_kategori a");
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
                a.nama LIKE '%$cari%' or
                a.keterangan LIKE '%$cari%' or
                IF(a.status = '0' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) LIKE '%$cari%'
            )");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function insert($user_id, $nama, $keterangan, $foto, $status)
    {
        $data = [
            'nama' => $nama,
            'keterangan' => $keterangan,
            'status' => $status,
            'foto' => $foto,
            'created_by' => $user_id,
        ];
        // Insert users
        $execute = $this->db->insert('kelas_kategori', $data);
        $execute = $this->db->insert_id();
        return $execute;
    }


    public function update($id, $user_id, $nama, $keterangan, $foto, $status)
    {
        $data = [
            'nama' => $nama,
            'keterangan' => $keterangan,
            'status' => $status,
            'foto' => $foto,
            'updated_by' => $user_id,
        ];
        // Update users
        $execute = $this->db->where('id', $id);
        $execute = $this->db->update('kelas_kategori', $data);
        return  $execute;
    }


    public function delete($id)
    {
        // Delete users
        $exe = $this->db->where('id', $id)->update('kelas_kategori', [
            'status' => 3,
            'deleted_at' => Date("Y-m-d H:i:s", time())
        ]);
        return $exe;
    }
}
