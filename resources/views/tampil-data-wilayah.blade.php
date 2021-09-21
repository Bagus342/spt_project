@extends('templates.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-4">
                    <h1 class="m-0 text-dark" style="font-size: 2.5em">DATA WILAYAH</h1>
                </div>
                <div class="content-header">
                    <div id="flash-data-success" data-flash-success="{{ session('sukses') }}"></div>
                    <div id="flash-data-error" data-flash-error="{{ session('error') }}"></div>
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
                                            <form action="" method="POST">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        </div>
                                                        <input type="text" class="form-control float-right" id="search" name="date" value="">
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
                                    <a href="/wilayah/view/add" class="btn btn-success float-right text-bold"><i class="fas fa-plus"></i>&nbsp;Tambah</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tb" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Wilayah</th>
                                        <th>Harga Wilayah</th>
                                        @if (session('role') === 2)
                                        <th style="text-align: center;">Action</th>
                                        @endif
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody id="list-data">
                                    @if (count($wilayah) === 0)
                                    <td colspan="5" style="text-align: center;">DATA KOSONG</td>
                                    @else
                                    <?php $no = 1; ?>
                                    @foreach ($wilayah as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama_wilayah }}</td>
                                        <td>Rp {{ number_format($item->harga_wilayah, 0, ',', '.') }}</td>
                                        {{-- <td>{{ formatTanggal(date('Y-m-d', strtotime($item->created_at))) }}</td> --}}
                                        @if (session('role') === 2)
                                        <td style="text-align: center;">
                                            <a href="#" class="btn btn-warning text-bold update" data-target="#modal-lg" data-toggle="modal" data-id="{{ $item->id_wilayah }}"><i class="fas fa-pencil-alt"></i>&nbsp;Ubah</a>
                                            <a href="/wilayah/{{ $item->id_wilayah }}" class="btn btn-danger text-bold delete"><i class="far fa-trash-alt"></i>&nbsp;Hapus</a>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->

            <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">UBAH DATA WILAYAH</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="" id="form-update">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Wilayah</label>
                                    <input type="text" class="form-control" placeholder="Nama " name="nama_wilayah" required>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="form-group">

                                    <label for="exampleInputPassword1">Harga Wilayah</label>
                                    <div class="input-group-prepend">
                                        <input type="text" class="form-control harga" onkeypress="return isNumber(event)" value="Rp. " placeholder="Harga " name="harga_wilayah" required>
                                    </div>

                                    <span class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <!-- COBA PANGGIL DATA MSQL -->
            <div class="row">
                <!-- ISI -->
            </div>

        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.min.js" integrity="sha512-mBSqtiBr4vcvTb6BCuIAgVx4uF3EVlVvJ2j+Z9USL0VwgL9liZ638rTANn5m1br7iupcjjg/LIl5cCYcNae7Yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('Js/Wilayah.js') }}"></script>
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