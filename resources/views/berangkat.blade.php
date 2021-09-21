@extends('templates.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tambah Data Berangkat</h1>
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
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Isi Form Data Berangkat</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="/spt-project/berangkat" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tanggal Berangkat</label>
                                    <input type="date" class="form-control" placeholder="Tanggal Berangkat " name="tanggal_berangkat" required>
                                    <span class="text-dark"></span>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Tipe</label>
                                    </div>
                                    <select name="tipe" class="custom-select" id="tipe">
                                        <option selected>Choose...</option>
                                        <option value="SPT">SPT</option>
                                        <option value="AMPERA">AMPERA</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">No SP</label>
                                    <input type="text" class="form-control" placeholder="No SP " name="no_sp" required>
                                    <span class="text-dark"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">No Induk</label>
                                    <input type="text" class="form-control" placeholder="No Induk " name="no_induk" required>
                                    <span class="text-dark"></span>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Wilayah</label>
                                            </div>
                                            <select name="wilayah" class="custom-select" id="wilayah">
                                                <option selected>Choose...</option>
                                                @foreach ($wilayah as $item)
                                                <option value="{{ $item->nama_wilayah }}">{{ $item->nama_wilayah }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Nama
                                                    Petani</label>
                                            </div>
                                            <select name="nama_petani" class="custom-select" id="nama_petani">
                                                <option selected>Choose...</option>
                                                @foreach ($petani as $item)
                                                <option value="{{ $item->nama_petani }}">{{ $item->nama_petani }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Nama
                                                    Sopir</label>
                                            </div>
                                            <select name="nama_sopir" class="custom-select" id="nama_sopir">
                                                <option selected>Choose...</option>
                                                @foreach ($sopir as $item)
                                                <option value="{{ $item->nama_sopir }}">{{ $item->nama_sopir }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Nama
                                                    Pabrik</label>
                                            </div>
                                            <select name="nama_pabrik" class="custom-select" id="nama_pabrik">
                                                <option selected>Choose...</option>
                                                @foreach ($pg as $item)
                                                <option value="{{ $item->nama_pg }}">{{ $item->nama_pg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPassword1">Sangu</label>
                                    <input type="text" class="form-control" placeholder="Sangu " name="sangu" required>
                                    <span class="text-dark"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Berat Timbang</label>
                                    <input type="text" class="form-control" placeholder="Berat Timbang " name="berat_timbang" required>
                                    <span class="text-dark"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tara MBL</label>
                                    <input type="text" class="form-control" placeholder="Tara MBL " name="tara_mbl" required>
                                    <span class="text-dark"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Netto</label>
                                    <input type="text" class="form-control" placeholder="Netto " name="netto" required>
                                    <span class="text-dark"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Harga</label>
                                    <input type="text" class="form-control" placeholder="Harga " name="harga" required>
                                    <span class="text-dark"></span>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">SIMPAN</button>
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
@endsection
