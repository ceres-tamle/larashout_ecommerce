<dl class="dlist-inline">
    {{-- all attributes --}}
    {{-- @dd($attributes) --}}

    {{-- a product --}}
    {{-- @dd($product) --}}

    {{-- all product attributes --}}
    {{-- @dd($product->attributes) --}}

    {{-- capacity --}}
    @foreach ($attributes as $attribute)
        {{-- first attribute --}}
        {{-- @dd($attribute) --}}
        @php
            $attributeCheck = in_array($attribute->id, $product->attributes->pluck('attribute_id')->toArray());
        @endphp

        @if ($attributeCheck)
            @if ($attribute->name === 'Capacity')
                <div class="py-2">
                    {{-- first attribute name --}}
                    {{-- @dd($attribute->name) --}}
                    <dt>
                        {{ $attribute->name }}:
                    </dt>
                    <dd>
                        <select class="form-control form-control-sm option" style="width:180px;"
                            name="{{ strtolower($attribute->name) }}">
                            <option data-capacityprice="0" value="0">
                                Select {{ $attribute->name }}
                            </option>

                            @foreach ($product->attributes as $attributeValue)
                                {{-- first attribute id --}}
                                {{-- @dd($attribute->id) --}}

                                {{-- compare attribute_id in products table with id in attributes table --}}
                                @if ($attributeValue->attribute_id == $attribute->id)
                                    <option data-capacityprice="{{ $attributeValue->price }}"
                                        value="{{ $attributeValue->value }}">
                                        {{ ucwords($attributeValue->value) }}

                                        @if ($attributeValue->price > 0)
                                            {{ $attributeValue->price }}
                                            @php
                                                $capacity_price = $attributeValue->price;
                                                // echo $capacity_price;
                                            @endphp
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </dd>
                </div>
            @endif
        @endif
    @endforeach

    {{-- color --}}
    @foreach ($attributes as $attribute)
        @php
            $attributeCheck = in_array($attribute->id, $product->attributes->pluck('attribute_id')->toArray());
        @endphp

        @if ($attributeCheck)
            @if ($attribute->name === 'Color')
                <div class="py-2">
                    <dt>
                        {{ $attribute->name }}:
                    </dt>
                    <dd>
                        <select class="form-control form-control-sm option" style="width:180px;"
                            name="{{ strtolower($attribute->name) }}">
                            <option data-colorprice="0" value="0">
                                Select {{ $attribute->name }}
                            </option>

                            @foreach ($product->attributes as $attributeValue)
                                {{-- compare attribute_id in products table with id in attributes table --}}
                                @if ($attributeValue->attribute_id == $attribute->id)
                                    <option data-colorprice="{{ $attributeValue->price }}"
                                        value="{{ $attributeValue->value }}">
                                        {{ ucwords($attributeValue->value) }}

                                        @if ($attributeValue->price > 0)
                                            {{ $attributeValue->price }}
                                            @php
                                                $color_price = $attributeValue->price;
                                                // echo $color_price;
                                            @endphp
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </dd>
                </div>
            @endif
        @endif
    @endforeach

    {{-- materials --}}
    @foreach ($attributes as $attribute)
        @php
            $attributeCheck = in_array($attribute->id, $product->attributes->pluck('attribute_id')->toArray());
        @endphp

        @if ($attributeCheck)
            @if ($attribute->name === 'Materials')
                <div class="py-2">
                    <dt>
                        {{ $attribute->name }}:
                    </dt>
                    <dd>
                        <select class="form-control form-control-sm option" style="width:180px;"
                            name="{{ strtolower($attribute->name) }}">
                            <option data-materialsprice="0" value="0">
                                Select {{ $attribute->name }}
                            </option>

                            @foreach ($product->attributes as $attributeValue)
                                {{-- compare attribute_id in products table with id in attributes table --}}
                                @if ($attributeValue->attribute_id == $attribute->id)
                                    <option data-materialsprice="{{ $attributeValue->price }}"
                                        value="{{ $attributeValue->value }}">
                                        {{ ucwords($attributeValue->value) }}

                                        @if ($attributeValue->price > 0)
                                            {{ $attributeValue->price }}
                                            @php
                                                $materials_price = $attributeValue->price;
                                                // echo $materials_price;
                                            @endphp
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </dd>
                </div>
            @endif
        @endif
    @endforeach

    {{-- size --}}
    @foreach ($attributes as $attribute)
        @php
            $attributeCheck = in_array($attribute->id, $product->attributes->pluck('attribute_id')->toArray());
        @endphp

        @if ($attributeCheck)
            @if ($attribute->name === 'Size')
                <div class="py-2">
                    <dt>
                        {{ $attribute->name }}:
                    </dt>
                    <dd>
                        <select class="form-control form-control-sm option" style="width:180px;"
                            name="{{ strtolower($attribute->name) }}">
                            <option data-sizeprice="0" value="0">
                                Select {{ $attribute->name }}
                            </option>

                            @foreach ($product->attributes as $attributeValue)
                                {{-- compare attribute_id in products table with id in attributes table --}}
                                @if ($attributeValue->attribute_id == $attribute->id)
                                    <option data-sizeprice="{{ $attributeValue->price }}"
                                        value="{{ $attributeValue->value }}">
                                        {{ ucwords($attributeValue->value) }}

                                        @if ($attributeValue->price > 0)
                                            {{ $attributeValue->price }}
                                            @php
                                                $size_price = $attributeValue->price;
                                                // echo $size_price;
                                            @endphp
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </dd>
                </div>
            @endif
        @endif
    @endforeach
</dl>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#addToCart').submit(function(e) {
                if ($('.option').val() == 0) {
                    e.preventDefault();
                    alert('Please select an option');
                }
            });

            // $('.option').change(function() {
            //     $('#productPrice').html(
            //         "{{ $product->sale_price != '' ? $product->sale_price : $product->price }}");
            //     let extraPrice = $(this).find(':selected').data('price');
            //     let price = parseFloat($('#productPrice').html());
            //     let finalPrice = (Number(extraPrice) + price).toFixed(2);
            //     $('#finalPrice').val(finalPrice);
            //     $('#productPrice').html(finalPrice);
            // });

            $('.option').change(function() {
                $('#productPrice').html(
                    "{{ $product->sale_price != '' ? $product->sale_price : $product->price }}"
                );

                // original price
                let price = parseFloat($('#productPrice').html());

                // attributes price
                let extraCapacityPrice = $(this).find(':selected').data('capacityprice');
                let extraColorPrice = $(this).find(':selected').data('colorprice');
                let extraMaterialsPrice = $(this).find(':selected').data('materialsprice');
                let extraSizePrice = $(this).find(':selected').data('sizeprice');

                // let finalPrice = (price + Number(extraSizePrice)).toFixed(2);

                let finalPrice = (price +
                    Number(extraCapacityPrice) +
                    Number(extraColorPrice) +
                    Number(extraMaterialsPrice) +
                    Number(extraSizePrice)).toFixed(2);

                $('#finalPrice').val(finalPrice);
                $('#productPrice').html(finalPrice);
            });
        });
    </script>
@endpush
