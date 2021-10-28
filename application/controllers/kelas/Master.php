<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends Render_Controller
{
    public function index()
    {
        // Page Settings
        $this->title = 'Data Kelas';
        $this->navigation = ['Data Kelas'];
        $this->plugins = ['datatables', 'select2'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_3 = 'Kelas';
        $this->breadcrumb_3_url = '#';
        $this->breadcrumb_4 = 'master';
        $this->breadcrumb_4_url = base_url() . 'kelas/master/list';
        // content
        $this->content      = 'kelas/master/list';

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

        $kategori = $this->input->post('kategori');
        $filter = [
            'kategori' => $kategori,
        ];

        $data = $this->model->getAllData($draw, $length, $start, $_cari, $order, $filter)->result_array();
        $count = $this->model->getAllData(null, null, null, $_cari, $order, $filter)->num_rows();

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
    }


    public function getList()
    {
        $result = $this->model->getList();
        $code = $result ? 200 : 500;
        $this->output_json($result, $code);
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
        $kategori_id = $this->input->post("kategori_id");
        $keterangan = $this->input->post("keterangan");
        $tipe = $this->input->post("tipe");
        $status = $this->input->post("status");
        $user_id = $this->id;
        $result = $this->model->insert($user_id, $kategori_id, $nama, $keterangan, $foto, $tipe, $status);

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
        $kategori_id = $this->input->post("kategori_id");
        $keterangan = $this->input->post("keterangan");
        $status = $this->input->post("status");
        $tipe = $this->input->post("tipe");
        $user_id = $this->id;
        $result = $this->model->update($id, $user_id, $kategori_id, $nama, $keterangan, $foto, $tipe, $status);
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
        $this->photo_path = './files/kelas/master/';
        $this->load->model("kelas/MasterModel", 'model');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
    }
}
