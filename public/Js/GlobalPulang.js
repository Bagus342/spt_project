const URL = document.getElementById('url').value;
const TOKEN = document.getElementById('token').value;

function displayU() {
    const elementUpdate = document.getElementsByClassName('update');
    for (let i = 0; i < elementUpdate.length; i++) {
        elementUpdate[i].addEventListener('click', function () {
            const ID = this.getAttribute('data-id');
            console.log(ID);
            document
                .getElementById('form-update')
                .setAttribute('action', URL + '/pulang/' + ID);
            fetch(URL + '/pulang/view/get/' + ID)
                .then(res => res.json())
                .then(res => {
                    document.querySelector('input[name=no_truk]').value =
                        res.data.no_truk;
                    document.querySelector('input[name=berat_pulang]').value =
                        res.data.berat_pulang;
                    document.querySelector('input[name=refaksi]').value =
                        res.data.refaksi;
                    document.querySelector('input[name=tanggal_pulang]').value =
                        setTanggal(res.data.tanggal_pulang);
                    document.querySelector(
                        'input[name=tanggal_bongkar]'
                    ).value = setTanggal(res.data.tanggal_bongkar);
                    document.querySelector('input[name=berat_bersih]').value =
                        res.data.berat_pulang - res.data.refaksi;
                    document.querySelector('input[name=berat_bersih]').addEventListener('keyup', function () {
                        document.querySelector('input[name=berat_bersih]').value = this.value
                    });
                    document.querySelector('input[name=refaksi]').addEventListener('keyup', function () {
                        let refaksi = 0
                        if (this.value === '') {
                            document.querySelector('input[name=berat_bersih]').value = 'Berat Bersih'
                        } else {
                            refaksi = parseInt(this.value)
                            const jumlah = parseInt(document.querySelector('input[name=berat_pulang]').value) - refaksi
                            document.querySelector('input[name=berat_bersih]').value = jumlah
                        }
                    });
                });
        });
    }
}

function setTanggal(tgl) {
    tanggal = tgl.split('-')
    return `${tanggal[2]}/${tanggal[1]}/${tanggal[0]}`
}

document
    .querySelector('input[name=berat_pulang]')
    .addEventListener('keyup', function () {
        const netto = document.querySelector('input[name=berat_bersih]');
        netto.value = this.value;
    });

document
    .querySelector('input[name=refaksi]')
    .addEventListener('keyup', function () {
        const netto = document.querySelector('input[name=berat_bersih]');
        const total =
            parseInt(document.querySelector('input[name=berat_pulang]').value) -
            parseInt(this.value);
        netto.value = total.toString();
    });

displayU();

document.getElementById('filter').addEventListener('click', function () {
    filter();
});

function filter() {
    try {
        getfilter();
    } catch (e) {
        console.log(e);
        document.getElementById('list-data').innerHTML = 'error';
    }
}

function getfilter() {
    const date = document.getElementById('date-range').value;
    const split = date.split(' / ');
    const format = split[0].split('-');
    const format2 = split[1].split('-');
    const date1 = `${format[2]}-${format[1]}-${format[0]}`;
    const date2 = `${format2[2]}-${format2[1]}-${format2[0]}`;
    fetch(`${URL}/filterpulang`, {
        method: 'post',
        body: JSON.stringify({ tgl1: date1, tgl2: date2 }),
        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': TOKEN },
    })
        .then(res => res.json())
        .then(res => {
            document.getElementById('list-data').innerHTML = parse(res);
            displayD();
            displayU();
            tablePagination();
        });
}

const parse = data => {
    let html = '';
    let no = 1;
    data.data.map(res => {
        html += htmldata(res, no++);
    });
    return html;
};

const htmldata = (res, no) => {
    if (res.status) {
        return /*html*/ `<tr>
    <td>${no}</td>
    <td>${formatTanggal(res.tanggal_pulang)}</td>
    <td>${res.no_sp}</td>
    <td>${res.no_truk}</td>
    <td>${res.pabrik_tujuan}</td>
    <td>${res.nama_sopir}</td>
    <td>${res.wilayah}</td>
    <td>${formatRupiah(res.harga.toString(), 'Rp ')}</td>
    <td style="text-align: center;">
        <button type="button" class="btn btn-primary text-bold detail" id="detail" data-target="#modal-lg-2" data-toggle="modal" data-id="${res.id_keberangkatan
            }"><i class="fas fa-info-circle"></i>&nbsp;Detail</button>
        <button type="button" disabled class="btn btn-secondary text-bold update" data-target="#modal-lg" data-toggle="modal" data-id="${res.id_keberangkatan
            }"><i class="fas fa-pencil-alt"></i>&nbsp;Ubah</button>
        <button disabled="disabled" class="btn btn-secondary text-bold"><i class="far fa-trash-alt"></i>&nbsp;Hapus</button>
    </td>
</tr>`
    } else {
        return /*html*/ `<tr>
    <td>${no}</td>
    <td>${formatTanggal(res.tanggal_pulang)}</td>
    <td>${res.no_sp}</td>
    <td>${res.no_truk}</td>
    <td>${res.pabrik_tujuan}</td>
    <td>${res.nama_sopir}</td>
    <td>${res.wilayah}</td>
    <td>${formatRupiah(res.harga.toString(), 'Rp ')}</td>
    <td style="text-align: center;">
        <button type="button" class="btn btn-primary text-bold detail" id="detail" data-target="#modal-lg-2" data-toggle="modal" data-id="${res.id_keberangkatan
            }"><i class="fas fa-info-circle"></i>&nbsp;Detail</button>
        <button type="button" class="btn btn-warning text-bold update" data-target="#modal-lg" data-toggle="modal" data-id="${res.id_keberangkatan
            }"><i class="fas fa-pencil-alt"></i>&nbsp;Ubah</button>
        <a href="/pulang/${res.id_keberangkatan
            }" class="btn btn-danger text-bold"><i class="far fa-trash-alt"></i>&nbsp;Hapus</a>
    </td>
</tr>`
    }
};

