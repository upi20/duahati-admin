<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Team extends Render_Controller
{

    // dipakai Administrator |
    public function index()
    {
        // Page Settings
        $this->title = 'Team';
        $this->navigation = ['Master', 'Team'];
        $this->plugins = ['datatables'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_2 = 'Master';
        $this->breadcrumb_2_url = '#';
        $this->breadcrumb_3 = 'Team';
        $this->breadcrumb_3_url = base_url() . 'master/team';

        // content
        $this->content      = 'master/team';

        // Send data to view
        $this->render();
    }

    public function uploadImage()
    {
        $config['upload_path']          = './files/team/';
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

        $data = $this->model->getAllData($draw, $length, $start, $_cari, $order)->result_array();
        $count = $this->model->getAllData(null, null, null, $_cari, $order, null)->num_rows();

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
    }

    // dipakai Administrator |
    public function getTeam()
    {
        $id = $this->input->get("id");
        $result = $this->model->getTeam($id);
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    // dipakai Administrator |
    public function insert()
    {
        $this->db->trans_start();
        if ($_FILES['logo']['name'] != '') {
            $logo = $this->uploadImage();
            $logo = $logo['data'];
        }
        $nama = $this->input->post("nama");
        $status = $this->input->post("status");
        $result = $this->model->insert($nama, $logo, $status);
        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    // dipakai Administrator |
    public function update()
    {
        $id = $this->input->post("id");
        $nama = $this->input->post("nama");
        $temp_logo = $this->input->post("temp_logo");
        if ($_FILES['logo']['name'] != '') {
            $logo = $this->uploadImage();
            $logo = $logo['data'];
        } else {
            $logo = $temp_logo;
        }
        $status = $this->input->post("status");
        $result = $this->model->update($id, $nama, $logo, $status);
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

        $this->load->model("master/teamModel", 'model');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
    }
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/master/Pengguna.php */