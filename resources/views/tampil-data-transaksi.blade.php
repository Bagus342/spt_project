@extends('templates.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-1">
                    <div class="col-sm-4">
                        <h1 class="m-0 text-dark" style="font-size: 2.5em">DATA TRANSAKSI</h1>
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
                                <form action="/transaksi/berangkat/cetak" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-9">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            </div>
                                                            <select class="form-control" id="pabrik" name="pabrik">
                                                                <option value="" default>Pabrik Tujuan</option>
                                                                @foreach ($pg as $i)
                                                                    <option value="{{ $i->nama_pg }}">{{ $i->nama_pg }}</option>
                                                                @endforeach
                                                            </select>
                                                            <select class="form-control" id="type" name="tipe">
                                                                <option default value="">Tipe</option>
                                                                <option value="SPT">SPT</option>
                                                                <option value="AMPERAN">AMPERAN</option>
                                                            </select>
                                                            <input type="text" class="form-control float-right" id="date-range" name="tanggal" value="<?= date('01-m-Y') ?> / <?= date('d-m-Y') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <button type="button" id="filter" class="btn btn-primary text-bold"><i class="fas fa-filter"></i>&nbsp;Cari</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary float-right text-bold"><i class="fas fa-print"></i>&nbsp;Cetak Laporan </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tb" class="table table-bordered table-striped " style="white-space: nowrap;">
                                        <thead>
                                            <tr style="text-align: center">
                                                <th>No</th>
                                                <th>Tanggal Berangkat</th>
                                                <th>Tanggal Pulang</th>
                                                <th>Tgl Bongkar</th>
                                                <th>Tipe</th>
                                                <th>Pemilik</th>
                                                <th>Petani</th>
                                                <th>No SP</th>
                                                <th>No Truk</th>
                                                <th>Pabrik Tujuan</th>
                                                <th>Wilayah</th>
                                                <th>Berat Pulang</th>
                                                <th>Rafaksi</th>
                                                <th>Berat Bersih</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                                <th>Sangu</th>
                                                <th>Berat Timbang</th>
                                                <th>Tara mobil</th>
                                                <th>Netto   </th>
                                            </tr>
                                        </thead>
                                        <tbody id='list-data' style="text-align: center">
                                            <?php $no = 1; ?>
                                            <?php $c = 0; ?>
                                            @foreach ($list as $item)
                                                <tr>
                                                    <?php $c += $item->harga * ($item->berat_pulang - $item->refaksi); ?>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ formatTanggal($item->tanggal_keberangkatan) }}</td>
                                                    <td>{{ $item->tanggal_pulang === null ? 'belum pulang' : formatTanggal($item->tanggal_pulang) }}</td>
                                                    <td>{{ formatTanggal($item->tanggal_bongkar) }}</td>
                                                    <td>{{ $item->tipe }}</td>
                                                    <td>{{ $item->nama_petani }}</td>
                                                    <td>{{ $item->nama_sopir }}</td>
                                                    <td>{{ $item->no_sp }}</td>
                                                    <td>{{ $item->no_truk === null ? 'belum pulang' : $item->no_truk }}</td>
                                                    <td>{{ $item->pabrik_tujuan }}</td>
                                                    <td>{{ $item->wilayah }}</td>
                                                    <td>{{ $item->berat_pulang }}</td>
                                                    <td>{{ $item->refaksi }}</td>
                                                    <td>{{ $item->berat_pulang - $item->refaksi }}</td>
                                                    <td>{{ formatRupiah($item->harga) }}</td>
                                                    <td>{{ formatRupiah($item->harga * ($item->berat_pulang - $item->refaksi)) }}</td>
                                                    <td>{{ $item->tipe === 'SPT' ? '-' : formatRupiah($item->sangu) }}</td>
                                                    <td>{{ $item->tipe === 'SPT' ? '-' : $item->berat_timbang }}</td>
                                                    <td>{{ $item->tipe === 'SPT' ? '-' : $item->tara_mbl }}</td>
                                                    <td>{{ $item->tipe === 'SPT' ? '-' : $item->berat_timbang - $item->tara_mbl }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </table>


                                </div>
                                <div class="tota mt-3">
                                    <table id="total" class="table table-bordered" style="width: 100%;">
                                        <tr>
                                            <th>Total</th>
                                            <th style="text-align: right;">{{ formatRupiah($c) }}</th>
                                        </tr>
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
            <script src="{{ asset('Js/LaporanTransaksi.js') }}"></script>
            <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
            <script src="{{ asset('Js/Range.js') }}"></script>
            <script src="{{ asset('Js/Pagination.js') }}"></script>
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
