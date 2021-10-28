<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends Render_Controller
{
    public function index()
    {
        // Page Settings
        $this->title = 'Data News';
        $this->navigation = ['Data News'];
        $this->plugins = ['datatables', 'select2'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_3 = 'News';
        $this->breadcrumb_3_url = '#';
        $this->breadcrumb_4 = 'Data News';
        $this->breadcrumb_4_url = base_url() . 'news/master/list';
        // content
        $this->content      = 'news/master/list';

        // Send data to view
        $this->render();
    }
    public function tambah($id = null)
    {
        // Page Settings
        $this->title = 'Data News';
        $this->navigation = ['Data News'];
        $this->plugins = ['datatables', 'select2', 'summernote'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_3 = 'News';
        $this->breadcrumb_3_url = '#';
        $this->breadcrumb_4 = 'Tambah';
        $this->breadcrumb_4_url = base_url() . 'news/master/tambah';
        // content
        $this->content      = 'news/master/tambah';

        // cek id news
        if ($id == null) {
            $id = $this->model->cekNewId();
        }
        $cekData = $this->db->get_where('news', ['id' => $id]);
        if ($cekData->num_rows() == 0) {
            $this->index();
        }
        $this->data['isi'] = $cekData->result_array()[0];

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

        $filter = [
            '' => '',
        ];

        $data = $this->model->getAllData($draw, $length, $start, $_cari, $order, $filter)->result_array();
        $count = $this->model->getAllData(null, null, null, $_cari, $order, $filter)->num_rows();

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
    }
    public function getDeskripsi()
    {
        $id = $this->input->get('id');
        $result = $this->model->getDeskripsi($id);
        $code = $result ? 200 : 500;
        $this->output_json($result, $code);
    }

    public function getList()
    {
        $result = $this->model->getList();
        $code = $result ? 200 : 500;
        $this->output_json($result, $code);
    }

    public function updatePublish()
    {
        $id = $this->input->post("id");
        $st = $this->input->post("st");
        $user_id = $this->id;
        $result = $this->model->updatePublish($id, $st, $user_id);
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
        $judul = $this->input->post("judul");
        $deskripsi = $this->input->post("deskripsi");
        $tanggal_terbit = $this->input->post("tanggal_terbit");
        $status = $this->input->post("status");
        $user_id = $this->id;
        $result = $this->model->update($id, $user_id, $judul, $deskripsi, $foto, $tanggal_terbit, $status);
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
        $this->photo_path = './files/news/master/';
        $this->load->model("news/MasterModel", 'model');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
    }
}
