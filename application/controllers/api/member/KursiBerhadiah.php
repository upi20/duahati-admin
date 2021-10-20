<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class KursiBerhadiah extends RestController
{

    public function index_get()
    {
        // Page Settings
        $this->title = 'Kursi Berhadiah';
        $this->content = 'kursi_berhadiah/list';

        // Send data to view
        $this->render();
    }

    public function detail($id)
    {
        // Page Settings
        $this->title = 'Kursi Berhadiah';
        $this->content = 'kursi_berhadiah/detail';

        // Send data to view
        $this->render();
    }

    function __construct()
    {
        parent::__construct();
        $key = $this->input->get('key');
        $key = $key ?? $this->input->post('key');
        $this->key = $key;
        if ($key == null) {
            $this->response([
                'status' => false,
                'message' => 'Key Tidak Valid'
            ], RestController::HTTP_UNAUTHORIZED);
            exit();
        }

        // cek level
        // Get data
        $userdata = $this->sesion->cek_userdata_api_member($key);
        if ($userdata == null) {
            $this->response([
                'status' => false,
                'message' => 'Key Tidak Valid'
            ], RestController::HTTP_UNAUTHORIZED);
            exit();
        }
        $this->id = $userdata['id'];

        // import model
        $this->load->model('api/HomeModel', 'model');
        $this->check_cors = true;
    }
}
