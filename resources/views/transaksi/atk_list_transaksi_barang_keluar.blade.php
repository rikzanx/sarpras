@extends('main')

@section('link')

<style>
    .dt-buttons button {
        margin-right: 5px;
    }

    .dt-buttons {
        margin-bottom: 20px;
        margin-top: 10px;
    }

</style>

@endsection

@section('judul')
List Transaksi Barang Keluar
@endsection

@section('isi')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card px-4">
                <div class="card-header mt-4 py-2 px-1 d-flex justify-content-between align-items-center">
                    <h4>Data Barang</h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modaltambah">+ Add Transaksi Keluar</button>
                </div>
                <div class="card-datatable table-responsive mb-4 mt-4 dt-buttons display nowrap" style="width:100%">
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Group</th>
                                <th style="text-align: center;">Tanggal</th>
                                <th style="text-align: center;">Deskripsi</th>
                                <th style="text-align: center;">Nama Penerima</th>
                                <th style="text-align: center;">Jumlah Jenis Barang</th>
                                <th style="text-align: center;">Jumlah Kuantitas Barang</th>
                                <th style="text-align: center; width:5px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi_barang_keluar as $index => $item)
                            <tr>
                                <td style="text-align: center;">{{ $index+1 }}</td>
                                <td>{{ $item->group->nama }}</td>
                                <td style="text-align: center;">{{ $item->tanggal}}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->penerima }}</td>
                                <td>{{ $item->transaksi_barangs_count }}</td>
                                <td>{{ $item->total_barang }}</td>
                                <td style="text-align: center;">
                                    <div class="demo-inline-spacing">
                                        <button type="button" class="btn btn-icon btn-primary" onclick="modalshow('{{ Crypt::encryptString($item->id_transaksi) }}')">
                                            <span class="tf-icons bx bx-show-alt"></span>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-warning" onclick="modaledit('{{ Crypt::encryptString($item->id_transaksi) }}')">
                                            <span class="tf-icons bx bx-edit"></span>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-danger" onclick="modaldelete('{{ Crypt::encryptString($item->id_transaksi) }}')">
                                            <span class="tf-icons bx bx-eraser"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modaltambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('atk_add_transaksi_barang_keluar_action') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Tanggal Transaksi</label>
                            <input type="datetime-local" class="form-control" name="tanggal" >
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label  class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" placeholder="Enter Deskripsi" name="deskripsi" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="penerima" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            List Barang:
                        </div>
                        <div class="col-2 d-grid gap-2">
                            <button type="button" class="btn btn-primary add-item">
                            <span class="tf-icons bx bx-plus"></span> Barang
                            </button>
                        </div>
                    </div>
                    <div class="dynamic-items">
                        <div class="row item-row mb-3">
                            <div class="col-9">
                                <label for="barang[0][id_barang]" class="form-label">Pilih Barang</label>
                                <select class="form-control" name="barang[0][id_barang]" required>
                                    <option selected disabled>Pilih Barang</option>
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->id_barang }}">{{ $item->nama }} ({{ $item->satuan->nama }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="barang[0][quantity]" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="barang[0][quantity]" value="1" required>
                            </div>
                            <div class="col-1">
                                <label class="form-label">&nbsp;</label>
                                <div class="mx-auto">
                                    <button type="button" class="btn btn-icon btn-danger remove-item">
                                        <span class="tf-icons bx bx-eraser"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="input" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Tambah -->

<!-- Modal Show -->
<div class="modal fade" id="modalshow" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="#" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Tanggal Transaksi</label>
                            <input type="datetime-local" class="form-control" name="tanggal" >
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label  class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" placeholder="Enter Deskripsi" name="deskripsi" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="penerima" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            List Barang:
                        </div>
                    </div>
                    <div class="dynamic-items">
                        <div class="row item-row mb-3">
                            <div class="col-9">
                                <label for="barang[0][id_barang]" class="form-label">Pilih Barang</label>
                                <select class="form-control" name="barang[0][id_barang]" required>
                                    <option selected disabled>Pilih Barang</option>
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->id_barang }}">{{ $item->nama }} ({{ $item->satuan->nama }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="barang[0][quantity]" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="barang[0][quantity]" value="1" required>
                            </div>
                            <div class="col-1">
                                <label class="form-label">&nbsp;</label>
                                <div class="mx-auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- End Modal Show -->

 <!-- Modal Edit -->
