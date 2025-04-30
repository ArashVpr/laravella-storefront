<section>
    <div class="container">
        <h2>Latest Added Cars</h2>
        <div class="car-items-listing">
            @foreach ($cars as $car)
                {{-- @if ($car->published_at) --}}
                    <x-car-items :$car :in-watchlist="$car->favoredUsers->contains(
                        \Illuminate\Support\Facades\Auth::user())"/>
                {{-- @endif --}}
            @endforeach
        </div>
    </div>
</section>
