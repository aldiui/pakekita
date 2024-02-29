@extends('layouts.admin')

@section('title', 'Dashboard')

@push('style')
@endpush

@section('main')
    <div class="content-wrapper container">
        <div class="page-heading">
            <h3>@yield('title')</h3>
        </div>
        <div class="page-content">
            <section class="row">
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('static/js/pages/dashboard.js') }}"></script>
@endpush
