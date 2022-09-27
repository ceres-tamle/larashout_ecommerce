@extends('admin.app')
@section('title')
    {{-- {{ $pageTitle }} --}}
@endsection
@section('content')
    <div class="app-title">
        <div>
            {{-- <h1><i class="fa fa-shopping-bag"></i> {{ $pageTitle }} - {{ $subTitle }}</h1> --}}
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-3">
            <div class="tile p-0">
                <ul class="nav flex-column nav-tabs user-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <form action="{{ route('admin.coupons.store') }}" method="POST" role="form">
                    @csrf
                    <div class="tab-pane active" id="general">
                        <div class="tile">
                            <h3 class="tile-title">Coupon Information</h3>
                            <hr>
                            <div class="tile-body">
                                <div class="row">
                                    {{-- Name --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text"
                                                name="name" value="{{ old('name') }}" />
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('name')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Code --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Code</label>
                                            <input class="form-control @error('code') is-invalid @enderror" type="text"
                                                name="code" value="{{ old('code') }}" />
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('code')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- Time --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Time</label>
                                            <input class="form-control @error('time') is-invalid @enderror" type="text"
                                                name="time" value="{{ old('time') }}" />
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('time')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Condition --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label class="control-label">Condition</label>
                                            <select name="condition" class="form-control">
                                                <option value="1">Percent</option>
                                                <option value="2">Value</option>
                                            </select>

                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('condition')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- Active --}}
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label class="control-label">Active</label>
                                            <select name="active" class="form-control">
                                                <option value="0">Inactive</option>
                                                <option value="1">Active</option>
                                            </select>

                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('active')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Discount --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Discount</label>
                                            <input class="form-control @error('discount') is-invalid @enderror"
                                                type="text" name="discount" value="{{ old('discount') }}" />
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('discount')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <div class="row d-print-none mt-2">
                            <div class="col-12 text-right">
                                <button class="btn btn-success" type="submit"><i
                                        class="fa fa-fw fa-lg fa-check-circle"></i>Save
                                    Coupon</button>
                                <a class="btn btn-danger" href="{{ route('admin.coupons.index') }}">
                                    <i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script type="text/javascript" src="{{ asset('backend/js/plugins/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#categories').select2();
            });
        </script>
    @endpush
