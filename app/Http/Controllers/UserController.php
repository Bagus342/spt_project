<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Index()
    {
        return view('login');
    }


    public function viewIndex()
    {
        return view('tampil-data-user', [
            'user' => User::get(),
            'title' => 'User'
        ]);
    }

    public function add(Request $req)
    {
        if (User::where('username', $req->username)->first() === null) {
            if (User::insert([
                'nama_user' => $req->nama_user,
                'username' => $req->username,
                'pass_user' => bcrypt($req->password),
                'text' => $req->password,
                'level' => $req->level
            ])) {
                return redirect('/user')->with('sukses', 'data berhasil di tambah');
            } else {
                return redirect()->back()->with('gagal', 'username telas terdaftar');
            }
        } else {
            return redirect()->back()->with('gagal', 'username telas terdaftar');
        }
    }
    public function update(Request $req, $id)
    {
        $data = User::where('username', $req->uusername)->first();
        if ($data !== null) {
            if ($data->username === $req->uusername && $data->id_user === (int) $id) {
                return $this->saveUpdate($req, $id);
            } elseif ($data->id_user !== (int) $id) {
                return redirect()->back()->with('gagal', 'username telah dipakai');
            } else {
                return $this->saveUpdate($req, $id);
            }
        } else {
            return $this->saveUpdate($req, $id);
        }
    }

    public function saveUpdate($req, $id)
    {
        return User::where('id_user', $id)->update([
            'nama_user' => $req->unama_user,
            'username' => $req->uusername,
            'pass_user' => bcrypt($req->upassword),
            'text' => $req->upassword,
            'level' => $req->ulevel
        ])
            ? redirect('/user')->with('sukses', 'data berhasil di update')
            : redirect()->back()->with('error', 'data gagal di update');
    }

    public function delete($id)
    {
        return User::where('id_user', $id)->delete()
            ? redirect('/user')->with('sukses', 'data berhasil di delete')
            : redirect()->back()->with('error', 'data gagal di delete');
    }
    public function search()
    {
        $param = '%' . request('name') . '%';
        $data = User::where('nama_user', 'LIKE', $param)
            ->orWhere('username', 'LIKE', $param)
            ->orWhere('level', 'LIKE', $param)
            ->get();
        return response()->json(['data' => $data]);
    }
    public function viewAdd()
    {
        return view('user', [
            'title' => 'Tambah | User'
        ]);
    }
    public function getUpdate($id)
    {
        $data = User::where('id_user', $id)->first();
        return response()->json([
            'data_update' => [
                'nama_user' => $data->nama_user,
                'username' => $data->username,
                'level' => $data->level,
                'plain_text' => $data->text
            ]
        ]);
    }
}
