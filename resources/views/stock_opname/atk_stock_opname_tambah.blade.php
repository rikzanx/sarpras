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
Tambah Stock Opname Barang ATK | Sarpras Depkam
@endsection

@section('isi')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card px-4">
                <div class="card-header mt-4 py-2 px-1 d-flex justify-content-between align-items-center">
                    <h4>Tambah Stock Opname Barang ATK</h4>
                </div>
                <div class="card">
                    <p>Lakukan perhitungan stock fisik dan input di bawah</p>
                    <form action="{{ route('atk_stock_opname_tambah_action') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Tanggal Stock Opname</label>
                                <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label  class="form-label">Deskripsi</label>
                                <input type="text" class="form-control" placeholder="Enter Deskripsi" name="deskripsi" />
                            </div>
                        </div>
                        @foreach($barangs as $index => $item)
                        <div class="row item-row mb-3">
                            <div class="col-4">
                                <input type="hidden" name="barang[{{$index}}][id_barang]" value="{{ $item->id_barang }}">
                                <label for="barang[{{$index}}][nama_barang]" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" name="barang[{{$index}}][nama_barang]" value="{{ $item->nama }} ({{ $item->satuan->nama }})" disabled>
                            </div>
                            <div class="col-2">
                                <input type="hidden" name="barang[{{$index}}][stock_sistem]" value="{{ $item->stock->available_stock }}">
                                <label for="barang[{{$index}}][available_stock]" class="form-label">Stock Sistem</label>
                                <input type="text" class="form-control" name="barang[{{$index}}][available_stock]" value="{{ $item->stock->available_stock }}" disabled>
                            </div>
                            <div class="col-2">
                                <label for="barang[{{$index}}][stock_fisik]" class="form-label">Stock Fisik</label>
                                <input type="number" class="form-control" name="barang[{{$index}}][stock_fisik]" value="0" required>
                            </div>
                            <div class="col-4">
                                <label for="barang[{{$index}}][alasan]" class="form-label">Isi Alasan (Apabila stock tidak sesuai)</label>
                                <input type="text" class="form-control" name="barang[{{$index}}][alasan]" placeholder="Alasan" value="" required>
                            </div>
                        </div>
                        @endforeach
                        <div class="row mb-3">
                            <div class="col-12">
                            <a href="{{ route('atk_stock_opname') }}" class="btn btn-outline-secondary">Back</a>
                            <button type="input" class="btn btn-primary">Tambah Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modaldelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <form action="{{  route('delete_barang_action',':id') }}" method="post" enctype="multipart/form-data">
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
    function modaldelete(id) {
        var url = $('#modaldelete form').attr('action');
        $('#modaldelete form').attr('action', url.replace(':id', id));
        $('#modaldelete').modal('show');
    }
    $(document).ready(function () {
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
