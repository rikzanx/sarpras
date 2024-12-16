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
Stock Opname Barang ISMS | Sarpras Depkam
@endsection

@section('isi')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card px-4">
                <div class="card-header mt-4 py-2 px-1 d-flex justify-content-between align-items-center">
                    <h4>Stock Opname Barang ISMS</h4>
                    <a href="{{ route('isms_stock_opname_tambah') }}" class="btn btn-primary text-white">+ Add Stock Opname</a>
                </div>
                <div class="card-datatable table-responsive mb-4 mt-4 dt-buttons display nowrap" style="width:100%">
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">User</th>
                                <th style="text-align: center;">Deskripsi</th>
                                <th style="text-align: center;">Hasil</th>
                                <th style="text-align: center;">Tanggal</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stock_opname as $index => $item)
                            <tr>
                                <td style="text-align: center;">{{ $index+1 }}</td>
                                <td style="text-align: center;">{{ $item->user->nama }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->total_selisih ?? '0' }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td style="text-align: center;">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('isms_stock_opname_show',Crypt::encryptString($item->id_stock_opname)) }}" class="btn btn-icon btn-primary text-white">
                                            <span class="tf-icons bx bx-show-alt"></span>
                                        </a>
                                        <button type="button" class="btn btn-icon btn-danger" onclick="modaldelete('{{ Crypt::encryptString($item->id_stock_opname) }}')">
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

<!-- Modal Delete -->
<div class="modal fade" id="modaldelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <form action="{{  route('isms_stock_opname_delete_action',':id') }}" method="post" enctype="multipart/form-data">
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
            scrollX: false,
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
