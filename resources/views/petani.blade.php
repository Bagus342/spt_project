@extends('templates.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Tambah Data Pemilik</h1>
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
                        <!-- general form elements -->
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Isi Form Data Pemilik</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="/pemilik" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Nama Pemilik</label>
                                        <input type="text" class="form-control" placeholder="Nama " name="nama_petani" required>
                                        <span class="text-secondary"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Nomor Induk</label>
                                        <input type="text" class="form-control" placeholder="Nomor Induk  " name="register_petani" required>
                                        <span class="text-secondary"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="pabriktujuan">Nama Pabrik</label>
                                        <select class="form-control" id="pabriktujuan" name="nama_pabrik" required>
                                            <option value="">Pilih</option>
                                            @foreach ($pabrik as $item)
                                                <option value="{{ $item->nama_pg }}">{{ $item->nama_pg }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <label for="exampleInputPassword1">Nama Pabrik</label> --}}
                                        {{-- <input type="text" class="form-control" placeholder="Nama Pabrik " name="nama_pabrik" required> --}}
                                        <span class="text-secondary"></span>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="/pemilik" class="btn btn-danger">Batal</a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->

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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    var elements = document.getElementsByTagName("INPUT");
    var element = document.getElementsByTagName("SELECT");
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
    for (var i = 0; i < element.length; i++) {
        element[i].oninvalid = function(e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity("List Harap dipilih !");
            }
        };
        element[i].oninput = function(e) {
            e.target.setCustomValidity("");
        };
    }
})
    </script>
@endsection
