<?php

namespace App\Http\Controllers;

use App\Models\Berangkat;
use Illuminate\Http\Request;

class PulangContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Berangkat $berangkat)
    {
        return view('tampil-data-pulang', [
            'data' => $berangkat->whereNotNull('tanggal_pulang')->whereDate('updated_at', now())->orderBy('id_keberangkatan', 'desc')->get(),
            'title' => 'Pulang'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req, Berangkat $berangkat, $id)
    {
        return $berangkat
            ->where('id_keberangkatan', $id)
            ->update([
                'tanggal_pulang' => tanggal($req->tanggal_pulang),
                'tanggal_bongkar' => tanggal($req->tanggal_bongkar),
                'no_truk' => $req->no_truk,
                'berat_pulang' => $req->berat_pulang,
                'refaksi' => $req->refaksi
            ]) ? redirect('/pulang') : redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Berangkat  $berangkat
     * @return \Illuminate\Http\Response
     */
    public function show(Berangkat $berangkat)
    {
        return view('list-dipulangkan', [
            'data' => $berangkat->whereNull('tanggal_pulang')->orderBy('id_keberangkatan', 'asc')->get(),
            'title' => 'Tambah | Pulang'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Berangkat  $berangkat
     * @return \Illuminate\Http\Response
     */
    public function edit(Berangkat $berangkat, Request $req, $id)
    {
        return $berangkat->where('id_keberangkatan', $id)->update([
            'tanggal_pulang' => tanggal($req->tanggal_pulang),
            'tanggal_bongkar' => tanggal($req->tanggal_bongkar),
            'no_truk' => $req->no_truk,
            'berat_pulang' => $req->berat_pulang,
            'refaksi' => $req->refaksi,
            'netto_pulang' => $req->berat_pulang - $req->refaksi,
            'updated_at' => now()
        ]) ? redirect('/pulang')->with('sukses', 'sukses menambah data kepulangan') : redirect()->back()->with('error', 'gagal menambah data kepulangan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Berangkat  $berangkat
     * @return \Illuminate\Http\Response
     */
    public function update(Berangkat $berangkat, $id)
    {
        return response()->json([
            'data' => $berangkat->where('id_keberangkatan', $id)->first()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Berangkat  $berangkat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Berangkat $berangkat, $id)
    {
        return $berangkat->where('id_keberangkatan', $id)->delete()
            ? redirect('/pulang')->with('sukses', 'sukses menghapus data') : redirect('/pulang')->with('error', 'gagal menghapus data');
    }

    public function cetak(Berangkat $berangkat)
    {
        return view('laporan-pulang', [
            'data' => $berangkat->whereNotNull('tanggal_pulang')->whereDate('updated_at', now())->get(),
            'title' => 'Laporan | Pulang'
        ]);
    }

    public function updateSp(Berangkat $berangkat, Request $req, $id)
    {
        if (Berangkat::where('no_sp', $req->no_sp)->first() === null) {
            return $berangkat->where('id_keberangkatan', $id)->update([
                'no_sp' => $req->no_sp
            ]) ? redirect()->back()->with('sukses', 'sukses update nomor sp') : redirect()->back()->with('error', 'gagal update nomor sp');
        } else {
            return redirect()->back()->with('error', 'Nomor Sp Telah Terdaftar');
        }
    }
}
