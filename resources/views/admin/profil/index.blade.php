@extends('layouts.admin')

@section('title', 'User')

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
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-dark">Data @yield('title')</h4>
                        </div>
                        <div class="card-body">
                            <form id="updateData">
                                @method('PUT')
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Foto </label>
                                    <input type="file" name="image" id="image" class="form-control"
                                        data-height="200">
                                    <small class="invalid-feedback" id="errorimage"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ Auth::user()->nama }}">
                                    <small class="invalid-feedback" id="errornama"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ Auth::user()->email }}">
                                    <small class="invalid-feedback" id="erroremail"></small>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-dark">Ubah Password</h4>
                        </div>
                        <div class="card-body">
                            <form id="updatePassword">
                                @method('PUT')
                                <div class="form-group mb-3">
                                    <label for="password_lama" class="form-label">Password Lama <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_lama" name="password_lama">
                                    <small class="invalid-feedback" id="errorpassword_lama"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password Baru <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <small class="invalid-feedback" id="errorpassword"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                    <small class="invalid-feedback" id="errorpassword_confirmation"></small>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $("#updateData").submit(function(e) {
                setButtonLoadingState("#updateData .btn.btn-primary", true);
                e.preventDefault();
                const url = `{{ route('admin.profil') }}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleSuccess(response, null, null, "no");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updateData .btn.btn-primary", false);
                    handleValidationErrors(error, "updateData", ["nama", "email",
                        "image"
                    ]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });

            $("#updatePassword").submit(function(e) {
                setButtonLoadingState("#updatePassword .btn.btn-primary", true);
                e.preventDefault();
                const url = `{{ route('admin.profil.password') }}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#updatePassword .btn.btn-primary", false);
                    handleSuccess(response, null, null, "no");
                    $('#updatePassword .form-control').removeClass("is-invalid").val("");
                    $('#updatePassword .invalid-feedback').html("");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updatePassword .btn.btn-primary", false);
                    handleValidationErrors(error, "updatePassword", ["password_lama", "password"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
