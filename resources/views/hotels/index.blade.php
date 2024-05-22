<h3>List of hotels</h3>
@if (isset($hotelPrices))
    @foreach($hotelPrices as $hotel)
        <div>
            <h3>{{ $hotel->name }}</h3>
            <p>{{ $hotel->description }}</p>
        </div>
    @endforeach
@else
    @include('errors.error')
@endif