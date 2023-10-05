@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Resource Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div id="alert">
                @include('components.alert')
            </div>
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Resources</h6>
                    <div class="col-md-10">
                    </div>
                    <div class="col-md-13 text-end">
                        <a href="{{ route('user.show')}}" data-bs-toggle="tooltip" data-bs-title="Add" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kingdom ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Food
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Wood
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stone
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Gold
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">User
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No. Handphone</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">2254</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">200 / 1500</p>
                                        </td>
                            </tr>        
                                <!-- @foreach( $users as $i => $user )
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div>
                                                    <img src="./img/team-1.jpg" class="avatar me-3" alt="image">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user->firstname }} {{ $user->lastname }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->ownership }}</p>
                                        </td>
                                        <td class="align-middle  text-center text-sm">
                                            @if($user->status == "pending")
                                                <span class="badge badge-sm bg-gradient-secondary">{{ $user->status }}</span>
                                            @elseif($user->status == "active")
                                                <span class="badge badge-sm bg-gradient-success">{{ $user->status }}</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-danger">{{ $user->status }}</span>
                                            @endif
                                        </td>    
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->created_at }}</p>
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                <a href="{{ route('user.edit', ['id' => encrypt($user->id)] )}}" data-bs-toggle="tooltip" data-bs-title="Edit" class="ms-2">
                                                    <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Edit</p>
                                                </a>
                                                <a href="{{ route('user.delete', ['id' => encrypt($user->id)] )}}" data-bs-toggle="tooltip" data-bs-title="Delete" class="ms-2">
                                                    <p class="text-sm font-weight-bold mb-0 ps-2 cursor-pointer">Delete</p>
                                                </a>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach -->
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
