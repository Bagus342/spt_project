<?php

namespace App\Http\Controllers;

use App\Models\Berangkat;
use App\Models\Pembayaran;
use App\Models\Petani;
use App\Models\Pg;
use App\Models\Sopir;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class BerangkatController extends Controller
{

    public function index(Berangkat $berangkat)
    {
        if (request('id') !== null) {
            $dau = $berangkat->where('id_keberangkatan', request('id'))->orderBy('id_keberangkatan', 'desc')->get();
            $update = ['sopir' => Sopir::get(), 'wilayah' => Wilayah::get(), 'pg' => Pg::get(), 'petani' => Petani::get(), 'data' => $dau];
            return view('tampil-data-berangkat', $update);
        } else {
            $list = $berangkat->whereDate('created_at', now())->orderBy('id_keberangkatan', 'desc')->get();
            $data = ['sopir' => Sopir::get(), 'wilayah' => Wilayah::get(), 'pg' => Pg::get(), 'petani' => Petani::get(), 'data' => $list, 'title' => 'Berangkat'];
            return view('tampil-data-berangkat', $data);
        }
    }

    public function getPg($name) {
        return response()->json(['data' => Petani::where('nama_pabrik', $name)->get()]);
    }

    public function addView()
    {
        $data = ['sopir' => Sopir::get(), 'wilayah' => Wilayah::get(), 'pg' => Pg::get(), 'petani' => Petani::get()];
        return view('berangkat', $data);
    }

    public function add(Request $req)
    {
        $harga = explode('Rp. ', $req->harga);
        $sangu = explode('Rp. ', $req->sangu);
        if (Berangkat::where('no_sp', $req->no_sp)->first() === null) {
            if ($req->sangu === null) {
                return Berangkat::insert([
                    'tanggal_keberangkatan' => tanggal($req->tanggal_berangkat),
                    'tipe' => $req->tipe,
                    'no_sp' => $req->no_sp,
                    'no_induk' => $req->no_induk,
                    'wilayah' => $req->wilayah,
                    'nama_petani' => $req->nama_petani,
                    'nama_sopir' => $req->nama_sopir,
                    'pabrik_tujuan' => $req->nama_pabrik,
                    'sangu' => $req->sangu,
                    'berat_timbang' => $req->berat_timbang,
                    'tara_mbl' => $req->tara_mbl,
                    'netto' => $req->netto,
                    'status' => false,
                    'harga' => str_replace('.', '', $harga[1]),
                ])
                    ? redirect('/berangkat')->with('sukses', 'sukses tambah data')
                    : redirect()->back()->with('error', 'gagal menambah data');
            } else {
                return Berangkat::insert([
                    'tanggal_keberangkatan' => tanggal($req->tanggal_berangkat),
                    'tipe' => $req->tipe,
                    'no_sp' => $req->no_sp,
                    'no_induk' => $req->no_induk,
                    'wilayah' => $req->wilayah,
                    'nama_petani' => $req->nama_petani,
                    'nama_sopir' => $req->nama_sopir,
                    'pabrik_tujuan' => $req->nama_pabrik,
                    'sangu' => str_replace('.', '', $sangu[1]),
                    'berat_timbang' => $req->berat_timbang,
                    'tara_mbl' => $req->tara_mbl,
                    'netto' => $req->netto,
                    'status' => false,
                    'harga' => str_replace('.', '', $harga[1]),
                ])
                    ? redirect('/berangkat')->with('sukses', 'sukses tambah data')
                    : redirect()->back()->with('error', 'gagal menambah data');
            }
        } else {
            return redirect()->back()->with('error', 'Nomor Sp Telah Terdaftar');
        }
        
    }

    public function update(Request $req, $id)
    {
        $data = Berangkat::where('no_sp', $req->uno_sp)->first();
        if ($req->usangu === null) {
            if ($data !== null) {
                if ($data->no_sp === $req->uno_sp && $data->id_keberangkatan === (int) $id) {
                    return $this->saveUpdate($req, $id);
                } elseif ($data->id_keberangkatan !== (int) $id) {
                    return redirect()->back()->with('gagal', 'Nomot Sp Telah Terdaftar');
                } else {
                    return $this->saveUpdate($req, $id);
                }
            } else {
                return $this->saveUpdate($req, $id);
            }
        } else {
            if ($data !== null) {
                if ($data->no_sp === $req->uno_sp && $data->id_keberangkatan === (int) $id) {
                    return $this->usaveUpdate($req, $id);
                } elseif ($data->id_keberangkatan !== (int) $id) {
                    return redirect()->back()->with('gagal', 'Nomot Sp Telah Terdaftar');
                } else {
                    return $this->usaveUpdate($req, $id);
                }
            } else {
                return $this->usaveUpdate($req, $id);
            }
        }
    }

    public function usaveUpdate($req, $id)
    {
        $uharga = explode('Rp. ', $req->uharga);
        $usangu = explode('Rp. ', $req->usangu);
        return Berangkat::where('id_keberangkatan', $id)->update([
            'tanggal_keberangkatan' => tanggal($req->utanggal_berangkat),
            'tipe' => $req->utipe,
            'no_sp' => $req->uno_sp,
            'no_induk' => $req->uno_induk,
            'wilayah' => $req->uwilayah,
            'nama_petani' => $req->unama_petani,
            'nama_sopir' => $req->unama_sopir,
            'pabrik_tujuan' => $req->upabrik_tujuan,
            'sangu' => str_replace('.', '', $usangu[1]),
            'berat_timbang' => $req->uberat_timbang,
            'tara_mbl' => $req->utara_mbl,
            'netto' => $req->unetto,
            'status' => false,
            'harga' => str_replace('.', '', $uharga[1]),
        ])
            ? redirect('/berangkat')->with('sukses', 'sukses update data')
            : redirect()->back()->with('error', 'gagal menambah data');
    }

    public function saveUpdate($req, $id)
    {
        $uharga = explode('Rp. ', $req->uharga);
        $usangu = explode('Rp. ', $req->usangu);
        return Berangkat::where('id_keberangkatan', $id)->update([
            'tanggal_keberangkatan' => tanggal($req->utanggal_berangkat),
            'tipe' => $req->utipe,
            'no_sp' => $req->uno_sp,
            'no_induk' => $req->uno_induk,
            'wilayah' => $req->uwilayah,
            'nama_petani' => $req->unama_petani,
            'nama_sopir' => $req->unama_sopir,
            'pabrik_tujuan' => $req->upabrik_tujuan,
            'sangu' => $req->usangu,
            'berat_timbang' => $req->uberat_timbang,
            'tara_mbl' => $req->utara_mbl,
            'netto' => $req->unetto,
            'status' => false,
            'harga' => str_replace('.', '', $uharga[1]),
        ])
            ? redirect('/berangkat')->with('sukses', 'sukses update data')
            : redirect()->back()->with('error', 'gagal menambah data');
    }

    public function delete($id)
    {
        return Berangkat::where('id_keberangkatan', $id)->delete()
            ? redirect('/berangkat')->with('sukses', 'sukses delete data')
            : redirect()->back()->with('error', 'gagal delete data');
    }

    public function search(Berangkat $berangkat)
    {
        return response()->json([
            'data' => $berangkat
                ->where('no_induk', 'LIKE', '%' . request('s') . '%')
                ->orWhere('wilayah', 'LIKE', '%' . request('s') . '%')
                ->orWhere('pabrik_tujuan', 'LIKE', '%' . request('s') . '%')
                ->get()
        ]);
    }

    public function filter(Request $req, Berangkat $berangkat)
    {
        return response()->json([
            'data' => $berangkat->whereBetween('created_at', [$req->tgl1, $req->tgl2])->get()
        ]);
    }

    public function getUpdate(Berangkat $berangkat, $id)
    {
        return response()->json([
            'data' => $berangkat->where('id_keberangkatan', $id)->first()
        ]);
    }

    public function cetak(Berangkat $berangkat)
    {
        return view('laporan-berangkat', [
            'data' => $berangkat->whereNull('tanggal_pulang')->whereDate('created_at', now())->get()
        ]);
    }
}
