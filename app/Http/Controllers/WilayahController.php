<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    // CRUD Wilayah ya Guys

    public function index()
    {
        return view('tampil-data-wilayah', [
            'wilayah' => Wilayah::get(),
            'title' => 'Wilayah'
        ]);
    }

    public function add(Request $req)
    {
        if (Wilayah::where('nama_wilayah', $req->nama_wilayah)->first() === null) {
            $trimHarga = explode(' ', $req->harga_wilayah);
            if (count($trimHarga) > 1) {
                return Wilayah::insert([
                    'nama_wilayah' => $req->nama_wilayah,
                    'harga_wilayah' => str_replace('.', '', $trimHarga[1]),
            ])
                ? redirect('/wilayah')->with('sukses', 'data berhasil di tambah')
                : redirect()->back()->with('error', 'data gagal di tambah');
            } else {
                return redirect()->back()->with('error', 'data harga belum diisi');
            }
        }
        else {
            return redirect()->back()->with('error', 'Nama Wilayah Sudah Terdaftar');
        }
    }

    public function update(Request $req, $id)
    {
        $data = Wilayah::where('nama_wilayah', $req->nama_wilayah)->first();
        if ($data !== null) {
            if ($data->nama_wilayah === $req->nama_wilayah && $data->id_wilayah === (int) $id) {
                return $this->saveUpdate($req, $id);
            } elseif ($data->id_wilayah !== (int) $id) {
                return redirect()->back()->with('error', 'Nama Wilayah Telah dipakai');
            } else {
                return $this->saveUpdate($req, $id);
            }
        } else {
            return $this->saveUpdate($req, $id);
        }
    }

    public function saveUpdate($req, $id)
    {
        $trimHarga = explode(' ', $req->harga_wilayah);
        return Wilayah::where('id_wilayah', $id)->update([
            'nama_wilayah' => $req->nama_wilayah,
            'harga_wilayah' => str_replace('.', '', $trimHarga[1]),
        ])
            ? redirect('/wilayah')->with('sukses', 'data berhasil di update')
            : redirect()->back()->with('error', 'data gagal di update');
    }

    public function delete($id)
    {
        return Wilayah::where('id_wilayah', $id)->delete()
            ? redirect('/wilayah')->with('sukses', 'data berhasil di delete')
            : redirect()->back()->with('error', 'data gagal di delete');
    }

    public function getUpdate($id)
    {
        return response()->json([
            'data_update' => Wilayah::where('id_wilayah', $id)->first(),
        ]);
    }

    public function getHarga($id)
    {
        return response()->json([
            'data' => Wilayah::select('id_wilayah', 'harga_wilayah')->where('nama_wilayah', $id)->get()
        ]);
    }

    public function search()
    {
        $trim = explode(' ', request('name'));
        if (count($trim) === 2) {
            $param = '%' . $trim[1] . '%';
            $data = Wilayah::where('harga_wilayah', 'LIKE', $param)->get();
            return response()->json(['data' => $data]);
        } else {
            $param = '%' . request('name') . '%';
            $data = Wilayah::where('nama_wilayah', 'LIKE', $param)->get();
            return response()->json(['data' => $data]);
        }
    }

    public function updateHarga($id, $harga)
    {
        $h = explode('Rp. ', $harga);
        return response()->json([
            'status' => Wilayah::where('id_wilayah', $id)->update([
                'harga_wilayah' => str_replace('.', '', $h[1])
            ]) ? 'sukses' : 'gagal'
        ]);
    }

    public function viewAdd()
    {
        return view('wilayah', [
            'title' => 'Tambah | Wilayah'
        ]);
    }
}
