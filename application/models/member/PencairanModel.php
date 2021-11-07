<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PencairanModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null,  $filter = null)
    {

        $level = $this->config->item('level_mentor');
        // select tabel
        $this->db->select("a.*,
        IF(a.status = '0' , 'Diajukan',
            IF(a.status = '1' , 'Diterima',
                IF(a.status = '2' , 'Ditolak',
                    IF(a.status = '3' , 'Dibatalkan', 'Tidak Diketahui')
                )
            )
        ) as status_str, date(a.created_at) as tanggal,
        b.user_nama as diubah_oleh, c.nama as member_nama");
        $this->db->from("referral_pencairan a");
        $this->db->join("users b", 'a.updated_by = b.user_id', 'left');
        $this->db->join("member c", 'a.member_id = c.id', 'left');
        $this->db->where('c.status <>', 3);
        $this->db->order_by('a.status');

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
                IF(a.status = '0' , 'Diajukan',
                    IF(a.status = '1' , 'Diterima',
                        IF(a.status = '2' , 'Ditolak',
                            IF(a.status = '3' , 'Dibatalkan', 'Tidak Diketahui')
                        )
                    )
                ) LIKE '%$cari%' or
                b.user_nama  LIKE '%$cari%' or
                a.nama_bank  LIKE '%$cari%' or
                a.no_rekening  LIKE '%$cari%' or
                a.atas_nama  LIKE '%$cari%' or
                a.created_at  LIKE '%$cari%' or
                a.jumlah_dana  LIKE '%$cari%' or
                c.nama LIKE '%$cari%'
            )");
        }

        // filter
        if ($filter != null) {

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


    public function simpan($user_id, $id, $catatan, $foto, $status)
    {
        $this->db->trans_start();
        // get member
        $datas = $this->db->select('member_id as member, jumlah_dana as jumlah')
            ->from('referral_pencairan')
            ->where('id', $id)
            ->get()->row();
        $datas = $datas ?? (object)['member' => 0, 'jumlah' => 0];

        // update saldo
        if ($status == 1) {
            $this->db->query("
            UPDATE `referral` SET `belum_dicairkan` = (
                (ifnull((SELECT belum_dicairkan from referral where member_id = $datas->member LIMIT 1), 0)) - $datas->jumlah
                ) WHERE `referral`.`member_id` = $datas->member;
            ");

            // catat transaksi
            $this->db->insert('referral_transaksi', [
                'member_id' => $datas->member,
                'jumlah_dana' => $datas->jumlah,
                'jenis' => 0
            ]);
        }


        // simpan referral_pencairan
        $result =  $this->db->where('id', $id)->update('referral_pencairan', [
            'status' => $status,
            'foto' => $foto,
            'tanggal_respon' => Date('Y-m-d H:i:s'),
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