const tablePagination = () => {
    $('#tb').dataTable({
        searching: false,
        lengthChange: false,
        language: {
            info: 'Halaman ke _PAGE_ dari _PAGES_',
        },
    });
};

function displayD() {
    const dt = document.getElementsByClassName('detail');

    for (let i = 0; i < dt.length; i++) {
        dt[i].addEventListener('click', function () {
            const ID = this.getAttribute('data-id');
            fetch(URL + '/detail?id=' + ID)
                .then(res => res.json())
                .then(res => {
                    document.getElementById('tabel_detail').innerHTML =
                        htmldetail(res.data);
                });
        });
    }
}

displayD();

const htmldetail = res => {
    if (res.tipe == 'SPT') {
        return /*html*/ `<thead>
        <tr class="col-sm" style="display: flex; flex-direction: column;">
                        <th>Tanggal Keberangkatan</th>
                        <th>Tanggal Bongkar</th>
                        <th>No Sp</th>
                        <th>Nama Pemilik</th>
                        <th>Tujuan</th>
                        <th>No Truk</th>
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
                </tr>
                <tbody id="detail1">
                <tr class="col-sm" style="display: flex; flex-direction: column;">
                <td>${formatTanggal(res.tanggal_keberangkatan)}</td>
                <td>${formatTanggal(res.tanggal_bongkar)}</td>
                <td>${res.no_sp}</td>
                <td>${res.nama_petani}</td>
                <td>${res.pabrik_tujuan}</td>
                <td>${res.no_truk}</td>
                <td>${res.berat_pulang}</td>
                <td>${res.netto_pulang}</td>
            </tr>
                </tbody>
                <thead>
                    <tr class="col-sm" style="display: flex; flex-direction: column;">
                        <th>Tanggal Kepulangan</th>
                        <th>Tipe</th>
                        <th>No Induk</th>
                        <th>Nama Petani</th>
                        <th>Wilayah</th>
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
                </tr>
                <tbody id="detail2">
                <tr class="col-sm" style="display: flex; flex-direction: column;">
                <td>${formatTanggal(res.tanggal_pulang)}</td>
                <td>${res.tipe}</td>
                <td>${res.no_induk}</td>
                <td>${res.nama_sopir}</td>
                <td>${res.wilayah}</td>
                <td>${formatRupiah(res.harga.toString(), 'Rp ')}</td>
                <td>${res.refaksi}</td>
            </tr></tbody>`;
    } else {
        return /*html*/ `<thead>
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
                <td>${formatTanggal(res.tanggal_keberangkatan)}</td>
                <td>${formatTanggal(res.tanggal_bongkar)}</td>
                <td>${res.no_sp}</td>
                <td>${res.nama_petani}</td>
                <td>${res.pabrik_tujuan}</td>
                <td>${res.no_truk}</td>
                <td>${res.berat_timbang}</td>
                <td>${res.netto}</td>
                <td>${res.berat_pulang}</td>
                <td>${res.netto_pulang}</td>
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
                <td>${formatTanggal(res.tanggal_pulang)}</td>
                <td>${res.tipe}</td>
                <td>${res.no_induk}</td>
                <td>${res.nama_sopir}</td>
                <td>${res.wilayah}</td>
                <td>${res.sangu}</td>
                <td>${res.tara_mbl}</td>
                <td>${formatRupiah(res.harga.toString(), 'Rp ')}</td>
                <td>${res.refaksi}</td>
            </tr></tbody>`;
    }
};

const formatTanggal = tgl => {
    const listMonth = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'November',
        'Desember',
    ];
    const month = tgl.split('-');
    return `${month[2]}/${month[1]}/${month[0]}`;
};

const formatRupiah = (angka, prefix) => {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? 'Rp. ' + rupiah : '';
};

function listDelete() {
    const documentDel = document.querySelectorAll('.delete');
    for (let i = 0; i < documentDel.length; i++) {
        documentDel[i].onclick = function (e) {
            e.preventDefault();
            swalDelete(this.getAttribute('href'));
        };
    }
}

function swalDelete(param) {
    Swal.fire({
        title: 'Yakin ingin Menghapus?',
        text: 'Data akan di hapus secara permanent!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
    }).then(result => {
        result.isConfirmed ? (window.location.href = param) : '';
    });
}

listDelete();

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
