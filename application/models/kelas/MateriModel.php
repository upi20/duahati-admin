<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MateriModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null)
    {
        $level = $this->config->item('level_mentor');
        // select tabel
        $this->db->select("a.*,
        IF(a.status = '0' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str,
        b.nama as kelas,
        (
            select count(*) from member_materi_tonton as z where z.kelas_materi_id = a.id
        ) as jumlah_ditonton,
        c.nama as kategori
        ");
        $this->db->from("kelas_materi a");
        $this->db->join("kelas b", 'a.kelas_id = b.id', 'left');
        $this->db->join("kelas_kategori c", 'b.kategori_id = c.id', 'left');
        $this->db->where('a.status <>', 3);
        $this->db->order_by('a.no_urut');

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
                b.nama LIKE '%$cari%' or
                a.keterangan LIKE '%$cari%' or
                IF(a.status = '0' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) LIKE '%$cari%'
            )");
        }

        // filter
        if ($filter != null) {
            // by kategori
            if ($filter['kategori'] != '') {
                $this->db->where('c.id', $filter['kategori']);
            }
            // by kelas
            if ($filter['kelas'] != '') {
                $this->db->where('b.id', $filter['kelas']);
            }
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function insert($user_id, $kelas_id, $nama, $keterangan, $url, $no_urut, $status)
    {
        $data = [
            'nama' => $nama,
            'kelas_id' => $kelas_id,
            'keterangan' => $keterangan,
            'no_urut' => $no_urut,
            'status' => $status,
            'url' => $url,
            'created_by' => $user_id,
        ];
        // Insert users
        $execute = $this->db->insert('kelas_materi', $data);
        $execute = $this->db->insert_id();
        return $execute;
    }

    public function update($id, $user_id, $kelas_id, $nama, $keterangan, $url, $no_urut, $status)
    {
        $data = [
            'nama' => $nama,
            'kelas_id' => $kelas_id,
            'keterangan' => $keterangan,
            'no_urut' => $no_urut,
            'status' => $status,
            'url' => $url,
            'updated_by' => $user_id,
        ];
        // Update users
        $execute = $this->db->where('id', $id);
        $execute = $this->db->update('kelas_materi', $data);
        return  $execute;
    }

    public function delete($user_id, $id)
    {
        // Delete users
        $exe = $this->db->where('id', $id)->update('kelas_materi', [
            'status' => 3,
            'deleted_by' => $user_id,
            'deleted_at' => Date("Y-m-d H:i:s", time())
        ]);
        return $exe;
    }

    public function getList()
    {
        return $this->db->select('id, nama as text')->from('kelas_materi')->where('status', 1)->get()->result_array();
    }

    public function noUrut($kelas_id)
    {
        $data = $this->db
            ->select('(max(no_urut)+1) as no_urut')
            ->from('kelas_materi')
            ->where('kelas_id', $kelas_id)
            ->where('status <>', 3)
            ->get()
            ->row_array();
        $data = $data ?? ['no_urut' => 1];
        $data = $data['no_urut'];
        $data = $data ?? 1;
        return $data;
    }

    public function cekNoUrut($kelas_id, $no)
    {
        $data = $this->db
            ->select('count(*) as found')
            ->from('kelas_materi')
            ->where('kelas_id', $kelas_id)
            ->where('no_urut', $no)
            ->where('status <>', 3)
            ->get()
            ->row_array();
        $data = $data['found'] == 0;
        return $data;
    }
}
