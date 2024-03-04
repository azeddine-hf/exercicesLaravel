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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCityModal">
                    Add City
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

        <table id="cities_table" class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Country</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            {{-- Loop through cities data and display in table --}}
            @foreach($cities as $city)
                <tr>
                    <td>{{ $city->id }}</td>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->country->name }}</td>
                    <td>
                        <button type="button" class="btn btn-secondary view-people" data-city-id="{{ $city->id }}">View People</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Add City Modal --}}
        <div class="modal fade" id="addCityModal" tabindex="-1" aria-labelledby="addCityModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCityModalLabel">Add City</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('cities.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">City Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="country_id" class="form-label">Country</label>
                                <select class="form-select" id="country_id" name="country_id" required>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
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
        {{-- People Modal --}}
        <div class="modal fade" id="personModal" tabindex="-1" aria-labelledby="citiesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="citiesModalLabel">Cities</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="personList" class="list-group">
                            <!-- City list will be dynamically populated here -->
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            $('#cities_table').DataTable();

            // Event handler for clicking "View Cities" button
            $('.view-people').click(function () {
                var cityId = $(this).data('city-id');
                fetchPeople(cityId);
            });

            // Function to fetch and display cities of a country
            function fetchPeople(cityId) {
                $.ajax({
                    url: '/people/' + cityId + '/cities',
                    type: 'GET',
                    success: function (response) {
                        if(response.length > 0){
                            displayPeople(response);
                        }else{
                            var personsList = $('#personList');
                            personsList.empty();
                            personsList.append('<li class="list-group-item">No Person</li>');
                            $('#personModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Function to display cities in the modal
            function displayPeople(people) {
                var personsList = $('#personList');
                personsList.empty();
                people.forEach(function (person) {
                    if(person.name !== null && person.name !== ''){
                        personsList.append('<li class="list-group-item">' + person.name + '</li>');
                    }else{
                        personsList.append('<li class="list-group-item">No Person</li>');
                    }
                });
                $('#personModal').modal('show');
            }
        });
    </script>
@endsection
