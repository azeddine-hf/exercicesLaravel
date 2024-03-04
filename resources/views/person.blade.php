@extends('app')

@section('content')
    <div class="p-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item @if(Route::currentRouteName() != 'countries') active @endif">
                    @if(Route::currentRouteName() != 'countries')
                        <a href="{{ route('countries') }}">Countries</a>
                    @else
                        <span class="text-muted">Countries</span>
                    @endif
                </li>
                <li class="breadcrumb-item @if(Route::currentRouteName() != 'cities') active @endif">
                    @if(Route::currentRouteName() != 'cities')
                        <a href="{{ route('cities') }}">Cities</a>
                    @else
                        <span class="text-muted">Cities</span>
                    @endif
                </li>
                <li class="breadcrumb-item @if(Route::currentRouteName() != 'persons') active @endif">
                    @if(Route::currentRouteName() != 'persons')
                        <a href="{{ route('persons') }}">People</a>
                    @else
                        <span class="text-muted">People</span>
                    @endif
                </li>
            </ol>
        </nav>

        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPersonModal">
                    Add Person
                </button>
            </div>
        </div>

        <div class="sessionMessage m-2">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>

        <table id="persons_table" class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>City</th>
                <th>Coutry</th>
            </tr>
            </thead>
            <tbody>
            {{-- Loop through persons data and display in table --}}
            @foreach($persons as $person)
                <tr>
                    <td>{{ $person->id }}</td>
                    <td>{{ $person->name }}</td>
                    <td>{{ $person->city->name }}</td>
                    <td>{{ $person->city->country->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Add Person Modal --}}
        <div class="modal fade" id="addPersonModal" tabindex="-1" aria-labelledby="addPersonModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPersonModalLabel">Add Person</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('persons.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Person Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="city_id" class="form-label">City</label>
                                <select class="form-select" id="city_id" name="city_id" required>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#persons_table').DataTable();
        });
    </script>
@endsection
