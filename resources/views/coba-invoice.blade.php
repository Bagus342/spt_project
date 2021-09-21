<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cetak Invoice</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <style>
        hr {
           border: 1px solid black; 
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <section class="invoice">
                <!-- title row -->
                <div id="cetak">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 style="text-align: center;">
                                <i>USAHA PENGANGKUTAN</i><br>
                            </h4>
                            <h4 style="text-align: center"><b>CV RAYA GUNA</b></h4>
                            <p style="text-align: center">JL. RAYA BLAMBANGAN 88 SALAKAN KREBET - MALANG <br> TELP (0341) 803808, 085100727127, 08179660466</p>
                            <hr>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col pull-right">
                            Malang &emsp;&emsp;&emsp; Maret 2021 <br>
                            Kepada <br>
                            Yth PT ASINDO KARSA JAYA <br>
                            KREBET MALANG
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
                                        <th>Tanggal</th>
                                        <th>No Truck</th>
                                        <th>No Sp</th>
                                        <th>Netto</th>
                                        <th>Harga</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Rp. </td>
                                            <td>Rp. </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th>Total</th>
                                            <td></td>
                                            <th></th>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div><br>
                    <!-- /.row -->
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-4 table-responsive pull-right">
                            Hormat kami <br> <br> <br> <br>
                            CV. RAYA GUNA
                        </div>
                        <!-- /.col -->
                    </div><br>
                    <!-- /.row -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-xs-12">
                        <a id="button" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
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

<script>
    const tombol = document.getElementById('button')
    const documen = document.getElementById('cetak')

    tombol.addEventListener('click', () => {
        var restorepage = document.body.innerHTML
        var printcontent = documen.innerHTML
        document.body.innerHTML = printcontent
        window.print()
        window.location.reload(true)
    })
</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>

</html>
