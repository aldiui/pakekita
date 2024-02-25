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
                        @foreach ($menus as $menu)
                            <div class="col-lg-3 col-6 col-md-3">
                                <div class="card">
                                    <img src="/storage/image/menu/{{ $menu->image }}" class="card-img-top" alt="...">
                                    <div class="card-body text-center">
                                        <p class="card-title fw-bold">{{ $menu->nama }}</p>
                                        <small class="d-block text-center small">{{ formatRupiah($menu->harga) }}</small>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                {!! $menus->links() !!}
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('extensions/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush
