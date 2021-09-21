<?php

namespace App\Http\Controllers;

use App\Models\Berangkat;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function index (Berangkat $berangkat, Pembayaran $pembayaran) {
        $keberangkatan = $berangkat->whereDate('created_at', now())->orderBy('id_keberangkatan', 'desc')->get();
        $kepulangan = $berangkat->whereNotNull('tanggal_pulang')->whereDate('updated_at', now())->orderBy('id_keberangkatan', 'desc')->get();
        $saldo = $pembayaran->whereDate('tanggal_bayar', now())->orderBy('id_keberangkatan', 'desc')->get();
        $kondisi = $berangkat->get();
        return view('dashboard', [
            'berangkat' => $keberangkatan,
            'pulang' => $kepulangan,
            'saldo' => $saldo,
            'kondisi' => $kondisi,
        ]);
    }

}