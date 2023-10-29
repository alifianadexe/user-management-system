@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'History Sell'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>History Sell table</h6>
                        <div class="col-md-10">
                        </div>
                    </div>
                    <div class="card-body px-2 pt-2 pb-5">
                        <div class="table-responsive p-3">
                            <table id="myTable" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            No</th>
                                        <th
                                            class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID Transactions</th>
                                        @if ($ownership != 'user')
                                            <th
                                                class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                User</th>
                                        @endif
                                        <th
                                            class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kingdom ID</th>
                                        <th
                                            class="text-uppercase  align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Resource Name</th>
                                        <th
                                            class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Amount Accepted</th>
                                        <th
                                            class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Price</th>
                                        <th
                                            class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status Transactions</th>
                                        <th
                                            class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Approved At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history_sell as $i => $history)
                                        <tr>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">{{ $no++ }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">{{ $history->transaction_id }}</p>
                                            </td>

                                            @if ($ownership != 'user')
                                                <td class="align-middle text-center text-sm">
                                                    <p class="text-sm font-weight-bold mb-0">{{ $history->firstname }}
                                                        {{ $history->lastname }}</p>
                                                </td>
                                            @endif
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">{{ $history->kingdom_id }}</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">{{ $history->resource_name }}</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">{{ $history->qty }}</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ 'Rp ' . number_format($history->total_price, 0, ',', '.') }}</p>
                                            </td>

                                            <td class="align-middle  text-center text-sm">
                                                @if ($history->status_transactions == 'pending')
                                                    <span
                                                        class="badge badge-sm bg-gradient-secondary">{{ $history->status_transactions }}</span>
                                                @elseif ($history->status_transactions == 'approved')
                                                    <span
                                                        class="badge badge-sm bg-gradient-success">{{ $history->status_transactions }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-sm bg-gradient-danger">{{ $history->status_transactions }}</span>
                                                @endif
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $history->created_at }}</p>
                                            </td>

                                            {{-- Button Action --}}

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
