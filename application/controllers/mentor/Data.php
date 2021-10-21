<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends Render_Controller
{

    public function index()
    {
        // Page Settings
        $this->title = 'Data Mentor';
        $this->navigation = ['Mentor'];
        $this->plugins = ['datatables'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_3 = 'Data Mentor';
        $this->breadcrumb_3_url = base_url() . 'mentor/list';
        // content
        $this->content      = 'mentor/list';

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
        $this->db->trans_start();
        $foto = '';
        if ($_FILES['foto']['name'] != '') {
            $foto = $this->uploadImage('foto');
            $foto = $foto['data'];
        }
        $nama = $this->input->post("nama");
        $tanggal_lahir = $this->input->post("tanggal_lahir");
        $password = $this->input->post("password");
        $status = $this->input->post("status");
        $jenis_kelamin = $this->input->post("jenis_kelamin");
        $telepon = $this->input->post("telepon");
        $email = $this->input->post("email");
        $alamat = $this->input->post("alamat");
        $level = $this->config->item('level_mentor');
        $result = $this->model->insert($nama, $tanggal_lahir, $jenis_kelamin, $telepon, $email, $password,  $foto, $status, $level, $alamat);

        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function update()
    {
        $id = $this->input->post("id");
        $temp_foto = $this->input->post("temp_foto");
        if ($_FILES['foto']['name'] != '') {
            $foto = $this->uploadImage('foto');
            $foto = $foto['data'];
            $this->deleteFile($temp_foto);
        } else {
            $foto = $temp_foto;
        }
        $nama = $this->input->post("nama");
        $tanggal_lahir = $this->input->post("tanggal_lahir");
        $password = $this->input->post("password");
        $status = $this->input->post("status");
        $jenis_kelamin = $this->input->post("jenis_kelamin");
        $telepon = $this->input->post("telepon");
        $email = $this->input->post("email");
        $alamat = $this->input->post("alamat");
        $level = $this->config->item('level_mentor');
        $result = $this->model->update($id, $nama, $tanggal_lahir, $jenis_kelamin, $telepon, $email, $password,  $foto, $status, $level, $alamat);
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function delete()
    {
        $id = $this->input->post("id");
        $result = $this->model->delete($id);
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


    public function emailCheck()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->output_json([
                'status' => false,
                'data' => null,
                'message' => validation_errors()
            ], 400);
        } else {
            $email = $this->input->post('email');
            $id_user = $this->input->post('id_user');
            $result = $this->model->emailCheck($email, $id_user);

            $code = $result == null ? 200 : 409;
            $status = $result == null;
            $this->output_json([
                'status' => $status,
                'length' => 1,
                'data' =>  $result,
                'message' => $status ? 'Email belum digunakan' : 'Email sudah terdaftar'
            ], $code);
        }
    }


    public function getList()
    {
        $result = $this->model->getList();
        $code = $result ? 200 : 500;
        $this->output_json($result, $code);
    }

    function __construct()
    {
        parent::__construct();
        $this->sesion->cek_session();
        if ($this->session->userdata('data')['level'] != 'Administrator') {
            redirect('my404', 'refresh');
        }
        $this->photo_path = './files/mentor/';
        $this->load->model("mentor/DataModel", 'model');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
    }
}
