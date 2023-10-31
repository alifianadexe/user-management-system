@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $title])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div id="alert">
                    @include('components.alert')
                </div>
                <div class="card">
                    {{-- Form --}}
                    <form role="form" method="POST" action={{ route('sales.insert') }}>
                        @csrf

                        <div class="card-body">

                            {{-- Kingdom ID --}}
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Kingdom ID</label>
                                        <input class="form-control" type="text"
                                            value="{{ $sale->kingdom }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            {{-- Resource Name (Stone, Food, Wood, Gold) --}}
                            @foreach ($sale->resources as $i => $resource)
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Resource Name</label>
                                            <input class="form-control" type="text"
                                                value="{{ $resource->name }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Qty</label>
                                            <input class="form-control" type="number" min="0"
                                                value="{{ $resource->qty }}"
                                                readonly>

                                        </div>
                                    </div>

                                    {{-- Resource Price --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Total
                                                Price</label>
                                                <input class="form-control" type="number" min="0"
                                                value="{{ $resource->total_price }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="row">
                                {{-- Buy Price --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Buy Price</label>
                                        <input class="form-control" type="number" min="0" name="buy_price"
                                            value="{{ $sale->get_sum() }}"
                                            readonly>
                                    </div>
                                </div>

                                {{-- Sell Price --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Sell Price</label>
                                        <input class="form-control" type="number" min="0" name="sell_price"
                                            value="{{ $sale->get_sum() }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Button Save --}}
                            <input type="hidden" name="id"
                                value="{{ !isset($sale) ? '' : old('id', encrypt($sale->id)) }}">
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto"
                                    style="margin-top: 20px;">Insert</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    <script>
        function calculate_price(id_resource) {
            var price = document.getElementById("price_" + id_resource);
            var amount = document.getElementById(id_resource);
            var total_price = amount.value * price.value;
            document.getElementById("resource_price_" + id_resource).value = new Number(total_price);
        }
    </script>
@endsection
