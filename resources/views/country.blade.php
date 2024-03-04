@extends('app')

@section('content')
    <div class="p-5">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item @if(Route::currentRouteName() != 'countries' || Route::currentRouteName() != 'home') active @endif">
                    @if(Route::currentRouteName() != 'countries' && Route::currentRouteName() != 'home')
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCountryModal">
                    Add Country
                </button>
            </div>
        </div>

        <div class="sessionMEssage m-2">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>

        <table id="countries_table" class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            {{-- Loop through countries data and display in table --}}
            @foreach($countries as $country)
                <tr>
                    <td>{{ $country->id }}</td>
                    <td>{{ $country->name }}</td>
                    <td>
                        <button type="button" class="btn btn-secondary view-cities" data-country-id="{{ $country->id }}">View Cities</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Add Country Modal --}}
        <div class="modal fade" id="addCountryModal" tabindex="-1" aria-labelledby="addCountryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCountryModalLabel">Add Country</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('countries.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Country Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
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
        {{-- Cities Modal --}}
        <div class="modal fade" id="citiesModal" tabindex="-1" aria-labelledby="citiesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="citiesModalLabel">Cities</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="citiesList" class="list-group">
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
            $('#countries_table').DataTable();

            // Event handler for clicking "View Cities" button
            $('.view-cities').click(function () {
                var countryId = $(this).data('country-id');
                fetchCities(countryId);
            });

            // Function to fetch and display cities of a country
            function fetchCities(countryId) {
                $.ajax({
                    url: '/countries/' + countryId + '/cities',
                    type: 'GET',
                    success: function (response) {
                        if(response.length > 0){
                            displayCities(response);

                        }else{
                            var citiesList = $('#citiesList');
                            citiesList.empty();
                            citiesList.append('<li class="list-group-item">No City</li>');
                            $('#citiesModal').modal('show');

                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Function to display cities in the modal
            function displayCities(cities) {
                var citiesList = $('#citiesList');
                citiesList.empty();
                cities.forEach(function (city) {
                    if(city.name!=null)
                    {
                        citiesList.append('<li class="list-group-item">' + city.name + '</li>');
                    }else{
                        citiesList.append('<li class="list-group-item">No City</li>');
                    }
                });
                $('#citiesModal').modal('show');
            }
        });
    </script>
@endsection
