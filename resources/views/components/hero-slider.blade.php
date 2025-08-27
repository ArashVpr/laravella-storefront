<section class="hero-slider">
    <!-- Carousel wrapper -->
    <div class="hero-slides">
        <!-- Item 1 -->
        <div class="hero-slide">
            <div class="container">
                <div class="slide-content">
                    <h1 class="hero-slider-title">
                        Buy <strong>The Best Cars</strong> <br />
                        in your region
                    </h1>
                    <div class="hero-slider-content">
                        <p>
                            Use powerful search tool to find your desired cars based on
                            multiple search criteria: Maker, Model, Year, Price Range, Car
                            Type, etc...
                        </p>

                        <a href="{{ route('car.search') }}" class="btn btn-hero-slider">Find the car</a>
                    </div>
                </div>
                <div class="slide-image">
                    <img src="/img/car-png-39071.webp"
                        alt="Modern car illustration showcasing the best cars available in your region"
                        class="img-responsive" />
                </div>
            </div>
        </div>
        <!-- Item 2 -->
        <div class="hero-slide">
            <div class="flex container">
                <div class="slide-content">
                    <h2 class="hero-slider-title">
                        Do you want to <br />
                        <strong>sell your car?</strong>
                    </h2>
                    <div class="hero-slider-content">
                        <p>
                            Submit your car in our user friendly interface, describe it,
                            upload photos and the perfect buyer will find it...
                        </p>

                        <a href="{{ route('car.create') }}" class="btn btn-hero-slider">Add Your Car</a>
                    </div>
                </div>
                <div class="slide-image">
                    <img src="/img/car-png-39071.webp"
                        alt="Car illustration representing selling your vehicle on our platform"
                        class="img-responsive" />
                </div>
            </div>
        </div>
        <button type="button" class="hero-slide-prev" aria-label="Previous slide">
            <svg style="width: 18px" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 1 1 5l4 4" />
            </svg>
            <span class="sr-only">Previous</span>
        </button>
        <button type="button" class="hero-slide-next" aria-label="Next slide">
            <svg style="width: 18px" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
            </svg>
            <span class="sr-only">Next</span>
        </button>
    </div>
</section>
