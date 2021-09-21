<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pembayaran extends Model
{
    protected $table = 'tb_pembayaran';

    public function getGlobal()
    {
        return DB::select('SELECT no_invoice,nama_sopir,GROUP_CONCAT(DISTINCT tb_pembayaran.harga) as hrg,SUM(nominal) as sub_total,GROUP_CONCAT(nama_petani) as pemilik, GROUP_CONCAT(DISTINCT tipe) as type, GROUP_CONCAT(DISTINCT tanggal_bayar) as tgl FROM tb_pembayaran JOIN tb_transaksi ON tb_pembayaran.id_keberangkatan = tb_transaksi.id_keberangkatan GROUP BY no_invoice, nama_sopir');
    }

    public function getPembayaran()
    {
        return DB::select('SELECT no_invoice,nama_sopir, GROUP_CONCAT(DISTINCT no_sp) as sp, GROUP_CONCAT(sangu) as s, GROUP_CONCAT(netto_pulang) as n, GROUP_CONCAT(DISTINCT tanggal_bayar) as tgl FROM tb_pembayaran JOIN tb_transaksi ON tb_pembayaran.id_keberangkatan = tb_transaksi.id_keberangkatan GROUP BY no_invoice, nama_sopir');
    }

    public function getFilter($tgl1, $tgl2)
    {
        return DB::select("SELECT no_invoice,nama_sopir, GROUP_CONCAT(DISTINCT no_sp) as sp, GROUP_CONCAT(sangu) as s, GROUP_CONCAT(netto_pulang) as n, GROUP_CONCAT(DISTINCT tanggal_bayar) as tgl FROM tb_pembayaran JOIN tb_transaksi ON tb_pembayaran.id_keberangkatan = tb_transaksi.id_keberangkatan WHERE (CAST(tanggal_bayar as date) BETWEEN '$tgl1' AND '$tgl2') GROUP BY no_invoice, nama_sopir");
    }
}
