<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TebakMOTM extends Render_Controller
{

    // dipakai Administrator |
    public function index()
    {
        // Page Settings
        $this->title = 'Tebak Man Of The Match';
        $this->navigation = ['Pertandingan', 'Tebak Man Of The Match'];
        $this->plugins = ['datatables', 'select2'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_2 = 'Pertandingan';
        $this->breadcrumb_2_url = '#';
        $this->breadcrumb_3 = 'Tebak Man Of The Match';
        $this->breadcrumb_3_url = base_url() . 'pertandingan/tebak-motm';

        // content
        $this->content      = 'pertandingan/tebak-motm';

        // Send data to view
        $this->render();
    }

    public function uploadImage()
    {
        $config['upload_path']          = './files/tebakMOTM/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPG|PNG|JPEG';
        $config['file_name']            = md5(uniqid("ktm_home", true));
        $config['overwrite']            = true;
        $config['max_size']             = 8024;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('logo')) {
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

    // dipakai Administrator |
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

        $date_start = $this->input->post('date_start');
        $date_end = $this->input->post('date_end');
        $team_1 = $this->input->post('team_1');
        $team_2 = $this->input->post('team_2');
        $stadion = $this->input->post('stadion');
        $data = $this->model->getAllData($draw, $length, $start, $_cari, $order)->result_array();
        $count = $this->model->getAllData(null, null, null, $_cari, $order, null)->num_rows();

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
    }

    // dipakai Administrator |
    public function getTebakMOTM()
    {
        $id = $this->input->get("id");
        $result = $this->model->getTebakMOTM($id);
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    // dipakai Administrator |
    public function insert()
    {
        $this->db->trans_start();
        $pertandingan = $this->input->post("pertandingan");
        $member = $this->input->post("member");
        $pemain = $this->input->post("pemain");
        $status = $this->input->post("status");
        $result = $this->model->insert($pertandingan, $member, $pemain, $status);
        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    // dipakai Administrator |
    public function update()
    {
        $this->db->trans_start();
        $id = $this->input->post("id");
        $pertandingan = $this->input->post("pertandingan");
        $member = $this->input->post("member");
        $pemain = $this->input->post("pemain");
        $status = $this->input->post("status");
        $result = $this->model->update($id, $pertandingan, $member, $pemain, $status);
        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    // dipakai Administrator |
    public function delete()
    {
        $id = $this->input->post("id");
        $result = $this->model->delete($id);
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function ajax_select_list_pertandingan()
    {
        $return = $this->model->list_pertandingan();
        $this->output_json($return);
    }

    public function ajax_select_list_member()
    {
        $return = $this->model->list_member();
        $this->output_json($return);
    }

    public function ajax_select_list_pemain()
    {
        $return = $this->model->list_pemain();
        $this->output_json($return);
    }

    // dipakai Registrasi |
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
        // Cek session
        $this->sesion->cek_session();
        if ($this->session->userdata('data')['level'] != 'Administrator') {
            redirect('my404', 'refresh');
        }

        $this->load->model("pertandingan/tebakMOTMModel", 'model');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
    }
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/pertandingan/Pengguna.php */