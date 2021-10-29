<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KomentarModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null, $filter = null)
    {
        $level = $this->config->item('level_mentor');
        // select tabel
        $this->db->select("a.*,
        IF(a.status = '0' , 'Dibuat', IF(a.status = '1' , 'Aktif', IF(a.status = '2' , 'Tidak Aktif', 'Tidak Diketahui'))) as status_str,
        b.judul as news,
        c.nama as member
        ");
        $this->db->from("news_komentar a");
        $this->db->join("news b", 'a.news_id = b.id', 'left');
        $this->db->join("member c", 'a.member_id = c.id', 'left');
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
            // by news
            if ($filter['news'] != '') {
                $this->db->where('b.id', $filter['news']);
            }
            // by member
            if ($filter['member'] != '') {
                $this->db->where('c.id', $filter['member']);
            }
        }

        // pencarian
        if ($cari != null) {
            $this->db->where("(
                a.komentar LIKE '%$cari%' or
                b.judul LIKE '%$cari%' or
                c.nama LIKE '%$cari%' or
                IF(a.status = '0' , 'Dibuat', IF(a.status = '1' , 'Aktif', IF(a.status = '2' , 'Tidak Aktif', 'Tidak Diketahui'))) LIKE '%$cari%'
            )");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function setStatus($id, $st)
    {
        // Delete users
        $exe = $this->db->where('id', $id)->update('news_komentar', [
            'status' => $st,
            'updated_at' => Date("Y-m-d H:i:s", time())
        ]);
        return $exe;
    }

    public function delete($user_id, $id)
    {
        // Delete users
        $exe = $this->db->where('id', $id)->update('news_komentar', [
            'status' => 3,
            'deleted_by' => $user_id,
            'deleted_at' => Date("Y-m-d H:i:s", time())
        ]);
        return $exe;
    }

    public function getList()
    {
        return $this->db->select('id, nama as text')->from('news_komentar')->where('status', 1)->get()->result_array();
    }

    public function getListMember()
    {
        return $this->db->select('id, nama as text')->from('member')->where('status', 1)->get()->result_array();
    }
}
