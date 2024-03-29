<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PembayaranModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null,  $filter = null)
    {

        $level = $this->config->item('level_mentor');
        // select tabel
        $this->db->select("a.*,
        IF(a.status = '0' , 'Diajukan',
            IF(a.status = '1' , 'Diterima',
                IF(a.status = '2' , 'Ditolak', 'Tidak Diketahui')
            )
        ) as status_str,
        IF(a.jenis = '1' , 'Pembayaran Pendaftaran', 'Tidak Diketahui') as jenis_str,
        b.user_nama as diubah_oleh");
        $this->db->from("pembayaran a");
        $this->db->join("users b", 'a.updated_by = b.user_id', 'left');
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


    public function simpan($user_id, $id, $member_id, $jenis, $catatan, $status)
    {
        $this->db->trans_start();

        if ($status == 1 && $jenis == 1) {
            $this->db->where('id', $member_id)->update('member', ['status' => $status]);

            // tambah saldo referral pengundang
            // get parrent
            $parrent = $this->db->select('parrent_id as id')
                ->from('member')
                ->where('id', $member_id)
                ->get()
                ->row();
            if (!is_null($parrent->id)) {
                $nominal = $this->db->select('ifnull(nominal, 0) as referral')
                    ->from('referral_nominal')
                    ->where('status', 1)
                    ->get()->row();

                // simpan belum dicairkan
                $this->db->query("UPDATE `referral` SET

                    `belum_dicairkan` = ((ifnull(
                    (SELECT belum_dicairkan FROM `referral` WHERE member_id = '{$parrent->id}' limit 1) ,0)
                    ) + ({$nominal->referral})),

                    `total_pendapatan` = ((ifnull(
                    (SELECT belum_dicairkan FROM `referral` WHERE member_id = '{$parrent->id}' limit 1) ,0)
                    ) + ({$nominal->referral}))

                    WHERE `referral`.`member_id` = '{$parrent->id}';
                        ");

                // simpan riwayat masuk
                $this->db->insert('referral_transaksi', [
                    'member_id' => $parrent->id,
                    'dari_member_id' => $member_id,
                    'jumlah_dana' => $nominal->referral,
                    'jenis' => 1
                ]);
            }

            // cek apakah sudah mempunyai detail referral
            $detail = $this->db->select('count(*) as jumlah')
                ->from('referral')
                ->where('member_id', $member_id)
                ->where('status', 1)
                ->get()->row();

            if ($detail->jumlah == 0) {
                // tambah referral detail member
                $data = [
                    'total_pendapatan' => 0,
                    'dicairkan' => 0,
                    'belum_dicairkan' => 0,
                    'member_id' => $member_id
                ];
                $this->db->insert('referral', $data);
            }
        }

        // simpan pembayaran
        $result =  $this->db->where('id', $id)->update('pembayaran', [
            'status' => $status,
            'catatan' => $catatan,
            'updated_by' => $user_id
        ]);


        $this->db->trans_complete();
        return (object)[
            'code' => 200,
            'status' => true,
            'data' => $result,
            'message' => 'success',
        ];
    }

    private function kodePembayaran($pre = '')
    {
        $date = date('Y-m-d') . ' 00:00:00.0';
        $this->db->select('RIGHT(a.kode,5) as kode', FALSE);
        $this->db->order_by('kode', 'DESC');
        $this->db->where('created_at >=', $date);
        $this->db->limit(1);
        $query = $this->db->get('pembayaran a');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $return = $pre . date('y') . date('m')  . date('d') . str_pad($kode, 5, "0", STR_PAD_LEFT);
        return $return;
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
