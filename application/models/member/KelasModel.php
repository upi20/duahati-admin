<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelasModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null,  $filter = null)
    {
        $level = $this->config->item('level_mentor');
        // select tabel
        $this->db->select("a.*, b.nama as nama_kelas,
        IF(a.status = '0' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str");
        $this->db->from("member_kelas a");
        $this->db->join("kelas b", 'b.id = a.kelas_id', 'left');
        $this->db->where('a.status <>', 3);
        $this->db->where('b.status <>', 3);

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
                IF(a.status = '0' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) LIKE '%$cari%'
            )");
        }

        // filter
        if ($filter != null) {
            // by sekolah
            if ($filter['member_id'] != '') {
                $this->db->where('a.member_id', $filter['member_id']);
            }
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function getListKelas($member_id)
    {
        return $this->db
            ->select('a.id, a.nama as text')
            ->from('kelas a')
            ->where('a.tipe <>', 1)
            ->where('a.status', 1)
            ->get()->result_array();
    }

    public function getMember($id)
    {
        return $this->db
            ->select("a.id, concat(a.nama, ' (', b.user_nama, ')') as nama")
            ->from('member a')
            ->join('users b', 'a.mentor_id = b.user_id', 'left')
            ->where('id', $id)
            ->get()
            ->row_array();
    }

    public function insert($user_id, $kelas_id, $member_id, $status)
    {
        $cek = $this->db->select('id')->from('member_kelas')
            ->where('kelas_id', $kelas_id)
            ->where('member_id', $member_id)
            ->where('status <>', 3)
            ->get()->num_rows();
        if ($cek > 0) {
            return false;
        }
        $data = [
            'kelas_id' => $kelas_id,
            'member_id' => $member_id,
            'kelas_id' => $kelas_id,
            // 'status' => $status,
            'created_by' => $user_id,
        ];

        // Insert users
        $execute = $this->db->insert('member_kelas', $data);
        $execute = $this->db->insert_id();
        return $execute;
    }

    public function update($user_id, $id, $kelas_id, $member_id, $status)
    {
        $cek = $this->db->select('id')->from('member_kelas')
            ->where('kelas_id', $kelas_id)
            ->where('member_id', $member_id)
            ->where('status <>', 3)
            ->where('id <>', $id)
            ->get()->num_rows();
        if ($cek > 0) {
            return false;
        }

        $data = [
            'kelas_id' => $kelas_id,
            'member_id' => $member_id,
            'kelas_id' => $kelas_id,
            // 'status' => $status,
            'created_by' => $user_id,
        ];

        // Update users
        $execute = $this->db->where('id', $id)->update('member_kelas', $data);
        return  $execute;
    }

    public function delete($user_id, $id)
    {
        // Delete users
        $exe = $this->db->where('id', $id)->update('member_kelas', [
            'status' => 3,
            'deleted_by' => $user_id,
            'deleted_at' => Date("Y-m-d H:i:s", time())
        ]);
        return $exe;
    }
}
