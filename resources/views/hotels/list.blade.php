@extends('layouts.app')

@section('content')
@if(isset($hotels['ads']))
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Hotel List</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Rating</th>
                                <th>Reviews</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hotels['ads'] as $hotel)
                                <tr>
                                    <td>
                                        @isset($hotel['thumbnail'])
                                            <img class="card-img-top" src="{{ $hotel['thumbnail'] }}" alt="Hotel image">
                                        @else
                                            <img class="card-img-top" src="{{ asset('assets/img/no-hotels.jpg') }}" alt="Hotel image">
                                        @endisset
                                    </td>
                                    <td>{{ $hotel['title'] }}</td>
                                    <td>
                                        @isset($hotel['price'])
                                            {{ $hotel['price'] }}
                                        @else
                                            No price
                                        @endif
                                    </td>
                                    <td>
                                        @isset($hotel['rating'])
                                            {{ $hotel['rating'] }}
                                        @else
                                            No rating
                                        @endif
                                    </td>
                                    <td>
                                        @isset($hotel['reviews'])
                                            {{ $hotel['reviews'] }}
                                        @else
                                            No reviews
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
    @include('errors.error')
@endif
@endsection
