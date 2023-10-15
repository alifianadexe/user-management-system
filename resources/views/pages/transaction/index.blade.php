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
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
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
                                        <td class="align-middle  text-center text-sm">

                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $transaction['firstname'] }} {{ $transaction['lastname'] }}</p>

                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $transaction['kingdom_id'] }}</p>
                                        </td>
                                        @foreach ($resources_name as $resource_name)
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $transaction['resources'][$resource_name] }}</p>
                                            </td>
                                        @endforeach

                                        <td class="align-middle  text-center text-sm">
                                            @if ($transaction['status'] == 'pending')
                                                <span
                                                    class="badge badge-sm bg-gradient-secondary">{{ $transaction['status'] }}</span>
                                            @elseif ($transaction['status'] == 'active')
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

                                                <a href="{{ route('transactions.edit', ['id' => encrypt($transaction_id)]) }}"
                                                    data-bs-toggle="tooltip" data-bs-title="Edit" class="ms-2">
                                                    <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Edit</p>
                                                </a>
                                                <a href="{{ route('transactions.delete', ['id' => encrypt($transaction_id)]) }}"
                                                    data-bs-toggle="tooltip" data-bs-title="Delete" class="ms-2">
                                                    <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Delete</p>
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
        @include('layouts.footers.auth.footer')
    </div>
@endsection
