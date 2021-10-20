<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BackupResetModel extends Render_Model
{
    public function kembaliStok()
    {

        // kembalikan stok produk
        $list_details = $this->db
            ->select('id_produk, jumlah_karton, jumlah_renceng, status')
            ->where('status !=', 99)
            ->get('stok_keluar_detail')->result_array();
        $this->db->reset_query();

        foreach ($list_details as $detail) {
            $idp = $detail['id_produk'];

            $b = $this->getStok($idp)->row_array();
            $keluar    = $b['keluar'];
            $terjual        = $b['terjual'];
            $retur_renceng = $keluar - $terjual;
            $retur_karton = floor($retur_renceng / 12);
            $retur_renceng = $retur_renceng % 12;

            $detail_karton = $detail['jumlah_karton'];
            $detail_renceng = $detail['jumlah_renceng'];
            if ($detail['status'] == 2) {
                $detail_karton = $detail['jumlah_karton'] - $retur_karton;
                $detail_renceng = $detail['jumlah_renceng'] - $retur_renceng;
            }
            // update stok
            $set = $this->db->query("UPDATE produk as a
                SET qty_karton =
                    ((
                        SELECT qty_karton
                        FROM produk as b
                        WHERE b.id = a.id
                        ) + {$detail_karton}),
                    qty_renceng =
                    ((
                        SELECT qty_renceng
                        FROM produk as c
                        WHERE c.id = a.id
                        ) + {$detail_renceng})
                WHERE a.id = {$idp}");
            $this->db->reset_query();
            $this->resetStok($idp, 'floor');
        }

        return $set;
    }

    public function getStok($group = null)
    {
        $this->db->select("a.id, a.id_stok_keluar, a.id_produk, a.jumlah_karton, a.jumlah_renceng, b.jumlah_karton as skarton, b.jumlah_renceng as srenceng, ((b.jumlah_karton*12)+(IFNULL(b.jumlah_renceng, 0))) AS keluar, b.status");
        $this->db->from("warung_sales_penjualan a");
        $this->db->join("stok_keluar_detail b", "a.id_stok_keluar = b.id_stok_keluar", "left");
        $this->db->select_sum("(a.jumlah_karton*12)+(IFNULL(a.jumlah_renceng, 0))", "terjual");
        $this->db->where('b.status !=', 99);
        if ($group != null) {
            $this->db->group_by("a.id_produk");
        }
        $result = $this->db->get();
        return $result;
    }

    public function resetStok($produk, $mod = 'ceil')
    {
        $cek = $this->db->get_where('produk', ['id' => $produk])->result_array();

        $min = abs($cek[0]['qty_renceng']);
        $kar = $mod($min / 12);
        $ren = $min % 12;
        $sis = abs(12 - $min);

        // jika jumlah renceng minus
        if ($cek[0]['qty_renceng'] < 0) {
            // update stok
            $this->db->query("UPDATE produk as a
            SET qty_karton =
                ((
                    SELECT qty_karton
                    FROM produk as b
                    WHERE b.id = a.id
                    ) - $kar),
                qty_renceng =  $sis
            WHERE a.id = $produk");
        }
        // jika jumlah renceng lebih dari 12
        if ($cek[0]['qty_renceng'] > 12) {
            // update stok
            $this->db->query("UPDATE produk as a
            SET qty_karton =
                ((
                    SELECT qty_karton
                    FROM produk as b
                    WHERE b.id = a.id
                    ) + $kar),
                qty_renceng =  $sis
            WHERE a.id = $produk");
        }
    }
}
