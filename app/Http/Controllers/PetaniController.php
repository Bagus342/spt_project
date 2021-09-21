<?php

namespace App\Http\Controllers;

use App\Models\Petani;
use App\Models\Pg;
use Illuminate\Http\Request;

class PetaniController extends Controller
{
    // CRUD ya Guys

    /**
     * @return View
     */
    public function index()
    {
        return view('tampil-data-petani', [
            'petani' => Petani::get(),
            'pabrik' => Pg::select('nama_pg')->get(),
            'title' => 'Pemilik'
        ]);
    }

    /**
     * @param Request this param is requested form user
     * @return Redirect this return is redirect type
     */
    public function add(Request $req)
    {
        return Petani::insert([
            'nama_pemilik' => $req->nama_petani,
            'register_pemilik' => $req->register_petani,
            'nama_pabrik' => $req->nama_pabrik,
        ])
            ? redirect('/pemilik')->with('sukses', 'data berhasil di tambah')
            : redirect()->back()->with('error', 'data gagal di tambah');
    }

    /**
     * @param Request this param is requested form user
     * @return Redirect this return is redirect type
     */
    public function update(Request $req, $id)
    {
        return Petani::where('id_pemilik', $id)->update([
            'nama_pemilik' => $req->nama_petani,
            'register_pemilik' => $req->register_petani,
            'nama_pabrik' => $req->nama_pabrik,
        ])
            ? redirect('/pemilik')->with('sukses', 'data berhasil di update')
            : redirect()->back()->with('error', 'data gagal di update');
    }

    /**
     * @param id this param is requested form user
     * @return Redirect this return is redirect type
     */
    public function delete($id)
    {
        return Petani::where('id_pemilik', $id)->delete()
            ? redirect('/pemilik')->with('sukses', 'data berhasil di delete')
            : redirect()->back()->with('error', 'data gagal di delete');
    }

    /**
     * @param Request this param is requested form user
     * @return JSON this return is JSON type
     */
    public function getUpdate($id)
    {
        return response()->json([
            'data_update' => Petani::where('id_pemilik', $id)->first()
        ]);
    }

    /**
     * @return View
     */
    public function viewAdd()
    {
        return view('petani', [
            'pabrik' => Pg::select('nama_pg')->get(),
            'title' => 'Tambah | Pemilik'
        ]);
    }

    /**
     * @param Query parameters
     * @return String this return string html
     */
    public function search()
    {
        $param = '%' . request('name') . '%';
        $data = Petani::where('nama_pemilik', 'LIKE', $param)
            ->orWhere('register_pemilik', 'LIKE', $param)
            ->orWhere('nama_pabrik', 'LIKE', $param)
            ->get();
        return response()->json(['data' => $data]);
    }

    public function getRegister($id)
    {
        return response()->json([
            'data' => Petani::select('register_pemilik', 'id_pemilik')->where('nama_pemilik', $id)->get()
        ]);
    }

    public function updateInduk($id, $induk)
    {
        return response()->json([
            'data' => Petani::where('id_pemilik', $id)->update([
                'register_pemilik' => $induk
            ]) ? 'sukses' : 'gagal'
        ]);
    }
}
