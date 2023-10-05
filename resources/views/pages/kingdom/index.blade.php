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
                        <a href="{{ route('kingdom.show')}}" data-bs-toggle="tooltip" data-bs-title="Add" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Number</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status
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
                                @foreach( $kingdoms as $i => $kingdom )
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div>
                                                    <img src="./img/team-1.jpg" class="avatar me-3" alt="image">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $kingdom->firstname }} {{ $kingdom->lastname }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $kingdom->ownership }}</p>
                                        </td>
                                        <td class="align-middle  text-center text-sm">
                                            @if($kingdom->status == "pending")
                                                <span class="badge badge-sm bg-gradient-secondary">{{ $kingdom->status }}</span>
                                            @elseif($kingdom->status == "active")
                                                <span class="badge badge-sm bg-gradient-success">{{ $kingdom->status }}</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-danger">{{ $kingdom->status }}</span>
                                            @endif
                                        </td>    
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $kingdom->created_at }}</p>
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                @if($kingdom->status == "pending")
                                                    <a href="{{ route('kingdom.approve', ['id' => encrypt($kingdom->id)] )}}" data-bs-toggle="tooltip" data-bs-title="Approve">
                                                        <p class="text-sm font-weight-bold mb-0 cursor-pointer">Approve</p>
                                                    </a>

                                                    <a href="{{ route('kingdom.reject', ['id' => encrypt($kingdom->id)] )}}" data-bs-toggle="tooltip" data-bs-title="Reject" class="ms-2">
                                                        <p class="text-sm font-weight-bold ps-2 mb-0 cursor-pointer">Reject</p>
                                                    </a>
                                                @endif
                                                
                                                <a href="{{ route('kingdom.edit', ['id' => encrypt($kingdom->id)] )}}" data-bs-toggle="tooltip" data-bs-title="Edit" class="ms-2">
                                                    <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Edit</p>
                                                </a>
                                                <a href="{{ route('kingdom.delete', ['id' => encrypt($kingdom->id)] )}}" data-bs-toggle="tooltip" data-bs-title="Delete" class="ms-2">
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
