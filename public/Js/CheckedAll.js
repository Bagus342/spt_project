const checkAll = document.getElementById('check-all');
const URL = document.getElementById('url').value;
const TOKEN = document.getElementById('token').value;

checkAll.onchange = function () {
  let cl = document.getElementsByClassName('cl');
  if (cl !== null) {
    if (this.checked) {
      for (let i = 0; i < cl.length; i++) {
        cl[i].checked = true;
        array.push({ in: cl[i].value })
        document.getElementById('bayar').disabled = false;
      }
    } else {
      for (let i = 0; i < cl.length; i++) {
        cl[i].checked = false;
        array.map((x) => {
          deleteArray(x.in)
        })
        console.log(array)
        document.getElementById('bayar').disabled = true;
      }
    }
  }
};

let array = [];

function ch() {
  const cl = document.getElementsByClassName('cl');
  for (let i = 0; i < cl.length; i++) {
    cl[i].onchange = function () {
      if (cl[i].checked) {
        document.getElementById('bayar').disabled = false;
        array.push({ in: cl[i].value });
      } else {
        array.map((x) => {
          if (x.in === cl[i].value) {
            deleteArray(cl[i].value);
            if (array.length === 0) {
              checkAll.checked = false
              document.getElementById('bayar').disabled = true;
            }
          }
        });
      }
    };
  }
}

function deleteArray(val) {
  array = array.filter((u) => u.in != val);
}

ch();

document.getElementById('filter').addEventListener('click', function () {
  getSopir();
});

document.querySelector('select[name=pilih]').onchange = function () {
  if (this.value === 'Pilih Petani') {
    const ds = document.querySelectorAll('input[type=checkbox]');
    for (let i = 0; i < ds.length; i++) {
      ds[i].disabled = true;
    }
  }
};

function getSopir() {
  const sopir = document.querySelector('select[name=pilih]').value;
  fetch(URL + '/pilih?name=' + sopir)
    .then((res) => res.json())
    .then((res) => {
      document.getElementById('list-data').innerHTML = parse(res.pembayaran);
      res.type === 'base' ? dCheckbox() : oCheckbox();
      // res.type === 'base'
      //     ? (document.getElementById('bayar').disabled = true)
      //     : (document.getElementById('bayar').disabled = false);
      ch();
    });
}

const parse = (data) => {
  let html = '';
  data.map((res) => {
    html += htmldata(res);
  });
  return html;
};

const dCheckbox = () => {
  const ds = document.querySelectorAll('input[type=checkbox]');
  for (let i = 0; i < ds.length; i++) {
    ds[i].disabled = true;
  }
};

const oCheckbox = () => {
  const ds = document.querySelectorAll('input[type=checkbox]');
  for (let i = 0; i < ds.length; i++) {
    ds[i].disabled = false;
  }
};

const htmldata = (item) => {
  const total = item.harga * item.netto_pulang;
  if (item.tanggal_bayar != null) {
    return /* html */ `
        <td colspan="9" style="text-align: center;">DATA KOSONG</td>`;
  } else {
    return /*html*/ `<tr>
    <td><input type="checkbox" class="cl" name="id[]" value="${item.id_keberangkatan}" disabled /></td>
    <td>${formatTanggal(item.tanggal_pulang)}</td>
    <td>${item.tipe}</td>
    <td>${item.no_sp}</td>
    <td>${item.nama_petani}</td>
    <td>${item.nama_sopir}</td>
    <td>${item.pabrik_tujuan}</td>
    <td>${formatTanggal(item.tanggal_keberangkatan)}</td>
    <td>${item.no_induk}</td>
    <td>${item.no_truk}</td>
    <td>${item.netto_pulang}</td>
    <td>${formatRupiah(item.harga.toString(), 'Rp ')}</td>
    <td>${formatRupiah(total.toString(), 'Rp ')}</td>
</tr>`;
  }
};

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
