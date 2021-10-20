<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends Render_Model
{
    public function getJumlahSales(): int
    {
        $return = $this->db
            ->query('SELECT count(*) as jumlah FROM role_users WHERE role_lev_id = 6')
            ->row_array();
        $return['jumlah'] = $return['jumlah'] ?? 0;
        return $return['jumlah'];
    }

    public function getJumlahWarung(): int
    {
        $return = $this->db
            ->query('SELECT count(*) as jumlah FROM warung')
            ->row_array();
        $return['jumlah'] = $return['jumlah'] ?? 0;
        return $return['jumlah'];
    }

    public function getJumlahKecamatan(): int
    {
        $return = $this->db
            ->query('SELECT count(*) as jumlah FROM kecamatan')
            ->row_array();
        $return['jumlah'] = $return['jumlah'] ?? 0;
        return $return['jumlah'];
    }

    public function getJumlahWilayah(): int
    {
        $return = $this->db
            ->query('SELECT count(*) as jumlah FROM wilayah')
            ->row_array();
        $return['jumlah'] = $return['jumlah'] ?? 0;
        return $return['jumlah'];
    }

    public function getJumlahStokDiluar(): int
    {
        $return = $this->db
            ->query('SELECT sum((jumlah_karton*12)+jumlah_renceng) as jumlah FROM stok_keluar_detail WHERE status = 1')
            ->row_array();
        $return['jumlah'] = $return['jumlah'] ?? 0;
        return $return['jumlah'];
    }

    public function getJumlahKredit(): int
    {
        $return = $this->db
            ->query('SELECT sum(dibayar) as jumlah FROM warung_sales_penjualan WHERE status = 1')
            ->row_array();
        $return['jumlah'] = $return['jumlah'] ?? 0;
        return $return['jumlah'];
    }

    public function getJumlahPemasukan(): int
    {
        $return = $this->db
            ->query('SELECT sum(dibayar) as jumlah FROM warung_sales_penjualan WHERE status = 2')
            ->row_array();
        return $return['jumlah'] ?? 0;
    }

    public function getJumlahPengadaan(): int
    {
        $return = $this->db
            ->query('SELECT sum(dibayar) as jumlah FROM stok_masuk WHERE status = 1')
            ->row_array();
        return $return['jumlah'] ?? 0;
    }

    public function penjualanBySales($filter = null)
    {
        $this->db->order_by('');
        $return = $this->db->select('
            a.user_nama as sales,
            ((SUM(d.jumlah_karton)*12)+(SUM(d.jumlah_renceng))) as terjual
            ')
            ->from('users a')
            ->join('role_users b', 'a.user_id = b.role_user_id')
            ->join('level c', 'b.role_lev_id = c.lev_id')
            ->where('c.lev_nama', 'Sales')
            ->where('a.user_status', 1)
            ->join("warung_sales_penjualan d", "a.user_id = d.id_sales", "left")
            ->order_by('terjual', 'desc')
            ->group_by("a.user_id");
        // filter
        if ($filter != null) {
            // filter date
            if ($filter['date']['start'] != null && $filter['date']['end'] != null) {
                $this->db->where("(DATE(a.created_at) BETWEEN '{$filter['date']['start']}' AND  '{$filter['date']['end']}')");
            }
        }
        $return = $this->db->get();
        return $return;
    }

    public function penjualanByKelompok($filter = null)
    {
        $return = $this->db->select('
            e.nama as kelompok,
            ((SUM(d.jumlah_karton)*12)+(SUM(d.jumlah_renceng))) as terjual
            ')
            ->from('tim e')
            ->join('tim_detail f', 'e.id = f.id_tim', 'left')
            ->join('users a', 'f.id_sales = a.user_id', 'left')
            ->join('role_users b', 'a.user_id = b.role_user_id')
            ->join('level c', 'b.role_lev_id = c.lev_id')
            ->where('c.lev_nama', 'Sales')
            ->where('e.status', 1)
            ->join("warung_sales_penjualan d", "a.user_id = d.id_sales", "left")
            ->order_by('terjual', 'desc')
            ->group_by("e.id");
        // filter
        if ($filter != null) {
            // filter date
            if ($filter['date']['start'] != null && $filter['date']['end'] != null) {
                $this->db->where("(DATE(a.created_at) BETWEEN '{$filter['date']['start']}' AND  '{$filter['date']['end']}')");
            }
        }
        $return = $this->db->get();
        return $return;
    }

    public function api_getStokDibawa($id_sales): array
    {
        $return = $this->db
            ->select_sum('a.jumlah_karton')
            ->select_sum('a.jumlah_renceng')
            // =======
            // ->select_sum('(a.jumlah_karton*12)+a.jumlah_renceng', 'jumlah')
            // >>>>>>> f02aabcd684ec0699e02d890bdc1c80527b1db57
            ->from('stok_keluar_detail a')
            ->join('stok_keluar b', 'b.id = a.id_stok_keluar')
            ->where('b.status', 1)
            ->where('b.id_sales', $id_sales)
            ->get()->row_array();
        $return = [
            'karton' => (int)($return['jumlah_karton'] ?? 0),
            'renceng' => (int)($return['jumlah_renceng'] ?? 0)
        ];
        return $return;
    }

    public function api_getTerjual($id_sales): array
    {
        $return = $this->db
            ->select_sum('a.jumlah_karton')
            ->select_sum('a.jumlah_renceng')
            ->from('warung_sales_penjualan a')
            ->join('stok_keluar b', 'b.id = a.id_stok_keluar')
            ->where('b.status', 1)
            ->where('b.id_sales', $id_sales)
            ->get()->row_array();
        $return = [
            'karton' => (int)($return['jumlah_karton'] ?? 0),
            'renceng' => (int)($return['jumlah_renceng'] ?? 0),
        ];
        return $return;
    }

    public function api_sisaPenjualan($stok, $terjual): array
    {
        $total_stok_renceng = ($stok['karton'] * 12) + $stok['renceng'];
        $total_terjual_renceng = ($terjual['karton'] * 12) + $terjual['renceng'];
        $sisa_renceng = $total_stok_renceng - $total_terjual_renceng;
        $karton = floor($sisa_renceng / 12);
        $renceng = $sisa_renceng % 12;
        $return = [
            'karton' => $karton,
            'renceng' => $renceng
        ];
        return $return;
    }

    public function api_warung($id_sales, $id = null, $cari = null): ?array
    {
        $this->db->select("a.id,
            CONCAT(a.nama_pemilik, ' ', '[', a.kode, ']') as nama,
            a.alamat");
        $this->db->from('warung a');
        $this->db->where('a.id_sales', $id_sales);
        if ($cari != null) {
            $this->db->where("(
            a.kode LIKE '%$cari%' or
            a.nama_pemilik LIKE '%$cari%' or
            a.alamat LIKE '%$cari%' or
            a.no_hp LIKE '%$cari%' or
            a.patokan LIKE '%$cari%'
            )");
        }
        $this->db->limit(20);

        if ($id == null) {
            $db = $this->db->get();
            $length = $db->num_rows();
            $return = $db->result_array();
        } else {
            $this->db->where('a.id', $id);
            $db = $this->db->get();
            $length = $db->num_rows();
            $return = $db->row_array();
        }

        if ($return != null) {
            $stok_keluar = $this->db->select('id as id_stok_keluar')
                ->from('stok_keluar')
                ->where('status', 1)
                ->where('id_sales', $id_sales)
                ->get()
                ->row_array() ?? ['id_stok_keluar' => null];
            if ($id == null) {
                $rows = [];
                foreach ($return as $row) {
                    $rows[] = array_merge($row, [
                        'id_sales' => $id_sales,
                        'id_stok_keluar' => $stok_keluar['id_stok_keluar'],
                    ]);
                }
                $return = $rows;
            } else {
                $return = array_merge($return, [
                    'id_sales' => $id_sales,
                    'id_stok_keluar' => $stok_keluar['id_stok_keluar'],
                ]);
            }
        }

        $return = ['data' => $return, 'length' => $length];
        return $return;
    }

    public function api_listSatuanHarga($id, $cari): ?array
    {
        $this->db->select('id, nama as text, harga, qty, id_produk, jenis');
        $this->db->from('satuan_harga');
        $this->db->where('status', 1);
        $this->db->where('jenis <>', 3);
        if ($id != null) {
            $this->db->where('id', $id);
        }

        if ($cari != null) {
            $this->db->where("(
            id LIKE '%$cari%' or
            nama LIKE '%$cari%' or
            harga LIKE '%$cari%' or
            qty LIKE '%$cari%'
            )");
        }

        $result = $this->db->get();
        $length = $result->num_rows();
        $data = $result->result_array();
        $return = ['data' => $data, 'length' => $length];
        return $return;
    }

    public function api_listProduk($id, $cari): ?array
    {
        $this->db->select('id, nama as text');
        $this->db->from('produk');
        $this->db->where('status', 1);
        if ($id != null) {
            $this->db->where('id', $id);
        }

        if ($cari != null) {
            $this->db->where("(
            id LIKE '%$cari%' or
            nama LIKE '%$cari%'
            )");
        }

        $result = $this->db->get();
        $length = $result->num_rows();
        $data = $result->result_array();
        $return = ['data' => $data, 'length' => $length];
        return $return;
    }


    public function api_insertSalesPenjualan(
        $id_stok_keluar,
        $qty_karton,
        $qty_renceng,
        $id_produk,
        $id_satuan_harga_karton,
        $id_satuan_harga_renceng,
        $id_warung,
        $harga_karton,
        $harga_renceng,
        $total_harga,
        $dibayar,
        $sisa,
        $status,
        $id_sales
    ): int {
        $data = [
            'id_stok_keluar' => $id_stok_keluar,
            'id_produk' => $id_produk,
            'id_satuan_harga_karton' => $id_satuan_harga_karton,
            'id_satuan_harga_renceng' => $id_satuan_harga_renceng,
            'id_warung' => $id_warung,
            'harga_karton' => $harga_karton,
            'harga_renceng' => $harga_renceng,
            'total_harga' => $total_harga,
            'dibayar' => $dibayar,
            'sisa' => $sisa,
            'status' => $status,
            'jumlah_karton' => $qty_karton,
            'jumlah_renceng' => $qty_renceng,
            'id_sales' => $id_sales,
        ];
        $this->db->insert('warung_sales_penjualan', $data);
        $return = $this->db->insert_id();
        return $return;
    }


    public function api_warung_detail($id_sales, $id = null): ?array
    {
        $this->db->select("a.kode, a.nama_pemilik, a.nama_warung, a.alamat");
        $this->db->from('warung a');
        $this->db->where('a.id_sales', $id_sales);

        if ($id == null) {
            $db = $this->db->get();
            $length = $db->num_rows();
            $return = $db->result_array();
        } else {
            $this->db->where('a.id', $id);
            $db = $this->db->get();
            $length = $db->num_rows();
            $return = $db->row_array();
        }


        $return = ['data' => $return, 'length' => $length];
        return $return;
    }
}
