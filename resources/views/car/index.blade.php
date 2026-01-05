<x-app title="My Cars">
    <div>
        <main>
            <div>
                <div class="container">
                    <h1 class="car-details-page-title">My Cars</h1>
                    <div class="card p-medium">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Published</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cars as $car)
                                        <tr>
                                            <td>
                                                <div class="relative inline-block">
                                                    <img src=`{{ $car->primaryImage?->getUrl() ?? '/img/no-image.png' }}`
                                                        alt="" class="my-cars-img-thumbnail" />
                                                    @if($car->isFeatured())
                                                        <div class="absolute -top-1 -right-1">
                                                            <svg class="h-5 w-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td> {{ $car->getTitle() }}
                                            </td>
                                            <td>{{ $car->formatDate() }}</td>
                                            <td>{{ $car->published_at ? 'YES' : 'NO' }}</td>
                                            <td>
                                                @if($car->isFeatured())
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                        Featured
                                                    </span>
                                                    <small class="block text-gray-500 mt-1">Until {{ $car->featured_until->format('M d') }}</small>
                                                @else
                                                    <span class="text-gray-400 text-xs">Standard</span>
                                                @endif
                                            </td>
                                            <td class="">
                                                <a href="{{ route('car.edit', $car) }}"
                                                    class="btn btn-edit inline-flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        style="width: 12px; margin-right: 5px">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                    </svg>
                                                    edit
                                                </a>
                                                <a href="{{ route('car.images', $car) }}" class="btn btn-edit inline-flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        style="width: 12px; margin-right: 5px">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                    </svg>
                                                    images
                                                </a>
                                                @if(!$car->isFeatured())
                                                    <form action="{{ route('stripe.checkout', $car) }}" method="POST" class="inline-flex">
                                                        @csrf
                                                        <button type="submit" class="btn btn-edit inline-flex items-center" style="background: linear-gradient(135deg, #f97316 0%, #fb923c 100%); color: white; border: none;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 12px; margin-right: 5px">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                                            </svg>
                                                            promote
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('car.destroy', $car) }}" method="POST"
                                                    class="inline-flex">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Are you sure?')"
                                                        class="btn btn-delete inline-flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            style="width: 12px; margin-right: 5px">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                        delete
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center p-large">
                                                <p class="text-gray-500">No cars found.</p>
                                                <a href="{{ route('car.create') }}">Add a new car</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        {{ $cars->onEachSide(2)->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app>
