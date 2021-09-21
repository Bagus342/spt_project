const URL = document.getElementById('url').value;
const TOKEN = document.getElementById('token').value;

const BTN = {
  update: document.getElementsByClassName('update'),
  uharga: document.getElementById('eharga'),
  uinduk: document.getElementById('einduk'),
};

const DATA_HARGA = {
  id: 0,
  harga: 0,
};

const REGISTER = {
  id: 0,
  induk: '',
};

const FORM_ADD = {
  wilayah: document.querySelector('select[name=wilayah]'),
  sangu: document.querySelector("input[name='sangu']"),
  berat: document.querySelector('input[name=berat_timbang]'),
  truk: document.querySelector('input[name=tara_mbl]'),
  netto: document.querySelector('input[name=netto]'),
  harga: document.querySelector('input[name=harga]'),
  petani: document.querySelector('select[name=nama_petani]'),
  tipe: document.getElementById('tipe'),
  no_induk: document.querySelector('input[name=no_induk]'),
};

const FORM_UPDATE = {
  tgl_b: document.querySelector('input[name=utanggal_berangkat]'),
  tipe: document.querySelector('select[name=utipe]'),
  no_sp: document.querySelector('input[name=uno_sp]'),
  no_induk: document.querySelector('input[name=uno_induk]'),
  wilayah: document.querySelector('select[name=uwilayah]'),
  pemilik: document.querySelector('select[name=unama_petani]'),
  petani: document.querySelector('select[name=unama_sopir]'),
  pabrik: document.querySelector('select[name=upabrik_tujuan]'),
  sangu: document.querySelector('input[name=usangu]'),
  berat: document.querySelector('input[name=uberat_timbang]'),
  truk: document.querySelector('input[name=utara_mbl]'),
  netto: document.querySelector('input[name=unetto]'),
  harga: document.querySelector('input[name=uharga]'),
};

const setFunctionu = () => {
  for (let i = 0; i < BTN.update.length; i++) {
    BTN.update[i].addEventListener('click', function () {
      setForm(this.getAttribute('data-id'));
    });
  }
};

setFunctionu();

document.getElementById('tbh').addEventListener('click', function () {
  const register = document.querySelector('select[name=nama_petani]');
  register.disabled = true;
  console.log(register);
});

document.querySelector('select[name=nama_pabrik]').addEventListener('change', function () {
  const pg = this.value;
  console.log(pg);
  const register = document.querySelector('select[name=nama_petani]');
  const induk = document.querySelector('input[name=no_induk]');
  if (pg !== '') {
    register.disabled = false;
    fetch(URL + '/berangkat/getPg/' + pg)
      .then((res) => res.json())
      .then((res) => {
        register.innerHTML = loop(res);
        fetch(URL + '/pemilik/getRegister/' + register.value)
          .then((res) => res.json())
          .then((res) => updateRegister(res.data[0]));

        register.value === 'def' ? (BTN.uinduk.disabled = true) : (BTN.uinduk.disabled = false);
      });
  } else {
    register.innerHTML = /* html */ `<option selected value="">Pilih...</option>`;
    register.disabled = true;
    console.log(register);
    induk.value = '';
    BTN.uinduk.disabled = true;
  }
});

const loop = (data) => {
  let html = '';
  data.data.map((res) => {
    html += input(res);
  });
  return html;
};

const input = (res) => {
  return /*html*/ `
    <option value="${res.nama_pemilik}">${res.nama_pemilik}</option>
    `;
};

function a() {
  const key = document.getElementById('tipe')
  if (key.value === 'AMPERAN') {
    oForm(FORM_ADD)
  } else {
    addForm(FORM_ADD)
  }
}

const dForm = (THIS) => {
  THIS.sangu.readOnly = true;
  THIS.berat.readOnly = true;
  THIS.truk.readOnly = true;
  THIS.netto.readOnly = true;
  THIS.sangu.value = null;
  THIS.berat.value = null;
  THIS.truk.value = null;
  THIS.netto.value = null;
};

const addForm = (THIS) => {
  THIS.sangu.readOnly = true;
  THIS.sangu.value = null;
  THIS.berat.readOnly = true;
  THIS.truk.readOnly = true;
  THIS.netto.readOnly = true;
};

const oForm = (THIS) => {
  THIS.sangu.readOnly = false;
  THIS.berat.readOnly = false;
  THIS.truk.readOnly = false;
  THIS.netto.readOnly = false;
};

FORM_UPDATE.tipe.addEventListener('change', function () {
  if (this.value === 'SPT') {
    dForm(FORM_UPDATE);
  } else {
    oForm(FORM_UPDATE);
  }
});

FORM_ADD.berat.addEventListener('keyup', function () {
  FORM_ADD.netto.value = this.value;
});

