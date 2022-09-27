@extends('admin.app')
@section('content')
    <div class="app-title">
        <div></div>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary pull-right">Add Coupon</a>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th class="text-center"> # </th>
                                <th class="text-center"> Name </th>
                                <th class="text-center"> Code </th>
                                <th class="text-center"> Time </th>
                                <th class="text-center"> Condition </th>
                                <th class="text-center"> Active </th>
                                <th class="text-center"> Discount </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger">
                                    <i class="fa fa-bolt"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->id }}</td>
                                    <td>{{ $coupon->name }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>
                                        @if ((int) $coupon->time === 1)
                                            one time coupon
                                        @elseif ((int) $coupon->time > 1)
                                            {{ $coupon->time }} coupons
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td>
                                        @if ((int) $coupon->condition === 1)
                                            Percent
                                        @elseif ((int) $coupon->condition === 2)
                                            Value
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td>
                                        @if ((int) $coupon->active === 0)
                                            Inactive
                                        @elseif ((int) $coupon->active === 1)
                                            Active
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td>
                                        @if ((int) $coupon->condition === 1)
                                            Discount {{ $coupon->discount }} %
                                        @elseif ((int) $coupon->condition === 2)
                                            Discount {{ $coupon->discount }} VND
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.coupons.delete', $coupon->id) }}"
                                                class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>
@endpush
