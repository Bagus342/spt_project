@extends('templates.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-1">
                    <div class="col-sm-4">
                        <h1 class="m-0 text-dark" style="font-size: 2.5em">DATA PULANG</h1>
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
                                                <button type="button" id="filter" class="btn btn-primary text-bold"><i class="fas fa-search"></i>&nbsp;Cari</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tabel_pemasukan" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Keberangkatan</th>
                                            <th>Tipe</th>
                                            <th>Nama Pemilik</th>
                                            <th>No Induk</th>
                                            <th>No SP</th>
                                            <th>Pabrik Tujuan</th>
                                            <th>Nama Petani</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-data">
                                        <?php $no = 1; ?>
                                        @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ formatTanggal($item->tanggal_keberangkatan) }}</td>
                                            <td>{{ $item->tipe }}</td>
                                            <td>{{ $item->nama_petani }}</td>
                                            <td>{{ $item->no_induk }}</td>
                                            <td>{{ $item->no_sp === null ? '-' : $item->no_sp }}</td>
                                            <td>{{ $item->pabrik_tujuan }}</td>
                                            <td>{{ $item->nama_sopir }}</td>
                                            <td>
                                                @if ($item->no_sp === null)
                                                <a href="#" class="btn btn-danger text-bold sp" data-target="#modal-sp" data-toggle="modal" data-id="{{ $item->id_keberangkatan }}"><i class="fas fa-mouse-pointer"></i></i>&nbsp;Lengkapi</a>
                                            @else
                                                <a href="#" class="btn btn-primary text-bold update" data-target="#modal-lg" data-toggle="modal" data-id="{{ $item->id_keberangkatan }}"><i class="fas fa-mouse-pointer"></i></i>&nbsp;Pilih</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
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
                                        <input type="text" class="form-control date" placeholder="Tanggal Pulang " value="{{ date('d/m/Y') }}" name="tanggal_pulang" required>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group" id="2">
                                        <label for="exampleInputPassword1">Tanggal Bongkar</label>
                                        <input type="text" class="form-control date" placeholder="Tanggal Bongkar " value="{{ date('d/m/Y') }}" name="tanggal_bongkar" required>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">No Truk</label>
                                        <input type="text" class="form-control" placeholder="No Truk " name="no_truk" required>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Berat Pulang</label>
                                        <input type="number" class="form-control" placeholder="Berat Pulang " name="berat_pulang" required>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Refaksi</label>
                                        <input type="number" class="form-control" placeholder="Refaksi " name="refaksi" required>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Netto</label>
                                        <input type="number" class="form-control" placeholder="Netto " name="netto" readonly required>
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
                {{-- modal update sp --}}
                <div class="modal fade" id="modal-sp">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">UPDATE NOMOR SP</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="" id="form-sp">
                                @csrf
                                @method('put')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Nomor SP</label>
                                        <input type="number" class="form-control" placeholder="Nomor Sp " name="no_sp" required>
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
    <script src="{{ asset('Js/List.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.min.js" integrity="sha512-mBSqtiBr4vcvTb6BCuIAgVx4uF3EVlVvJ2j+Z9USL0VwgL9liZ638rTANn5m1br7iupcjjg/LIl5cCYcNae7Yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('Js/Range.js') }}"></script>
    <script>
        const flash = document.querySelector('#flash-data-success');

const alert = Swal.mixin({
  toast: true,
  position: 'top-end',
  icon: 'success',
  showConfirmButton: false,
  timer: 1500,
});

if (flash.getAttribute('data-flash-success') !== '') {
  alert.fire({
    icon: 'success',
    title: `${flash.getAttribute('data-flash-success')}`,
  });
}

const errorflash = document.querySelector('#flash-data-error');

const alerterror = Swal.mixin({
  toast: true,
  position: 'top-end',
  icon: 'error',
  showConfirmButton: false,
  timer: 1500,
});

if (errorflash.getAttribute('data-flash-error') !== '') {
  alerterror.fire({
    icon: 'error',
    title: `${errorflash.getAttribute('data-flash-error')}`,
  });
}

    </script>
@endsection
