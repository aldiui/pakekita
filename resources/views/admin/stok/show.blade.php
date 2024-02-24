@extends('layouts.admin')

@section('title', 'Detail Stok')

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
                                <li class="breadcrumb-item"><a href="/admin/stok">Stok</a></li>
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
                                    @if ($stok->status != 1)
                                        <a href="{{ route('admin.stok.index') }}" class="btn btn-secondary btn-sm"><i
                                                class="bi bi-arrow-left me-1"></i>Kembali</a>
                                        <button class="btn btn-success btn-sm" id="createBtn"
                                            onclick="getModal('createModal')">
                                            <i class="bi bi-plus me-2"></i>Tambah
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-4 col-lg-2 mb-2">Tanggal</div>
                                    <div class="col-8 col-lg-10 mb-2">: {{ formatTanggal($stok->tanggal) }}</div>
                                    <div class="col-4 col-lg-2 mb-2">Nama</div>
                                    <div class="col-8 col-lg-10 mb-2">: {{ $stok->user->nama }}</div>
                                    <div class="col-4 col-lg-2 mb-2">Jenis</div>
                                    <div class="col-8 col-lg-10 mb-2">: {{ $stok->jenis }}</div>
                                    <div class="col-4 col-lg-2 mb-2">Status</div>
                                    <div class="col-8 col-lg-10 mb-2">
                                        : {!! statusBadge($stok->status) !!}
                                    </div>
                                    <div class="col-4 col-lg-2 mb-2">Persetujuan</div>
                                    <div class="col-8 col-lg-10 mb-2">
                                        :
                                        @if ($stok->status != 1)
                                            <button class="btn btn-primary btn-sm d-inline-flex" type="button"
                                                onclick="confirmStok('{{ $stok->id }}')"><i
                                                    class="bi bi-question-circle me-1"></i>Konfirmasi</button>
                                        @else
                                            @if ($stok->approval_id != null)
                                                {{ $stok->approval->nama }}
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="detail-stok-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="5%">#</th>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col" width="20%">Aksi</th>
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
    @include('admin.detail-stok.create')
    @include('admin.detail-stok.edit')
@endsection

@push('scripts')
    <script src="{{ asset('extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('extensions/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            datatableCall('detail-stok-table', '/admin/stok/{{ $stok->id }}', [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                },
            ]);

            $("#createBtn").click(function() {
                select2ToJson("#barang_id", "/admin/barang", "#createModal");
            });

            $("#saveData").submit(function(e) {
                setButtonLoadingState("#saveData .btn.btn-primary", true);
                e.preventDefault();
                const url = "{{ route('admin.detail-stok.store') }}";
                const data = new FormData(this);


                const successCallback = function(response) {
                    setButtonLoadingState("#saveData .btn.btn-primary", false);
                    handleSuccess(response, "detail-stok-table", "createModal");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#saveData .btn.btn-primary", false);
                    handleValidationErrors(error, "saveData", ["stok_id", "barang_id", "qty",
                        "deskripsi"
                    ]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });

            $("#updateData").submit(function(e) {
                setButtonLoadingState("#updateData .btn.btn-primary", true);
                e.preventDefault();
                const kode = $("#updateData #id").val();
                const url = `/admin/detail-stok/${kode}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleSuccess(response, "detail-stok-table", "editModal");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleValidationErrors(error, "updateData", ["stok_id", "barang_id", "qty",
                        "deskripsi"
                    ]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });

        function getSelectEdit() {
            select2ToJson(".editBarang", "/admin/barang", "#editModal");
        }
    </script>
@endpush
