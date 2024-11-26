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
List Data User
@endsection

@section('isi')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card px-4">
                <div class="card-header mt-4 py-2 px-1 d-flex justify-content-between align-items-center">
                    <h4>Data User</h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exLargeModal">+ Add User</button>
                </div>
                <div class="card-datatable table-responsive mb-4 mt-4 dt-buttons display nowrap" style="width:100%">
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 10px;">No</th>
                                <th style="text-align: center; width: 10px;">Foto</th>
                                <th style="text-align: center; width: 10px;">NIK</th>
                                <th style="text-align: center; width: 30px;">Nama</th>
                                <th style="text-align: center; width: 20px;">Email</th>
                                <th style="text-align: center; width: 20px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $index => $item)
                            <tr>
                                <td style="text-align: center;">{{ $index+1 }}</td>
                                <td style="text-align: center;">
                                    <img src="{{ asset('assets/img/foto_profil/'.$item->profile_photo_path)}}" class="d-block rounded" height="100" width="100">
                                </td>
                                <td style="text-align: center;">{{$item->nik}}</td>
                                <td style="text-align: center;">{{$item->nama}}</td>
                                <td style="text-align: center;">{{$item->email}}</td>
                                <td style="text-align: center;">
                                    <div class="demo-inline-spacing">
                                        <button type="button" class="btn btn-icon btn-primary" onclick="modaledit({{$item->id}})">
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


<!-- Modal Tambah -->
<div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('add_user_action') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Level User</label>
                            <select class="form-control" name="level_user" id="level_user">
                            <option selected disabled>Pilih Level User</option>
                                        @foreach ($level_user as $item)
                                        <option value="{{ $item->id_level_user }}">{{ $item->level_user }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">NIK</label>
                            <input type="text" id="nameExLarge" class="form-control" placeholder="Enter Name" name="nik" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Nama</label>
                            <input type="text" id="nameExLarge" class="form-control" placeholder="Enter Name" name="nama" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailExLarge" class="form-label">Foto Profil</label>
                            <input type="file" id="emailExLarge" class="form-control" placeholder="xxxx@xxx.xx" name="foto" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailExLarge" class="form-label">Email</label>
                            <input type="text" id="emailExLarge" class="form-control" placeholder="xxxx@xxx.xx" name="email" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="emailExLarge" class="form-label">Password</label>
                            <input type="password" id="emailExLarge" class="form-control" placeholder="*****" name="password"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Tambah -->

<!-- Modal Edit -->
<div class="modal fade" id="modaledit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('add_user_action') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Level User</label>
                            <select class="form-control" name="level_user" id="level_user">
                            <option selected disabled>Pilih Level User</option>
                                        @foreach ($level_user as $item)
                                        <option value="{{ $item->id_level_user }}">{{ $item->level_user }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">NIK</label>
                            <input type="text" id="nameExLarge" class="form-control" placeholder="Enter Name" name="nik" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Nama</label>
                            <input type="text" id="nameExLarge" class="form-control" placeholder="Enter Name" name="nama" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailExLarge" class="form-label">Foto Profil</label>
                            <input type="file" id="emailExLarge" class="form-control" placeholder="xxxx@xxx.xx" name="foto" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailExLarge" class="form-label">Email</label>
                            <input type="text" id="emailExLarge" class="form-control" placeholder="xxxx@xxx.xx" name="email" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="emailExLarge" class="form-label">Password</label>
                            <input type="password" id="emailExLarge" class="form-control" placeholder="*****" name="password"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Edit -->
@endsection


@section('script')

<script>
    function modaldelete(id) {
        // alert(id);
        var url = $('.delete-form').attr('action');
        $('.delete-form').attr('action', url.replace(':id', id));
        $('#deleteModal').modal('show');
    }
    function modaledit(id){

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