FORM_ADD.truk.addEventListener('keyup', function () {
  let truk = 0;
  if (this.value === '') {
    FORM_ADD.netto.value = 'Netto';
  } else {
    truk = parseInt(this.value);
    const netto = parseInt(FORM_ADD.berat.value) - parseInt(truk);
    FORM_ADD.netto.value = netto.toString();
  }
});

FORM_ADD.wilayah.addEventListener('change', function () {
  fetch(URL + '/wilayah/getHarga/' + this.value)
    .then((res) => res.json())
    .then((res) => updateHarga(res.data[0]));

  this.value === 'def' ? (BTN.uharga.disabled = true) : (BTN.uharga.disabled = false);
});

FORM_ADD.petani.addEventListener('change', function () {
  fetch(URL + '/pemilik/getRegister/' + this.value)
    .then((res) => res.json())
    .then((res) => updateRegister(res.data[0]));

  this.value === 'def' ? (BTN.uinduk.disabled = true) : (BTN.uinduk.disabled = false);
});

const updateHarga = (res) => {
  if (res == null) {
    FORM_ADD.harga.value = '';
  } else {
    DATA_HARGA.id = res.id_wilayah;
    DATA_HARGA.harga = res.harga_wilayah;
    FORM_ADD.harga.value = formatRupiah(DATA_HARGA.harga.toString(), 'Rp ');
  }
};

const updateHargau = (res) => {
  if (res == null) {
    FORM_UPDATE.harga.value = '';
  } else {
    DATA_HARGA.id = res.id_wilayah;
    DATA_HARGA.harga = res.harga_wilayah;
    FORM_UPDATE.harga.value = formatRupiah(DATA_HARGA.harga.toString(), 'Rp ');
  }
};

const updateRegister = (res) => {
  if (res == null) {
    FORM_ADD.no_induk.value = '';
  } else {
    FORM_ADD.no_induk.value = res.register_pemilik;
    REGISTER.id = res.id_pemilik;
    REGISTER.induk = res.register_pemilik;
  }
};

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
  fetch(`${URL}/filterberangkat`, {
    method: 'post',
    body: JSON.stringify({ tgl1: date1, tgl2: date2 }),
    headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': TOKEN },
  })
    .then((res) => res.json())
    .then((res) => {
      document.getElementById('list-data').innerHTML = parse(res);
      setFunctionu();
      listDelete();
    });
}

function setForm(THIS) {
  const ID = THIS;
  document.getElementById('form-update').setAttribute('action', URL + '/berangkat/' + ID);
  fetch(URL + '/berangkat/view/get/' + ID)
    .then((res) => res.json())
    .then((res) => {
      if (res.data.sangu === null) {
        FORM_UPDATE.tgl_b.value = formatInputUpdate(res.data.tanggal_keberangkatan);
        FORM_UPDATE.tipe.value = res.data.tipe;
        FORM_UPDATE.no_sp.value = res.data.no_sp;
        FORM_UPDATE.no_induk.value = res.data.no_induk;
        FORM_UPDATE.wilayah.value = res.data.wilayah;
        FORM_UPDATE.pemilik.value = res.data.nama_petani;
        FORM_UPDATE.petani.value = res.data.nama_sopir;
        FORM_UPDATE.pabrik.value = res.data.pabrik_tujuan;
        FORM_UPDATE.sangu.value = res.data.sangu;
        FORM_UPDATE.berat.value = res.data.berat_timbang;
        FORM_UPDATE.truk.value = res.data.tara_mbl;
        FORM_UPDATE.netto.value = res.data.netto;
        FORM_UPDATE.harga.value = formatRupiah(res.data.harga.toString(), 'Rp. ');
      } else {
        FORM_UPDATE.tgl_b.value = formatInputUpdate(res.data.tanggal_keberangkatan);
        FORM_UPDATE.tipe.value = res.data.tipe;
        FORM_UPDATE.no_sp.value = res.data.no_sp;
        FORM_UPDATE.no_induk.value = res.data.no_induk;
        FORM_UPDATE.wilayah.value = res.data.wilayah;
        FORM_UPDATE.pemilik.value = res.data.nama_petani;
        FORM_UPDATE.petani.value = res.data.nama_sopir;
        FORM_UPDATE.pabrik.value = res.data.pabrik_tujuan;
        FORM_UPDATE.sangu.value = formatRupiah(res.data.sangu.toString(), 'Rp ');
        FORM_UPDATE.berat.value = res.data.berat_timbang;
        FORM_UPDATE.truk.value = res.data.tara_mbl;
        FORM_UPDATE.netto.value = res.data.netto;
        FORM_UPDATE.harga.value = formatRupiah(res.data.harga.toString(), 'Rp. ');
      }
      FORM_UPDATE.netto.addEventListener('keyup', function () {
        FORM_UPDATE.netto.value = this.value;
      });
      FORM_UPDATE.truk.addEventListener('keyup', function () {
        let tara = 0;
        if (this.value === '') {
          FORM_UPDATE.netto.value = 'Netto';
        } else {
          tara = parseInt(this.value);
          const jumlah = parseInt(FORM_UPDATE.berat.value) - tara;
          FORM_UPDATE.netto.value = jumlah;
        }
      });
      res.data.tipe === 'SPT' ? dForm(FORM_UPDATE) : oForm(FORM_UPDATE);
    });
}

