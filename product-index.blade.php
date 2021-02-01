@extends('layout/auth')

@section('content')
    <div class="grey-section border-top-0 mb-3">
        <h3><i class="fa fa-slideshare"></i>&nbsp;&nbsp;{{ transUi('Conference / Upgrades') }}</h3>
        <p class="mb-0">{{ transUi('View conferences and book on today') }}</p>
    </div>

    @if (basket_product_count() > 0)
        <p class="text-center mt-2 mb-4">
            <a
                class="btn btn-primary btn-md"
                href="{{ route('basket') }}"
            >
                Continue to basket&nbsp;&nbsp;<i class="fa fa-shopping-cart"></i>
            </a>
        </p>
    @endif

    <div class="row">
        @foreach ($products as $product)
            @php
                $inBasket = false;
                $booked   = false;
                $included = false;

                if ($basketInfo && isset($basketInfo[$product->identifier])) {
                    if ($basketInfo[$product->identifier] == 'basket') {
                        $inBasket = true;
                    } elseif($basketInfo[$product->identifier] == 'booked') {
                        $booked = true;
                    } elseif($basketInfo[$product->identifier] == 'included') {
                        $included = true;
                    }
                }
            @endphp
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title text-muted text-center" style="font-size: 15px;"
                            @if($inBasket)
                                class="inBasket"
                            @elseif($booked)
                                class="booked"
                            @elseif($included)
                                class="included"
                            @endif
                        >
                            <strong>{{ $product->name }}</strong>&nbsp;
                            <i
                                data-toggle="tooltip"
                                data-placement="right"
                                title="Click for more information"
                                class="fa fa-info-circle more-info"
                                id="{{ $product->identifier }}-more-info"
                                style="cursor: pointer"
                            >
                            </i>
                        </p>
                        <hr>
                        <p class="text-center" style="font-size: 15px;">
                            @if(focVisitor() == 'student' && !in_array($product->identifier, ['visitor', 'p-access']))
                                &pound; 10.00 inc VAT
                            @elseif(earlyBirdCheck($product->identifier))
                                @if($product->identifier == 'visitor')
                                    &pound; 50.00 inc VAT
                                @elseif($product->identifier == 'ww')
                                    &pound; 149.00 + VAT
                                @elseif($product->identifier == 'writers-summit')
                                    &pound; 149.00 + VAT
                                @elseif($product->identifier == 'forum')
                                    &pound; 149.00 + VAT
                                @endif
                            @else
                                {{ $product->cost_formatted }} + VAT
                            @endif
                        </p>
                        @if($inBasket)
                            <a
                                class="btn btn-danger btn-sm"
                                href="/remove-product/{{ $product->id }}"
                                style="width: 100%; color: #fff; text-decoration: none;"
                            >
                                Remove from basket&nbsp;&nbsp;<i class="fa fa-trash"></i>
                            </a>
                        @elseif($booked)
                            <a
                                class="btn btn-success btn-sm disabled"
                                href="#"
                                style="width: 100%; color: #fff; text-decoration: none;"
                            >
                                Already purchased&nbsp;&nbsp;<i class="fa fa-check"></i>
                            </a>
                        @elseif($included)
                            <a
                                class="btn btn-success btn-sm disabled"
                                href="#"
                                style="width: 100%; color: #fff; text-decoration: none;"
                            >
                                Included in selection&nbsp;&nbsp;<i class="fa fa-check"></i>
                            </a>
                        @elseif(isset($productClashes[$product->identifier]))
                            <a
                                class="btn btn-secondary btn-sm disabled"
                                href="#"
                                style="width: 100%; color: #fff; text-decoration: none;"
                            >
                                Clashes with other selections&nbsp;&nbsp;<i class="fa fa-exclamation-triangle"></i>
                            </a>
                        @else
                            <a
                                class="btn btn-primary btn-sm"
                                href="/add-product/{{ $product->id }}"
                                style="width: 100%; color: #fff; text-decoration: none;"
                            >
                                Add to basket&nbsp;&nbsp;<i class="fa fa-shopping-cart"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if (basket_product_count() > 0)
        <p class="text-center mt-2 mb-0">
            <a
                class="btn btn-primary btn-md"
                href="{{ route('basket') }}"
            >
                Continue to basket&nbsp;&nbsp;<i class="fa fa-shopping-cart"></i>
            </a>
        </p>
    @endif
    @include('partials/modals')
@endsection

@push('js')
    <script>
        $(document).on('click', '.more-info', function () {
            var e = $(this).attr('id');
            $('#' + e + '-modal').modal();
        });
    </script>
@endpush
