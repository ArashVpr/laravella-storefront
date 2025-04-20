@extends('layouts.app')
@section('title', 'Watchlist')

<main>
    <!-- New Cars -->
    <section>
      <div class="container">
        <div class="flex justify-between items-center"> 
          <h2>My Favourite Cars</h2>

          @if ($cars->total() > 0)
            <div class="pagination-summary"> 
              <p> 
                Showing {{ $cars->firstItem() }} to {{ $cars->lastItem() }} of {{ $cars->total() }} results
              </p>
            </div>
            
          @endif
        </div>

        
        <div class="car-items-listing">
          <!-- Car Item Card -->
          @foreach($cars as $car)
          <x-car-items :$car :inWatchlist="true" />
          @endforeach
          </div>

        <!-- Pagination -->
        {{ $cars->onEachSide(2)->links() }}
      </div>
    </section>
    <!--/ New Cars -->
  </main>
