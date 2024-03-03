@extends('layouts.auth')

@section('title', 'Menu')

@push('style')
    <link rel="stylesheet" href="{{ asset('extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('extensions/choices.js/choices.css') }}">
@endpush

@section('main')
    <div class="row justify-content-center align-items-center py-5">
        <div class="col-12">
            <div class="row">
                <div class="col-12 mb-3 text-center">
                    <h3>Daftar @yield('title')</h3>
                </div>
            </div>
            <div class="row  flex-column-reverse flex-lg-row">
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
                        @include('home.data')
                    </div>
                </div>
                <div class="col-lg-4">
                    <form id="createTransaksi" autocomplete="off">
                        <div class="card">
                            <div class="card-body p-3">
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
                            <div class="card-footer p-3">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="fw-bold">Total</div>
                                    <div id="textGrandTotal">Rp. 0</div>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="fw-bold">Kembalian</div>
                                    <div id="textKembalian">Rp. 0</div>
                                </div>
                                <div class="form-group mb-3 d-none" id="meja-input">
                                    <label for="meja_id" class="form-label">Meja</label>
                                    <select class="choices" id="meja_id" name="meja_id">
                                        <option value="">Pilih Meja</option>
                                        @foreach ($meja as $row)
                                            <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3 d-none" id="pembayaran-input">
                                    <label for="pembayaran_id" class="form-label">Pembayaran <span
                                            class="text-danger">*</span></label>
                                    <select class="choices" id="pembayaran_id" name="pembayaran_id"
                                        onchange="selectPembayaran(this.value, 'free')" required>
                                        <option value="">Pilih Metode</option>
                                        <option value="Cash">Cash</option>
                                        @foreach ($pembayaran as $row)
                                            <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="pembayaran-deskripsi"></div>
                                <input type="hidden" class="form-control" id="grandTotal" name="grandTotal">
                                <button class="btn btn-success btn-sm d-block w-100 d-none" type="submit"
                                    id="proses">Proses</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('extensions/choices.js/choices.js') }}"></script>
    <script src="{{ asset('static/js/pages/form-element-select.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#search, #kategori').on('input change', function() {
                getMenus(1, "ada");
            });

            getMenus(1, "ada");

            $("#createTransaksi").submit(function(e) {
                setButtonLoadingState("#createTransaksi .btn.btn-success", true, "Proses");
                e.preventDefault();
                const url = `{{ route('transaksi.store') ?? '' }}`;
                const data = new FormData(this);

                const successCallback = function(response) {
                    setButtonLoadingState("#createTransaksi .btn.btn-success", false, "Proses");
                    handleSuccess(response, null, null, "/");
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
