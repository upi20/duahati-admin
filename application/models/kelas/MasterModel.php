<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MasterModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null)
    {
        $level = $this->config->item('level_mentor');
        // select tabel
        $this->db->select("a.*,
        IF(a.tipe = '1' , 'Premium', IF(a.tipe = '2' , 'VIP', 'Tidak Diketahui')) as tipe_str,
        IF(a.status = '0' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str,
        ( select count(*) from kelas_materi z where z.kelas_id = a.id and z.status = 1 ) as jumlah_materi,
        b.nama as kategori
        ");
        $this->db->from("kelas a");
        $this->db->join("kelas_kategori b", 'a.kategori_id = b.id', 'left');
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

        // filter
        if ($filter != null) {
            // by kategori
            if ($filter['kategori'] != '') {
                $this->db->where('b.id', $filter['kategori']);
            }
        }

        // pencarian
        if ($cari != null) {
            $this->db->where("(
                a.nama LIKE '%$cari%' or
                b.nama LIKE '%$cari%' or
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

    public function insert($user_id, $kategori_id, $nama, $keterangan, $foto, $tipe, $status)
    {
        $data = [
            'nama' => $nama,
            'kategori_id' => $kategori_id,
            'keterangan' => $keterangan,
            'tipe' => $tipe,
            'status' => $status,
            'foto' => $foto,
            'created_by' => $user_id,
        ];
        // Insert users
        $execute = $this->db->insert('kelas', $data);
        $execute = $this->db->insert_id();
        return $execute;
    }

    public function update($id, $user_id, $kategori_id, $nama, $keterangan, $foto, $tipe, $status)
    {
        $data = [
            'nama' => $nama,
            'kategori_id' => $kategori_id,
            'keterangan' => $keterangan,
            'tipe' => $tipe,
            'status' => $status,
            'foto' => $foto,
            'updated_by' => $user_id,
        ];
        // Update users
        $execute = $this->db->where('id', $id);
        $execute = $this->db->update('kelas', $data);
        return  $execute;
    }

    public function delete($user_id, $id)
    {
        // Delete users
        $exe = $this->db->where('id', $id)->update('kelas', [
            'status' => 3,
            'deleted_by' => $user_id,
            'deleted_at' => Date("Y-m-d H:i:s", time())
        ]);
        return $exe;
    }

    public function getList()
    {
        return $this->db->select('id, nama as text')->from('kelas')->where('status', 1)->get()->result_array();
    }
}
