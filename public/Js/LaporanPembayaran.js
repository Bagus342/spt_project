const URL = document.getElementById('url').value;
const TOKEN = document.getElementById('token').value;

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
    const type = document.getElementById('type').value;
    const date = document.getElementById('date-range').value;
    const split = date.split(' / ');
    const format = split[0].split('-');
    const format2 = split[1].split('-');
    const date1 = `${format[2]}-${format[1]}-${format[0]}`;
    const date2 = `${format2[2]}-${format2[1]}-${format2[0]}`;
    fetch(`${URL}/filterlaporan`, {
        method: 'post',
        body: JSON.stringify({
            tgl1: date1,
            tgl2: date2,
            type: type,
        }),
        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': TOKEN },
    })
        .then(res => res.json())
        .then(res => {
            document.getElementById('list-data').innerHTML = parse(res);
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
    const inv = res.no_invoice
    const split = inv.split('/')
    const no_inv = `${split[0]}-${split[1]}-${split[2]}-${split[3]}`
    return /*html*/ `<tr>
	<td>${no}</td>
	<td>${res.no_invoice}</td>
	<td>${formatTanggal(res.tanggal_bayar)}</td>
	<td>${res.nama_sopir}</td>
	<td>${res.no_sp}</td>
	<td style="text-align: center;">
        <a href="/pembayaran/${no_inv}" class="btn btn-danger text-bold delete"><i class="far fa-trash-alt"></i>&nbsp;Hapus</a>
        &nbsp;&nbsp;
        <a href="/transaksi/pembayaran/cetak?inv=${res.no_invoice}" class="btn btn-success text-bold"><i class="fas fa-print"></i>&nbsp;Cetak</a>
        </td>
</tr>`;
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
        title: `${flash.getAttribute('data-flash-error')}`,
    });
}
