@extends('site.app')
@section('title', 'Homepage')

@section('content')
    <section class="section-content bg padding-y">
        <div class="container">
            <h2>Homepage</h2>
            <div id="code_prod_complex">
                <div class="row">
                    <div class="col-3">
                        <a href="{{ Route('home.desc.price') }}" class="">Soft by desc price</a><br>
                        <a href="{{ Route('home.asc.price') }}" class="">Soft by asc price</a>
                    </div>
                    <div class="col-9">
                        <div class="row">
                            @forelse($filter as $filterr)
                                <div class="col-4">
                                    <figure class="card card-product">
                                        @if ($filterr->images->count() > 0)
                                            <div class="img-wrap padding-y"><img
                                                    src="{{ asset('storage/' . $filterr->images->first()->full) }}"
                                                    alt="">
                                            </div>
                                        @else
                                            <div class="img-wrap padding-y"><img src="https://via.placeholder.com/176"
                                                    alt=""></div>
                                        @endif
                                        <figcaption class="info-wrap">
                                            <h4 class="title"><a
                                                    href="{{ route('product.show', $filterr->slug) }}">{{ $filterr->name }}</a>
                                            </h4>
                                        </figcaption>
                                        <div class="bottom-wrap">
                                            <a href="{{ route('product.show', $filterr->slug) }}"
                                                class="btn btn-sm btn-success float-right">View Details</a>
                                            @if ($filterr->sale_price != 0)
                                                <div class="price-wrap h5">
                                                    <span class="price">
                                                        {{ config('settings.currency_symbol') . $filterr->sale_price }}
                                                    </span>
                                                    <del class="price-old">
                                                        {{ config('settings.currency_symbol') . $filterr->price }}</del>
                                                </div>
                                            @else
                                                <div class="price-wrap h5">
                                                    <span class="price">
                                                        {{ config('settings.currency_symbol') . $filterr->price }}
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
