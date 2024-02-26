@extends('layouts.auth')

@section('title', 'Menu')

@push('style')
    <link rel="stylesheet" href="{{ asset('extensions/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('main')
    <div class="row justify-content-center align-items-center py-5">
        <div class="col-12">
            <div class="row">
                <div class="col-12 mb-3 text-center">
                    <h3>Daftar @yield('title')</h3>
                </div>
                <div class="col-lg-8 mb-3">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Cari menu...">
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
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#search, #kategori').on('input change', function() {
                let search = $('#search').val();
                let kategori = $('#kategori').val();
                getMenus(1, search, kategori);
            });
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let search = $('#search').val();
            let kategori = $('#kategori').val();
            getMenus(page, search, kategori);
        });

        const getMenus = (page, search = null, kategori = 'semua') => {
            $.ajax({
                url: '/?page=' + page,
                data: {
                    search,
                    kategori,
                },
            }).done(function(data) {
                $('#menus').html(data);
            });
        }
    </script>
@endpush
