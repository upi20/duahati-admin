<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginModel extends Render_Model
{

	public function cekLogin($email, $password)
	{
		$query = $this->db->get_where('member', ['email' => $email]);
		if ($query->num_rows() == 1) {

			$cek = $this->b_password->hash_check($password, $query->row_array()['password']);

			if ($cek == true) {
				$return['status'] = 0;
				$return['data'] 	= $query->result_array();
			} else {
				$return['status'] = 1;
				$return['data'] 	= null;
			}
		} else {
			$return['status'] 	= 2;
			$return['data'] 	= null;
		}

		return $return;
	}

	public function registrasi($nama, $email, $telepon, $password, $status = 1)
	{
		$this->db->db_debug = false;
		$data['username'] 			= $nama;
		$data['email'] 		= $email;
		$data['kata_sandi'] 		= $this->b_password->bcrypt_hash($password);
		$data['no_whatsapp'] 		= $telepon;
		$data['status'] 		= $status;
		$data['created_at'] 		= Date('Y-m-d h:i:s');
		$data['token'] 		= uniqid("nobar" . Date('Ymdhis'), false);
		// Insert member
		$execute 					= $this->db->insert('member', $data);
		$execute 					= $this->db->insert_id();
		return $execute;
	}
}

/* End of file LoginModel.php */
/* Location: ./application/models/LoginModel.php */