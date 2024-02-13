@extends('layouts.admin')

@section('title', 'Meja')

@push('style')
    <link rel="stylesheet" href="{{ asset('plugins/notifications/css/lobibox.min.css') }}" />
    <link href="{{ asset('plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@section('main')
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Data @yield('title')</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Data @yield('title')</h5>
                            <div>
                                <button class="btn btn-success btn-sm" onclick="getModal('createModal')">
                                    <i class="bx bx-plus"></i>Tambah
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="meja-table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Kode Meja</th>
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
        </div>
    </div>
    @include('admin.meja.create')
    @include('admin.meja.edit')
@endsection

@push('scripts')
    <script src="{{ asset('plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('plugins/notifications/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('plugins/notifications/js/notifications.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            datatableCall('meja-table', '{{ route('admin.meja.index') }}', [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'kode_meja',
                    name: 'kode_meja'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                },
            ]);

            $("#saveData").submit(function(e) {
                setButtonLoadingState("#saveData .btn.btn-primary", true);
                e.preventDefault();
                const url = "{{ route('admin.meja.store') }}";
                const data = new FormData(this);


                const successCallback = function(response) {
                    setButtonLoadingState("#saveData .btn.btn-primary", false);
                    handleSuccess(response, "meja-table", "createModal");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#saveData .btn.btn-primary", false);
                    handleValidationErrors(error, "saveData", ["kode_meja"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });

            $("#updateData").submit(function(e) {
                setButtonLoadingState("#updateData .btn.btn-primary", true);
                e.preventDefault();
                const kode = $("#updateData #uuid").val();
                const url = `/admin/meja/${kode}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleSuccess(response, "meja-table", "editModal");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleValidationErrors(error, "updateData", ["kode_meja"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
