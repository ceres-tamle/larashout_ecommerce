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
    <div class="row user">
        <div class="col-md-3">
            <div class="tile p-0">
                <ul class="nav flex-column nav-tabs user-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">General</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <div class="tile">
                        <form action="{{ route('admin.users.update') }}" method="POST" role="form">
                            @csrf
                            <h3 class="tile-title">User Information</h3>
                            <hr>
                            @if (Session::get('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            @if (Session::get('fail'))
                                <div class="alert alert-danger">
                                    {{ Session::get('fail') }}
                                </div>
                            @endif
                            <div class="tile-body">
                                <div class="row">
                                    {{-- Id --}}
                                    <div class="col-6">
                                        <label class="control-label">Id</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="id" value="{{ old('id', $user->id) }}" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- First Name --}}
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">First Name</label>
                                            <input class="form-control @error('first_name') is-invalid @enderror"
                                                type="text" name="first_name"
                                                value="{{ old('first_name', $user->first_name) }}" />
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('first_name')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Last Name --}}
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">Last Name</label>
                                            <input class="form-control @error('last_name') is-invalid @enderror"
                                                type="text" name="last_name"
                                                value="{{ old('last_name', $user->last_name) }}" />
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('last_name')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- Email --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="text"
                                                name="email" value="{{ old('email', $user->email) }}" readonly />
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('email')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Password --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Password</label>
                                            <input class="form-control @error('password') is-invalid @enderror"
                                                type="password" name="password"
                                                value="{{ old('password', $user->password) }}" readonly />
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('password')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- Address --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Address</label>
                                            <input class="form-control @error('address') is-invalid @enderror"
                                                type="text" name="address"
                                                value="{{ old('address', $user->address) }}" />
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('address')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- City --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">City</label>
                                            <input class="form-control @error('city') is-invalid @enderror" type="text"
                                                name="city" value="{{ old('city', $user->city) }}" />
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('city')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Country</label>
                                            <input class="form-control @error('country') is-invalid @enderror"
                                                type="text" name="country"
                                                value="{{ old('country', $user->country) }}" />
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('country')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tile-footer">
                                <div class="row d-print-none mt-2">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-success" type="submit"><i
                                                class="fa fa-fw fa-lg fa-check-circle"></i>Save User</button>
                                        <a class="btn btn-danger" href="{{ route('admin.users.index') }}">
                                            <i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
