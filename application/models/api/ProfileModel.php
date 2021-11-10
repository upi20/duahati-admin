<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProfileModel extends Render_Model
{
  private $path = './files/member/profiles/';
  public function info($id)
  {
    return $this->db->select("
      a.email,
      a.nama ,
      a.address_full as detail_lainnya ,
      a.nama_panggilan,
      a.foto,
      a.no_telepon as telepon,
      date(a.created_at) as since,
      a.menikah,
      (
        if(a.menikah = 0, 'Belum Menikah',
          if(a.menikah = 1, 'Sudah Menikah', 'Tidak Diketahui')
        )
      ) as menikah_str,
      a.jenis_kelamin,
      a.tanggal_lahir,
      a.pekerjaan,
      a.kode_referral,
      a.address_full as alamat,
      b.id as id_provinsi,
      b.name as nama_provinsi,
      c.id as id_kabupaten_kota,
      c.name as nama_kabupaten_kota,
      d.id as id_kecamatan,
      d.name as nama_kecamatan,
      e.id as id_desa_kelurahan,
      e.name as nama_desa_kelurahan,
    ")->from('member a')
      ->join('address_provinces b', 'a.id_address_provinces = b.id', 'left')
      ->join('address_regencies c', 'a.id_address_regencies = c.id', 'left')
      ->join('address_districts d', 'a.id_address_districts = d.id', 'left')
      ->join('address_villages e', 'a.id_address_villages = e.id', 'left')
      ->where('a.id', $id)
      ->get()->row_array();
  }

  public function UpdateProfile(
    $id,
    $nama,
    $email,
    $telepon,
    $password,
    $nama_panggilan,
    $tanggal_lahir,
    $jenis_kelamin,
    $status,
    $alamat_provinsi,
    $alamat_kabupaten_kota,
    $alamat_kecamatan,
    $alamat_desa_kelurahan,
    $detail_lainnya
  ) {
    $data = [
      'nama' => $nama,
      'no_telepon' => $telepon,
      'nama_panggilan' => $nama_panggilan,
      'tanggal_lahir' => $tanggal_lahir,
      'jenis_kelamin' => $jenis_kelamin,
      'menikah' => $status,
      'id_address_provinces' => $alamat_provinsi,
      'id_address_regencies' => $alamat_kabupaten_kota,
      'id_address_districts' => $alamat_kecamatan,
      'id_address_villages' => $alamat_desa_kelurahan,
      'address_full' => $detail_lainnya,
      'email' => $email,
      'updated_at' => Date('Y-m-d h:i:s')
    ];

    $return = false;
    $code = 0;
    $new_foto = null;

    // cek profile
    $get_db = $this->db->select('email')
      ->from('member')
      ->where('email', $email)
      ->where('id <>', $id)
      ->get();

    if ($get_db->num_rows() == 0) {
      if (!in_array($password, ['', null])) {
        $data['kata_sandi'] = $this->b_password->bcrypt_hash($password);
      }

      $ubah_foto = false;
      if ($_FILES['file']['name'] != '') {
        // simpan foto
        $foto = $this->saveFile();
        $ubah_foto = true;
        $get_photo = $this->db->select('photo as photo')->from('member')->where('id', $id)->get()->row_array();
        $this->db->reset_query();
        // delete foto
        if ($get_photo != null) {
          if ($get_photo['photo'] != null && $get_photo['photo'] != '') {
            $this->deleteFile($get_photo['photo']);
          }
        }
      }

      if ($ubah_foto) {
        $data['photo'] = $foto['data'];
        $new_foto = $foto['data'];
      }

      $this->db->where('id', $id);
      $return = $this->db->update('member', $data);
      $code = 1;
    }

    return [
      'code' => $code,
      'result' => $return,
      'foto' => $new_foto
    ];
  }

  private function saveFile()
  {
    $config['upload_path']          = $this->path;
    $config['allowed_types']        = 'gif|jpg|png|jpeg|JPG|PNG|JPEG';
    $config['file_name']            = md5(uniqid("klub", true));
    $config['overwrite']            = true;
    $config['max_size']             = 8024;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if ($this->upload->do_upload('file')) {
      return [
        'status' => true,
        'data' => $this->upload->data("file_name"),
        'message' => 'Success'
      ];
    } else {
      return [
        'status' => false,
        'data' => null,
        'message' => $this->upload->display_errors('', '')
      ];
    }
  }

  private function deleteFile($file)
  {
    $res_foto = true;
    if (file_exists($this->path . $file)) {
      $res_foto = unlink($this->path . $file);
    }
    return $res_foto;
  }
}
