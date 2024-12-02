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
List Stock Barang ATK
@endsection

@section('isi')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card px-4">
                <div class="card-header mt-4 py-2 px-1 d-flex justify-content-between align-items-center">
                    <h4>List Stock Barang ATK</h4>
                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modaltambah">+ Add Barang</button> -->
                </div>
                <div class="card-datatable table-responsive mb-4 mt-4 dt-buttons display nowrap" style="width:100%">
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Nama Group</th>
                                <th style="text-align: center;">Nama Barang</th>
                                <th style="text-align: center;">Deskripsi</th>
                                <th style="text-align: center;">Stock Tersedia</th>
                                <th style="text-align: center;">Barang Masuk</th>
                                <th style="text-align: center;">Barang Keluar</th>
                                <th style="text-align: center;">Satuan</th>
                                <th style="text-align: center; width:5px;">Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangs as $index => $item)
                            <tr>
                                <td style="text-align: center;">{{ $index+1 }}</td>
                                <td style="text-align: center;">{{ $item->group->nama }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->stock->available_stock }}</td>
                                <td>{{ $item->total_barang_masuk ?? '0' }}</td>
                                <td>{{ $item->total_barang_keluar ?? '0' }}</td>
                                <td>{{ $item->satuan->nama }}</td>
                                <td>{{ $item->stock->updated_at }}</td>
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
            <form action="{{ route('add_barang_action') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Group</label>
                            <select class="form-control" name="id_group" >
                            <option selected disabled>Pilih Group</option>
                                        @foreach ($group as $item)
                                        <option value="{{ $item->id_group }}">{{ $item->nama }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="nama" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label  class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" placeholder="Enter Deskripsi" name="deskripsi" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-0">
                            <label for="nameExLarge" class="form-label">Satuan</label>
                            <select class="form-control" name="id_satuan" >
                            <option selected disabled>Pilih Satuan</option>
                                        @foreach ($satuan as $item)
                                        <option value="{{ $item->id_satuan }}">{{ $item->nama }}</option>
                                        @endforeach
                            </select>
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
                    <h5 class="modal-title" id="exampleModalLabel4">Show Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Group</label>
                            <select class="form-control" name="id_group" >
                            <option selected disabled>Pilih Group</option>
                                        @foreach ($group as $item)
                                        <option value="{{ $item->id_group }}">{{ $item->nama }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="nama" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label  class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" placeholder="Enter Deskripsi" name="deskripsi" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-0">
                            <label for="nameExLarge" class="form-label">Satuan</label>
                            <select class="form-control" name="id_satuan" >
                            <option selected disabled>Pilih Satuan</option>
                                        @foreach ($satuan as $item)
                                        <option value="{{ $item->id_satuan }}">{{ $item->nama }}</option>
                                        @endforeach
                            </select>
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
            <form action="{{ route('edit_barang_action',':id') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Eidt Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Group</label>
                            <select class="form-control" name="id_group" >
                            <option selected disabled>Pilih Group</option>
                                        @foreach ($group as $item)
                                        <option value="{{ $item->id_group }}">{{ $item->nama }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="nama" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label  class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" placeholder="Enter Deskripsi" name="deskripsi" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-0">
                            <label for="nameExLarge" class="form-label">Satuan</label>
                            <select class="form-control" name="id_satuan" >
                            <option selected disabled>Pilih Satuan</option>
                                        @foreach ($satuan as $item)
                                        <option value="{{ $item->id_satuan }}">{{ $item->nama }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="input" class="btn btn-primary">Edit Data</button>
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
    function modalshow(id){
        $.ajax({
            url: `{{ route('show_data_barang', ':id') }}`.replace(':id', id),
            method: 'GET',
            success: function(data){
                
                $('#modalshow input[name="nama"]').val(data.nama);
                $('#modalshow input[name="deskripsi"]').val(data.deskripsi);
                $('#modalshow select[name="id_group"]').val(data.id_group);
                $('#modalshow select[name="id_satuan"]').val(data.id_satuan);
                $('#modalshow').modal('show');
            },
            error: function(err){
                alert('Gagal mengambil data user');
            }
        });
    }
    function modaledit(id){
        $.ajax({
            url: `{{ route('show_data_barang', ':id') }}`.replace(':id', id),
            method: 'GET',
            success: function(data){
                let url = $('#modaledit form').attr('action');
                $('#modaledit form').attr('action',url.replace(':id',id));
                $('#modaledit input[name="nama"]').val(data.nama);
                $('#modaledit input[name="deskripsi"]').val(data.deskripsi);
                $('#modaledit select[name="id_group"]').val(data.id_group);
                $('#modaledit select[name="id_satuan"]').val(data.id_satuan);
                $('#modaledit').modal('show');
            },
            error: function(err){
                alert('Gagal mengambil data user');
            }
        });

    }
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
