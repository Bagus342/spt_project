<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pembukuan harian - Masuk</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href=" {{ asset('') }}plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href=" {{ asset('') }}plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href=" {{ asset('') }}dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Laporan</h2>
                <strong>01/01/2021</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="h5">
                            Id Keberangkatan :
                        </div>
                        <div class="h5">
                            Tanggal Berangkat :
                        </div>
                        <div class="h5">
                            Tipe :
                        </div>
                        <div class="h5">
                            No Sp :
                        </div>
                        <div class="h5">
                            No Induk :
                        </div>
                        <div class="h5">
                            Wilayah :
                        </div>
                        <div class="h5">
                            Nama Petani :
                        </div>
                        <div class="h5">
                            Nama Sopir :
                        </div>
                        <div class="h5">
                            Pabrik Tujuan :
                        </div>
                        <div class="h5">
                            Sangu :
                        </div>
                    </div>
                    <div class="col-md-6 ml-auto">
                        <div class="h5">
                            Berat Timbang :
                        </div>
                        <div class="h5">
                            Tara Mbl :
                        </div>
                        <div class="h5">
                            Netto :
                        </div>
                        <div class="h5">
                            Harga :
                        </div>
                        <div class="h5">
                            Tanggal Pulang :
                        </div>
                        <div class="h5">
                            Tanggal Bongkar :
                        </div>
                        <div class="h5">
                            No Truk :
                        </div>
                        <div class="h5">
                            Berat Pulang :
                        </div>
                        <div class="h5">
                            Rafaksi :
                        </div>
                        <div class="h5">
                            Date add :
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                <a href="/transaksi/pembayaran" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Kembali</a>
            </div>
        </div>
    </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>

</html>
