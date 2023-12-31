@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Kingdom Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div id="alert">
                @include('components.alert')
            </div>
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Kingdoms</h6>
                    <div class="col-md-10">
                    </div>
                    <div class="col-md-13 text-end">
                        <a href="{{ route('kingdom.show') }}" data-bs-toggle="tooltip" data-bs-title="Add"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        <table id="myTable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kingdom ID
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Description
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Created Date</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Updated Date</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kingdoms as $i => $kingdom)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <p class="text-sm font-weight-bold mb-0">{{ $kingdom->kingdom_id }}</p>
                                        </td>
                                        <td class="align-middle text-left text-sm" style="white-space: normal; word-wrap: break-word;">
                                            <p class="text-sm font-weight-bold mb-0">{{ $kingdom->desc }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $kingdom->created_at }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $kingdom->updated_at }}</p>
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                <a href="{{ route('kingdom.edit', ['id' => encrypt($kingdom->id)]) }}"
                                                    data-bs-toggle="tooltip" data-bs-title="Edit" class="ms-2">
                                                    <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Edit</p>
                                                </a>
                                                <a href="{{ route('kingdom.delete', ['id' => encrypt($kingdom->id)]) }}"
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
