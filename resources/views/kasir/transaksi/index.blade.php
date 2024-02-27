@extends('layouts.kasir')

@section('title', 'Transaksi')

@push('style')
    <link rel="stylesheet" href="{{ asset('extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('extensions/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('main')
    @php
        $bulans = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    @endphp
    <div class="content-wrapper container">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>@yield('title')</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/kasir">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Data @yield('title')</h5>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="bulan_filter" class="form-label">Bulan</label>
                                        <select name="bulan_filter" id="bulan_filter" class="form-control">
                                            @foreach ($bulans as $key => $value)
                                                <option value="{{ $key + 1 }}"
                                                    {{ $key + 1 == date('m') ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
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
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="transaksi-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Kode Transaksi</th>
                                            <th>Pesanan</th>
                                            <th>Total Menu</th>
                                            <th>Total</th>
                                            <th>Pembayaran</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('extensions/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            datatableCall('transaksi-table', '{{ route('kasir.transaksi.index') }}', [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'pesanan',
                    name: 'pesanan'
                },
                {
                    data: 'detail_transaksis_count',
                    name: 'detail_transaksis_count'
                },
                {
                    data: 'total_rupiah',
                    name: 'total_rupiah'
                },
                {
                    data: 'pembayaran',
                    name: 'pembayaran'
                },
                {
                    data: 'tgl',
                    name: 'tgl'
                },
            ]);

            $("#bulan_filter, #tahun_filter").on("change", function() {
                $("#transaksi-table").DataTable().ajax.reload();
            });
        });
    </script>
@endpush
