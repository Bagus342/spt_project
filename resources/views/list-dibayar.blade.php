@extends('templates.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-4">
                    <h1 class="m-0 text-dark" style="font-size: 2.5em">DATA PEMBAYARAN</h1>
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
    <form action="/pembayaran/chekout" method="post">
        @csrf
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
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        </div>
                                                        <select class="form-control" name="pilih" id="pilih">
                                                            <option selected value="">Pilih Petani</option>
                                                            @foreach ( $sopir as $i )
                                                            <option value="{{ $i->nama_petani }}">{{ $i->nama_petani }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" id="filter" class="btn btn-primary text-bold"><i class="fas fa-filter"></i>&nbsp;Pilih</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" disabled class="btn btn-primary float-right text-bold" id="bayar"><i class="fas fa-money-bill-wave"></i>&nbsp;Bayar</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tabel_pemasukan" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="check-all" disabled></th>
                                            <th>Tanggal Berangkat</th>
                                            <th>Tanggal Pulang</th>
                                            <th>Tipe</th>
                                            <th>No SP</th>
                                            <th>No Induk</th>
                                            <th>Nama Pemilik</th>
                                            <th>Nama Petani</th>
                                            <th>No Truk</th>
                                            <th>Pabrik Tujuan</th>
                                            <th>Berat Bersih</th>
                                            <th>Harga</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-data">
                                        @if (count($data) === 0)
                                        <td colspan="13" style="text-align: center;">DATA KOSONG</td>
                                        @else
                                        @foreach ($data as $item)
                                        <tr>
                                            <td><input type="checkbox" class="cl" name="id[]" value="{{ $item->id_keberangkatan }}" disabled /></td>
                                            <td>{{ formatTanggal(date('Y-m-d', strtotime($item->tanggal_keberangkatan))) }}</td>
                                            <td>{{ formatTanggal(date('Y-m-d', strtotime($item->tanggal_keberangkatan))) }}</td>
                                            <td>{{ $item->tipe }}</td>
                                            <td>{{ $item->no_sp }}</td>
                                            <td>{{ $item->no_induk }}</td>
                                            <td>{{ $item->nama_petani }}</td>
                                            <td>{{ $item->nama_sopir }}</td>
                                            <td>{{ $item->no_truk }}</td>
                                            <td>{{ $item->pabrik_tujuan }}</td>
                                            <td>{{ $item->netto_pulang }}</td>
                                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td>{{ formatRupiah($item->harga * $item->netto_pulang) }}</td>
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
                <!-- COBA PANGGIL DATA MSQL -->
                <div class="row">
                    <!-- ISI -->
                </div>

            </div>
            <!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </form>
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<script src="{{ asset('Js/CheckedAll.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
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
