<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Materi extends Render_Controller
{
    public function index()
    {
        // Page Settings
        $this->title = 'Data Materi';
        $this->navigation = ['Materi'];
        $this->plugins = ['datatables', 'select2'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_3 = 'Kelas';
        $this->breadcrumb_3_url = '#';
        $this->breadcrumb_4 = 'Materi';
        $this->breadcrumb_4_url = base_url() . 'kelas/materi/list';
        // content
        $this->content      = 'kelas/materi/list';

        // Send data to view
        $this->render();
    }

    public function materi_kelas($id)
    {
        // Page Settings
        $this->title = 'Data Materi';
        $this->navigation = ['Data Kelas'];
        $this->plugins = ['datatables'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_3 = 'Kelas';
        $this->breadcrumb_3_url = '#';
        $this->breadcrumb_4 = 'Materi';
        $this->breadcrumb_4_url = base_url() . 'kelas/materi';
        // content
        $this->content      = 'kelas/materi/detail';
        $this->data['kelas_id'] = $id;
        $this->data['detail'] = $this->model->getDetail($id);
        if ($this->data['detail'] == null) {
            redirect('my404', 'refresh');
        }

        // Send data to view
        $this->render();
    }

    public function sub($id)
    {
        // Page Settings
        $this->title = 'Data Sub Materi';
        $this->navigation = ['Data Kelas'];
        $this->plugins = ['datatables'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_3 = 'Kelas';
        $this->breadcrumb_3_url = '#';
        $this->breadcrumb_4 = 'Sub Materi';
        $this->breadcrumb_4_url = base_url() . 'kelas/materi';
        // content
        $this->content      = 'kelas/materi/sub';
        $this->data['kelas_id'] = $id;
        $this->data['detail'] = $this->model->getDetailMateri($id);
        if ($this->data['detail'] == null) {
            redirect('my404', 'refresh');
        }

        // Send data to view
        $this->render();
    }

    public function ajax_data_materi_kelas()
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
        $kelas = $this->input->post('kelas');
        $filter = [
            'kategori' => $kategori,
            'kelas' => $kelas,
        ];

        $data = $this->model->getAllData($draw, $length, $start, $_cari, $order, $filter)->result_array();
        $count = $this->model->getAllData(null, null, null, $_cari, $order, $filter)->num_rows();

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
    }

    public function ajax_data_materi_kelas_sub()
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
        $materi = $this->input->post('materi');
        $filter = [
            'kategori' => $kategori,
            'materi' => $materi,
        ];

        $data = $this->model->getAllDataSub($draw, $length, $start, $_cari, $order, $filter)->result_array();
        $count = $this->model->getAllDataSub(null, null, null, $_cari, $order, $filter)->num_rows();

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
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
        $kelas = $this->input->post('kelas');
        $filter = [
            'kategori' => $kategori,
            'kelas' => $kelas,
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
        if (isset($_FILES['foto']['name'])) {
            if ($_FILES['foto']['name'] != '') {
                $foto = $this->uploadImage('foto');
                $foto = $foto['data'];
            }
        }
        $url = $this->input->post("url");
        $nama = $this->input->post("nama");
        $submateri = $this->input->post("submateri");
        $kelas_id = $this->input->post("kelas_id");
        $keterangan = $this->input->post("keterangan");
        $status = $this->input->post("status");
        $no_urut = $this->input->post("no_urut");
        $user_id = $this->id;
        $result = $this->model->insert($user_id, $kelas_id, $nama, $keterangan, $url, $no_urut, $submateri, $status);

        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function insert_sub()
    {
        $this->db->trans_start();
        $foto = '';
        if (isset($_FILES['foto']['name'])) {
            if ($_FILES['foto']['name'] != '') {
                $foto = $this->uploadImage('foto');
                $foto = $foto['data'];
            }
        }
        $materi_id = $this->input->post("materi_id");
        $url = $this->input->post("url");
        $nama = $this->input->post("nama");
        $submateri = $this->input->post("submateri");
        $kelas_id = $this->input->post("kelas_id");
        $keterangan = $this->input->post("keterangan");
        $status = $this->input->post("status");
        $no_urut = $this->input->post("no_urut");
        $user_id = $this->id;
        $result = $this->model->insert_sub($user_id, $kelas_id, $materi_id, $nama, $keterangan, $url, $no_urut, $submateri, $status);

        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function update()
    {
        $id = $this->input->post("id");
        $temp_foto = $this->input->post("temp_foto");
        if (isset($_FILES['foto']['name'])) {
            if ($_FILES['foto']['name'] != '') {
                $foto = $this->uploadImage('foto');
                $foto = $foto['data'];
                $this->deleteFile($temp_foto);
            } else {
                $foto = $temp_foto;
            }
        }
        $url = $this->input->post("url");
        $nama = $this->input->post("nama");
        $kelas_id = $this->input->post("kelas_id");
        $keterangan = $this->input->post("keterangan");
        $submateri = $this->input->post("submateri");
        $no_urut = $this->input->post("no_urut");
        $status = $this->input->post("status");
        $user_id = $this->id;
        $result = $this->model->update($id, $user_id, $kelas_id, $nama, $keterangan, $url,  $no_urut, $submateri, $status);
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function update_sub()
    {
        $id = $this->input->post("id");
        $temp_foto = $this->input->post("temp_foto");
        if (isset($_FILES['foto']['name'])) {
            if ($_FILES['foto']['name'] != '') {
                $foto = $this->uploadImage('foto');
                $foto = $foto['data'];
                $this->deleteFile($temp_foto);
            } else {
                $foto = $temp_foto;
            }
        }
        $url = $this->input->post("url");
        $nama = $this->input->post("nama");
        $kelas_id = $this->input->post("kelas_id");
        $keterangan = $this->input->post("keterangan");
        $submateri = $this->input->post("submateri");
        $no_urut = $this->input->post("no_urut");
        $status = $this->input->post("status");
        $user_id = $this->id;
        $result = $this->model->update_sub($id, $user_id, $kelas_id, $nama, $keterangan, $url,  $no_urut, $submateri, $status);
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

    public function delete_sub()
    {
        $id = $this->input->post("id");
        $result = $this->model->delete_sub($this->id, $id);
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

    public function noUrut()
    {
        $kelas_id = $this->input->post('kelas_id');
        $result = $this->model->noUrut($kelas_id);
        $code = $result ? 200 : 500;
        $this->output_json($result, $code);
    }

    public function cekNoUrut()
    {
        $kelas_id = $this->input->post('kelas_id');
        $no = $this->input->post('no');
        $result = $this->model->cekNoUrut($kelas_id, $no);
        $this->output_json($result, 200);
    }

    public function noUrut_sub()
    {
        $materi_id = $this->input->post('materi_id');
        $result = $this->model->noUrut_sub($materi_id);
        $code = $result ? 200 : 500;
        $this->output_json($result, $code);
    }

    public function cekNoUrut_sub()
    {
        $materi_id = $this->input->post('materi_id');
        $no = $this->input->post('no');
        $result = $this->model->cekNoUrut_sub($materi_id, $no);
        $this->output_json($result, 200);
    }

    function __construct()
    {
        parent::__construct();
        $this->sesion->cek_session();
        if ($this->session->userdata('data')['level'] != 'Administrator') {
            redirect('my404', 'refresh');
        }
        $this->id = $this->session->userdata('data')['id'];
        $this->photo_path = './files/kelas/materi/';
        $this->load->model("kelas/materiModel", 'model');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
    }
}
