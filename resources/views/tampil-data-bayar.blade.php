<?php $total = 0; ?>
@extends('templates.template')
@section('css-list')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection
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
                                                    <input type="text" class="form-control float-right" id="date-range" name="date" value="<?= date('01-m-Y') ?> / <?= date('d-m-Y') ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" id='filter' onClick="filter()" class="btn btn-primary text-bold"><i class="fas fa-filter"></i>&nbsp;Cari</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <a href="/pembayaran/view/list" class="btn btn-success float-right text-bold">Tambah
                                        &nbsp;<i class="fas fa-plus"></i> </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tb" class="table table-bordered table-striped ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Invoice</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Nama Petani</th>
                                            <th>No SP</th>
                                            <th>Sub Total</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id='list-data'>
                                        <?php if (count($list) === 0) : ?>
                                            <td colspan="11" style="text-align: center;">DATA KOSONG</td>
                                        <?php else : ?>
                                            @foreach ($list as $item)
                                            @php
                                                $total += $item['subtotal']
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item['invoice'] }}</td>
                                                <td>{{ formatTanggal($item['tgl']) }}</td>
                                                <td>{{ $item['petani'] }}</td>
                                                <td>{{ $item['list_sp'] }}</td>
                                                <td>{{ formatRupiah($item['subtotal'])}}</td>
                                                <td style="text-align: center;">
                                                    <button type="button" class="btn btn-primary text-bold detail" id="detail" data-target="#exampleModal" data-toggle="modal" data-id="{{ $item['invoice'] }}"><i class="fas fa-info-circle"></i>&nbsp;Detail</button>
                                                    <a href="/pembayaran/{{ str_replace('/', '-', $item['invoice']) }}" class="btn btn-danger text-bold delete"><i class="far fa-trash-alt"></i>&nbsp;Hapus</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tota mt-3">
                                <table id="total" class="table table-bordered" style="width: 100%;">
                                    <tr>
                                        <th>Total</th>
                                        <th style="text-align: right;">{{formatRupiah($total)}}</th>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>
</div>


{{-- modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-responsive-xl">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Berangkat</th>
                            <th>Tanggal Pulang</th>
                            <th>No Sp</th>
                            <th>No Truk</th>
                            <th>Pabrik</th>
                            <th>Berat Bersih</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-detail">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-responsive-xl">
                    <tbody id="t">
                        <tr>
                            <td>Subtotal Invoice</td>
                            <td>Rp</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
{{-- /modal --}}


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.min.js" integrity="sha512-mBSqtiBr4vcvTb6BCuIAgVx4uF3EVlVvJ2j+Z9USL0VwgL9liZ638rTANn5m1br7iupcjjg/LIl5cCYcNae7Yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('Js/Pagination.js') }}"></script>
<script src="{{ asset('Js/Pembayaran.js') }}"></script>
<script src="{{ asset('Js/Range.js') }}"></script>
{{-- <script src="{{ asset('Js/Pagination.js') }}"></script> --}}

@endsection
{{-- <!-- <a href="/pembayaran/{{ $item->id_pembayaran }}" class="btn btn-danger text-bold"><i class="far fa-trash-alt"></i>&nbsp;Hapus</a> --> --}}