<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProfileModel extends Render_Model
{
  private $path = './files/member/profiles/';
  public function info($id)
  {
    return $this->db->select("
    email as email,
    username as nama,
    photo as foto,
    no_whatsapp as telepon,
    date(created_at) as since
    ")->from('member')->where('id', $id)->get()->row_array();
  }

  public function UpdateProfile($id, $nama, $email, $telepon, $password)
  {
    $data = [
      'username' => $nama,
      'no_whatsapp' => $telepon,
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
