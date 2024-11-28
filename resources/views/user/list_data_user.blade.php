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
                        data-bs-target="#modaltambah">+ Add User</button>
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
                                        <button type="button" class="btn btn-icon btn-primary" onclick="modalshow('{{ Crypt::encryptString($item->id_user) }}')">
                                            <span class="tf-icons bx bx-show-alt"></span>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-primary" onclick="modaledit('{{ Crypt::encryptString($item->id_user) }}')">
                                            <span class="tf-icons bx bx-edit"></span>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-primary" onclick="modaldelete('{{ Crypt::encryptString($item->id_user) }}')">
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
                            <select class="form-control" name="level_user" >
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
                            <input type="text"  class="form-control" placeholder="Enter Name" name="nik" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Nama</label>
                            <input type="text"  class="form-control" placeholder="Enter Name" name="nama" />
                        </div>
                    </div>
                    <img src="{{ asset('assets/img/foto_profil/default.png') }}" class="img-fluid preview_foto" width="100px">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailExLarge" class="form-label">Foto Profil</label>
                            <input type="file"  class="form-control" placeholder="xxxx@xxx.xx" name="foto" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailExLarge" class="form-label">Email</label>
                            <input type="text"  class="form-control" placeholder="xxxx@xxx.xx" name="email" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="emailExLarge" class="form-label">Password</label>
                            <input type="password"  class="form-control" placeholder="*****" name="password"/>
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

<!-- Modal Show -->
<div class="modal fade" id="modalshow" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Show Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Level User</label>
                            <select class="form-control" name="level_user"  disabled>
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
                            <input type="text"  class="form-control" placeholder="Enter Name" name="nik" disabled/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Nama</label>
                            <input type="text"  class="form-control" placeholder="Enter Name" name="nama" disabled/>
                        </div>
                    </div>
                    <img src="{{ asset('assets/img/foto_profil/default.png') }}" class="img-fluid preview_foto" width="100px">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailExLarge" class="form-label">Email</label>
                            <input type="text"  class="form-control" placeholder="xxxx@xxx.xx" name="email" disabled/>
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
            <form action="{{  route('edit_user_action',':id') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Level User</label>
                            <select class="form-control" name="level_user" >
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
                            <input type="text"  class="form-control" placeholder="Enter Name" name="nik" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Nama</label>
                            <input type="text"  class="form-control" placeholder="Enter Name" name="nama" />
                        </div>
                    </div>
                    <img src="{{ asset('assets/img/foto_profil/default.png') }}" class="img-fluid preview_foto" width="100px">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailExLarge" class="form-label">Foto Profil</label>
                            <input type="file"  class="form-control" placeholder="xxxx@xxx.xx" name="foto" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="emailExLarge" class="form-label">Email</label>
                            <input type="text"  class="form-control" placeholder="xxxx@xxx.xx" name="email" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="emailExLarge" class="form-label">Password *Kosongi jika tidak diganti</label>
                            <input type="password"  class="form-control" placeholder="*****" value="" name="password" autocomplete="new-password"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Edit Data</button>
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
            <form action="{{  route('delete_user_action',':id') }}" method="post" enctype="multipart/form-data">
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
        // alert(id);
        var url = $('#modaldelete form').attr('action');
        $('#modaldelete form').attr('action', url.replace(':id', id));
        $('#modaldelete').modal('show');
    }
    function modalshow(id){
        $.ajax({
            url: `{{ route('show_user_data', ':id') }}`.replace(':id', id),
            method: 'GET',
            success: function(data){
                console.log(data);
                $('#modalshow input[name="nik"]').val(data.nik);
                $('#modalshow input[name="nama"]').val(data.nama);
                $('#modalshow input[name="email"]').val(data.email);
                $('#modalshow select[name="level_user"]').val(data.id_level_user);
                $('#modalshow .preview_foto').attr('src', "{{ asset('assets/img/foto_profil/:path')}}".replace(':path',data.profile_photo_path));
                $('#modalshow').modal('show');
            },
            error: function(err){
                alert('Gagal mengambil data user');
            }
        });
    }
    function modaledit(id){
        $.ajax({
            url: `{{ route('show_user_data', ':id') }}`.replace(':id', id),
            method: 'GET',
            success: function(data){
                let url = $('#modaledit form').attr('action');
                $('#modaledit form').attr('action',url.replace(':id',id));
                $('#modaledit input[name="nik"]').val(data.nik);
                $('#modaledit input[name="nama"]').val(data.nama);
                $('#modaledit input[name="email"]').val(data.email);
                $('#modaledit select[name="level_user"]').val(data.id_level_user);
                $('#preview_foto').attr('src', "{{ asset('assets/img/foto_profil/:path')}}".replace(':path',data.profile_photo_path));
                $('#modaledit').modal('show');
            },
            error: function(err){
                alert('Gagal mengambil data user');
            }
        });

    }
    $(document).ready(function () {
        $('input[name="foto"').on('change',function(){
            let file = this.files[0];
            if(file){
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('.preview_foto').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }else {
                $('.preview_foto').attr('src', "");
            }
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
