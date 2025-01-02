@extends('main')

@section('link')

<style>
    /* Sesuaikan tinggi dan border Select2 */
.select2-container .select2-selection--single {
    height: calc(2.25rem + 2px); /* Sama dengan form-control */
    border: 1px solid #ced4da; /* Border Bootstrap */
    border-radius: 0.375rem; /* Radius Bootstrap */
    padding: 0.375rem 0.75rem; /* Padding Bootstrap */
    box-shadow: none; /* Hilangkan shadow */
}

/* Hilangkan background focus dan outline */
.select2-container .select2-selection--single:focus {
    outline: none;
    box-shadow: none;
    border-color: #80bdff; /* Warna fokus Bootstrap */
}

/* Sesuaikan warna placeholder */
.select2-container .select2-selection__placeholder {
    color: #6c757d; /* Warna placeholder Bootstrap */
}

/* Posisi ikon dropdown */
.select2-container .select2-selection__arrow {
    height: 100%;
    top: 50%;
    transform: translateY(-50%);
}

/* Atur dropdown agar tampak lebih bersih */
.select2-container .select2-dropdown {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
}
</style>

@endsection

@section('judul')
Form Pengajuan | Sarpras Depkam
@endsection

@section('isi')

<div class="container-xxl flex-grow-1 container-p-y">


    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12" style="text-align:center">
                            <h5>FORM PERMINTAAN, PENUKARAN & PENGEMBALIAN BARANG INVENTARIS</h5>
                            <h5>DEPARTEMEN KEAMANAN</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <div class="my-1">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="pe-4"><b>Kepada</b></td>
                                    <td>:</td>
                                    <td>Admin Departemen Kawasan</td>
                                </tr>
                                <tr>
                                    <td class="pe-4"><b>Dari</b></td>
                                    <td>:</td>
                                    <td>{{ auth()->user()->nama }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div> --}}

                    <br>
                    <div class="row">
                        <div class="col-10">

                        </div>
                        <div class="col-2">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary add-item">
                                <span class="tf-icons bx bx-plus"></span> Barang
                                </button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive border rounded border-bottom-0 mb-4">
                        <table class="table m-0 sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 5%;">No</th>
                                    <th style="text-align: center; width: 40%;">Nama Barang</th>
                                    <th style="text-align: center; width: 15%;">Jumlah</th>
                                    <th style="text-align: center; width: 35%;">Keterangan</th>
                                    <th style="text-align: center; width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="barang">
                                <tr>
                                    <td style="text-align: center">1</td>
                                    <td style="text-align: left">
                                        <select class="form-control" name="barang[0][id_barang]" required>
                                            <option selected disabled>Pilih Barang</option>
                                            @foreach ($barang as $item)
                                                <option value="{{ $item->id_barang }}">{{ $item->kategori->nama }} - {{ $item->nama }} ({{ $item->satuan->nama }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="text-align: center">
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="barang[0][quantity]">
                                            <span class="input-group-text">Satuan</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center">
                                        <div class="input-group input-group-merge">
                                            <textarea class="form-control" name="barang[0][keterangan]""></textarea>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mx-auto">
                                            <button type="button" class="btn btn-icon btn-danger remove-item">
                                                <span class="tf-icons bx bx-eraser"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2 col-lg-6 mx-auto">
                        <button class="btn btn-primary" type="button">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection


@section('script')

<script>


// Fungsi untuk inisialisasi Select2
function initializeSelect2() {
    $('.barang select').select2({
        placeholder: "Pilih Barang",
        allowClear: true,
        width: 'resolve' // Agar Select2 mengikuti lebar parent
    });
}

// Panggil fungsi inisialisasi saat dokumen siap
$(document).ready(function () {
    initializeSelect2(); // Inisialisasi awal
});

// Tambah baris baru ketika tombol "Barang" diklik
document.querySelector('.add-item').addEventListener('click', function () {
    const tbody = document.querySelector('.barang');
    const rowCount = tbody.children.length; // Hitung jumlah baris
    const newRow = document.createElement('tr'); // Buat elemen baris baru

    // Template baris baru
    newRow.innerHTML = `
        <td style="text-align: center">${rowCount + 1}</td>
        <td style="text-align: left">
            <select class="form-control" name="barang[${rowCount}][id_barang]" required>
                <option selected disabled>Pilih Barang</option>
                @foreach ($barang as $item)
                    <option value="{{ $item->id_barang }}">{{ $item->kategori->nama }} - {{ $item->nama }} ({{ $item->satuan->nama }})</option>
                @endforeach
            </select>
        </td>
        <td style="text-align: center">
            <div class="input-group">
                <input type="number" class="form-control" name="barang[${rowCount}][quantity]">
                <span class="input-group-text">Satuan</span>
            </div>
        </td>
        <td style="text-align: center">
            <div class="input-group input-group-merge">
                <textarea class="form-control" name="barang[${rowCount}][keterangan]"></textarea>
            </div>
        </td>
        <td>
            <div class="mx-auto">
                <button type="button" class="btn btn-icon btn-danger remove-item">
                    <span class="tf-icons bx bx-eraser"></span>
                </button>
            </div>
        </td>
    `;

    // Tambahkan baris baru ke dalam tbody
    tbody.appendChild(newRow);

    // Re-inisialisasi Select2 untuk elemen baru
    initializeSelect2();

    // Tambahkan event listener untuk tombol hapus
    newRow.querySelector('.remove-item').addEventListener('click', function () {
        newRow.remove();
        updateRowNumbers();
    });
});

// Fungsi untuk memperbarui nomor urut setelah penghapusan
function updateRowNumbers() {
    const rows = document.querySelectorAll('.barang tr');
    rows.forEach((row, index) => {
        row.querySelector('td:first-child').textContent = index + 1; // Update nomor urut
        row.querySelector('select').setAttribute('name', `barang[${index}][id_barang]`);
        row.querySelector('input[name*="[quantity]"]').setAttribute('name', `barang[${index}][quantity]`);
        row.querySelector('textarea[name*="[keterangan]"]').setAttribute('name', `barang[${index}][keterangan]`);
    });
}


</script>


@endsection
