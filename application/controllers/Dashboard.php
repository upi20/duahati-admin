<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Render_Controller
{

	public function index()
	{
		// Page Settings
		$this->title = 'Dashboard';
		$this->navigation = ['Dashboard'];
		$this->plugins = ['datatables', 'daterangepicker', 'select2'];
		$this->load->library('libs');

		// Breadcrumb setting
		$this->breadcrumb_1 = 'Dashboard';
		$this->breadcrumb_1_url = '#';

		$this->content = 'dashboard/admin';
		// $this->data['total_sales'] = $this->model->getJumlahSales();
		// $this->data['total_warung'] = $this->model->getJumlahWarung();
		// $this->data['total_kecamatan'] = $this->model->getJumlahKecamatan();
		// $this->data['total_wilayah'] = $this->model->getJumlahWilayah();
		// $this->data['stok_diluar'] = $this->model->getJumlahStokDiluar();
		// $this->data['total_kredit'] = $this->model->getJumlahKredit();
		// $this->data['total_pemasukan'] = $this->model->getJumlahPemasukan();
		// $this->data['total_pengadaan'] = $this->model->getJumlahPengadaan();
		// Send data to view
		$this->render();
	}

	public function penjualanBySales()
	{
		$date_start = $this->input->post('date_start');
		$date_end = $this->input->post('date_end');
		$filter = [
			'date' => [
				'start' => $date_start,
				'end' => $date_end,
			],
		];
		$data = $this->data['penjualanBySales'] = $this->model->penjualanBySales($filter)->result_array();
		$count = $this->data['penjualanBySales'] = $this->model->penjualanBySales($filter)->num_rows();

		$this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'data' => $data]);
	}

	public function penjualanByKelompok()
	{
		$date_start = $this->input->post('date_start');
		$date_end = $this->input->post('date_end');
		$filter = [
			'date' => [
				'start' => $date_start,
				'end' => $date_end,
			],
		];
		$data = $this->data['penjualanByKelompok'] = $this->model->penjualanByKelompok($filter)->result_array();
		$count = $this->data['penjualanByKelompok'] = $this->model->penjualanByKelompok($filter)->num_rows();

		$this->output_json(['recordsTotal' => $count, 'recordsFiltered' => $count, 'data' => $data]);
	}

	function __construct()
	{
		parent::__construct();
		$this->sesion->cek_session();
		$this->default_template = 'templates/dashboard';
		$this->load->library('plugin');
		$this->load->helper('url');

		// Cek session

		// model
		$this->load->model("DashboardModel", 'model');
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */