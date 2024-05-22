@if(isset($hotels['ads']))
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
@else
    @include('errors.error')
@endif