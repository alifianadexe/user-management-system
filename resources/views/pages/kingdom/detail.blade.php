@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => isset($kingdom) ? 'Edit Kingdom' : 'Add Kingdom'])
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
                <form role="form" method="POST" action={{ isset($kingdom) ? route('kingdom.update', ['id' => $kingdom->id]) : route('kingdom.store') }} enctype="multipart/form-data">
                        @csrf
                        @if(isset($kingdom))
                            <input type="hidden" name="id" value="{{ encrypt($kingdom->id) }}">
                        @endif
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">{{ isset($kingdom) ? 'Edit Kingdom' : 'Add Kingdom' }}</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Kingdom Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kingdom_id" class="form-control-label">Kingdom ID</label>
                                        <input type="number" class="form-control" name="kingdom_id" value="{{ old('kingdom_id', isset($kingdom) ? $kingdom->kingdom_id : '') }}">
                                        @error('kingdom_id') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="desc" class="form-control-label">Kingdom Description</label>
                                        <input type="text" class="form-control" name="desc" value="{{ old('desc', isset($kingdom) ? $kingdom->desc : '') }}">
                                        @error('desc') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- <form role="form" method="POST" action={{isset($kingdoms) ? route('kingdom.update') : route('kingdom.store')}} enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ !isset($kingdoms) ? "" : old('id', encrypt($users->id)) }}">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">{{ !isset($kingdoms) ? "Add" : "Edit" }} Kingdom</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Kingdom Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Kingdom ID</label>
                                        <input class="form-control" type="number" name="kingdom_id"  value="{{ !isset($kingdoms) ? "" : old('kingdom_id', $kingdoms->kingdom_id) }}">
                                        @error('kingdom_id') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Kingdom Description</label>
                                        <input class="form-control" type="teks" name="desc"  value="{{ !isset($kingdoms) ? "" : old('desc', $kingdoms->desc) }}">
                                        @error('desc') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> -->
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
