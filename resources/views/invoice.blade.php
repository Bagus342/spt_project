<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Invoice</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
</head>

<body>
    <div class="container">
        <div class="card">
            <section class="invoice">
                <!-- title row -->
                <div id="cetak">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> RAYA GUNA
                                <small class="pull-right">Date: 2/10/2014</small>
                            </h2>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            {{-- <b>Invoice #{{ $inv }}</b><br> --}}
                        </div>
                        <!-- /.col -->
                    </div> <br>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Harga</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Nominal</th>
                                        <th>Netto</th>
                                        <th>No SP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @php $total = 0; @endphp
                                    @foreach ($data as $item)
                                    @php $total += $item->nominal @endphp
                                    <tr>
                                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ formatTanggal($item->tanggal_bayar) }}</td>
                                    <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                    {{-- <td>{{ $item->netto }}</td>
                                    <td>{{ $item->no_sp }}</td> --}}
                                    </tr>
                                    {{-- @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div><br>
                    <!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->

                        <!-- /.col -->
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Total:</th>
                                            {{-- <td style="text-align: right">Rp {{ number_format($total, 0, ',', '.') }}</td> --}}
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-xs-12">
                        <a id="button" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                        {{-- <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
                        </button>
                        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                            <i class="fa fa-download"></i> Generate PDF
                        </button> --}}
                    </div>
                </div>
            </section>
        </div>
    </div> 
</body>

</html>
