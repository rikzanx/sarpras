@extends('main')

@section('link')

@endsection

@section('judul')
Dashboard | Sarpras Depkam
@endsection

@section('isi')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat Datang {{ auth()->user()->nama }}!</h5>
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
        <!-- ISMS Dashboard -->
        <div class="col-12 col-lg-12 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-12">
                        <h5 class="card-header m-0 me-2 pb-3">ISMS Dashboard</h5>
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
                                    <a href="{{ route('isms_stock_barang') }}">
                                      <img src="{{ asset('assets/img/icons/unicons/chart-success.png')}}"
                                          alt="chart success" class="rounded" />
                                    </a>
                                </div>
                            </div>
                            <span >Stock Tersedia</span>
                            <h3 class="card-title mb-2">{{ $overviewisms['stock_tersedia'] }}</h3>
                            <small class="text-success fw-semibold"></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <a href="{{ route('isms_list_transaksi_barang_keluar') }}">
                                      <img src="{{ asset('assets/img/icons/unicons/wallet-info.png')}}"
                                          alt="Credit Card" class="rounded" />
                                    </a>
                                </div>
                            </div>
                            <span>Barang Keluar</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $overviewisms['jumlah_barang_keluar'] }}</h3>
                            <small class="text-success fw-semibold"></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <a href="{{ route('isms_list_transaksi_barang_masuk') }}">
                                      <img src="{{ asset('assets/img/icons/unicons/chart-success.png')}}"
                                          alt="chart success" class="rounded" />
                                    </a>
                                </div>
                            </div>
                            <span >Barang Masuk</span>
                            <h3 class="card-title mb-2">{{ $overviewisms['jumlah_barang_masuk'] }}</h3>
                            <small class="text-success fw-semibold"></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <a href="{{ route('isms_list_transaksi_barang_keluar') }}">
                                      <img src="{{ asset('assets/img/icons/unicons/wallet-info.png')}}"
                                          alt="Credit Card" class="rounded" />
                                    </a>
                                </div>
                            </div>
                            <span>Rata" Barang Keluar</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $overviewisms['rata_rata_barang_keluar'] }}</h3>
                            <small class="text-success fw-semibold"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
        <div class="col-12 col-lg-12 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-12">
                        <h5 class="card-header m-0 me-2 pb-3">Total Transaksi ISMS</h5>
                        <div id="totalTransaksiChart" class="px-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Transactions -->
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Transaksi Terbaru ISMS</h5>
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
                        @foreach($transaksiisms as $index => $item)
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
        <!-- END ISMS Dashboard -->

        <!-- ATK Dashboard -->
        <div class="col-12 col-lg-12 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-12">
                        <h5 class="card-header m-0 me-2 pb-3">ATK Dashboard</h5>
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
                                  <a href="{{ route('atk_stock_barang') }}">
                                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png')}}"
                                        alt="chart success" class="rounded" />
                                  </a>
                                </div>
                            </div>
                            <span >Stock Tersedia</span>
                            <h3 class="card-title mb-2">{{ $overviewatk['stock_tersedia'] }}</h3>
                            <small class="text-success fw-semibold"></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <a href="{{ route('atk_list_transaksi_barang_keluar') }}">
                                      <img src="{{ asset('assets/img/icons/unicons/wallet-info.png')}}"
                                          alt="Credit Card" class="rounded" />
                                    </a>
                                </div>
                            </div>
                            <span>Barang Keluar</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $overviewatk['jumlah_barang_keluar'] }}</h3>
                            <small class="text-success fw-semibold"></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                  <a href="{{ route('atk_list_transaksi_barang_masuk') }}">
                                    <img src="{{ asset('assets/img/icons/unicons/chart-success.png')}}"
                                        alt="chart success" class="rounded" />
                                    </a>
                                </div>
                            </div>
                            <span >Barang Masuk</span>
                            <h3 class="card-title mb-2">{{ $overviewatk['jumlah_barang_masuk'] }}</h3>
                            <small class="text-success fw-semibold"></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                  <a href="{{ route('atk_list_transaksi_barang_keluar') }}">
                                    <img src="{{ asset('assets/img/icons/unicons/wallet-info.png')}}"
                                        alt="Credit Card" class="rounded" />    
                                  </a>
                                </div>
                            </div>
                            <span>Rata" Barang Keluar</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $overviewatk['rata_rata_barang_keluar'] }}</h3>
                            <small class="text-success fw-semibold"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
        <div class="col-12 col-lg-12 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-12">
                        <h5 class="card-header m-0 me-2 pb-3">Total Transaksi ATK</h5>
                        <div id="totalTransaksiChart2" class="px-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Transactions -->
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Transaksi Terbaru ATK</h5>
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
                        @foreach($transaksiatk as $index => $item)
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
        <!-- END ATK Dashboard -->
    </div>
</div>

@endsection


@section('script')
<script>
/**
 * Dashboard Analytics
 */

'use strict';

