@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
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
                    <div class="table-responsive p-3">
                        <table id="myTable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
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
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Create Date</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction_id => $transaction)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $transaction['firstname'] }}
                                                        {{ $transaction['lastname'] }}</h6>
                                                </div>
                                            </div>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $transaction['kingdom_id'] }}</p>
                                        </td>
                                        @foreach ($resources_name as $resource_name)
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">
                                                    @if (array_key_exists($resource_name, $transaction['qty_accept']) &&
                                                            array_key_exists($resource_name, $transaction['resources']))
                                                        @if ($transaction['status'] == 'approved')
                                                            {{ $transaction['qty_accept'][$resource_name] }}
                                                        @else
                                                            {{ $transaction['resources'][$resource_name] }}
                                                        @endif
                                                    @else
                                                        0
                                                    @endif
                                                </p>
                                            </td>
                                        @endforeach

                                        <td class="align-middle  text-center text-sm">
                                            @if ($transaction['status'] == 'pending')
                                                <span
                                                    class="badge badge-sm bg-gradient-secondary">{{ $transaction['status'] }}</span>
                                            @elseif ($transaction['status'] == 'approved')
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ $transaction['status'] }}</span>
                                            @else
                                                <span
                                                    class="badge badge-sm bg-gradient-danger">{{ $transaction['status'] }}</span>
                                            @endif
                                        </td>


                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $transaction['created_at'] }}</p>
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                @if ($transaction['status'] == 'pending')
                                                    <a href="{{ route('transactions.approve', ['id' => encrypt($transaction_id)]) }}"
                                                        data-bs-toggle="tooltip" data-bs-title="Approve" class="ms-2">
                                                        <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Approve
                                                        </p>
                                                    </a>
                                                    <a href="{{ route('transactions.edit', ['id' => encrypt($transaction_id)]) }}"
                                                        data-bs-toggle="tooltip" data-bs-title="Adjust" class="ms-2">
                                                        <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Adjust
                                                        </p>
                                                    </a>
                                                    <a href="{{ route('transactions.reject', ['id' => encrypt($transaction_id)]) }}"
                                                        data-bs-toggle="tooltip" data-bs-title="Reject" class="ms-2">
                                                        <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Reject
                                                        </p>
                                                    </a>
                                                @endif
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
