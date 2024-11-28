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
List Data Barang
@endsection

@section('isi')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card px-4">
                <div class="card-header mt-4 py-2 px-1 d-flex justify-content-between align-items-center">
                    <h4>Data Barang</h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exLargeModal">+ Add Barang</button>
                </div>
                <div class="card-datatable table-responsive mb-4 mt-4 dt-buttons display nowrap" style="width:100%">
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Nama Group</th>
                                <th style="text-align: center;">Nama Barang</th>
                                <th style="text-align: center;">Deskripsi</th>
                                <th style="text-align: center;">Satuan</th>
                                <th style="text-align: center; width:5px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangs as $index => $item)
                            <tr>
                                <td style="text-align: center;">{{ $index+1 }}</td>
                                <td style="text-align: center;">{{ $item->group->nama }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->satuan->nama }}</td>
                                <td style="text-align: center;">
                                    <div class="demo-inline-spacing">
                                        <button type="button" class="btn btn-icon btn-primary">
                                            <span class="tf-icons bx bx-show-alt"></span>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-primary">
                                            <span class="tf-icons bx bx-edit"></span>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-primary">
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



<div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameExLarge" class="form-label">Nama Group</label>
                        <input type="text" id="nameExLarge" class="form-control" placeholder="Enter Name" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameExLarge" class="form-label">Nama Barang</label>
                        <input type="text" id="nameExLarge" class="form-control" placeholder="Enter Name" />
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                        <label for="emailExLarge" class="form-label">Deskripsi</label>
                        <input type="text" id="emailExLarge" class="form-control" placeholder="Enter Name" />
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                        <label for="emailExLarge" class="form-label">Satuan</label>
                        <input type="text" id="emailExLarge" class="form-control" placeholder="Enter Name" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary">Tambah Data</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')

<script>
    function modaldelete(id) {
        // alert(id);
        var url = $('.delete-form').attr('action');
        $('.delete-form').attr('action', url.replace(':id', id));
        $('#deleteModal').modal('show');
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
