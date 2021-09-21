@extends('templates.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
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
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-money-bill-wave"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pengiriman Hari Ini</span>
                                <span class="info-box-number">
                                    <?php if (count($berangkat) === 0) : ?>
                                        Tidak Ada Pengiriman
                                    <?php else : ?>
                                        <?php $no = 0; ?>
                                        @foreach($berangkat as $data)
                                        <?php $no++ ?>
                                        @endforeach
                                        {{ $no }}
                                    <?php endif ?>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
                            <div class="info-box-content">

                                <span class="info-box-text">Kepulangan Hari Ini</span>
                                <span class="info-box-number">
                                    <?php if (count($pulang) === 0) : ?>
                                        Tidak Ada Kepulangan
                                    <?php else : ?>
                                        <?php $no = 0; ?>
                                        @foreach($pulang as $data)
                                        <?php $no++ ?>
                                        @endforeach
                                        {{ $no }}
                                    <?php endif ?>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <a href="">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-check-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pembayaran Hari Ini</span>
                                <span class="info-box-number">
                                    <?php if (count($saldo) === 0) : ?>
                                        Tidak Ada Pembayaran
                                    <?php else : ?>
                                        <?php $no = 0; ?>
                                        @foreach($saldo as $data)
                                        <?php $no += $data->harga * ($data->berat_pulang - $data->refaksi); ?>
                                        @foreach($kondisi as $item)
                                        @if($data->id_keberangkatan === $item->id_keberangkatan)
                                        <?php $no += $data->harga * ($item->berat_pulang - $item->refaksi) ?>
                                        @endif
                                        @endforeach
                                        @endforeach
                                        {{ formatRupiah($no) }}
                                    <?php endif ?>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
@endsection