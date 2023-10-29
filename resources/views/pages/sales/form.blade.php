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
                    <form role="form" method="POST" action={{ route('transactions.update') }}
                        enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">

                            {{-- Kingdom ID --}}
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Kingdom ID</label>
                                        <select class="form-control" name="kingdom_id">
                                            <option value="{{ $transactions['kingdom_id'] }}">
                                                {{ $transactions['kingdom_id'] }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            @foreach ($resources_name as $i => $resource)
                                <div class="row">
                                    {{-- Resource Name
                                  (Stone, Food, Wood, Gold) --}}


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Resource Name</label>
                                            <input class="form-control" type="text"
                                                name="resource_name_{{ $resource }}" value="{{ $resource }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Unit</label>
                                            <input class="form-control" type="number" min="0"
                                                onchange="calculate_price('{{ strtolower($resource) }}')"
                                                id="{{ strtolower($resource) }}" class="resources_controller"
                                                name="{{ strtolower($resource) }}"
                                                value="{{ $transactions['resources'][$resource] }}">

                                        </div>
                                    </div>

                                    {{-- Resource Price --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Resource
                                                Price</label>
                                            <input type="hidden" id="price_{{ strtolower($resource) }}"
                                                name="price_{{ strtolower($resource) }}"
                                                value="{{ $transactions['resources_price'][$resource] }}">
                                            <input type="hidden" id="stock_id_{{ strtolower($resource) }}"
                                                name="stock_id_{{ strtolower($resource) }}"
                                                value="{{ $transactions['stock_id'][$resource] }}">
                                            <input type="number" min="0"
                                                id="resource_price_{{ strtolower($resource) }}"
                                                name="resource_price_{{ strtolower($resource) }}" class="form-control"
                                                value="{{ $transactions['resources'][$resource] * $transactions['resources_price'][$resource] }}">

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Button Save --}}
                            <input type="hidden" name="id"
                                value="{{ !isset($transactions) ? '' : old('id', encrypt($transactions['transaction_id'])) }}">
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto"
                                    style="margin-top: 20px;">Save</button>
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
