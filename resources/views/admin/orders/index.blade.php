@extends('admin.app')
@section('title')
    {{-- {{ $pageTitle }} --}}
@endsection
@section('content')
    {{-- <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary pull-right">Add Order</a>
    </div> --}}
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th class="text-center"> # </th>
                                <th class="text-center"> Order Number </th>
                                {{-- <th class="text-center"> Customer </th> --}}
                                <th class="text-center"> Status </th>
                                <th class="text-center"> Total </th>
                                <th class="text-center"> Quantity </th>
                                <th class="text-center"> Payment Status </th>
                                <th class="text-center"> Payment Method </th>
                                <th class="text-center"> First Name </th>
                                <th class="text-center"> Last Name </th>
                                <th class="text-center"> Address </th>
                                <th class="text-center"> City </th>
                                <th class="text-center"> Country </th>
                                <th class="text-center"> Post Code </th>
                                <th class="text-center"> Phone Number </th>
                                <th class="text-center"> Notes </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger">
                                    <i class="fa fa-bolt"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->order_number }}</td>
                                    {{-- <td>{{ $order->user_id }}</td> --}}
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->grand_total }}</td>
                                    <td>{{ $order->item_count }}</td>
                                    {{-- <td>{{ $order->payment_status }}</td> --}}
                                    <td>
                                        @if ($order->payment_status === 1)
                                            Available
                                        @else
                                            Unavailable
                                        @endif
                                    </td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ $order->first_name }}</td>
                                    <td>{{ $order->last_name }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{{ $order->city }}</td>
                                    <td>{{ $order->country }}</td>
                                    <td>{{ $order->post_code }}</td>
                                    <td>{{ $order->phone_number }}</td>
                                    <td>{{ $order->notes }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.orders.delete', $order->id) }}" class="btn btn-sm btn-danger">
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
