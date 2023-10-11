@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $title])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    {{-- Form --}}
                    <form role="form" method="POST"
                        action={{ !empty($stocks) ? route('stocks.update') : route('stocks.store') }}
                        enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">

                            @if (empty($stocks))
                                {{-- Kingdom ID --}}
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Kingdom ID</label>
                                            <select class="form-control" name="kingdom_id">
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
                                            @error('kingdom')
                                                <p class='text-danger text-xs pt-1'> {{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Description</label>
                                            <input class="form-control" type="text" name="description"
                                                value="{{ !empty($stocks) ? '' : $resources['desc'] }}">
                                            @error('desc')
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
                                            value="{{ !empty($stocks) ? '' : $resources[$resource_name . '_id'] }}">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Resource
                                                    Name</label>
                                                <input class="form-control" type="text"
                                                    name="resource_name_{{ strtolower($resource_name) }}"
                                                    value="{{ $resource_name }}" readonly>

                                            </div>
                                        </div>

                                        {{-- Unit --}}
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Unit</label>
                                                <input class="form-control" type="number"
                                                    name="unit_{{ strtolower($resource_name) }}"
                                                    value="{{ !empty($stocks) ? 0 : $resources[$resource_name . '_unit'] }}">

                                            </div>
                                        </div>


                                    </div>
                                @endforeach
                            @endif
                            {{-- Button Save --}}
                            <input type="hidden" name="id"
                                value="{{ empty($stocks) ? '' : old('id', encrypt($stocks['id'])) }}">
                            <div class="card-header pb-0">
                                <div>
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
