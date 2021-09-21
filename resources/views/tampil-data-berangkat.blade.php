@extends('templates.template')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-4">
                    <h1 class="m-0 text-dark" style="font-size: 2.5em">DATA KEBERANGKATAN</h1>
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
                                    <a href="berangkat/view/cetak" class="btn btn-primary float-right text-bold ml-1"><i class="fas fa-print"></i>&nbsp;Cetak Laporan</a>
                                    <a href="#" class="btn btn-success float-right text-bold" data-target="#modal-lg-tambah" id='tbh' data-toggle="modal"><i class="fas fa-plus"></i>&nbsp;Tambah</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if (session('sukses') !== null) : ?>
                            <?php endif; ?>
                            <div class="table-responsive">
                                <table id="tb" class="table table-bordered table-striped ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Berangkat</th>
                                            <th>No SP</th>
                                            <th>Nama Pemilik</th>
                                            <th>Nama Petani</th>
                                            <th>Pabrik Tujuan</th>
                                            <th>No Induk</th>
                                            <th>Wilayah</th>
                                            <th>Harga</th>
                                            <th style="text-align: center;">action</th>
                                        </tr>
                                    </thead>
                                    <tbody id='list-data'>
                                        @if (count($data) === 0)
                                        <td colspan="11" style="text-align: center;">DATA KOSONG</td>
                                        @else
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ formatTanggal(date('Y-m-d', strtotime($item->tanggal_keberangkatan))) }}</td>
                                            <td>{{ $item->no_sp === null ? '-' : $item->no_sp }}</td>
                                            <td>{{ $item->nama_petani }}</td>
                                            <td>{{ $item->nama_sopir }}</td>
                                            <td>{{ $item->pabrik_tujuan }}</td>
                                            <td>{{ $item->no_induk }}</td>
                                            <td>{{ $item->wilayah }}</td>
                                            <td>{{ formatRupiah($item->harga) }}</td>
                                            <td style="text-align: center;">
                                                @if ($item->tanggal_pulang == null)
                                                <button type="button" class="btn btn-warning text-bold update" data-toggle="modal" data-target="#exampleModal" data-id="{{ $item->id_keberangkatan }}">
                                                    <i class="fas fa-pencil-alt"></i>&nbsp;Ubah</button>
                                                <a href="berangkat/{{ $item->id_keberangkatan }}" class="btn btn-danger text-bold delete"><i class="far fa-trash-alt"></i>&nbsp;Hapus</a>
                                                @else
                                                <button type="button" disabled class="btn btn-secondary text-bold update" data-toggle="modal" data-target="#exampleModal" data-id="{{ $item->id_keberangkatan }}">
                                                    <i class="fas fa-pencil-alt"></i>&nbsp;Ubah</button>
                                                <button disabled="disabled" class="btn btn-secondary text-bold"><i class="far fa-trash-alt"></i>&nbsp;Hapus</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                </table>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->

            <!-- modal untuk tambah data -->
            <form action="/berangkat" method="post">
                @csrf
                <div class="modal fade" id="modal-lg-tambah">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Data Keberangkatan</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" id="1">
                                    <label for="exampleInputPassword1">Tanggal Berangkat</label>
                                    <input type="text" class="form-control" placeholder="Tanggal Berangkat" value="{{ date('d/m/Y') }}" name="tanggal_berangkat" required>
                                    <span class="text-dark"></span>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Tipe</label>
                                    </div>
                                    <select name="tipe" onchange="a()" id="tipe" class="custom-select" required>
                                        <option selected value="">Pilih</option>
                                        <option value="SPT">SPT</option>
                                        <option value="AMPERAN">AMPERAN</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">No SP</label>
                                    <input type="number" pattern="[0-9]{5}" class="form-control" placeholder="No SP " name="no_sp">
                                    <span class="text-dark"></span>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Wilayah</label>
                                            </div>
                                            <select name="wilayah" class="custom-select" id="wilayah1" required>
                                                <option selected value="">Pilih...</option>
                                                @foreach ($wilayah as $item)
                                                <option value="{{ $item->nama_wilayah }}">{{ $item->nama_wilayah }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Nama
                                                    Pabrik</label>
                                            </div>
                                            <select name="nama_pabrik" class="custom-select" id="pabrik" required>
                                                <option selected value="">Pilih...</option>
                                                @foreach ($pg as $item)
                                                <option value="{{ $item->nama_pg }}">{{ $item->nama_pg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Nama
                                                    Petani</label>
                                            </div>
                                            <select name="nama_sopir" class="custom-select" required>
                                                <option selected value="">Pilih...</option>
                                                @foreach ($sopir as $item)
                                                <option value="{{ $item->nama_petani }}">{{ $item->nama_petani }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Nama
                                                    Pemilik</label>
                                            </div>
                                            <select name="nama_petani" class="custom-select" id="pemilik" required>
                                                <option selected value="">Pilih...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">No Induk</label>
                                            <input type="text" class="form-control" placeholder="No Induk " name="no_induk" required>
                                            <span class="text-dark"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="margin-top: 32px;">
                                        <button disabled type="button" class="btn btn-primary text-bold" id="einduk"><i class="fas fa-pencil-alt"></i>&nbsp; Edit Data</button>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Harga</label>
                                            <input type="text" value="Rp. " onkeypress="return isNumber(event)" class="form-control harga" placeholder="Harga " name="harga" required>
                                            <span class="text-dark"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="margin-top: 32px;">
                                        <button disabled type="button" class="btn btn-primary text-bold" id="eharga"><i class="fas fa-pencil-alt"></i>&nbsp; Edit Data</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Sangu</label>
                                    <input type="text" value="Rp. " onkeypress="return isNumber(event)" class="form-control harga" placeholder="Sangu " name="sangu" required readonly>
                                    <span class="text-dark"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Berat (Kuintal)</label>
                                    <input type="number" class="form-control" placeholder="Berat Timbang " name="berat_timbang" required readonly>
                                    <span class="text-dark"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tara MBL</label>
                                    <input type="number" class="form-control" placeholder="Tara MBL " name="tara_mbl" required readonly>
                                    <span class="text-dark"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Netto</label>
                                    <input type="number" class="form-control" placeholder="Netto " name="netto" required readonly>
                                    <span class="text-dark"></span>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
        </div>
        </form>

        <!-- modal untuk Ubah data -->
        <form action="" method="post">
            <div class="modal fade" id="">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Ubah Data Barang</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_barang" value="">

                        </div>
                    </div>
                </div>
            </div>
        </form>

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
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="form-update" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group" id="2">
                            <label for="tglberangkat">Tanggal Berangkat</label>
                            <input type="text" name="utanggal_berangkat" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="tipe">Tipe</label>
                                    <select class="form-control" id="utipe" name="utipe">
                                        <option value="SPT">SPT</option>
                                        <option value="AMPERAN">AMPERAN</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nosp">No Sp</label>
                                    <input type="text" name="uno_sp" class="form-control" id="nosp" placeholder="No Sp">
                                </div>
                                <div class="form-group">
                                    <label for="noinduk">No Induk</label>
                                    <input type="text" name="uno_induk" class="form-control" id="noinduk" placeholder="No Induk" required>
                                </div>
                                <div class="form-group">
                                    <label for="wilayah">Wilayah</label>
                                    <select class="form-control" id="wilayah" name="uwilayah" required>
                                        <option selected value="">Pilih...</option>
                                        @foreach ($wilayah as $item)
                                        <option value="{{ $item->nama_wilayah }}">{{ $item->nama_wilayah }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="namapetani">Nama Pemilik</label>
                                    <select class="form-control" id="namapetani" name="unama_petani" required>
                                        <option selected value="">Pilih...</option>
                                        @foreach ($petani as $item)
                                        <option value="{{ $item->nama_pemilik }}">{{ $item->nama_pemilik }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="namasopir">Nama Petani</label>
                                    <select class="form-control" id="namasopir" name="unama_sopir" required>
                                        <option selected value="">Pilih...</option>
                                        @foreach ($sopir as $item)
                                        <option value="{{ $item->nama_petani }}">{{ $item->nama_petani }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 ml-auto">

                                <div class="form-group">
                                    <label for="pabriktujuan">Pabrik Tujuan</label>
                                    <select class="form-control" id="pabriktujuan" name="upabrik_tujuan" required>
                                        <option selected value="">Pilih...</option>
                                        @foreach ($pg as $item)
                                        <option value="{{ $item->nama_pg }}">{{ $item->nama_pg }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sangu">Sangu</label>
                                    <input type="text" value="Rp. " onkeypress="return isNumber(event)" class="form-control harga" placeholder="Sangu " name="usangu" required>
                                </div>
                                <div class="form-group">
                                    <label for="berattimbang">Berat Timbang (kwintal)</label>
                                    <input type="number" name="uberat_timbang" class="form-control" id="berattimbang" placeholder="Berat Timbang">
                                </div>
                                <div class="form-group">
                                    <label for="tarambl">Tara mbl</label>
                                    <input type="number" name="utara_mbl" class="form-control" id="tarambl" placeholder="Tara mbl">
                                </div>
                                <div class="form-group">
                                    <label for="netto">Netto</label>
                                    <input type="number" name="unetto" class="form-control" id="netto" placeholder="Netto" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" value="Rp. " onkeypress="return isNumber(event)" class="form-control harga" placeholder="Harga " name="uharga" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer float-left">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /Modal -->

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.min.js" integrity="sha512-mBSqtiBr4vcvTb6BCuIAgVx4uF3EVlVvJ2j+Z9USL0VwgL9liZ638rTANn5m1br7iupcjjg/LIl5cCYcNae7Yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('Js/Berangkat.js') }}"></script>
<script src="{{ asset('Js/Range.js') }}"></script>
<script src="{{ asset('Js/Pagination.js') }}"></script>
<script>
    $('#1').datepicker({
        inputs: $('input[name=tanggal_berangkat]'),
        format: 'dd/mm/yyyy'
    })
    $('#2').datepicker({
        inputs: $('input[name=utanggal_berangkat]'),
        format: 'dd/mm/yyyy'
    })
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
    
        function isNumber(evt) {
            var charCode = evt.which ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
            return true;
        }

        var sangu = document.querySelector("input[name=sangu]")
        var rupiah = document.querySelector('.harga');
        rupiah.addEventListener('keyup', function(e) {

            const val = this.value.split('Rp. ')
            val.length > 1 ? rupiah.value = formatRupiah(val[1], 'Rp. ') : rupiah.value = formatRupiah(this.value, 'Rp. ')
        });
        sangu.addEventListener('keyup', function(e) {

            const val = this.value.split('Rp. ')
            val.length > 1 ? sangu.value = formatRupiah(val[1], 'Rp. ') : sangu.value = formatRupiah(this.value, 'Rp. ')
        });
</script>

@endsection