FORM_UPDATE.wilayah.addEventListener('change', function () {
  fetch(URL + '/wilayah/getHarga/' + this.value)
    .then((res) => res.json())
    .then((res) => updateHargau(res.data[0]));
});

BTN.uharga.onclick = async function () {
  const HARGA = FORM_ADD.harga.value;
  const DATA = await fetch(URL + `/wilayah/harga/${DATA_HARGA.id}/${HARGA}`);
  const RESULT = await DATA.json();
  RESULT.status === 'sukses' ? toastr.success('sukses update harga', 'update harga') : toastr.error('gagal update harga', 'update harga');
};

BTN.uinduk.onclick = async function () {
  const INDUK = FORM_ADD.no_induk.value;
  const DATA = await fetch(URL + `/pemilik/induk/${REGISTER.id}/${INDUK}`);
  const RESULT = await DATA.json();
  RESULT.data === 'sukses' ? toastr.success('sukses update nomor induk', 'update no induk') : toastr.error('gagal update nomor induk', 'update no induk');
};

const parse = (data) => {
  let html = '';
  let no = 1;
  data.data.map((res) => {
    html += htmldata(res, no++);
  });
  return html;
};

const htmldata = (res, no) => {
  if (res.tanggal_pulang !== null) {
    return /*html*/ `<tr>
    <td>${no}</td>
    <td>${formatTanggal(res.tanggal_keberangkatan)}</td>
    <td>${res.no_sp === null ? '-' : res.no_sp}</td>
    <td>${res.nama_petani}</td>
    <td>${res.nama_sopir}</td>
    <td>${res.pabrik_tujuan}</td>
    <td>${res.no_induk}</td>
    <td>${res.wilayah}</td>
    <td>${formatRupiah(res.harga.toString(), 'Rp ')}</td>
    <td style="text-align: center;">
        <button type="button" disabled class="btn btn-secondary text-bold update" data-toggle="modal" data-target="#exampleModal" data-id="${res.id_keberangkatan}">
        <i class="fas fa-pencil-alt"></i>&nbsp;Ubah</button>
        <button disabled="disabled" class="btn btn-secondary text-bold"><i class="far fa-trash-alt"></i>&nbsp;Hapus</button>
    </td>
</tr>`;
  } else {
    return /*html*/ `<tr>
    <td>${no}</td>
    <td>${formatTanggal(res.tanggal_keberangkatan)}</td>
    <td>${res.no_sp}</td>
    <td>${res.nama_petani}</td>
    <td>${res.nama_sopir}</td>
    <td>${res.pabrik_tujuan}</td>
    <td>${res.no_induk}</td>
    <td>${res.wilayah}</td>
    <td>${formatRupiah(res.harga.toString(), 'Rp ')}</td>
    <td style="text-align: center;">
        <button type="button" class="btn btn-warning text-bold update" data-toggle="modal" data-target="#exampleModal" data-id="${res.id_keberangkatan}">
            <i class="fas fa-pencil-alt"></i>&nbsp;Ubah</button>
        
        <a href="${URL}/berangkat/${res.id_keberangkatan}" class="btn btn-danger text-bold delete"><i class="far fa-trash-alt"></i>&nbsp;Hapus</a>
    </td>
</tr>`;
  }

};

// optional function
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

function formatInputUpdate(tgl) {
  const tanggal = tgl.split('-');
  return `${tanggal[2]}/${tanggal[1]}/${tanggal[0]}`;
}

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

FORM_UPDATE.harga.addEventListener('keyup', function (e) {
  const val = this.value.split('Rp. ');
  val.length > 1 ? (FORM_UPDATE.harga.value = formatRupiah(val[1], 'Rp. ')) : (FORM_UPDATE.harga.value = formatRupiah(this.value, 'Rp. '));
});

FORM_UPDATE.sangu.addEventListener('keyup', function (e) {
  const val = this.value.split('Rp. ');
  val.length > 1 ? (FORM_UPDATE.sangu.value = formatRupiah(val[1], 'Rp. ')) : (FORM_UPDATE.sangu.value = formatRupiah(this.value, 'Rp. '));
});

// FORM_ADD.sangu.addEventListener('keyup', function (e) {
//   const val = this.value.split('Rp. ');
//   val.length > 1 ? (FORM_ADD.sangu.value = formatRupiah(val[1], 'Rp. ')) : (FORM_ADD.sangu.value = null);
// });