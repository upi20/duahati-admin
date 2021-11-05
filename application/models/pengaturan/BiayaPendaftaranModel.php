<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BiayaPendaftaranModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null)
    {
        $level = $this->config->item('level_mentor');
        // select tabel
        $this->db->select("a.*,
        IF(a.status = '0' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str
        ");
        $this->db->from("biaya_pendaftaran a");
        $this->db->where('a.status <>', 3);
        $this->db->order_by('a.status', 'desc');

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
                a.nominal LIKE '%$cari%' or
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

    public function insert($user_id, $nama, $nominal, $keterangan)
    {
        $status = 1;
        $get = $this->db->select('count(*) as jumlah')
            ->from('biaya_pendaftaran')
            ->where('status <> 3')
            ->get()->row();

        // jika row ada maka langsung di non aktifkan
        if ($get->jumlah > 0) {
            $status = 0;
        }

        $data = [
            'nama' => $nama,
            'nominal' => $nominal,
            'keterangan' => $keterangan,
            'status' =>  $status,
            'created_by' => $user_id,
        ];
        // Insert data
        $execute = $this->db->insert('biaya_pendaftaran', $data);
        $execute = $this->db->insert_id();
        return $execute;
    }

    public function update($id, $user_id, $nama, $nominal, $keterangan)
    {
        $data = [
            'nama' => $nama,
            'nominal' => $nominal,
            'keterangan' => $keterangan,
            'updated_by' => $user_id,
        ];
        // Update data
        $execute = $this->db->where('id', $id);
        $execute = $this->db->update('biaya_pendaftaran', $data);
        return  $execute;
    }

    public function aktifkan($user_id, $id)
    {

        // Update yang aktif
        $execute = $this->db->where('id', $id)
            ->update('biaya_pendaftaran', [
                'status' => 1,
                'updated_by' => $user_id,
            ]);

        // Update yang tidak aktif
        $execute = $this->db->where('id <>', $id)
            ->update('biaya_pendaftaran', [
                'status' => 0,
                'updated_by' => $user_id,
            ]);
        return  $execute;
    }



    public function delete($user_id, $id)
    {
        // Delete users
        $exe = $this->db->where('id', $id)->update('biaya_pendaftaran', [
            'status' => 3,
            'deleted_by' => $user_id,
            'deleted_at' => Date("Y-m-d H:i:s", time())
        ]);
        return $exe;
    }
}
