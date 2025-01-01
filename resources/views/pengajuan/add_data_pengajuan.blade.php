@extends('main')

@section('link')

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
                        <div class="col-sm-2" style="text-align:center">
                            <img style="height: 70px; text-align: center; vertical-align : middle;text-align:center" src="{{ asset('assets\img\logopetro.png')}}"" alt="" data-original-title="" title="">
                        </div>

                        <div class="col-sm-8" style="text-align:center">
                            <h5>FORM PERMINTAAN, PENUKARAN & PENGEMBALIAN BARANG INVENTARIS</h5>
                            <h5>DEPARTEMEN KEAMANAN</h5>
                        </div>

                        <div class="col-sm-2" style="text-align:center">
                            <img style="height: 90px; text-align: center; vertical-align : middle;text-align:center" src="{{ asset('assets\img\logosmp.png')}}"" alt="" data-original-title="" title="">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="my-1">
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
                                    <td>Admin ...............</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <br>
                    <br>
                    <div class="my-1">
                        <table>
                            <tr>
                                <td>Dengan ini kami mohon untuk memberikan atau menukarkan barang terlampir sbb:</td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <div class="table-responsive border rounded border-bottom-0 mb-4">
                        <table class="table m-0 sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center">No</th>
                                    <th style="text-align: center">Nama Barang</th>
                                    <th style="text-align: center">Jumlah</th>
                                    <th style="text-align: center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center">1</td>
                                    <td style="text-align: left">Spidol Permanen</td>
                                    <td style="text-align: center">2 Ea</td>
                                    <td style="text-align: center">Habis Bos!!!</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Yang meminta</th>
                                    <th></th>
                                    <th>Gresik,................<br>Yang menerima</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><br><br><br><br></td>
                                    <td><br><br><br><br></td>
                                    <td><br><br><br><br></td>
                                </tr>
                                <tr>
                                    <td>Nama : .................. <br>NIK :</td>
                                    <td></td>
                                    <td>Nama : .................. <br>NIK :</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection


@section('script')



@endsection
