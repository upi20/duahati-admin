<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KonfirmasiModel extends Render_Model
{
    public function getAllData($draw = null, $show = null, $start = null, $cari = null, $order = null, $email)
    {

        $level = $this->config->item('level_mentor');
        // select tabel
        $this->db->select("a.*,
        IF(a.status = '0' , 'Diajukan',
            IF(a.status = '1' , 'Diterima',
                IF(a.status = '2' , 'Ditolak', 'Tidak Diketahui')
            )
        ) as status_str,
        c.email,
        date(a.created_at) as tanggal_input,
        date(a.updated_at) as tanggal_respon,
        IF(a.jenis = '1' , 'Pembayaran Pendaftaran', 'Tidak Diketahui') as jenis_str");
        $this->db->from("pembayaran a");
        $this->db->join("users b", 'a.updated_by = b.user_id', 'left');
        $this->db->join("member c", 'c.id = a.member_id', 'left');
        $this->db->where('a.status <>', 3);
        $this->db->where('c.email', $email);

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

        // pagination
        if ($show != null && $start != null) {
            $this->db->limit($show, $start);
        }

        $result = $this->db->get();
        return $result;
    }


    public function simpan($email, $atas_nama, $nama_bank, $no_rekening, $nominal, $tanggal, $foto, $poto_path)
    {
        // cek email
        $get = $this->db->select('id, status')
            ->from('member')
            ->where('email', $email)
            ->get()->row();
        if ($get == null) {
            $this->deleteFile($poto_path . $foto);
            return (object)[
                'code' => 200,
                'status' => false,
                'data' => null,
                'message' => 'Email tidak terdaftar',
            ];
        }

        // cek status member
        if ($get->status != 2) {
            $this->deleteFile($poto_path . $foto);
            return (object)[
                'code' => 200,
                'status' => false,
                'data' => null,
                'message' => 'Pembyaran registrasi sudah sudah selesai',
            ];
        }

        // cek konfirmasi sebelumnya
        $pembayaran = $this->db->select('*')
            ->from('pembayaran')
            ->where('tipe', 1)
            ->where('jenis', 1)
            ->where('status', 0)
            ->where('member_id', $get->id)
            ->get()->row();
        if ($pembayaran != null) {
            $this->deleteFile($poto_path . $foto);
            return (object)[
                'code' => 200,
                'status' => false,
                'data' => null,
                'message' => 'Maaf. Konfirmasi pembayaran sebelumnya belum selesai.',
            ];
        }

        $result =  $this->db->insert('pembayaran', [
            'member_id' => $get->id,
            'bank_nama' => $nama_bank,
            'no_rekening' => $no_rekening,
            'atas_nama' => $atas_nama,
            'tanggal' => $tanggal,
            'jumlah_pembayaran' => $nominal,
            'foto' => $foto,
            'jenis' => 1,
            'tipe' => 1,
            'status' => 0,
        ]);

        return (object)[
            'code' => 200,
            'status' => true,
            'data' => $result,
            'message' => 'Data berhasil disimpan',
        ];
    }



    public function deleteFile($file)
    {
        $res_foto = true;
        if ($file != null && $file != '') {
            if (file_exists($file)) {
                $res_foto = unlink($file);
            }
        }
        return $res_foto;
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
