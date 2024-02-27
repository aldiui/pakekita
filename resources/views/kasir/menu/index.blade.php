@extends('layouts.kasir')

@section('title', 'Menu')

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
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-8 mb-3">
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Cari menu...">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="semua" selected>Semua</option>
                                @foreach ($kategori as $row)
                                    <option value="{{ $row->nama }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" id="menus">
                        @include('kasir.menu.data')
                    </div>
                </div>
                <div class="col-lg-4">
                    <form id="createTransaksi">
                        <div class="card">
                            <div class="card-body p-2">
                                <h5 class="card-title text-center py-2">Transaksi</h5>
                                <div class="form-group mb-3">
                                    <label for="pesanan" class="form-label">Pesanan</label>
                                    <input type="text" class="form-control" name="pesanan" id="pesanan"
                                        placeholder="Masukan Nama Pemesan" required>
                                </div>
                                <table class="table table-bordered" id="list-transaksi">
                                    <thead>
                                        <tr>
                                            <th width="45%">Menu</th>
                                            <th width="25%">Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer p-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="fw-bold">Total</div>
                                    <div id="textGrandTotal">Rp. 0</div>
                                </div>
                                <input type="hidden" class="form-control" id="grandTotal" name="grandTotal">
                                <button class="btn btn-success btn-sm d-block w-100" type="submit"
                                    id="proses">Proses</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#search, #kategori').on('input change', function() {
                getMenus(1);
            });

            getMenus(1);

            $("#createTransaksi").submit(function(e) {
                setButtonLoadingState("#createTransaksi .btn.btn-success", true, "Proses");
                e.preventDefault();
                const url = `{{ route('kasir.transaksi.store') ?? '' }}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#createTransaksi .btn.btn-success", false, "Proses");
                    handleSuccess(response, null, null, "/kasir/transaksi");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#createTransaksi .btn.btn-success", false, "Proses");
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            getMenus(page);
        });
    </script>
@endpush
