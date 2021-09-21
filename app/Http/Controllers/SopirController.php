<?php

namespace App\Http\Controllers;

use App\Models\Sopir;
use Illuminate\Http\Request;

class SopirController extends Controller
{
    // CRUD Sopir ya Guys

    public function index()
    {
        return view('tampil-data-sopir', [
            'sopir' => Sopir::get(),
            'title' => 'Petani'
        ]);
    }

    public function add(Request $req)
    {
        return Sopir::insert([
            'nama_petani' => $req->nama_sopir,
            'nohp_petani' => $req->nohp_sopir,
            'alamat_petani' => $req->alamat_sopir,
        ])
            ? redirect('/petani')->with('sukses', 'data berhasil di tambah')
            : redirect()->back()->with('error', 'data gagal di tambah');
    }

    public function update(Request $req, $id)
    {
        return Sopir::where('id_petani', $id)->update([
            'nama_petani' => $req->nama_sopir,
            'nohp_petani' => $req->nohp_sopir,
            'alamat_petani' => $req->alamat_sopir,
        ])
            ? redirect('/petani')->with('sukses', 'data berhasil di update')
            : redirect()->back()->with('error', 'data gagal di update');
    }

    public function delete($id)
    {
        return Sopir::where('id_petani', $id)->delete()
            ? redirect('/petani')->with('sukses', 'data berhasil di delete')
            : redirect()->back()->with('error', 'data gagal di delete');
    }

    public function search()
    {
        $param = '%' . request('name') . '%';
        $data = Sopir::where('nama_petani', 'LIKE', $param)
            ->orWhere('nohp_petani', 'LIKE', $param)
            ->orWhere('alamat_petani', 'LIKE', $param)
            ->get();
        return response()->json(['data' => $data]);
    }

    public function getUpdate($id)
    {
        return response()->json([
            'data_update' => Sopir::where('id_petani', $id)->first(),
        ]);
    }

    public function viewAdd()
    {
        return view('sopir', [
            'title' => 'Tambah | Petani'
        ]);
    }
}