<div class="modal fade" id="modaledit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('atk_edit_transaksi_barang_keluar_action',':id') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Tanggal Transaksi</label>
                            <input type="datetime-local" class="form-control" name="tanggal" >
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label  class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" placeholder="Enter Deskripsi" name="deskripsi" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="penerima" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            List Barang:
                        </div>
                        <div class="col-2 d-grid gap-2">
                            <button type="button" class="btn btn-primary add-item">
                            <span class="tf-icons bx bx-plus"></span> Barang
                            </button>
                        </div>
                    </div>
                    <div class="dynamic-items">
                        <div class="row item-row mb-3">
                            <div class="col-9">
                                <label for="barang[0][id_barang]" class="form-label">Pilih Barang</label>
                                <select class="form-control" name="barang[0][id_barang]" required>
                                    <option selected disabled>Pilih Barang</option>
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->id_barang }}">{{ $item->nama }} ({{ $item->satuan->nama }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="barang[0][quantity]" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="barang[0][quantity]" value="1" required>
                            </div>
                            <div class="col-1">
                                <label class="form-label">&nbsp;</label>
                                <div class="mx-auto">
                                    <button type="button" class="btn btn-icon btn-danger remove-item">
                                        <span class="tf-icons bx bx-eraser"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="input" class="btn btn-warning">Edit Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- End Modal Edit -->

