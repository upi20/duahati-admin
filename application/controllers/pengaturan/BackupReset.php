<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BackupReset extends Render_Controller
{

    // dipakai Administrator |
    public function index()
    {
        // Page Settings
        $this->title = 'Backup & Reset';
        $this->navigation = ['Pengaturan', 'Backup & Reset'];
        $this->plugins = ['datatables'];

        // Breadcrumb setting
        $this->breadcrumb_1 = 'Dashboard';
        $this->breadcrumb_1_url = base_url();
        $this->breadcrumb_2 = 'Pengaturan';
        $this->breadcrumb_2_url = '#';
        $this->breadcrumb_3 = 'Backup & Reset';
        $this->breadcrumb_3_url = base_url() . 'pengaturan/backup-reset';

        // content
        $this->content      = 'pengaturan/backup-reset';

        // Send data to view
        $this->render();
    }

    public function backupLoading()
    {
        $this->load->dbutil();
        $prefs = array(
            'tables'        => array('stok_keluar', 'stok_keluar_detail', 'stok_kembali'),   // Array of tables to backup.
            'ignore'        => array(),                     // List of tables to omit from the backup
            'format'        => 'txt',                       // gzip, zip, txt
            'filename'      => 'stok_keluar.sql',              // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
            'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
            'newline'       => "\n"                         // Newline character used in backup file
        );
        $backup = &$this->dbutil->backup($prefs);
        $this->load->helper('download');
        force_download('stok_keluar.sql', $backup);
    }

    public function resetLoading()
    {
        $this->db->trans_start();

        // $kembaliStok = $this->model->kembaliStok();
        // $this->db->reset_query();

        $result = $this->db->empty_table('stok_keluar_detail');
        $this->db->reset_query();

        $result = $this->db->empty_table('stok_keluar');
        $this->db->reset_query();

        $result = $this->db->empty_table('stok_kembali');
        $this->db->reset_query();

        // $this->db->update('produk', ['qty_karton' => 0, 'qty_renceng' => 0]);
        // $this->db->reset_query();

        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);

        // echo "<script>alert('Loading berhasil direset')</script>";
        // redirect("pengaturan/backupReset", "refresh");
    }

    public function backupPenjualan()
    {
        $this->load->dbutil();
        $prefs = array(
            'tables'        => array('warung_sales_penjualan'),   // Array of tables to backup.
            'ignore'        => array(),                     // List of tables to omit from the backup
            'format'        => 'txt',                       // gzip, zip, txt
            'filename'      => 'warung_sales_penjualan.sql',              // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
            'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
            'newline'       => "\n"                         // Newline character used in backup file
        );
        $backup = &$this->dbutil->backup($prefs);
        $this->load->helper('download');
        force_download('warung_sales_penjualan.sql', $backup);
    }

    public function resetPenjualan()
    {
        $this->db->trans_start();

        $result = $this->db->empty_table('warung_sales_penjualan');
        $this->db->reset_query();

        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }

    public function backupPembayaran()
    {
        $this->load->dbutil();
        $prefs = array(
            'tables'        => array('warung_pembayaran'),   // Array of tables to backup.
            'ignore'        => array(),                     // List of tables to omit from the backup
            'format'        => 'txt',                       // gzip, zip, txt
            'filename'      => 'warung_pembayaran.sql',              // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
            'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
            'newline'       => "\n"                         // Newline character used in backup file
        );
        $backup = &$this->dbutil->backup($prefs);
        $this->load->helper('download');
        force_download('warung_pembayaran.sql', $backup);
    }

    public function resetPembayaran()
    {
        $this->db->trans_start();

        $result = $this->db->empty_table('warung_pembayaran');
        $this->db->reset_query();

        $this->db->trans_complete();
        $code = $result ? 200 : 500;
        $this->output_json(["data" => $result], $code);
    }


    function __construct()
    {
        parent::__construct();
        // Cek session
        $this->sesion->cek_session();
        if ($this->session->userdata('data')['level'] != 'Administrator') {
            redirect('my404', 'refresh');
        }

        $this->load->model("pengaturan/backupResetModel", 'model');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
    }
}
