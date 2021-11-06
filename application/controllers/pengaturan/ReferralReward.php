<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReferralReward extends Render_Controller
{

    public function index()
    {
        // Page Settings
        $this->title = 'Pengaturan Referral Nominal Reward';
        $this->navigation = ['Referral Nominal Reward'];
        $this->plugins = ['datatables'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_3 = 'Pengaturan';
        $this->breadcrumb_3_url = '#';
        $this->breadcrumb_4 = 'Referral Nominal Reward';
        $this->breadcrumb_4_url = base_url() . 'pengaturan/referral_reward_nominal/list';
        // content
        $this->content      = 'pengaturan/referral_reward_nominal/list';

        // Send data to view
        $this->render();
    }

    public function ajax_data()
    {
        $order = ['order' => $this->input->post('order'), 'columns' => $this->input->post('columns')];
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

        $data = $this->model->getAllData($draw, $length, $start, $_cari, $order)->result_array();
        $count = $this->model->getAllData(null, null, null, $_cari, $order, null)->num_rows();

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
    }

    public function insert()
    {
        $nama = $this->input->post("nama");
        $nominal = $this->input->post("nominal");
        $keterangan = $this->input->post("keterangan");
        $user_id = $this->id;
        $result = $this->model->insert($user_id, $nama, $nominal, $keterangan);

        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function update()
    {
        $id = $this->input->post("id");
        $nama = $this->input->post("nama");
        $nominal = $this->input->post("nominal");
        $keterangan = $this->input->post("keterangan");
        $user_id = $this->id;
        $result = $this->model->update($id, $user_id, $nama, $nominal, $keterangan);
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function delete()
    {
        $id = $this->input->post("id");
        $result = $this->model->delete($this->id, $id);
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function aktifkan()
    {
        $id = $this->input->post("id");
        $result = $this->model->aktifkan($this->id, $id);
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
        $this->photo_path = './files/pengaturan/rekening/';
        $this->load->model("pengaturan/ReferralRewardModel", 'model');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
    }
}
