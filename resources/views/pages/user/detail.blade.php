@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management Detail'])
    <div class="card shadow-lg mx-4">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/img/anopics.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->firstname ?? 'Firstname' }} {{ auth()->user()->lastname ?? 'Lastname' }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ auth()->user()->ownership ?? 'Ownership' }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form role="form" method="POST" action={{isset($users) ? route('user.update') : route('user.store')}} enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ !isset($users) ? "" : old('id', encrypt($users->id)) }}">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">{{ !isset($users) ? "Add" : "Edit" }} User</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" value="{{ !isset($users) ? "" : old('email', $users->email) }}">
                                        @error('email') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">First name</label>
                                        <input class="form-control" type="text" name="firstname"  value="{{ !isset($users) ? "" : old('firstname', $users->firstname) }}">
                                        @error('firstname') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Last name</label>
                                        <input class="form-control" type="text" name="lastname" value="{{ !isset($users) ? "" : old('lastname', $users->lastname) }}">
                                        @error('lastname') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Update Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password">
                                        @error('password') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Password Confirmation</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation" aria-label="Password Confirmation">
                                        @error('password_confirmation') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Contact Information</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Phone Number</label>
                                        <input class="form-control" type="number" name="phone_number" value="{{ !isset($users) ? "" : old('phone_number', $users->phone_number) }}">
                                        @error('phone_number') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Ownership</label>
                                        <div class="custom-select">
                                            <select class="form-control mb-2 my-select" name="ownership" id="ownershipSelect">
                                                <option value="owner" {{ (!isset($users) ? "" : old('ownership', $users->ownership)) =='owner' ? 'selected' : ''  }}>Owner</option>
                                                <option value="admin" {{ (!isset($users) ? "" : old('ownership', $users->ownership)) =='admin' ? 'selected' : ''  }}>Admin</option>
                                                <option value="user"  {{ (!isset($users) ? "" : old('ownership', $users->ownership)) =='user' ? 'selected' : ''  }}>User</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Status</label>
                                        <div class="custom-select">
                                            <select class="form-control mb-2 my-select" name="status" id="statusSelect">
                                            <option value="active" {{ (!isset($users) ? "" : old('status', $users->status)) =='active' ? 'selected' : ''  }}>Active</option>
                                            <option value="reject" {{ (!isset($users) ? "" : old('status', $users->status)) =='reject' ? 'selected' : ''  }}>Rejected</option>
                                            <option value="deleted"  {{ (!isset($users) ? "" : old('status', $users->status)) =='deleted' ? 'selected' : ''  }}>Deleted</option>
                                            <option value="pending"  {{ (!isset($users) ? "" : old('status', $users->status)) =='pending' ? 'selected' : ''  }}>Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
