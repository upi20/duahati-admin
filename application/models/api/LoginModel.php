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
				return [
					'status' => 0,
					'data' => $query->result_array()
				];
			} else {
				return [
					'status' => 1,
					'data' => null
				];
			}
		} else {
			return [
				'status' => 2,
				'data' => null
			];
		}
	}

	public function registrasi($nama, $email, $telepon, $password, $referral, $status = 1)
	{
		$koder_referral = $this->getReferral(7);
		$referral = $referral == '' ? null : $referral;
		if ($referral != null) {
			$referral = $this->checkReferal($referral);
			if ($referral == null) {
				return (object) [
					'status' => false,
					'code' => 400,
					'data' => null,
					'message' => 'Kode referral tidak valid'
				];
			} else {
				$referral = $referral->id;
			}
		}

		$cek_email = $this->checkEmail($email);
		if ($cek_email) {
			return (object) [
				'status' => false,
				'code' => 409,
				'data' => null,
				'message' => 'Email sudah terdaftar'
			];
		}

		$mentor = $this->getRandomMentor();
		$token = uniqid("duahati" . Date('Ymdhis'));

		$this->db->db_debug = false;
		$data['mentor_id'] = $mentor->id;
		$data['parrent_id'] = $referral;
		$data['nama'] = $nama;
		$data['email'] = $email;
		$data['password']	= $this->b_password->bcrypt_hash($password);
		$data['no_telepon']	= $telepon;
		$data['status']	= $status;
		$data['kode_referral'] = $koder_referral;
		$data['created_at']	= Date('Y-m-d h:i:s');
		$data['token'] = $token;

		// Insert member
		$execute		= $this->db->insert('member', $data);
		$execute 					= $this->db->insert_id();

		$status = $execute != 0;

		return (object)[
			'status' => $status,
			'code' => $status ? 200 : 400,
			'data' => [
				'token' => $token
			],
			'message' => $status ? 'Registrasi Berhasil' : 'Registrasi Gagal'
		];
	}

	private function generateReferral($length_of_string)
	{
		$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		return substr(str_shuffle($str_result), 0, $length_of_string);
	}

	private function getReferral($length)
	{
		$loop = true;
		$ref = '';
		while ($loop) {
			$ref = $this->generateReferral($length);
			$loop = $this->checkReferal($ref) != null;
		}
		return $ref;
	}

	private function checkReferal($kode)
	{
		return $this->db->select('id')->from('member')->where('kode_referral', $kode)->get()->row();
	}

	private function checkEmail($email)
	{
		return $this->db->select('id')
			->from('member')
			->where('email', $email)
			->where('status <>', 3)
			->get()->row();
	}


	public function getRandomMentor()
	{
		$level = $this->config->item('level_mentor');
		// select tabel
		$this->db->select("a.user_id, a.user_nama,
		( select count(*) from member z where z.mentor_id = a.user_id and z.status <> 3 ) as jumlah_member
		")->from("users a")
			->join("role_users b", 'a.user_id=b.role_user_id')
			->where('b.role_lev_id', $level)
			->where('a.user_status <>', 3)
			->order_by('jumlah_member', 'asc');
		$mentor = $this->db->get()->row();
		return (object)[
			'id' => $mentor == null ? null : $mentor->user_id,
			'nama' => $mentor == null ? null : $mentor->user_nama,
			'jumlah_member' => $mentor == null ? null : $mentor->jumlah_member,
		];
	}
}

/* End of file LoginModel.php */
/* Location: ./application/models/LoginModel.php */