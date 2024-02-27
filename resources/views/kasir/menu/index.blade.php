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
                                    <label for="pesanan" class="form-label">Pesanan <span
                                            class="text-danger">*</span></label>
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
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="fw-bold">Kembalian</div>
                                    <div id="textKembalian">Rp. 0</div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pembayaran_id" class="form-label">Pembayaran <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="pembayaran_id" name="pembayaran_id" required>
                                        <option value="">Pilih Metode</option>
                                        <option value="Cash">Cash</option>
                                        @foreach ($pembayaran as $row)
                                            <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="pembayaran-deskripsi"></div>
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

            $('#pembayaran_id').on('change', function() {
                const pembayaran = $('#pembayaran_id').val();
                if (pembayaran == 'Cash') {
                    $('#pembayaran-deskripsi').html(`
                        <div class="form-group mb-3">
                            <label for="bayar" class="form-label">Bayar <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="bayar" id="bayar" oninput="hitungKembalian()" placeholder="Masukan Jumlah Bayar" required>
                        </div>
                    `);
                } else if (pembayaran > 0) {
                    const successCallback = function(response) {
                        $('#pembayaran-deskripsi').html(`
                            <div class="mb-3 text-center">
                                <div class="mb-3 fw-bold">${response.data.nama}</div>
                                <div class="mb-3">No Rekening : ${response.data.no_rekening}</div>
                            </div>
                        `);
                    };

                    const errorCallback = function(error) {
                        console.log(error);
                    };

                    ajaxCall(
                        `/kasir/pembayaran/${pembayaran}`,
                        "GET",
                        null,
                        successCallback,
                        errorCallback
                    );
                } else {
                    $('#pembayaran-deskripsi').html('');
                }
            });

        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            getMenus(page);
        });

        const hitungKembalian = () => {
            const bayar = $('#bayar').val();
            const grandTotal = $('#grandTotal').val();
            const kembalian = bayar ? (bayar >= grandTotal ? bayar - grandTotal : 0) : 0;
            $("#textKembalian").html(formatRupiah(kembalian));
        }
    </script>
@endpush
