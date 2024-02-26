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
                    <div class="card">
                        <div class="card-body p-2">
                            <h5 class="card-title text-center py-2">Transaksi</h5>
                            <table class="table table-bordered" id="list-transaksi">
                                <thead>
                                    <tr>
                                        <th width="40%">Menu</th>
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
                            <button class="btn btn-success btn-sm d-block w-100" id="proses">Proses</button>
                        </div>
                    </div>
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
                let search = $('#search').val();
                let kategori = $('#kategori').val();
                getMenus(1, search, kategori);
            });

            getMenus(1, '', 'semua');
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let search = $('#search').val();
            let kategori = $('#kategori').val();
            getMenus(page, search, kategori);
        });

        const getMenus = (page, search = null, kategori = "semua") => {
            $.ajax({
                url: "/kasir/menu?page=" + page,
                data: {
                    search,
                    kategori,
                },
            }).done(function(data) {
                $("#menus").html(data);
            });
        };

        const getChart = (kode) => {
            const successCallback = function(response) {
                let menu = response.data;
                let menuId = menu.id;

                if ($('#menu_' + menuId).length === 0) {
                    let tableRows = `
                        <tr id="menu_${menuId}">
                            <td><button class="border-0 bg-white text-danger" onclick="removeMenu('menu_${menuId}')">x</button> ${menu.nama}</td>
                            <td>
                                <input class="form-control" value="1" oninput="changeTotal(${menuId})" type="number" id="qty_${menuId}"/>
                            </td>
                            <td>
                                <input type="hidden" value="${menu.harga}" id="harga_${menuId}"/>
                                <span id="total_${menuId}">${formatRupiah(menu.harga)}</span>
                                <input type="hidden" class="totalFiks" value="${menu.harga}" id="totalFiks_${menuId}"/>
                                <input type="hidden" value="${menuId}" id="menu_${menuId}"/>
                            </td>
                        </tr>
                    `;
                    $("#list-transaksi tbody").append(tableRows);

                    grandTotal();
                }

            };

            const errorCallback = function(error) {
                console.log(error);
            };

            ajaxCall(
                `/kasir/menu/${kode}`,
                "GET",
                null,
                successCallback,
                errorCallback
            );
        };

        const formatRupiah = (angka) => {
            var reverse = angka.toString().split("").reverse().join(""),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join(".").split("").reverse().join("");
            return "Rp " + ribuan;
        };

        const changeTotal = (menuId) => {
            let qty = $("#qty_" + menuId).val();
            let harga = $("#harga_" + menuId).val();
            let total = qty * harga;
            $("#total_" + menuId).text(formatRupiah(total));
            $("#totalFiks_" + menuId).val(total);

            grandTotal();
        }

        const removeMenu = (menu) => {
            $(`#${menu}`).remove();
            grandTotal();

        }

        const grandTotal = () => {
            let totalFiks = 0;
            $('.totalFiks').each(function() {
                totalFiks += parseInt($(this).val());
            });
            $('#grandTotal').val(totalFiks);
            $('#textGrandTotal').text(formatRupiah(totalFiks));
        }
    </script>
@endpush
