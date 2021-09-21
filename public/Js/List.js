const elementUpdate = document.getElementsByClassName('update');
const URL = document.getElementById('url').value;
const TOKEN = document.getElementById('token').value;

for (let i = 0; i < elementUpdate.length; i++) {
    elementUpdate[i].addEventListener('click', function () {
        const ID = this.getAttribute('data-id');
        document
            .getElementById('form-update')
            .setAttribute('action', URL + '/pulang/' + ID);
    });
}

function elementSp() {
    const sp = document.getElementsByClassName('sp');
    for (let i = 0; i < sp.length; i++) {
        sp[i].addEventListener('click', function () {
            const ID = this.getAttribute('data-id');
            document
                .getElementById('form-sp')
                .setAttribute('action', URL + '/pulang/view/list/' + ID);
        });
    }
}

elementSp();

document
    .querySelector('input[name=berat_pulang]')
    .addEventListener('keyup', function () {
        document.querySelector('input[name=netto]').value =
            this.value.toString();
    });

document
    .querySelector('input[name=refaksi]')
    .addEventListener('keyup', function () {
        let refaksi = 0
        if (this.value === '') {
            document.querySelector('input[name=netto]').value = 'Netto'
        } else {
            refaksi = parseInt(this.value)
            let set =
                parseInt(document.querySelector('input[name=berat_pulang]').value) -
                refaksi;
            document.querySelector('input[name=netto]').value = set.toString();
        }
    });

document.getElementById('filter').addEventListener('click', function () {
    filter()
})

function filter() {
    try {
        getfilter();
    } catch (e) {
        document.getElementById('list-data').innerHTML = /*html*/ `<td colspan="6" style="text-align: center;">ERROR</td>`;
    }
}

function getfilter() {
    const date = document.getElementById('date-range').value;
    const split = date.split(' / ');
    const format = split[0].split('-');
    const format2 = split[1].split('-');
    const date1 = `${format[2]}-${format[1]}-${format[0]}`;
    const date2 = `${format2[2]}-${format2[1]}-${format2[0]}`;
    fetch(`${URL}/filterlist`, {
        method: 'post',
        body: JSON.stringify({ tgl1: date1, tgl2: date2 }),
        headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': TOKEN },
    })
        .then((res) => res.json())
        .then((res) => {
            document.getElementById('list-data').innerHTML = parse(res);
        });
}

const parse = (data) => {
    let html = '';
    let no = 1;
    data.data.map((res) => {
        html += htmldata(res, no++);
    });
    return html;
};

const htmldata = (res, no) => {
    if (res.no_sp === null) {
        return /* html */ `
        <tr>
            <td>${no++}</td>
            <td>${formatTanggal(res.tanggal_keberangkatan)}</td>
            <td>${res.tipe}</td>
            <td>${res.nama_petani}</td>
            <td>${res.no_induk}</td>
            <td>${res.no_sp}</td>
            <td>${res.pabrik_tujuan}</td>
            <td>${res.nama_sopir}</td>
            <td>
            <a href="#" class="btn btn-danger text-bold sp" data-target="#modal-sp" data-toggle="modal" data-id="${res.id_keberangkatan}"><i class="fas fa-mouse-pointer"></i></i>&nbsp;Lengkapi</a>
            </td>
        </tr>
        `
    } else {
        return /* html */ `
    <tr>
        <td>${no++}</td>
        <td>${formatTanggal(res.tanggal_keberangkatan)}</td>
        <td>${res.tipe}</td>
        <td>${res.nama_petani}</td>
        <td>${res.no_induk}</td>
        <td>${res.no_sp}</td>
        <td>${res.pabrik_tujuan}</td>
        <td>${res.nama_sopir}</td>
        <td>
        <a href="#" class="btn btn-primary text-bold update" data-target="#modal-lg" data-toggle="modal" data-id="${res.id_keberangkatan}"><i class="fas fa-mouse-pointer"></i></i>&nbsp;Pilih</a>
        </td>
    </tr>
    `
    }
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