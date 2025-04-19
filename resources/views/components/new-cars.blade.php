
<section>
    <div class="container">
      <h2>Latest Added Cars</h2>
      <div class="car-items-listing">
        @foreach($cars as $car)
          <x-car-items :$car/>
        @endforeach
      </div>
    </div>
  </section>