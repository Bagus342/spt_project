@extends('templates.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-1">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark" style="font-size: 2.5em">DATA LAPORAN PEMBAYARAN</h1>
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
                                            <div class="col-7">
                                                <form>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            </div>
                                                            <select class="form-control" id="type" name="utipe">
                                                                <option default value="">Tipe</option>
                                                                <option value="SPT">SPT</option>
                                                                <option value="AMPERAN">AMPERAN</option>
                                                            </select>
                                                            <input type="text" class="form-control float-right" id="date-range" name="date" value="<?= date('01-m-Y') ?> / <?= date('d-m-Y') ?>">
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" id="filter" class="btn btn-primary text-bold"><i class="fas fa-filter"></i>&nbsp;Cari</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tabel_pemasukan" class="table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Invoice</th>
                                                <th>Tanggal Pembayaran</th>
                                                <th>Nama Petani</th>
                                                <th>No SP</th>
                                                <th style="text-align: center;">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody id='list-data'>
                                            <?php if (count($list) === 0): ?>
                                            <td colspan="11" style="text-align: center;">DATA KOSONG</td>
                                            <?php else: ?>
                                            <?php $no = 1; ?>
                                            @foreach ($list as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item['invoice'] }}</td>
                                                    <td>{{ formatTanggal($item['tgl']) }}</td>
                                                    <td>{{ $item['petani'] }}</td>
                                                    <td>{{ $item['list_sp'] }}</td>
                                                    <td style="text-align: center;">
                                                        <a href="/pembayaran/{{ str_replace('/', '-', $item['invoice']) }}" class="btn btn-danger text-bold delete"><i class="far fa-trash-alt"></i>&nbsp;Hapus</a>
                                                        &nbsp;&nbsp;
                                                        <a href="/transaksi/pembayaran/cetak?inv={{ $item['invoice'] }}" class="btn btn-success text-bold"><i class="fas fa-print"></i>&nbsp;Cetak</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
                <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
                <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
                <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.min.js" integrity="sha512-mBSqtiBr4vcvTb6BCuIAgVx4uF3EVlVvJ2j+Z9USL0VwgL9liZ638rTANn5m1br7iupcjjg/LIl5cCYcNae7Yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="{{ asset('Js/LaporanPembayaran.js') }}"></script>
                <script>
                    $('#date-range').daterangepicker({
                        locale: {
                            format: 'DD-MM-YYYY',
                            separator: " / "
                        }
                    });
                </script>
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
