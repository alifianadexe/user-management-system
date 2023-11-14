@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $title])s
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div id="alert">
                    @include('components.alert')
                </div>
                <div class="card">
                    {{-- Form --}}
                    <form role="form" method="POST"
                        action={{ isset($resources) ? route('resources.update') : route('resources.store') }}
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            {{-- Kingdom ID --}}
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Kingdom ID</label>
                                        <div class="custom-select">
                                            <select class="form-control my-select" name="kingdom_id">
                                                @foreach ($kingdoms as $i => $kingdom)
                                                    @if ($kingdom->id == $resources['kingdom_id'])
                                                        <option value="{{ $kingdom->id }}"> {{ $kingdom->kingdom_id }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $kingdom->id }}"> {{ $kingdom->kingdom_id }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('email')
                                            <p class='text-danger text-xs pt-1'> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @foreach ($resources_name as $i => $resource_name)
                                <div class="row">
                                    {{-- Resource Name
                                  (Stone, Food, Wood, Gold) --}}

                                    <input type="hidden" name="{{ strtolower($resource_name) . '_id' }}"
                                        value="{{ !isset($resources) ? '' : $resources[$resource_name . '_id'] }}">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Resource Name</label>
                                            <input class="form-control" type="text"
                                                name="resource_name_{{ strtolower($resource_name) }}"
                                                value="{{ $resource_name }}" readonly>
                                            @error('email')
                                                <p class='text-danger text-xs pt-1'> {{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Unit</label>
                                            <input class="form-control" type="number" min="1"
                                                name="unit_{{ strtolower($resource_name) }}"
                                                value="{{ !isset($resources) ? 1 : $resources[$resource_name . '_unit'] }}">
                                            @error('lastname')
                                                <p class='text-danger text-xs pt-1'> {{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Resource Price --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Resource
                                                Price</label>
                                            <input type="number" min="0"
                                                name="resource_price_{{ strtolower($resource_name) }}" class="form-control"
                                                value="{{ !isset($resources) ? 0 : $resources[$resource_name] }}">
                                            @error('password')
                                                <p class='text-danger text-xs pt-1'> {{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Button Save --}}
                            <input type="hidden" name="id"
                                value="{{ !isset($resources) ? '' : old('id', encrypt($resources['id'])) }}">
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto"
                                    style="margin-top: 20px;">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
