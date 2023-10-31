@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $title])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div id="alert">
                @include('components.alert')
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Transactions</h6>
                    <div class="col-md-10">
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="myTable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        ID Transaction
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kingdom
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Stone
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Food
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Wood
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Gold
                                    </th>
                                   
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Buy Date</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Buy Price</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $index => $sale)
                                    <tr>
                                        <td class="align-middle">
                                            <p class="text-sm font-weight-bold mb-0">{{ $sale->id }}</p>
                                        </td>

                                        <td class="align-middle">
                                            <p class="text-sm font-weight-bold mb-0">{{ $sale->kingdom }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ number_format($sale->resources['food']->qty, 0, ',', '.') }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ number_format($sale->resources['wood']->qty, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ number_format($sale->resources['stone']->qty, 0, ',', '.') }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ number_format($sale->resources['gold']->qty, 0, ',', '.') }}</p>
                                        </td>

                                        <td class="align-middle">
                                            <p class="text-sm font-weight-bold mb-0">{{ $sale->buy_date }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ number_format($sale->get_sum(), 0, ',', '.') }}</p>
                                        </td>

                                        {{-- Button Action --}}
                                        @if ($sale->active)
                                        <td>
                                            <span
                                                    class="badge badge-sm bg-gradient-success"> Approve </span>
                                        </td>
                                        @else
                                        <td class="align-middle text-end">
                                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                <a href={{ route('sales.edit', ['id' => encrypt($sale->id)]) }}
                                                    data-bs-toggle="tooltip" data-bs-title="Add Sell Price" class="ms-2">
                                                    <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Add</p>
                                                </a>

                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Profit Tables</h6>
                        <div class="col-md-10">
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="myTable2" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        ID Transaction
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kingdom
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Stone
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Food
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Wood
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Gold
                                    </th>
                                   
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sell Date</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sell Price</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profits as $index => $profit)
                                    <tr>
                                        <td class="align-middle">
                                            <p class="text-sm font-weight-bold mb-0">{{ $profit->id }}</p>
                                        </td>

                                        <td class="align-middle">
                                            <p class="text-sm font-weight-bold mb-0">{{ $profit->kingdom }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ number_format($profit->resources['food']->qty, 0, ',', '.') }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ number_format($profit->resources['wood']->qty, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ number_format($profit->resources['stone']->qty, 0, ',', '.') }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ number_format($profit->resources['gold']->qty, 0, ',', '.') }}</p>
                                        </td>

                                        <td class="align-middle">
                                            <p class="text-sm font-weight-bold mb-0">{{ $profit->buy_date }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ number_format($profit->sell_price, 0, ',', '.') }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0"><b>{{ number_format($profit->profit, 0, ',', '.') }}</b></p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
