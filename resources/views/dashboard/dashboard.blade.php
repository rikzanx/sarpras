@extends('main')

@section('link')

@endsection

@section('judul')
Dashboard
@endsection

@section('isi')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat Datang {{ auth()->user()->nama }}! 🎉</h5>
                            <p class="mb-4">
                                Setiap langkah kecil hari ini membawa kita lebih dekat pada tujuan besar di masa depan.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png')}}"
                                height="140" alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png')}}"
                                        alt="chart success" class="rounded" />
                                </div>
                            </div>
                            <span >Stock Tersedia</span>
                            <h3 class="card-title mb-2">{{ $overview['stock_tersedia'] }}</h3>
                            <small class="text-success fw-semibold"><i
                                    class="bx bx-up-arrow-alt"></i> +72.80%</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/wallet-info.png')}}"
                                        alt="Credit Card" class="rounded" />
                                </div>
                            </div>
                            <span>Barang Keluar</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $overview['jumlah_barang_keluar'] }}</h3>
                            <small class="text-success fw-semibold"><i
                                    class="bx bx-up-arrow-alt"></i> +28.42%</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png')}}"
                                        alt="chart success" class="rounded" />
                                </div>
                            </div>
                            <span >Barang Masuk</span>
                            <h3 class="card-title mb-2">{{ $overview['jumlah_barang_masuk'] }}</h3>
                            <small class="text-success fw-semibold"><i
                                    class="bx bx-up-arrow-alt"></i> +72.80%</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/wallet-info.png')}}"
                                        alt="Credit Card" class="rounded" />
                                </div>
                            </div>
                            <span>Rata" Barang Keluar</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $overview['rata_rata_barang_keluar'] }}</h3>
                            <small class="text-success fw-semibold"><i
                                    class="bx bx-up-arrow-alt"></i> +28.42%</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
        <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-12">
                        <h5 class="card-header m-0 me-2 pb-3">Total Transaksi</h5>
                        <div id="totalTransaksiChart" class="px-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Transactions -->
        <div class="col-md-12 col-lg-12 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Transaksi Terbaru</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="transactionID"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="transactionID">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @foreach($transaksi as $index => $item)
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    @if($item->tipe == "in")
                                    <img src="{{ asset('assets/img/icons/unicons/cc-success.png')}}" alt="User"
                                        class="rounded" />
                                    @else
                                    <img src="{{ asset('assets/img/icons/unicons/cc-warning.png')}}" alt="User"
                                        class="rounded" />
                                    @endif
                                </div>
                                <div
                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <p class="mb-1">
                                            {{ ($item->tipe == "in") ? 'Barang Masuk' : 'Barang Keluar' }}
                                            <small class="mb-1 text-muted">2024-11-28 10:13:00</small>
                                        </p>
                                        <h6 class="mb-0">{{ $item->deskripsi }}</h6>
                                        
                                </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0">{{ ($item->tipe == "in") ? '+' : '-' }}{{ $item->total_barang }}</h6>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Transactions -->
    </div>
</div>

@endsection


@section('script')
<script src="{{ asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection
