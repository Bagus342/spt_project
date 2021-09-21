<?php

namespace App\Http\Controllers;

use App\Models\Berangkat;
use App\Models\Pembayaran;
use App\Models\Petani;
use App\Models\Sopir;
use Illuminate\Http\Request;
use Mockery\Undefined;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pembayaran $pembayaran)
    {
        foreach ($pembayaran->getPembayaran() as $item) :
            $this->data[] = [
                'invoice' => $item->no_invoice,
                'petani' => $item->nama_sopir,
                'tgl' => $item->tgl,
                'list_sp' => $item->sp,
                'subtotal' => $this->subTotal($item->s, $item->n),
            ];
        endforeach;
        return view('tampil-data-bayar', [
            'list' => !isset($this->data) ? [] : $this->data,
            'title' => 'Pembayaran'
        ]);
    }

    private function subTotal($sangu, $netto)
    {
        $s = explode(',', $sangu);
        $n = explode(',', $netto);
        $jumlah = 0;
        for ($i = 0; $i < count($s); $i++) {
            $jumlah += (int) $s[$i] * (int) $n[$i];
        }
        return $jumlah;
    }
    
    private function makeId(Pembayaran $pembayaran)
    {
        $last = $pembayaran->latest()->first();
        $pecah = $last === null ? 0 : explode("/", $last['no_invoice']);
        $parseid = $last === null ? 0 : (int) $pecah[0];
        return "{$this->makeZero($parseid)}/RG/{$this->getMounth(date('m'))}/" . date('Y');
    }

    public function makeZero($id)
    {
        if ($id < 9) {
            return '00' . ($id += 1);
        } elseif ($id < 99) {
            return '0' . ($id += 1);
        } else {
            return $id += 1;
        }
    }

    public function getMounth($intMounth)
    {
        $im = (int) $intMounth;
        $mounth = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        return $mounth[$im - 1];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Berangkat $berangkat, Pembayaran $pembayaran, Request $req)
    {
        $invoice = $this->makeId($pembayaran);
        $arr = [];
        foreach ($req->id as $item) :
            $data = $berangkat->where('id_keberangkatan', $item)->first();
            $arr[] = [
                'no_invoice' => $invoice,
                'harga' => $data['harga'],
                'tanggal_bayar' => now(),
                'nominal' => $data['harga'] * $data['netto'],
                'netto' => $data['netto'],
                'id_keberangkatan' => $data['id_keberangkatan']
            ];
        endforeach;
        if (count(Pembayaran::whereIn('id_keberangkatan', $req->id)->get()) !== 0) {
            $list = $pembayaran->join('tb_transaksi', 'tb_pembayaran.id_keberangkatan', '=', 'tb_transaksi.id_keberangkatan')->whereIn('tb_pembayaran.id_keberangkatan', $req->id)->get();
            return view('cetak-invoice', ['data' => $list, 'inv' => $invoice, 'penerima' => $list[0]['nama_sopir'], 'tgl' => $list[0]['tanggal_bayar'], 'title' => 'Invoice']);
        }
        $insert = $pembayaran->insert($arr);
        Berangkat::whereIn('id_keberangkatan', $req->id)->update([
            'status' => true,
        ]);
        $list = $pembayaran->join('tb_transaksi', 'tb_pembayaran.id_keberangkatan', '=', 'tb_transaksi.id_keberangkatan')->whereIn('tb_pembayaran.id_keberangkatan', $req->id)->get();
        return $insert ? view('cetak-invoice', ['data' => $list, 'inv' => $invoice, 'penerima' => $list[0]['nama_sopir'], 'tgl' => $list[0]['tanggal_bayar'], 'title' => 'Invoice']) : redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show(Berangkat $berangkat)
    {
        $data = Pembayaran::select('id_keberangkatan')->get();
        return view('list-dibayar', [
            'data' => $berangkat->whereNotNull('tanggal_pulang')->whereNotIn('id_keberangkatan', $data)->orderBy('id_keberangkatan', 'asc')->get(),
            'sopir' => Sopir::get(),
            'title' => 'Tambah | Pembayaran'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembayaran $pembayaran, $id)
    {
        $invoice = str_replace('-', '/', $id);
        return $pembayaran->where('no_invoice', $invoice)->delete()
            ? redirect()->back()->with('sukses', 'data berhasil di hapus')
            : redirect()->back()->with('error', 'data gagal di hapus');
    }
}
