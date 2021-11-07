<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pencairan extends Render_Controller
{
  public function index()
  {
    // Page Settings
    $this->title = 'Pencarian Referral';
    $this->navigation = ['Member'];
    $this->plugins = ['datatables', 'select2'];

    // Breadcrumb setting
    $this->breadcrumb_1 = 'Dashboard';
    $this->breadcrumb_1_url = base_url();
    $this->breadcrumb_3 = 'Referral';
    $this->breadcrumb_3_url = base_url() . 'referral/pencairan';
    $this->breadcrumb_4 = 'Pencairan';
    $this->breadcrumb_4_url = '';

    // content
    $this->content  = 'referral/pencairan';

    // Send data to view
    $this->render();
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

  public function simpan()
  {
    $this->db->trans_start();
    $foto = '';
    if ($_FILES['foto']['name'] != '') {
      $foto = $this->uploadImage('foto');
      $foto = $foto['data'];
    }
    $id = $this->input->post("id");
    $catatan = $this->input->post("catatan");
    $status = $this->input->post("status");
    $user_id = $this->id;
    $result = $this->model->simpan($user_id, $id, $catatan, $foto, $status);

    $this->db->trans_complete();
    $code = $result ? 200 : 500;
    $this->output_json(["data" => $result], $code);
  }

  function __construct()
  {
    parent::__construct();
    $this->sesion->cek_session();
    if ($this->session->userdata('data')['level'] != 'Administrator') {
      redirect('my404', 'refresh');
    }
    $this->id = $this->session->userdata('data')['id'];
    $this->photo_path = './files/bukti_pencairan/';
    $this->load->model("member/PencairanModel", 'model');
    $this->default_template = 'templates/dashboard';
    $this->load->library('plugin');
    $this->load->helper('url');
  }
}
