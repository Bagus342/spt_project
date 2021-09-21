const URL = document.getElementById('url').value;
const TOKEN = document.getElementById('token').value;

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
  fetch(`${URL}/filterpembayaran`, {
    method: 'post',
    body: JSON.stringify({ tgl1: date1, tgl2: date2 }),
    headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': TOKEN },
  })
    .then((res) => res.json())
    .then((res) => {
      document.getElementById('list-data').innerHTML = parse(res);
      displayD();
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
  const inv = res.invoice;
  const split = inv.split('/');
  const no_inv = `${split[0]}-${split[1]}-${split[2]}-${split[3]}`;
  return /*html*/ `<tr>
    <td>${no}</td>
    <td>${res.invoice}</td>
    <td>${formatTanggal(res.tgl)}</td>
    <td>${res.petani}</td>
    <td>${res.list_sp}</td>
    <td>${formatRupiah(res.subtotal.toString(), 'Rp ')}</td>
    <td style="text-align: center;">
    <button type="button" class="btn btn-primary text-bold detail" id="detail" data-target="#exampleModal" data-toggle="modal" data-id="${res.no_invoice}"><i class="fas fa-info-circle"></i>&nbsp;Detail</button>
        <a href="/pembayaran/${no_inv}" class="btn btn-danger text-bold"><i class="far fa-trash-alt"></i>&nbsp;Hapus</a>
    </td>
</tr>`;
};

displayD();

function displayD() {
  const dt = document.getElementsByClassName('detail');
  for (let i = 0; i < dt.length; i++) {
    dt[i].addEventListener('click', function () {
      const ID = this.getAttribute('data-id');
      fetch(URL + '/detailp?id=' + ID)
        .then((res) => res.json())
        .then((res) => {
          document.getElementById('tabel-detail').innerHTML = parse2(res);
          document.getElementById('t').innerHTML = parse3(res);
        });
    });
  }
}

const parse2 = (data) => {
  let html = '';
  let no = 1;
  data.data.map((res) => {
    html += detaildata(res, no++);
  });
  return html;
};

const detaildata = (res, no) => {
  const netto = res.berat_pulang - res.refaksi;
  const total = res.harga * netto;
  return /*html*/ `<tr>
    <td>${no}</td>
    <td>${formatTanggal(res.tanggal_keberangkatan)}</td>
    <td>${formatTanggal(res.tanggal_pulang)}</td>
    <td>${res.no_sp}</td>
    <td>${res.no_truk}</td>
    <td>${res.pabrik_tujuan}</td>
    <td>${netto}</td>
    <td>${formatRupiah(res.harga.toString(), 'Rp ')}</td>
    <td>${formatRupiah(total.toString(), 'Rp ')}</td>
</tr>
`;
};

const parse3 = data => {
  let no = 0;
  data.data.map(res => {
    no += total(res);
  });
  return /* html */ `
  <tr>
      <th>Subtotal Invoice</th>
      <th style = "text-align: right;">${formatRupiah(no.toString(), 'Rp ')}</th>
  </tr>
  `;
};

const total = (res) => {
  const netto = res.berat_pulang - res.refaksi
  const jumlah = res.harga * netto
  return jumlah
}

const formatTanggal = (tgl) => {
  const listMonth = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'November', 'Desember'];
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
  }).then((result) => {
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
