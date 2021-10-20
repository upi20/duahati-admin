<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemain extends Render_Controller
{

    // dipakai Administrator |
    public function index()
    {
        // Page Settings
        $this->title = 'Pemain';
        $this->navigation = ['Master', 'Pemain'];
        $this->plugins = ['datatables', 'select2'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_2 = 'Master';
        $this->breadcrumb_2_url = '#';
        $this->breadcrumb_3 = 'Pemain';
        $this->breadcrumb_3_url = base_url() . 'master/pemain';

        // content
        $this->content      = 'master/pemain';

        // Send data to view
        $this->render();
    }

    public function uploadImage()
    {
        $config['upload_path']          = './files/pemain/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPG|PNG|JPEG';
        $config['file_name']            = md5(uniqid("ktm_home", true));
        $config['overwrite']            = true;
        $config['max_size']             = 8024;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('photo')) {
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
    public function getPemain()
    {
        $id = $this->input->get("id");
        $result = $this->model->getPemain($id);
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    // dipakai Administrator |
    public function insert()
    {
        $this->db->trans_start();
        if ($_FILES['photo']['name'] != '') {
            $photo = $this->uploadImage();
            $photo = $photo['data'];
        }
        $nama = $this->input->post("nama");
        $team = $this->input->post("team");
        $posisi = $this->input->post("posisi");
        $status = $this->input->post("status");
        $result = $this->model->insert($team, $posisi, $nama, $photo, $status);
        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    // dipakai Administrator |
    public function update()
    {
        $id = $this->input->post("id");
        $nama = $this->input->post("nama");
        $team = $this->input->post("team");
        $posisi = $this->input->post("posisi");
        $temp_photo = $this->input->post("temp_photo");
        if ($_FILES['photo']['name'] != '') {
            $photo = $this->uploadImage();
            $photo = $photo['data'];
        } else {
            $photo = $temp_photo;
        }
        $status = $this->input->post("status");
        $result = $this->model->update($id, $team, $posisi, $nama, $photo, $status);
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

    public function ajax_select_list_team()
    {
        $return = $this->model->list_team();
        $this->output_json($return);
    }

    public function ajax_select_list_posisi()
    {
        $return = $this->model->list_posisi();
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

        $this->load->model("master/pemainModel", 'model');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
    }
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/master/Pengguna.php */