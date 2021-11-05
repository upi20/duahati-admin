<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null)
    {
        $level = $this->config->item('level_mentor');
        // select tabel
        // kelas vip
        $this->db->select("a.*,
        IF(a.status = '0' , 'Tidak Aktif',
            IF(a.status = '1' , 'Aktif',
                IF(a.status = '2' , 'Menunggu Pembayaran', 'Tidak Diketahui')
            )
        ) as status_str,
        ((select count(*) from member_kelas as z where z.status <> 3 and z.member_id = a.id)) as jumlah_kelas,
        ((select count(*) from pembayaran as y where y.status <> 3 and y.member_id = a.id)) as jumlah_pembayaran,
        b.user_nama as mentor,
        ");
        // semua kelas
        // $this->db->select("a.*,
        // IF(a.status = '0' , 'Tidak Aktif', IF(a.status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str,
        // ((select count(*) from member_kelas as z where z.status <> 3 and z.member_id = a.id) +
        // (select count(*) from kelas as y where y.tipe = 1)) as jumlah_kelas,
        // b.user_nama as mentor
        // ");
        $this->db->from("member a");
        $this->db->join("users b", 'a.mentor_id = b.user_id', 'left');
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
                b.user_nama LIKE '%$cari%' or
                a.nama LIKE '%$cari%' or
                a.kode_referral LIKE '%$cari%' or
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

    public function insert(
        $user_id,
        $mentor_id,
        $nama,
        $no_telepon,
        $foto,
        $alamat,
        $password,
        $email,
        $status,
        $kode_referral
    ) {
        $data = [
            'mentor_id' => $mentor_id,
            'nama' => $nama,
            'no_telepon' => '+62' . $no_telepon,
            'foto' => $foto,
            'token' => uniqid("duahati" . Date('Ymdhis'), false),
            'alamat' => $alamat,
            'password' => $this->b_password->bcrypt_hash($password),
            'email' => $email,
            'status' => $status,
            'kode_referral' => $kode_referral,
            'created_by' => $user_id,
        ];
        // Insert users
        $execute = $this->db->insert('member', $data);
        $execute = $this->db->insert_id();
        return $execute;
    }

    public function update(
        $user_id,
        $id,
        $mentor_id,
        $nama,
        $no_telepon,
        $foto,
        $alamat,
        $password,
        $email,
        $status,
        $kode_referral
    ) {
        $data = [
            'mentor_id' => $mentor_id,
            'nama' => $nama,
            'no_telepon' => '+62' . $no_telepon,
            'foto' => $foto,
            'alamat' => $alamat,
            'email' => $email,
            'status' => $status,
            'kode_referral' => $kode_referral,
            'updated_by' => $user_id,
        ];

        if ($password != '') {
            $data['password'] = $this->b_password->bcrypt_hash($password);
        }

        // Update users
        $execute = $this->db->where('id', $id)->update('member', $data);
        return  $execute;
    }

    public function delete($user_id, $id)
    {
        // Delete users
        $exe = $this->db->where('id', $id)->update('member', [
            'status' => 3,
            'deleted_by' => $user_id,
            'deleted_at' => Date("Y-m-d H:i:s", time())
        ]);
        return $exe;
    }


    public function emailCheck($email, $id)
    {
        return $this->db->select('email')
            ->from('member')
            ->where('email', $email)
            ->where('id <> ', $id)
            ->where('status <> ', 3)
            ->get()
            ->row_array();
    }

    public function cekKodeReferral($kode_referral, $member_id)
    {
        return $this->db->select('kode_referral')
            ->from('member')
            ->where('kode_referral', $kode_referral)
            ->where('id <> ', $member_id)
            ->where('status <> ', 3)
            ->get()
            ->row_array();
    }

    public function getList()
    {
        return $this->db->select('id, nama as text')->from('member')->where('status', 1)->get()->result_array();
    }
}
