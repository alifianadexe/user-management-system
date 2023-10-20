@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Stocks'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Stocks table</h6>
                        <div class="col-md-10">
                        </div>
                        <div class="col-md-13 text-end">
                            <a href="{{ route('stocks.show') }}" data-bs-toggle="tooltip" data-bs-title="Add"
                                class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-2 pt-2 pb-5">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kingdom ID</th>
                                        <th
                                            class="text-uppercase  align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Resource Name</th>
                                        <th
                                            class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Amount</th>
                                        <th
                                            class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Price</th>
                                        <th
                                            class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Created At</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stocks as $i => $stock)
                                        <tr>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">{{ $stock->kingdom_id_at }}</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">{{ $stock->resource_name }}</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">{{ $stock->amount }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <?php $unit = $stock->unit <= 0 ? 1 : $stock->unit; ?>
                                                <?php $totalPrice = ($stock->amount / $unit) * $stock->resource_price; ?>
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ 'Rp ' . number_format($totalPrice, 0, ',', '.') }}
                                                </p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $stock->created_at_time }}</p>
                                            </td>

                                            {{-- Button Action --}}
                                            <td class="align-middle text-end">
                                                <div class="d-flex px-3 py-1 justify-content-center align-items-center">

                                                    <a href="{{ route('stocks.edit', ['id' => encrypt($stock->stocks_id_main)]) }}"
                                                        data-bs-toggle="tooltip" data-bs-title="Edit" class="ms-2">
                                                        <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Edit
                                                        </p>
                                                    </a>

                                                    <a href="{{ route('stocks.delete', ['id' => encrypt($stock->stocks_id_main)]) }}"
                                                        data-bs-toggle="tooltip" data-bs-title="Delete" class="ms-2">
                                                        <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Delete
                                                        </p>
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
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
