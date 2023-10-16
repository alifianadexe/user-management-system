@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $title])

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Resource</h6>
                </div>
                <div class="card-header pb-0">
                    <div class="col-md-13 text-end">
                        <a href="{{ route('resources.add') }}" data-bs-toggle="tooltip" data-bs-title="Add"
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kingdom ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Food
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Wood
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Stone
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Gold
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resources as $id => $resource)
                                    <tr>
                                        <td class="align-middle">
                                            <p class="text-sm font-weight-bold mb-0">{{ $resource['kingdom_id'] }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $resource['Food'] }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $resource['Wood'] }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $resource['Stone'] }}</p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $resource['Gold'] }}</p>
                                        </td>
                                        {{-- Button Action --}}
                                        <td class="align-middle text-end">
                                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                <a href="{{ route('resources.edit', ['id' => encrypt($resource['id'])]) }}"
                                                    data-bs-toggle="tooltip" data-bs-title="Edit" class="ms-2">
                                                    <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Edit</p>
                                                </a>
                                                <a href="{{ route('resources.delete', ['id' => encrypt($resource['id'])]) }}"
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
