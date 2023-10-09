@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $title])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  {{-- Form --}}
                    <form role="form" method="POST" action={{isset($stocks) ? route('resources.update') : route('resources.store')}} enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">

                              {{-- Kingdom ID --}}
                              <div class="row">
                                <div class="col-md-2">
                                  <div class="form-group">
                                      <label for="example-text-input" class="form-control-label">Kingdom ID</label>
                                      <input class="form-control" type="number" name="kingdom_id" value="{{ !isset($stocks) ? "" : "test isset" }}">
                                      @error('email') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                  </div>
                                </div>
                              </div>

                              {{-- Description --}}
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Description</label>
                                        <input class="form-control" type="text" name="description"  value="{{ !isset($stocks) ? "" : "test isset" }}">
                                        @error('firstname') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                              </div>

                              @foreach( $resources_name as $i => $resource_name )

                              <div class="row">
                                {{-- Resource Name
                                  (Stone, Food, Wood, Gold) --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Resource Name</label>
                                        <input class="form-control" type="text" name="resource_name_{{strtolower($resource_name)}}" value="{{$resource_name}}" readonly>
                                        @error('email') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>

                                {{-- Unit --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Unit</label>
                                        <input class="form-control" type="number" name="unit_{{strtolower($resource_name)}}" value="{{ !isset($stocks) ? "" : "test isset" }}">
                                        @error('lastname') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>

                                {{-- Resource Price --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Resource Price</label>
                                        <input type="number" name="resource_price_{{strtolower($resource_name)}}" class="form-control">
                                        @error('password') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                              </div>

                              @endforeach

                              {{-- Button Save --}}
                              <input type="hidden" name="id" value="{{ !isset($stocks) ? "" : old('id', encrypt($stocks->id)) }}">
                              <div class="card-header pb-0">
                                  <div >
                                      <button type="submit" class="btn btn-primary btn-sm ms-auto">Submit</button>
                                  </div>
                              </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
