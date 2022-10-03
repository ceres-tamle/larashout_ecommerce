@extends('site.app')
@section('title', 'Shopping Cart')
@section('content')
    <section class="section-pagetop bg-dark">
        <div class="container clearfix">
            <h2 class="title-page">Cart</h2>
        </div>
    </section>
    <section class="section-content bg padding-y border-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    @if (Session::has('message'))
                        <p class="alert alert-success">{{ Session::get('message') }}</p>
                    @elseif (Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <main class="col-sm-9">
                    @if (\Cart::isEmpty())
                        <p class="alert alert-warning">Your shopping cart is empty.</p>
                    @else
                        <div class="card">
                            <table class="table table-hover shopping-cart-wrap">
                                <thead class="text-muted">
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col" width="120">Quantity</th>
                                        <th scope="col" width="120">Price</th>
                                        <th scope="col" class="text-right" width="200">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\Cart::getContent() as $item)
                                        <tr>
                                            <td>
                                                <figure class="media">
                                                    <figcaption class="media-body">
                                                        <h6 class="title text-truncate">
                                                            {{ Str::words($item->name, 20) }}
                                                        </h6>
                                                        @foreach ($item->attributes as $key => $value)
                                                            <dl class="dlist-inline small">
                                                                <dt>{{ ucwords($key) }}: </dt>
                                                                <dd>{{ ucwords($value) }}</dd>
                                                            </dl>
                                                        @endforeach
                                                    </figcaption>
                                                </figure>
                                            </td>
                                            <td>
                                                <var class="price">{{ $item->quantity }}</var>
                                            </td>
                                            <td>
                                                <div class="price-wrap">
                                                    <var class="price">
                                                        {{ number_format($item->price, 2) . config('settings.currency_symbol') }}
                                                        {{-- FIX PRODUCT PRICE HERE --}}
                                                    </var>
                                                    <small class="text-muted">each</small>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('checkout.cart.remove', $item->id) }}"
                                                    class="btn btn-outline-danger">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </main>

                @if (!Cart::isEmpty())
                    <aside class="col-sm-3">
                        <a href="{{ route('checkout.cart.clear') }}" class="btn btn-danger btn-block mb-4">Clear Cart</a>
                        <dl class="dlist-align h4">
                            <dt>Total:</dt>
                            <dd class="text-right">
                                <strong>
                                    {{ number_format(\Cart::getSubTotal(), 2) . config('settings.currency_symbol') }}
                                    {{-- FIX TOTAL PRICE HERE --}}
                                </strong>
                            </dd>
                        </dl>

                        @if (Session::get('coupon_code') !== null)
                            <dl class="dlist-align h4">
                                <dt>Coupon:</dt>
                                <dd class="text-right">
                                    <strong>
                                        @if (Session::get('coupon_code'))
                                            @foreach (Session::get('coupon_code') as $key => $coupon)
                                                {{-- Discount Percent --}}
                                                @if (isset($coupon['condition']) && $coupon['condition'] == 1)
                                                    {{ number_format($coupon['discount'], 2) }} %
                                                    {{-- Discount Value --}}
                                                @elseif(isset($coupon['condition']) && $coupon['condition'] == 2)
                                                    {{ number_format($coupon['discount'], 2) . config('settings.currency_symbol') }}
                                                @endif
                                            @endforeach
                                        @endif
                                    </strong>
                                </dd>
                            </dl>

                            <dl class="dlist-align h4">
                                <dt>Discount:</dt>
                                <dd class="text-right">
                                    <strong>
                                        @if (Session::get('discount_percent') !== null)
                                            {{ number_format(Session::get('discount_percent'), 2) . config('settings.currency_symbol') }}
                                        @elseif (Session::get('discount_value') !== null)
                                            {{ number_format(Session::get('discount_value'), 2) . config('settings.currency_symbol') }}
                                        @endif
                                    </strong>
                                </dd>
                            </dl>

                            <dl class="dlist-align h4">
                                <dt>Pay:</dt>
                                <dd class="text-right">
                                    <strong>
                                        @if (Session::get('pay_percent') !== null)
                                            {{ number_format(Session::get('pay_percent'), 2) . config('settings.currency_symbol') }}
                                        @elseif (Session::get('pay_value') !== null)
                                            {{ number_format(Session::get('pay_value'), 2) . config('settings.currency_symbol') }}
                                        @endif
                                    </strong>
                                </dd>
                            </dl>
                        @endif
                        <hr>

                        @if (Session::get('coupon_code') === null)
                            <form action="{{ route('coupon.check') }}" class="itemside mb-3" method="POST">
                                @csrf
                                <aside class="aside">
                                    <button type="submit" class="btn btn-success">Apply</button>
                                </aside>
                                <div class="text-wrap small text-muted">
                                    <input type="text" name="coupon_code" class="form-control" placeholder="Coupon Code">
                                </div>
                            </form>
                        @endif

                        @if (Session::get('coupon_code') !== null)
                            <form action="{{ route('coupon.cancel') }}" class="itemside mb-3" method="POST">
                                @csrf
                                <aside class="aside">
                                    <button type="submit" class="btn btn-warning">Cancel Apply</button>
                                </aside>
                            </form>
                        @endif

                        <figure class="itemside mb-3">
                            <aside class="aside"><img src="{{ asset('frontend/images/icons/pay-visa.png') }}"></aside>
                            <div class="text-wrap small text-muted">
                                Pay 84.78 AED ( Save 14.97 AED ) By using ADCB Cards
                            </div>
                        </figure>
                        <figure class="itemside mb-3">
                            <aside class="aside"> <img src="{{ asset('frontend/images/icons/pay-mastercard.png') }}">
                            </aside>
                            <div class="text-wrap small text-muted">
                                Pay by MasterCard and Save 40%. <br> Lorem ipsum dolor
                            </div>
                        </figure>

                        @if ((int) Cart::getSubTotal() !== 0)
                            <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg btn-block">
                                Proceed To Checkout
                            </a>
                        @endif
                    </aside>
                @endif
            </div>
        </div>
    </section>
@stop
