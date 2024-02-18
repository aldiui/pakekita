@extends('layouts.auth')

@section('title', 'Login')

@push('style')
@endpush

@section('main')
    <div class="card">
        <div class="card-body">
            <div class="border p-4 rounded">
                <div class="text-center">
                    <h3 class="">Login</h3>
                </div>
                <div class="form-body">
                    <form class="row g-3">
                        <div class="col-12">
                            <label for="inputEmailAddress" class="form-label">Email</label>
                            <input type="email" class="form-control" id="inputEmailAddress" placeholder="Email Address">
                        </div>
                        <div class="col-12">
                            <label for="inputChoosePassword" class="form-label">Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control border-end-0" id="inputChoosePassword"
                                    value="12345678" placeholder="Enter Password"> <a href="javascript:;"
                                    class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i
                                        class="bx bxs-lock-open"></i>Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
