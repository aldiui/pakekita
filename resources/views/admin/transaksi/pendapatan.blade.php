@extends('layouts.admin')

@section('title', 'Pendapatan')

@push('style')
    <link rel="stylesheet" href="{{ asset('extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('extensions/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('main')
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
                                        <label for="kategori_filter" class="form-label">Kategori</label>
                                        <select name="kategori_filter" id="kategori_filter" class="form-control">
                                            <option value="">Semua</option>
                                            @foreach ($kategori as $row)
                                                <option value="{{ $row->id }}">
                                                    {{ $row->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="pendapatan-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Tanggal</th>
                                            <th>Pesanan</th>
                                            <th>Menu</th>
                                            <th>Kategori</th>
                                            <th>Qty</th>
                                            <th>Total</th>
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
            datatableCall('pendapatan-table', '{{ route('admin.pendapatan') }}', [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'pesanan',
                    name: 'pesanan'
                },
                {
                    data: 'menu',
                    name: 'menu'
                },
                {
                    data: 'kategori',
                    name: 'kategori'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'total_harga',
                    name: 'total_harga'
                },
            ]);

            $("#bulan_filter, #tahun_filter, #kategori_filter").on("change", function() {
                $("#pendapatan-table").DataTable().ajax.reload();
            });
        });
    </script>
@endpush