<!-- Modal Delete -->
<div class="modal fade" id="modaldelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <form action="{{  route('atk_delete_transaksi_barang_keluar_action',':id') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <h6>Apakah yakin anda akan menghapus data ini?</h6>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-danger">Hapus Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Delete -->
@endsection


@section('script')

<script>
    let lastItemIndex = 0;
    function modalshow(id) {
        $.ajax({
            url: `{{ route('atk_show_transaksi_barang', ':id') }}`.replace(':id', id),
            method: 'GET',
            success: function (data) {
                console.log(data);
                $('#modalshow input[name="nama"]').val(data.nama);
                $('#modalshow input[name="tanggal"]').val(data.tanggal);
                $('#modalshow input[name="deskripsi"]').val(data.deskripsi);
                $('#modalshow input[name="penerima"]').val(data.penerima);
                $('#modalshow select[name="id_group"]').val(data.id_group);
                $('#modalshow select[name="id_satuan"]').val(data.id_satuan);
                $('#modalshow .dynamic-items').html('');

                data.transaksi_barangs.forEach((item, index) => {
                    const newItem = `
                        <div class="row item-row mb-3">
                            <div class="col-9">
                                <label for="barang[${index}][id_barang]" class="form-label">Pilih Barang</label>
                                <select class="form-control" name="barang[${index}][id_barang]" required disabled>
                                    <option selected disabled>Pilih Barang</option>
                                    @foreach ($barang as $barangItem)
                                        <option value="{{ $barangItem->id_barang }}">
                                            {{ $barangItem->nama }} ({{ $barangItem->satuan->nama }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="barang[${index}][quantity]" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="barang[${index}][quantity]" value="${item.quantity}" required disabled>
                            </div>
                            <div class="col-1">
                                <label class="form-label">&nbsp;</label>
                                <div class="mx-auto">
                                </div>
                            </div>
                        </div>
                    `;

                    const dynamicItems = $('#modalshow .dynamic-items');
                    dynamicItems.append(newItem);

                    const selectElement = dynamicItems.find(`select[name="barang[${index}][id_barang]"]`);
                    selectElement.val(item.id_barang);
                });

                $('#modalshow').modal('show');
            },
            error: function (err) {
                alert('Gagal mengambil data transaksi');
            }
        });
    }

    function modaledit(id){
        lastItemIndex = 0;
        $.ajax({
            url: `{{ route('atk_show_transaksi_barang', ':id') }}`.replace(':id', id),
            method: 'GET',
            success: function (data) {
                console.log(data);
                let url = $('#modaledit form').attr('action');
                $('#modaledit form').attr('action',url.replace(':id',id));
                $('#modaledit input[name="nama"]').val(data.nama);
                let tanggal = data.tanggal;
                let formattedDate = tanggal.replace(' ','T').slice(0,16);
                $('#modaledit input[name="tanggal"]').val(formattedDate);
                $('#modaledit input[name="deskripsi"]').val(data.deskripsi);
                $('#modaledit input[name="penerima"]').val(data.penerima);
                $('#modaledit select[name="id_group"]').val(data.id_group);
                $('#modaledit select[name="id_satuan"]').val(data.id_satuan);
                $('#modaledit .dynamic-items').html('');

                data.transaksi_barangs.forEach((item, index) => {
                    const newItem = `
                        <div class="row item-row mb-3">
                            <div class="col-9">
                                <label for="barang[${index}][id_barang]" class="form-label">Pilih Barang</label>
                                <select class="form-control" name="barang[${index}][id_barang]" required>
                                    <option selected disabled>Pilih Barang</option>
                                    @foreach ($barang as $barangItem)
                                        <option value="{{ $barangItem->id_barang }}">
                                            {{ $barangItem->nama }} ({{ $barangItem->satuan->nama }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="barang[${index}][quantity]" class="form-label">Jumlah</label>
                                <input type="hidden" name="barang[${index}][id_transaksi_barang]" value="${item.id_transaksi_barang}">
                                <input type="number" class="form-control" name="barang[${index}][quantity]" value="${item.quantity}" required>
                            </div>
                            <div class="col-1">
                                <label class="form-label">&nbsp;</label>
                                <div class="mx-auto">
                                    <button type="button" class="btn btn-icon btn-danger remove-item">
                                        <span class="tf-icons bx bx-eraser"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;

                    const dynamicItems = $('#modaledit .dynamic-items');
                    dynamicItems.append(newItem);

                    const selectElement = dynamicItems.find(`select[name="barang[${index}][id_barang]"]`);
                    selectElement.val(item.id_barang);
                    lastItemIndex++;
                });

                $('#modaledit').modal('show');
            },
            error: function (err) {
                alert('Gagal mengambil data transaksi');
            }
        });
    }
    function modaldelete(id) {
        var url = $('#modaldelete form').attr('action');
        $('#modaldelete form').attr('action', url.replace(':id', id));
        $('#modaldelete').modal('show');
    }
    $(document).ready(function () {
        let itemIndex = 1;
        $('#modaltambah .add-item').on('click', function () {
            console.log('clicked');
            const newItem = `
                <div class="row item-row mb-3">
                    <div class="col-9">
                        <label for="barang[${itemIndex}][id_barang]" class="form-label">Pilih Barang</label>
                        <select class="form-control" name="barang[${itemIndex}][id_barang]" required>
                            <option selected disabled>Pilih Barang</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id_barang }}">{{ $item->nama }} ({{ $item->satuan->nama }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <label for="barang[${itemIndex}][quantity]" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="barang[${itemIndex}][quantity]" value="1" required>
                    </div>
                    <div class="col-1">
                        <label class="form-label">&nbsp;</label>
                        <div class="mx-auto">
                            <button type="button" class="btn btn-icon btn-danger remove-item">
                                <span class="tf-icons bx bx-eraser"></span>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $('#modaltambah .dynamic-items').append(newItem);
            itemIndex++;
        });
        $('#modaltambah .dynamic-items').on('click', '.remove-item', function () {
            $(this).closest('.item-row').remove();
        });
        $('#modaledit .add-item').on('click', function () {
            console.log(lastItemIndex);
            const newItem = `
                <div class="row item-row mb-3">
                    <div class="col-9">
                        <label for="barang[${lastItemIndex}][id_barang]" class="form-label">Pilih Barang</label>
                        <select class="form-control" name="barang[${lastItemIndex}][id_barang]" required>
                            <option selected disabled>Pilih Barang</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id_barang }}">{{ $item->nama }} ({{ $item->satuan->nama }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <label for="barang[${lastItemIndex}][quantity]" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="barang[${lastItemIndex}][quantity]" value="1" required>
                    </div>
                    <div class="col-1">
                        <label class="form-label">&nbsp;</label>
                        <div class="mx-auto">
                            <button type="button" class="btn btn-icon btn-danger remove-item">
                                <span class="tf-icons bx bx-eraser"></span>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $('#modaledit .dynamic-items').append(newItem);
            lastItemIndex++;
        });
        $('#modaledit .dynamic-items').on('click', '.remove-item', function () {
            $(this).closest('.item-row').remove();
        });
        $('#myTable').DataTable({
            scrollX: true,
            responsive: true,
            autoWidth: false,
            dom: 'Blfrtip', // 'B' untuk Buttons, 'f' untuk filter, 'r' untuk processing, 't' untuk table, 'i' untuk info, 'p' untuk pagination
            buttons: [{
                    extend: 'copyHtml5',
                    text: '<i class="ri-file-text-line me-1"></i> Copy',
                    className: 'btn btn-primary'
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="ri-file-excel-line me-1"></i> Excel',
                    className: 'btn btn-primary'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="ri-file-pdf-line me-1"></i> PDF',
                    className: 'btn btn-primary'
                },
                {
                    extend: 'print',
                    text: '<i class="ri-printer-line me-1"></i> Print',
                    className: 'btn btn-primary'
                }
            ],
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            pageLength: 10
        });
    });

</script>

@endsection