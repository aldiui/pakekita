@extends('layouts.admin')

@section('title', 'Pembayaran')

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
                                <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
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
                                <div>
                                    <button class="btn btn-success btn-sm" onclick="getModal('createModal')">
                                        <i class="bi bi-plus me-2"></i>Tambah
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="pembayaran-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="10%">Foto</th>
                                            <th>Nama</th>
                                            <th>Atas Nama</th>
                                            <th>Jenis</th>
                                            <th>No. Rekening</th>
                                            <th width="15%">Aksi</th>
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
    @include('admin.pembayaran.create')
@endsection

@push('scripts')
    <script src="{{ asset('extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            datatableCall('pembayaran-table', '{{ route('admin.pembayaran.index') }}', [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'img',
                    name: 'img'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'atas_nama',
                    name: 'atas_nama'
                },
                {
                    data: 'jenis',
                    name: 'jenis'
                },
                {
                    data: 'no_rekening',
                    name: 'no_rekening'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                },
            ]);

            $("#saveData").submit(function(e) {
                setButtonLoadingState("#saveData .btn.btn-primary", true);
                e.preventDefault();
                const kode = $("#saveData #id").val();
                let url = "{{ route('admin.pembayaran.store') }}";
                const data = new FormData(this);

                if (kode !== "") {
                    data.append("_method", "PUT");
                    url = `/admin/pembayaran/${kode}`;
                }

                const successCallback = function(response) {
                    setButtonLoadingState("#saveData .btn.btn-primary", false);
                    handleSuccess(response, "pembayaran-table", "createModal");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#saveData .btn.btn-primary", false);
                    handleValidationErrors(error, "saveData", ["nama", "atas_nama", "jenis", "image",
                        "no_rekening"
                    ]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
