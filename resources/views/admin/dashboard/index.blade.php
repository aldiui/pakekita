@extends('layouts.admin')

@section('title', 'Dashboard')

@push('style')
@endpush

@section('main')
    <div class="content-wrapper container">
        <div class="page-heading">
            <h3>@yield('title')</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-clock-history me-2"></i>Transaksi Hari ini</h5>
                            <hr>
                            {{ formatRupiah($transaksiHariIni) }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-clock-history me-2"></i>Transaksi Bulan <span
                                    class="label-bulan">{{ formatTanggal(date('Y-m-d'), 'F') }}</span></h5>
                            <hr>
                            <span id="total-transaksi">
                                Rp. 0
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-clock-history me-2"></i>Transaksi Bulan <span
                                    class="label-bulan">{{ formatTanggal(date('Y-m-d'), 'F') }}</span></h5>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-lg-4 mb-3">
                                    <div class="form-group">
                                        <label for="bulan_filter" class="form-label">Bulan</label>
                                        <select name="bulan_filter" id="bulan_filter" class="form-control">
                                            @foreach (bulan() as $key => $value)
                                                <option value="{{ $key + 1 }}"
                                                    {{ $key + 1 == date('m') ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="form-group">
                                        <label for="tahun_filter" class="form-label">Tahun</label>
                                        <select name="tahun_filter" id="tahun_filter" class="form-control">
                                            @for ($i = now()->year; $i >= now()->year - 4; $i--)
                                                <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="form-group">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select name="kategori" id="kategori" class="form-control">
                                            <option value="">Semua</option>
                                            @foreach ($kategori as $row)
                                                <option value="{{ $row->id }}">
                                                    {{ $row->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="chart-transaksi"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            renderData();

            $("#bulan_filter, #tahun_filter, #kategori").on("change", function() {
                renderData();
            });
        });

        const renderData = () => {
            const successCallback = function(response) {
                renderChart(response.labels, response.transaksi);
                $('#total-transaksi').html(response.total)
                $('.label-bulan').html(response.bulan);
            };

            const errorCallback = function(error) {
                console.error(error);
            };

            const url = `/admin?bulan=${$("#bulan_filter").val()}&tahun=${$("#tahun_filter").val()}&
            kategori=${$("#kategori").val()}`;

            ajaxCall(url, "GET", null, successCallback, errorCallback);
        };
    </script>
@endpush
