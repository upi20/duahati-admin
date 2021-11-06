<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konfirmasi extends Render_Controller
{
  public function index()
  {

    $this->plugins = ['datatables', 'select2'];
    $this->title = 'Member Pembayaran';
    $this->render();
  }

  public function simpan()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('atas_nama', 'Atas Nama', 'trim|required');
    $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'trim|required');
    $this->form_validation->set_rules('no_rekening', 'No Rekening', 'trim|required|numeric');
    $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required|numeric');
    $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
    if ($this->form_validation->run() == FALSE) {
      $this->output_json([
        'status' => false,
        'data' => null,
        'message' => validation_errors()
      ], 400);
    } else {

      $email = $this->input->post('email');
      $atas_nama = $this->input->post('atas_nama');
      $nama_bank = $this->input->post('nama_bank');
      $no_rekening = $this->input->post('no_rekening');
      $nominal = $this->input->post('nominal');
      $tanggal = $this->input->post('tanggal');
      $bukti = $this->uploadImage('file');
      if (!$bukti['status']) {
        $this->output_json([
          'status' => false,
          'length' => 1,
          'data' =>  null,
          'message' => 'Foto bukti bermasala. mungkin karena ukuran foto atau format foto',
        ], 200);
        return;
      }

      $result = $this->model->simpan($email, $atas_nama, $nama_bank, $no_rekening, $nominal, $tanggal, $bukti['data'], $this->photo_path);
      $this->output_json([
        'status' => $result->status,
        'length' => 1,
        'data' =>  $result->data,
        'message' => $result->message,
      ], $result->code);
    }
  }

  public function ajax_data()
  {
    $order = [
      'order' => $this->input->post('order'),
      'columns' => $this->input->post('columns')
    ];
    $start = $this->input->post('start');
    $draw = $this->input->post('draw');
    $draw = $draw == null ? 1 : $draw;
    $length = $this->input->post('length');
    $cari = $this->input->post('search');
    $email = $this->input->post('email');

    if (isset($cari['value'])) {
      $_cari = $cari['value'];
    } else {
      $_cari = null;
    }

    $data = $this->model->getAllData($draw, $length, $start, $_cari, $order, $email)->result_array();
    $count = $this->model->getAllData(null, null,      null, $_cari, $order, $email)->num_rows();
    $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
  }

  public function getListPembayaran()
  {
    $id_member = $this->input->get('id_member');
    $result = $this->model->getListPembayaran($id_member);
    $this->output_json($result, 200);
  }

  public function insert()
  {
    $this->db->trans_start();
    $member_id = $this->input->post("member_id");
    $pembayaran_id = $this->input->post("pembayaran_id");
    $status = $this->input->post("status");
    $user_id = $this->id;
    $result = $this->model->insert($user_id, $pembayaran_id, $member_id, $status);

    $this->db->trans_complete();
    $code = $result ? 200 : 409;
    $this->output_json(["data" => $result], $code);
  }

  public function update()
  {
    $id = $this->input->post("id");
    $member_id = $this->input->post("member_id");
    $pembayaran_id = $this->input->post("pembayaran_id");
    $status = $this->input->post("status");
    $user_id = $this->id;
    $result = $this->model->update($user_id, $id, $pembayaran_id, $member_id, $status);
    $code = $result ? 200 : 409;
    $this->output_json(["data" => $result], $code);
  }

  public function delete()
  {
    $id = $this->input->post("id");
    $result = $this->model->delete($this->id, $id);
    $code = $result ? 200 : 500;
    $this->output_json(["data" => $result], $code);
  }

  public function cari()
  {
    $key = $this->input->post('q');
    // jika inputan ada
    if ($key) {
      $this->output_json([
        "results" => $this->model->cari($key)
      ]);
    } else {
      $this->output_json([
        "results" => []
      ]);
    }
  }

  function __construct()
  {
    parent::__construct();
    $this->photo_path = './files/bukti_pembayaran/';
    $this->load->model("member/KonfirmasiModel", 'model');
    $this->default_template = 'templates/konfirmasi';
    $this->load->library('plugin');
    $this->load->helper('url');
  }
}
