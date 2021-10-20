<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null)
    {
        $level = $this->config->item('level_mentor');
        // select tabel
        $this->db->select("a.*,
        IF(a.user_status = '2' , 'Tidak Aktif', IF(a.user_status = '1' , 'Aktif', 'Tidak Diketahui')) as status_str,
        ( select count(*) from member z where z.mentor_id = a.user_id and z.status = 1 ) as jumlah_member
        ");
        $this->db->from("users a");
        $this->db->join("role_users b", 'a.user_id=b.role_user_id');
        $this->db->where('b.role_lev_id', $level);
        $this->db->where('a.user_status <>', 3);

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
                a.user_nama LIKE '%$cari%' or
                a.user_email LIKE '%$cari%' or
                a.user_jk LIKE '%$cari%' or
                a.phone LIKE '%$cari%' or
                IF(a.user_status = '0' , 'Tidak Aktif', IF(a.user_status = '1' , 'Aktif', 'Tidak Diketahui')) LIKE '%$cari%'
            )");
        }

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }

    public function insert($nama, $tanggal_lahir, $jenis_kelamin, $telepon, $email, $password,  $foto, $status, $level, $alamat)
    {
        $data['user_nama'] = $nama;
        $data['user_email'] = $email;
        $data['user_password'] = $this->b_password->bcrypt_hash($password);
        $data['user_phone'] = $telepon;
        $data['user_status'] = $status;
        $data['user_tgl_lahir'] = $tanggal_lahir;
        $data['user_jk'] = $jenis_kelamin;
        $data['user_foto'] = $foto;
        $data['alamat'] = $alamat;

        // Insert users
        $execute = $this->db->insert('users', $data);
        $execute = $this->db->insert_id();

        $data2['role_user_id'] = $execute;
        $data2['role_lev_id'] = $level;
        // Insert role users
        $execute2 = $this->db->insert('role_users', $data2);
        $exe['id'] = $execute;
        $exe['level'] = $this->_cek('level', 'lev_id', $level, 'lev_nama');

        return $exe;
    }


    public function update($id, $nama, $tanggal_lahir, $jenis_kelamin, $telepon, $email, $password,  $foto, $status, $level, $alamat)
    {
        $data['user_nama'] = $nama;
        $data['user_email'] = $email;
        $data['user_phone'] = $telepon;
        $data['user_status'] = $status;
        $data['updated_at'] = Date("Y-m-d H:i:s", time());
        $data['user_tgl_lahir'] = $tanggal_lahir;
        $data['user_jk'] = $jenis_kelamin;
        $data['user_foto'] = $foto;
        $data['alamat'] = $alamat;
        if ($password != '') {
            $data['user_password'] = $this->b_password->bcrypt_hash($password);
        }

        // Update users
        $execute = $this->db->where('user_id', $id);
        $execute = $this->db->update('users', $data);

        $data2['role_user_id'] = $id;
        $data2['role_lev_id'] = $level;

        // Update role users
        $execute2 = $this->db->where('role_user_id', $id);
        $execute2 = $this->db->update('role_users', $data2);

        $exe['id'] = $id;
        $exe['level'] = $this->_cek('level', 'lev_id', $level, 'lev_nama');

        return $exe;
    }


    public function delete($id)
    {
        // Delete users
        $exe = $this->db->where('user_id', $id)->update('users', [
            'user_status' => 3,
            'deleted_at' => Date("Y-m-d H:i:s", time())
        ]);
        return $exe;
    }


    public function emailCheck($email, $id_user)
    {
        return $this->db->select('user_email')
            ->from('users')
            ->where('user_email', $email)

            ->where('user_id <> ', $id_user)

            ->where('user_status <> ', 3)
            ->get()
            ->row_array();
    }


    public function getDataMember($id)
    {
        $result = $this->db->get_where("member", ['id' => $id])->row_array();
        return $result;
    }

    // dipakai Registrasi
    public function cari($key)
    {
        $this->db->select('a.id as id, a.keterangan as text');
        $this->db->from('member a');
        $this->db->where("keterangan LIKE '%$key%' or keterangan LIKE '%$key%' or jumlah_klik LIKE '%$key%'");
        return $this->db->get()->result_array();
    }
}
