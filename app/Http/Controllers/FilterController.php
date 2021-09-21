<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Berangkat;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function FilterBData(Request $req)
    {
        return response()->json(['data' => Berangkat::whereBetween('tanggal_keberangkatan', [$req->tgl1, $req->tgl2])->get(), 'tgl2' => $req->tgl2, 'tgl1' => $req->tgl1]);
    }

    public function FilterLData(Request $req)
    {
        return response()->json(['data' => Berangkat::whereBetween('tanggal_keberangkatan', [$req->tgl1, $req->tgl2])->whereNull('tanggal_pulang')->get(), 'tgl2' => $req->tgl2, 'tgl1' => $req->tgl1]);
    }

    public function FilterData(Request $req)
    {
        return response()->json(['data' => Berangkat::whereBetween('tanggal_pulang', [$req->tgl1, $req->tgl2])->get(), 'tgl2' => $req->tgl2, 'tgl1' => $req->tgl1]);
    }

    public function FilterPData(Request $req, Pembayaran $pembayaran)
    {
        $dt = [];
        foreach ($pembayaran->getFilter($req->tgl1, $req->tgl2) as $item) {
            $dt[] = [
                'invoice' => $item->no_invoice,
                'petani' => $item->nama_sopir,
                'tgl' => $item->tgl,
                'list_sp' => $item->sp,
                'subtotal' => $this->subTotal($item->s, $item->n),
            ];
        }
        return response()->json(['data' => $dt]);
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

    public function FilterTData(Request $req)
    {   
        if ($req->tujuan === null && $req->type !== null) {
            return response()->json([
                'data' => Berangkat::whereBetween('tanggal_pulang', [$req->tgl1, $req->tgl2])
                    ->where('tipe', $req->type)
                    ->whereNotNull('tanggal_pulang')
                    ->orderBy('id_keberangkatan', 'asc')
                    ->get()
            ]);
        } else if ($req->type === null && $req->tujuan !== null) {
            return response()->json([
                'data' => Berangkat::whereBetween('tanggal_pulang', [$req->tgl1, $req->tgl2])
                    ->where('pabrik_tujuan', $req->tujuan)
                    ->whereNotNull('tanggal_pulang')
                    ->orderBy('id_keberangkatan', 'asc')
                    ->get()
            ]);
        } else if ($req->type !== null && $req->tujuan !== null) {
            return response()->json([
                'data' => Berangkat::whereBetween('tanggal_pulang', [$req->tgl1, $req->tgl2])
                    ->where('tipe', $req->type)
                    ->where('pabrik_tujuan', $req->tujuan)
                    ->whereNotNull('tanggal_pulang')
                    ->orderBy('id_keberangkatan', 'asc')
                    ->get()
            ]);
        } else {
        return response()->json([
            'data' => Berangkat::whereBetween('tanggal_pulang', [$req->tgl1, $req->tgl2])
                ->whereNotNull('tanggal_pulang')
                ->orderBy('id_keberangkatan', 'asc')
                ->get()
        ]);
        }
    }

    public function FilterLPData(Request $req)
    {
        if ($req->type !== null) {
            return response()->json([
                'data' => Pembayaran::rightJoin('tb_transaksi', 'tb_pembayaran.id_keberangkatan', '=', 'tb_transaksi.id_keberangkatan')
                    ->whereBetween('tb_pembayaran.tanggal_bayar', [$req->tgl1, $req->tgl2])
                    ->where('tipe', $req->type)
                    ->get()
            ]);
        } else {
            return response()->json([
                'data' => Pembayaran::rightJoin('tb_transaksi', 'tb_pembayaran.id_keberangkatan', '=', 'tb_transaksi.id_keberangkatan')
                    ->whereBetween('tb_pembayaran.tanggal_bayar', [$req->tgl1, $req->tgl2])
                    ->get()
            ]);
        }
        }

    public function getSopir()
    {
        $sopir = request('name');
        $data = Pembayaran::select('id_keberangkatan')->get();
        $filter = Berangkat::whereNotNull('tanggal_pulang')->whereNotIn('id_keberangkatan', $data)->where('nama_sopir', $sopir)->get();
        return count($filter) !== 0
            ? response()->json(['pembayaran' => $filter, 'type' => 'filter'])
            : response()->json([
                'pembayaran' => Berangkat::whereNotNull('tanggal_pulang')->whereNotIn('id_keberangkatan', $data)->get(),
                'type' => 'base'
            ]);
    }

    public function getDetail()
    {
        $id = request('id');
        return response()->json(['data' => Berangkat::where('id_keberangkatan', $id)->first()]);
    }

    public function getDetailP()
    {
        $id = request('id');
        return response()->json(['data' => Pembayaran::join('tb_transaksi', 'tb_pembayaran.id_keberangkatan', '=', 'tb_transaksi.id_keberangkatan')->where('tb_pembayaran.no_invoice', $id)->get()]);
    }
}
