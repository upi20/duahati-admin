<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends Render_Controller
{
  public function index($id = null)
  {
    // Page Settings
    $this->title = 'Member Pembayaran';
    $this->navigation = ['Member'];
    $this->plugins = ['datatables', 'select2'];

    // Breadcrumb setting
    $this->breadcrumb_1 = 'Dashboard';
    $this->breadcrumb_1_url = base_url();
    $this->breadcrumb_3 = 'Data Member';
    $this->breadcrumb_3_url = base_url() . 'member/data';
    $this->breadcrumb_4 = 'Pembayaran';
    $this->breadcrumb_4_url = '';

    $this->data['user'] = $this->model->getMember($id);
    if ($id == null || $this->data['user'] == null) {
      redirect('my404', 'refresh');
    }

    // content
    $this->content  = 'member/pembayaran';

    // Send data to view
    $this->render();
  }

  public function simpan()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('id', 'Id Pembayaran', 'trim|required|numeric');
    $this->form_validation->set_rules('member_id', 'ID Member', 'trim|required|numeric');
    $this->form_validation->set_rules('status', 'Status Pembayaran', 'trim|required|numeric');
    $this->form_validation->set_rules('jenis', 'jenis Pembayaran', 'trim|required|numeric');
    $this->form_validation->set_rules('catatan', 'catatan Pembayaran', 'trim');
    if ($this->form_validation->run() == FALSE) {
      $this->output_json([
        'status' => false,
        'data' => null,
        'message' => validation_errors()
      ], 400);
    } else {

      $member_id = $this->input->post('member_id');
      $status = $this->input->post('status');
      $catatan = $this->input->post('catatan');
      $jenis = $this->input->post('jenis');
      $id = $this->input->post('id');
      $result = $this->model->simpan($this->id, $id, $member_id, $jenis, $catatan, $status);
      $this->output_json([
        'status' => $result->status,
        'length' => 1,
        'data' =>  $result->data,
        'message' => $result->message,
      ], $result->code);
    }
  }



  public function tes()
  {
    $result = $this->model->tes();
    var_dump($result);
    die;
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

    if (isset($cari['value'])) {
      $_cari = $cari['value'];
    } else {
      $_cari = null;
    }
    $filter['member_id'] = $this->input->post('member_id');
    $data = $this->model->getAllData($draw, $length, $start, $_cari, $order, $filter)->result_array();
    $count = $this->model->getAllData(null, null,      null, $_cari, $order, $filter)->num_rows();

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
    $this->sesion->cek_session();
    if ($this->session->userdata('data')['level'] != 'Administrator') {
      redirect('my404', 'refresh');
    }
    $this->id = $this->session->userdata('data')['id'];
    $this->photo_path = './files/member/pembayaran/';
    $this->load->model("member/PembayaranModel", 'model');
    $this->default_template = 'templates/dashboard';
    $this->load->library('plugin');
    $this->load->helper('url');
  }
}
