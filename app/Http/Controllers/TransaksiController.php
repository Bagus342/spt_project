<?php

namespace App\Http\Controllers;

use App\Models\Berangkat;
use App\Models\Pembayaran;
use App\Models\Pg;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Berangkat $berangkat, Pembayaran $pembayaran)
    {
        return view('tampil-data-transaksi', [
            'list' => $berangkat->whereNotNull('tanggal_pulang')->whereMonth('tanggal_pulang', date('m'))->orderBy('id_keberangkatan', 'asc')->get(),
            'pembayaran' => $pembayaran->get(),
            'pg' => Pg::get(),
            'title' => 'Transaksi'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetakTransaksi(Berangkat $berangkat, Request $req)
    {
        $tgl = explode(' / ', $req->tanggal);
        if ( $req->tipe === null && $req->pabrik !== null ) {
            // return view('cetak-laporan', [
            //     'data' => $berangkat->whereNotNull('tanggal_pulang')->orderBy('id_keberangkatan', 'desc')->get()
            // ]);
            return view('cetak-laporan', [
                'data' => $berangkat->whereBetween('tanggal_pulang', [tanggal2($tgl[0]), tanggal2($tgl[1])])
                    ->where('pabrik_tujuan', $req->pabrik)
                    ->whereNotNull('tanggal_pulang')
                    ->get(),
                'title' => 'Cetak | Transaksi'
            ]);
        } else if ( $req->pabrik === null && $req->tipe !== null) {
            return view('cetak-laporan', [
                'data' => $berangkat->whereBetween('tanggal_pulang', [tanggal2($tgl[0]), tanggal2($tgl[1])])
                    ->where('tipe', $req->tipe)
                    ->whereNotNull('tanggal_pulang')
                    ->get(),
                'title' => 'Cetak | Transaksi'
            ]);
        } else if ( $req->pabrik !== null && $req->tipe !== null) {
            return view('cetak-laporan', [
                'data' => $berangkat->whereBetween('tanggal_pulang', [tanggal2($tgl[0]), tanggal2($tgl[1])])
                    ->where('tipe', $req->tipe)
                    ->where('pabrik_tujuan', $req->pabrik)
                    ->whereNotNull('tanggal_pulang')
                    ->get(),
                'title' => 'Cetak | Transaksi'
            ]);
        }
        else {
            return view('cetak-laporan', [
                'data' => $berangkat->whereBetween('tanggal_pulang', [tanggal2($tgl[0]), tanggal2($tgl[1])])
                    ->whereNotNull('tanggal_pulang')
                    ->get(),
                'title' => 'Cetak | Transaksi'
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewLaporan(Pembayaran $pembayaran)
    {
        foreach ($pembayaran->getPembayaran() as $item) :
            $this->data[] = [
                'invoice' => $item->no_invoice,
                'petani' => $item->nama_sopir,
                'tgl' => $item->tgl,
                'list_sp' => $item->sp,
            ];
        endforeach;
        return view('tampil-data-laporan-pembayaran', [
            'list' => !isset($this->data) ? [] : $this->data,
            'pg' => Pg::get(),
            'title' => 'Laporan | Pembayaran'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetakPembayaran(Pembayaran $pembayaran)
    {
        $list = $pembayaran->join('tb_transaksi', 'tb_pembayaran.id_keberangkatan', '=', 'tb_transaksi.id_keberangkatan')->where('tb_pembayaran.no_invoice', request('inv'))->get();
        return view('cetak-invoice', ['data' => $list, 'inv' => request('inv'), 'penerima' => $list[0]['nama_sopir'], 'tgl' => $list[0]['tanggal_bayar'], 'title' => 'Invoice']);
    }
}
