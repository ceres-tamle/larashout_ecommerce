@extends('site.app')
@section('title', 'Homepage')

@section('content')
    <section class="section-content bg padding-y">
        <div class="container">
            <h2>Featured</h2>
            <div id="code_prod_complex">
                <div class="row">
                    @forelse($featured as $product)
                        <div class="col-3">
                            <figure class="card card-product">
                                @if ($product->images->count() > 0)
                                    <div class="img-wrap padding-y"><img
                                            src="{{ asset('storage/' . $product->images->first()->full) }}" alt="">
                                    </div>
                                @else
                                    <div class="img-wrap padding-y"><img src="https://via.placeholder.com/176"
                                            alt=""></div>
                                @endif
                                <figcaption class="info-wrap">
                                    <h4 class="title"><a
                                            href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                    </h4>
                                </figcaption>
                                <div class="bottom-wrap">
                                    <a href="{{ route('product.show', $product->slug) }}"
                                        class="btn btn-sm btn-success float-right">View Details</a>
                                    @if ($product->sale_price != 0)
                                        <div class="price-wrap h5">
                                            <span class="price">
                                                {{ config('settings.currency_symbol') . $product->sale_price }}
                                            </span>
                                            <del class="price-old">
                                                {{ config('settings.currency_symbol') . $product->price }}</del>
                                        </div>
                                    @else
                                        <div class="price-wrap h5">
                                            <span class="price">
                                                {{ config('settings.currency_symbol') . $product->price }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </figure>
                        </div>
                    @empty
                        <p>No Products found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="section-content bg padding-y">
        <div class="container">
            <h2>All Products</h2>
            <div id="code_prod_complex">
                <div class="row">
                    <div class="col-3">
                        {{-- <div class="card">
                            <div class="cart-header">
                                <h4 class="text-center">Brand</h4>
                            </div>
                            <div class="cart-body">
                                @foreach ($categories as $category)
                                    <label class="d-block">
                                        <input type="checkbox" value="{{ $category->id }}" /> {{ $category->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div> --}}
                        <a href="{{ Route('home.desc.price') }}" class="">Soft by high price</a><br>
                        <a href="{{ Route('home.asc.price') }}" class="">Soft by low price</a>
                    </div>
                    <div class="col-9">
                        <div class="row">
                            @forelse($products as $product)
                                <div class="col-4">
                                    <figure class="card card-product">
                                        @if ($product->images->count() > 0)
                                            <div class="img-wrap padding-y"><img
                                                    src="{{ asset('storage/' . $product->images->first()->full) }}"
                                                    alt="">
                                            </div>
                                        @else
                                            <div class="img-wrap padding-y"><img src="https://via.placeholder.com/176"
                                                    alt=""></div>
                                        @endif
                                        <figcaption class="info-wrap">
                                            <h4 class="title"><a
                                                    href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                            </h4>
                                        </figcaption>
                                        <div class="bottom-wrap">
                                            <a href="{{ route('product.show', $product->slug) }}"
                                                class="btn btn-sm btn-success float-right">View Details</a>
                                            @if ($product->sale_price != 0)
                                                <div class="price-wrap h5">
                                                    <span class="price">
                                                        {{ config('settings.currency_symbol') . $product->sale_price }}
                                                    </span>
                                                    <del class="price-old">
                                                        {{ config('settings.currency_symbol') . $product->price }}</del>
                                                </div>
                                            @else
                                                <div class="price-wrap h5">
                                                    <span class="price">
                                                        {{ config('settings.currency_symbol') . $product->price }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </figure>
                                </div>
                            @empty
                                <p>No Products found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
