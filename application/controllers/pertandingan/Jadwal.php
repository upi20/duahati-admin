<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends Render_Controller
{

    public function index()
    {
        // Page Settings
        $this->title = 'Master';
        $this->navigation = ['Pertandingan', 'Master  '];
        $this->plugins = ['datatables', 'select2', 'daterangepicker'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_2 = 'Pertandingan';
        $this->breadcrumb_2_url = '#';
        $this->breadcrumb_3 = 'Master';
        $this->breadcrumb_3_url = base_url() . 'pertandingan/jadwal';

        // content
        $this->content      = 'pertandingan/jadwal';

        // Send data to view
        $this->render();
    }

    public function pemenang($id_pertandingan = null)
    {
        // Page Settings

        $this->navigation = ['Pertandingan', 'Master  '];
        $this->plugins = ['datatables'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_2 = 'Pertandingan';
        $this->breadcrumb_2_url = '#';
        $this->breadcrumb_3 = 'Master';
        $this->breadcrumb_3_url = base_url() . 'pertandingan/jadwal';
        $this->breadcrumb_4 = 'Pemenang';
        $this->breadcrumb_4_url = base_url() . 'pertandingan/pemenang';

        $this->data['data'] = $this->model->getAllData(null, null, null, null, null, null, null, $id_pertandingan)->row_array();
        $this->data['id_pertandingan'] = $id_pertandingan;

        if ($this->data['data'] == null) {
            redirect('my404', 'refresh');
        }
        $this->title = 'Pemenang Quiz';

        // content
        $this->content      = 'pertandingan/pemenang';

        // Send data to view
        $this->render();
    }

    public function uploadImage()
    {
        $config['upload_path']          = './files/jadwal/';
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
        $filter = [
            'date' => [
                'start' => $date_start,
                'end' => $date_end,
            ],
            'team_1' => $team_1,
            'team_2' => $team_2,
            'team_2' => $team_2,
            'stadion' => $stadion,
        ];

        $data = $this->model->getAllData($draw, $length, $start, $_cari, $order, $filter)->result_array();
        $count = $this->model->getAllData(null, null, null, $_cari, $order, null, $filter)->num_rows();

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
    }

    public function ajax_kursi()
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
        $id = $this->input->post('id');
        $filter = [
            'date' => [
                'start' => $date_start,
                'end' => $date_end,
            ],
            'team_1' => $team_1,
            'team_2' => $team_2,
            'team_2' => $team_2,
            'stadion' => $stadion,
            'id' => $id
        ];

        $data = $this->model->list_kursi($draw, $length, $start, $_cari, $order, $filter)->result_array();
        $count = $this->model->list_kursi(null, null, null, $_cari, $order, null, $filter)->num_rows();

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
    }

    public function simpan_kursi()
    {
        $id = $this->input->post('id');
        $menang = $this->input->post('menang');
        $status = $this->model->simpan_kursi($id, $menang);
        $this->output_json(['status' => $status]);
    }

    public function ajax_mot()
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
        $id = $this->input->post('id');
        $id_pemain = $this->input->post('id_pemain');
        $filter = [
            'date' => [
                'start' => $date_start,
                'end' => $date_end,
            ],
            'team_1' => $team_1,
            'team_2' => $team_2,
            'team_2' => $team_2,
            'stadion' => $stadion,
            'id_pemain' => $id_pemain,
            'id' => $id
        ];

        $data = $this->model->list_mot($draw, $length, $start, $_cari, $order, $filter)->result_array();
        $count = $this->model->list_mot(null, null, null, $_cari, $order, null, $filter)->num_rows();

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
    }

    public function simpan_mot()
    {
        $id = $this->input->post('id');
        $menang = $this->input->post('menang');
        $status = $this->model->simpan_mot($id, $menang);
        $this->output_json(['status' => $status]);
    }

    public function ajax_skor()
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
        $skor_1 = $this->input->post('skor_1');
        $skor_2 = $this->input->post('skor_2');
        $stadion = $this->input->post('stadion');
        $id = $this->input->post('id');
        $filter = [
            'date' => [
                'start' => $date_start,
                'end' => $date_end,
            ],
            'team_1' => $team_1,
            'team_2' => $team_2,
            'stadion' => $stadion,
            'id' => $id,
            'skor_1' => $skor_1,
            'skor_2' => $skor_2,
        ];

        $data = $this->model->list_skor($draw, $length, $start, $_cari, $order, $filter)->result_array();
        $count = $this->model->list_skor(null, null, null, $_cari, $order, null, $filter)->num_rows();

        $this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data]);
    }

    public function simpan_skor()
    {
        $id = $this->input->post('id');
        $menang = $this->input->post('menang');
        $status = $this->model->simpan_skor($id, $menang);
        $this->output_json(['status' => $status]);
    }

    public function getJadwal()
    {
        $id = $this->input->get("id");
        $result = $this->model->getJadwal($id);
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function insert()
    {
        $this->db->trans_start();
        $team_1 = $this->input->post("team_1");
        $team_2 = $this->input->post("team_2");
        $stadion = $this->input->post("stadion");
        $tanggal_main = $this->input->post("tanggal_main");
        $jam_main = $this->input->post("jam_main");
        $status = $this->input->post("status");
        $result = $this->model->insert($team_1, $team_2, $stadion, $tanggal_main, $jam_main, $status);
        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function hasil_pertandingan()
    {
        $this->db->trans_start();
        $id = $this->input->post("id");
        $hasil_team_1 = $this->input->post("hasil_team_1");
        $hasil_team_2 = $this->input->post("hasil_team_2");
        $man_of_the_match = $this->input->post("man_of_the_match");
        $result = $this->model->hasil_pertandingan($id, $hasil_team_1, $hasil_team_2, $man_of_the_match);
        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function update()
    {
        $this->db->trans_start();
        $id = $this->input->post("id");
        $team_1 = $this->input->post("team_1");
        $team_2 = $this->input->post("team_2");
        $stadion = $this->input->post("stadion");
        $tanggal_main = $this->input->post("tanggal_main");
        $jam_main = $this->input->post("jam_main");
        $status = $this->input->post("status");
        $result = $this->model->update($id, $team_1, $team_2, $stadion, $tanggal_main, $jam_main, $status);
        $this->db->trans_complete();
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

    public function ajax_select_list_team()
    {
        $return = $this->model->list_team();
        $this->output_json($return);
    }

    public function ajax_select_list_stadion()
    {
        $return = $this->model->list_stadion();
        $this->output_json($return);
    }

    public function ajax_select_list_pemain()
    {
        $return = $this->model->list_pemain();
        $this->output_json($return);
    }

    public function getDetailMotm()
    {
        $id = $this->input->post('id');
        $return = $this->model->getDetailMotm($id);
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

        $this->load->model("pertandingan/jadwalModel", 'model');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
    }
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/pertandingan/Pengguna.php */