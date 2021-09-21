@extends('templates.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-4">
                    <h1 class="m-0 text-dark" style="font-size: 2.5em">DATA USER</h1>
                </div>
                <div class="content-header">
                    <div id="flash-data-success" data-flash-success="{{ session('sukses') }}"></div>
                    <div id="flash-data-error" data-flash-error="{{ session('gagal') }}"></div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <form>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        </div>
                                                        <input type="text" class="form-control float-right" id="search" name="date" placeholder="Nama User" value="">
                                                        <select name="role" id="filter" class="form-control">
                                                            <option value="">pilih</option>
                                                            <option value="1">Admin</option>
                                                            <option value="2">Super Admin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" class="btn btn-primary text-bold"><i class="fas fa-search"></i>&nbsp;Cari</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-6">
                                    @if (session('role') === 2)
                                    <a href="/user/view/add" class="btn btn-success float-right text-bold"><i class="fas fa-plus"></i>&nbsp;Tambah</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- @if (session('gagal') !== null)
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('gagal') }}
                        </div>
                        @endif --}}
                        <div class="table-responsive">
                            <table id="tb" class="table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th>Nama User</th>
                                        <th>Username</th>
                                        <th style="width: 10%">Level</th>
                                        @if (session('role') === 2)
                                        <th style="text-align: center">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="list-data">
                                    @if (count($user) === 0)
                                    <td colspan="6" style="text-align: center">DATA KOSONG</td>
                                    @else
                                    @foreach ($user as $item)
                                    <tr>
                                        <td>{{ $item->nama_user }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->level == 2 ? 'Admin' : 'Petugas' }}</td>
                                        @if (session('role') === 2)
                                        <td style="text-align: center;">
                                            <a href="#" class="btn btn-warning text-bold update" data-target="#modal-edit" data-toggle="modal" data-id="{{ $item->id_user }}"><i class="fas fa-pencil-alt"></i>&nbsp;Ubah</a>
                                            @if (session('user_id') === $item->id_user)
                                            <button disabled="disabled" class="btn btn-danger text-bold"><i class="far fa-trash-alt"></i>&nbsp;Hapus</button>
                                            @else
                                            <a href="/user/{{ $item->id_user }}" class="btn btn-danger text-bold delete"><i class="far fa-trash-alt"></i>&nbsp;Hapus</a>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
</div>
<!-- /.row -->


<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">UBAH DATA USER</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="" id="form-update">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama User</label>
                        <input type="text" class="form-control" placeholder="Nama" name="unama_user" required>
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Username</label>
                        <input type="text" class="form-control" placeholder="Username" name="uusername" required>
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="upassword" required>
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Level</label>
                        <select name="ulevel" class="form-control">
                            <option value="1">Petugas</option>
                            <option value="2">Admin</option>
                        </select>
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.min.js" integrity="sha512-mBSqtiBr4vcvTb6BCuIAgVx4uF3EVlVvJ2j+Z9USL0VwgL9liZ638rTANn5m1br7iupcjjg/LIl5cCYcNae7Yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('Js/User.js') }}"></script>
<script src="{{ asset('Js/Range.js') }}"></script>
<script src="{{ asset('Js/Pagination.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var elements = document.getElementsByTagName("INPUT");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("Kolom Tidak Boleh Kosong !");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
    })
</script>
@endsection