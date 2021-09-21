<?php $no = 1 ?>
<?php $kw = 0 ?>
@extends('templates.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-4">
                    <h1 class="m-0 text-dark" style="font-size: 2.5em">DATA KEPULANGAN</h1>
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
                                            <form>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        </div>
                                                        <input type="text" class="form-control float-right" id="date-range" name="tanggal" value="<?= date('01-m-Y') ?> / <?= date('d-m-Y') ?>">
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" id='filter' class="btn btn-primary text-bold"><i class="fas fa-filter"></i>&nbsp;Cari</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <a href="/pulang/view/cetak" class="btn btn-primary float-right text-bold ml-1"><i class="fas fa-print"></i>&nbsp;Cetak Laporan</a>
                                    <a href="/pulang/view/list" class="btn btn-success float-right text-bold"><i class="fas fa-plus"></i>&nbsp;Tambah</a>
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
                                            <th>Tanggal Pulang</th>
                                            <th>No SP</th>
                                            <th>No Truck</th>
                                            <th>Pabrik</th>
                                            <th>Petani</th>
                                            <th>Wilayah</th>
                                            <th>Berat bersih</th>
                                            <th style="text-align: center;">action</th>
                                        </tr>
                                    </thead>
                                    <tbody id='list-data'>
                                        @if (count($data) === 0)
                                        <td colspan="11" style="text-align: center;">DATA KOSONG</td>
                                        @else

                                        @foreach ($data as $item)
                                        <?php $kw += $item->berat_pulang - $item->refaksi ?>
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ formatTanggal($item->tanggal_pulang) }}</td>
                                            <td>{{ $item->no_sp }}</td>
                                            <td>{{ $item->no_truk }}</td>
                                            <td>{{ $item->pabrik_tujuan }}</td>
                                            <td>{{ $item->nama_sopir }}</td>
                                            <td>{{ $item->wilayah }}</td>
                                            <td>{{ $item->berat_pulang - $item->refaksi }}</td>
                                            <td style="text-align: center;">
                                                @if ($item->status)
                                                <button type="button" class="btn btn-primary text-bold detail" id="detail" data-target="#modal-lg-2" data-toggle="modal" data-id="{{ $item->id_keberangkatan }}"><i class="fas fa-info-circle"></i>&nbsp;Detail</button>
                                                <button type="button" disabled class="btn btn-secondary text-bold update" data-target="#modal-lg" data-toggle="modal" data-id="{{ $item->id_keberangkatan }}"><i class="fas fa-pencil-alt"></i>&nbsp;Ubah</button>
                                                <button disabled="disabled" class="btn btn-secondary text-bold"><i class="far fa-trash-alt"></i>&nbsp;Hapus</button>
                                                @else
                                                <button type="button" class="btn btn-primary text-bold detail" id="detail" data-target="#modal-lg-2" data-toggle="modal" data-id="{{ $item->id_keberangkatan }}"><i class="fas fa-info-circle"></i>&nbsp;Detail</button>
                                                <button type="button" class="btn btn-warning text-bold update" data-target="#modal-lg" data-toggle="modal" data-id="{{ $item->id_keberangkatan }}"><i class="fas fa-pencil-alt"></i>&nbsp;Ubah</button>
                                                <a href="/pulang/{{ $item->id_keberangkatan }}" class="btn btn-danger text-bold delete"><i class="far fa-trash-alt"></i>&nbsp;Hapus</a>
                                                @endif

                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                </table>
                            </div>

                            <div class="total mt-3">
                                <table id="total" class="table table-bordered" style="width: 100%;">
                                    <tr>
                                        <th>Total berat bersih</th>
                                        <th style="text-align: right; width: 75%;"><?= $kw ?> KW</th>
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

<!-- Modal -->
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">UPDATE DATA KEPULANGAN</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="" id="form-update">
                @csrf
                @method('put')
                <div class="modal-body">
                    <div class="form-group" id="1">
                        <label for="exampleInputPassword1">Tanggal Pulang</label>
                        <input type="text" class="form-control" placeholder="Tanggal Pulang " name="tanggal_pulang">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group" id="2">
                        <label for="exampleInputPassword1">Tanggal Bongkar</label>
                        <input type="text" class="form-control" placeholder="Tanggal Bongkar " name="tanggal_bongkar">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">No Truk</label>
                        <input type="text" class="form-control" placeholder="No Truk " name="no_truk">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Berat Pulang</label>
                        <input type="number" class="form-control" placeholder="Berat Pulang " name="berat_pulang">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Refaksi</label>
                        <input type="number" class="form-control" placeholder="Refaksi " name="refaksi">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Berat Bersih</label>
                        <input type="number" class="form-control" placeholder="Berat Bersih" name="berat_bersih" readonly>
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-lg-2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">DETAIL DATA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <table id="tabel_detail" class="table table-borderless mt-3" style=" display: flex; flex-direction: row; justify-content: space-evenly;">
                <thead>
                    <tr class="col-sm" style="display: flex; flex-direction: column;">
                        <th>Tanggal Keberangkatan</th>
                        <th>Tanggal Bongkar</th>
                        <th>No Sp</th>
                        <th>Nama Pemilik</th>
                        <th>Tujuan</th>
                        <th>No Truk</th>
                        <th>Berat Timbang</th>
                        <th>Netto</th>
                        <th>Berat Pulang</th>
                        <th>Berat Bersih</th>
                    </tr>
                </thead>
                <tr class="col-sm" style="display: flex; flex-direction: column;">
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                </tr>
                <tbody id="detail1">
                    <tr class="col-sm" style="display: flex; flex-direction: column;">
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                    </tr>
                </tbody>
                <thead>
                    <tr class="col-sm" style="display: flex; flex-direction: column;">
                        <th>Tanggal Kepulangan</th>
                        <th>Tipe</th>
                        <th>No Induk</th>
                        <th>Nama Petani</th>
                        <th>Wilayah</th>
                        <th>Sangu</th>
                        <th>Tara</th>
                        <th>Harga</th>
                        <th>Refaksi</th>
                    </tr>
                </thead>
                <tr class="col-sm" style="display: flex; flex-direction: column;">
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                    <td>:</td>
                </tr>
                <tbody id="detail2">
                    <tr class="col-sm" style="display: flex; flex-direction: column;">
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>
                        <td>dummy</td>

                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /Modal -->

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.min.js" integrity="sha512-mBSqtiBr4vcvTb6BCuIAgVx4uF3EVlVvJ2j+Z9USL0VwgL9liZ638rTANn5m1br7iupcjjg/LIl5cCYcNae7Yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('Js/GlobalPulang.js') }}"></script>
<script src="{{ asset('Js/Range.js') }}"></script>
<script src="{{ asset('Js/Pagination.js') }}"></script>
<script>
    $('#1').datepicker({
        inputs: $('input[name=tanggal_pulang]'),
        format: 'dd/mm/yyyy'
    })
    $('#2').datepicker({
        inputs: $('input[name=utanggal_bongkar]'),
        format: 'dd/mm/yyyy'
    })
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