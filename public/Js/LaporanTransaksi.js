const URL = document.getElementById('url').value;
const TOKEN = document.getElementById('token').value;

const state = {
    tanggal1: '',
    tanggal2: '',
    pabrik: '',
    type: '',
};

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
    const pabrik = document.getElementById('pabrik').value;
    const type = document.getElementById('type').value;
    const date = document.getElementById('date-range').value;
    const split = date.split(' / ');
    const format = split[0].split('-');
    const format2 = split[1].split('-');
    const date1 = `${format[2]}-${format[1]}-${format[0]}`;
    const date2 = `${format2[2]}-${format2[1]}-${format2[0]}`;
    fetch(`${URL}/filtertransaksi`, {
        method: 'post',
        body: JSON.stringify({
            tgl1: date1,
            tgl2: date2,
            type: type,
            tujuan: pabrik,
        }),
        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': TOKEN },
    })
        .then(res => res.json())
        .then(res => {
            document.getElementById('list-data').innerHTML = parse(res);
            document.getElementById('total').innerHTML = parse2(res);
            setState(date1, date2, type, pabrik);
            checkState();
        });
}

const setState = (tgl1, tgl2, type, pabrik) => {
    state.tanggal1 = tgl1;
    state.tanggal2 = tgl2;
    state.type = type;
    state.pabrik = pabrik;
};

const checkState = () => {
    console.log(state);
};

const parse = data => {
    let html = '';
    let no = 1;
    data.data.map(res => {
        html += htmldata(res, no++);
    });
    return html;
};

const htmldata = (res, no) => {
    const berat = res.berat_pulang - res.refaksi;
    const total = res.harga * berat;
    return /*html*/ `<tr>
	<td>${no}</td>
	<td>${formatTanggal(res.tanggal_keberangkatan)}</td>
	<td>${res.tanggal_pulang == null
            ? 'Belum Pulang'
            : formatTanggal(res.tanggal_pulang)
        }</td>
	<td>${formatTanggal(res.tanggal_bongkar)
        }</td>
	<td>${res.tipe}</td>
	<td>${res.nama_petani}</td>
	<td>${res.nama_sopir}</td>
	<td>${res.no_sp}</td>
	<td>${res.no_truk == null ? 'Belum Pulang' : res.no_truk}</td>
	<td>${res.pabrik_tujuan}</td>
	<td>${res.wilayah}</td>
	<td>${res.berat_pulang}</td>
	<td>${res.refaksi}</td>
	<td>${berat}</td>
	<td>${formatRupiah(res.harga.toString(), 'Rp ')}</td>
	<td>${formatRupiah(total.toString(), 'Rp ')}</td>
    <td>${res.tipe === 'SPT' ? '-' : formatRupiah(res.sangu.toString(), 'Rp ')}</td>
    <td>${res.tipe === 'SPT' ? '-' : res.berat_timbang}</td>
    <td>${res.tipe === 'SPT' ? '-' : res.tara_mbl}</td>
    <td>${res.tipe === 'SPT' ? '-' : res.berat_timbang - res.tara_mbl}</td>
	</tr>`;
};

const parse2 = data => {
    let no = 0;
    data.data.map(res => {
        no += total(res);
    });
    return /* html */ `
    <tr>
        <th>Total</th>
        <th style="text-align: right;">${formatRupiah(no.toString(), 'Rp ')}</th>
    </tr>
    `;
};

const total = (res) => {
    const netto = res.berat_pulang - res.refaksi
    const jumlah = res.harga * netto
    return jumlah
}

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
