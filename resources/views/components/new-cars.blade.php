<section>
    <div class="container">
      <h2>Latest Added Cars</h2>
      <div class="car-items-listing">
        @for ($i = 0; $i < 12; $i++)
          <x-car-items />
        @endfor
      </div>
    </div>
  </section>