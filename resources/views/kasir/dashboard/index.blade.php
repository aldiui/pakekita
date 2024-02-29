@extends('layouts.kasir')

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
@endpush
