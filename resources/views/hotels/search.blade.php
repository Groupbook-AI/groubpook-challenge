@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lista de Hoteles</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="search-form" method="POST" action="{{ route('hotels.search') }}" class="row gx-3 gy-2 align-items-center">
                        @csrf
                        @include('components.hotel-search-form')
                    </form>

                    <div id="search-results">
                        @if(isset($hotels['ads']))
                            @include('components.hotel-list')
                        @else
                            @include('errors.error')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#search-results').html(response);
                    }
                });
            });
        });
    </script>
@endsection
