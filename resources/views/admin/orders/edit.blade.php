@extends('admin.app')
@section('content')
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-3">
            <div class="tile p-0">
                <ul class="nav flex-column nav-tabs user-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#general" data-toggle="tab">General</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <div class="tile">
                        <form action="{{ route('admin.orders.update') }}" method="POST" role="form">
                            @csrf
                            <h3 class="tile-title">Order Status</h3>
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
                                            <input class="form-control" type="text" name="id"
                                                value="{{ old('id', $order->id) }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">Order Status</label>
                                            <select class="form-control" name="order_status">
                                                @foreach ($order_statuses as $order_status)
                                                    <option value="{{ $order_status->id }}">
                                                        {{ $order_status->order_status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback active">
                                                <i class="fa fa-exclamation-circle fa-fw"></i> @error('order_status')
                                                    <span>{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tile-footer">
                                    <div class="row d-print-none mt-2">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-success" type="submit">
                                                <i class="fa fa-fw fa-lg fa-check-circle"></i>Save Order
                                            </button>
                                            <a class="btn btn-danger" href="{{ route('admin.orders.index') }}">
                                                <i class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back
                                            </a>
                                        </div>
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
