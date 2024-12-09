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
List Data Pengajuan | Sarpras Depkam
@endsection

@section('isi')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <div class="col-xxl">
            <div class="col-xl-12">
                <div class="nav-align-top mb-6">
                    <ul class="nav nav-pills mb-4 nav-fill" role="tablist">
                        <li class="nav-item mb-1 mb-sm-0" role="presentation">
                            <button type="button" class="nav-link active waves-effect waves-light" role="tab"
                                data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home"
                                aria-controls="navs-pills-justified-home" aria-selected="true">
                                <i class='bx bxs-hourglass-top'></i> Reviewer
                                <span
                                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1_5 pt-50">5</span>
                            </button>
                        </li>
                        <li class="nav-item mb-1 mb-sm-0" role="presentation">
                            <button type="button" class="nav-link waves-effect waves-light" role="tab"
                                data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile"
                                aria-controls="navs-pills-justified-profile" aria-selected="false" tabindex="-1">
                                <i class='bx bx-check-square'></i> Approve
                                <span
                                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1_5 pt-50">7</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link waves-effect waves-light" role="tab"
                                data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages"
                                aria-controls="navs-pills-justified-messages" aria-selected="false" tabindex="-1">
                                <i class='bx bxs-x-square'></i> Reject
                                <span
                                    class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1_5 pt-50">3</span>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                            <div class="card-header mt-4 py-2 px-1 d-flex justify-content-between align-items-center">
                                <h4>List Pengajuan</h4>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modaltambah">+ Add Transaksi Masuk</button>
                            </div>
                            <div class="card-body">
                                <table id="tableReviewer" class="datatables-category-list table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl Pengajuan</th>
                                            <th>Dari</th>
                                            <th>Transaksi</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                            <div class="card-header mt-4 py-2 px-1 d-flex justify-content-between align-items-center">
                                <h4>List Pengajuan</h4>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modaltambah">+ Add Transaksi Masuk</button>
                            </div>
                            <div class="card-body">
                                <table id="tableApprove" class="datatables-category-list table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl Pengajuan</th>
                                            <th>Dari</th>
                                            <th>Transaksi</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                            <div class="card-header mt-4 py-2 px-1 d-flex justify-content-between align-items-center">
                                <h4>List Pengajuan</h4>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modaltambah">+ Add Transaksi Masuk</button>
                            </div>
                            <div class="card-body">
                                <table id="tableReject" class="datatables-category-list table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl Pengajuan</th>
                                            <th>Dari</th>
                                            <th>Transaksi</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                        <label for="nameExLarge" class="form-label">Nama Satuan</label>
                        <input type="text" id="nameExLarge" class="form-control" placeholder="Enter Name" />
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                        <label for="emailExLarge" class="form-label">Deskripsi</label>
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
    $(document).ready(function () {
        $('#tableReviewer').DataTable({
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

        $('#tableApprove').DataTable({
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

        $('#tableReject').DataTable({
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