(function () {
  let cardColor, headingColor, axisColor, shadeColor, borderColor;

  cardColor = config.colors.white;
  headingColor = config.colors.headingColor;
  axisColor = config.colors.axisColor;
  borderColor = config.colors.borderColor;

  // Total Revenue Report Chart - Bar Chart
  // --------------------------------------------------------------------
  const totalTransaksiChartEl = document.querySelector('#totalTransaksiChart'),
    totalTransaksiChartOptions = {
      series: [
        {
          name: 'Barang Keluar',
          data: @json($overviewisms['data_barang_keluar'])
        },
        {
          name: 'Barang Masuk',
          data: @json($overviewisms['data_barang_masuk'])
        }
      ],
      chart: {
        height: 300,
        stacked: true,
        type: 'bar',
        toolbar: { show: false }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '33%',
          borderRadius: 12,
          startingShape: 'rounded',
          endingShape: 'rounded'
        }
      },
      colors: [config.colors.primary, config.colors.info],
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 6,
        lineCap: 'round',
        colors: [cardColor]
      },
      legend: {
        show: true,
        horizontalAlign: 'left',
        position: 'top',
        markers: {
          height: 8,
          width: 8,
          radius: 12,
          offsetX: -3
        },
        labels: {
          colors: axisColor
        },
        itemMargin: {
          horizontal: 10
        }
      },
      grid: {
        borderColor: borderColor,
        padding: {
          top: 0,
          bottom: -8,
          left: 20,
          right: 20
        }
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug','Sep','Okt','Des'],
        labels: {
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        },
        axisTicks: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        }
      },
      responsive: [
        {
          breakpoint: 1700,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '32%'
              }
            }
          }
        },
        {
          breakpoint: 1580,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '35%'
              }
            }
          }
        },
        {
          breakpoint: 1440,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '42%'
              }
            }
          }
        },
        {
          breakpoint: 1300,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '48%'
              }
            }
          }
        },
        {
          breakpoint: 1200,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 1040,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 11,
                columnWidth: '48%'
              }
            }
          }
        },
        {
          breakpoint: 991,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '30%'
              }
            }
          }
        },
        {
          breakpoint: 840,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '35%'
              }
            }
          }
        },
        {
          breakpoint: 768,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '28%'
              }
            }
          }
        },
        {
          breakpoint: 640,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '32%'
              }
            }
          }
        },
        {
          breakpoint: 576,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '37%'
              }
            }
          }
        },
        {
          breakpoint: 480,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '45%'
              }
            }
          }
        },
        {
          breakpoint: 420,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '52%'
              }
            }
          }
        },
        {
          breakpoint: 380,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '60%'
              }
            }
          }
        }
      ],
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
  if (typeof totalTransaksiChartEl !== undefined && totalTransaksiChartEl !== null) {
    const totalTransaksiChart = new ApexCharts(totalTransaksiChartEl, totalTransaksiChartOptions);
    totalTransaksiChart.render();
  }

  const totalTransaksiChartEl2 = document.querySelector('#totalTransaksiChart2'),
    totalTransaksiChartOptions2 = {
      series: [
        {
          name: 'Barang Keluar',
          data: @json($overviewatk['data_barang_keluar'])
        },
        {
          name: 'Barang Masuk',
          data: @json($overviewatk['data_barang_masuk'])
        }
      ],
      chart: {
        height: 300,
        stacked: true,
        type: 'bar',
        toolbar: { show: false }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '33%',
          borderRadius: 12,
          startingShape: 'rounded',
          endingShape: 'rounded'
        }
      },
      colors: [config.colors.primary, config.colors.info],
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 6,
        lineCap: 'round',
        colors: [cardColor]
      },
      legend: {
        show: true,
        horizontalAlign: 'left',
        position: 'top',
        markers: {
          height: 8,
          width: 8,
          radius: 12,
          offsetX: -3
        },
        labels: {
          colors: axisColor
        },
        itemMargin: {
          horizontal: 10
        }
      },
      grid: {
        borderColor: borderColor,
        padding: {
          top: 0,
          bottom: -8,
          left: 20,
          right: 20
        }
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug','Sep','Okt','Des'],
        labels: {
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        },
        axisTicks: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        }
      },
      responsive: [
        {
          breakpoint: 1700,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '32%'
              }
            }
          }
        },
        {
          breakpoint: 1580,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '35%'
              }
            }
          }
        },
        {
          breakpoint: 1440,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '42%'
              }
            }
          }
        },
        {
          breakpoint: 1300,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '48%'
              }
            }
          }
        },
        {
          breakpoint: 1200,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 1040,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 11,
                columnWidth: '48%'
              }
            }
          }
        },
        {
          breakpoint: 991,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '30%'
              }
            }
          }
        },
        {
          breakpoint: 840,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '35%'
              }
            }
          }
        },
        {
          breakpoint: 768,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '28%'
              }
            }
          }
        },
        {
          breakpoint: 640,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '32%'
              }
            }
          }
        },
        {
          breakpoint: 576,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '37%'
              }
            }
          }
        },
        {
          breakpoint: 480,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '45%'
              }
            }
          }
        },
        {
          breakpoint: 420,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '52%'
              }
            }
          }
        },
        {
          breakpoint: 380,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '60%'
              }
            }
          }
        }
      ],
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };
  if (typeof totalTransaksiChartEl2 !== undefined && totalTransaksiChartEl2 !== null) {
    const totalTransaksiChart2 = new ApexCharts(totalTransaksiChartEl2, totalTransaksiChartOptions2);
    totalTransaksiChart2.render();
  }

})();
</script>
@endsection
