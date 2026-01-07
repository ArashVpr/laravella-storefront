<x-app title="Manage Images" bodyClass="bg-gray-50">
    <style>
        .drag-over {
            border-color: #3b82f6 !important;
            background-color: rgba(59, 130, 246, 0.05) !important;
        }
        .drag-over .bg-primary\/10 {
            background-color: rgba(59, 130, 246, 0.2) !important;
        }

        /* SortableJS styles */
        .sortable-ghost {
            opacity: 0.4;
            background-color: rgba(59, 130, 246, 0.1) !important;
            border: 2px dashed #3b82f6 !important;
        }

        .sortable-chosen {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .sortable-drag {
            transform: rotate(5deg);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .image-item {
            transition: all 0.2s ease;
        }

        .image-item:hover .delete-btn {
            opacity: 1 !important;
        }
    </style>
    <div class="min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-7xl">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <a href="{{ route('homepage') }}" class="hover:text-primary transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('car.index') }}" class="hover:text-primary transition-colors">My Cars</a>
                    <span>/</span>
                    <a href="{{ route('car.show', $car) }}" class="hover:text-primary transition-colors">{{ $car->getTitle() }}</a>
                    <span>/</span>
                    <span class="text-gray-900 font-medium">Manage Images</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Manage Images</h1>
                <p class="text-gray-600 mt-2">Organize and update photos for: <span class="font-semibold text-gray-900">{{ $car->getTitle() }}</span></p>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                <!-- Image Gallery & Management -->
                <div class="xl:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 md:p-8 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                        <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Photo Gallery
                                    </h2>
                                    <p class="text-sm text-gray-600 mt-1">{{ $car->images->count() }} photos • Drag to reorder</p>
                                </div>
                            </div>
                        </div>

                        @if($car->images->count() > 0)
                            <!-- Image Grid -->
                            <div id="imageGrid" class="p-6 md:p-8">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach($car->images->sortBy('position') as $image)
                                        <div class="image-item group relative bg-gray-50 rounded-xl overflow-hidden border-2 border-transparent hover:border-primary/50 transition-all duration-200 cursor-move"
                                             data-id="{{ $image->id }}"
                                             data-position="{{ $image->position }}">
                                            <div class="aspect-square relative">
                                                <img src="{{ $image->getUrl() }}"
                                                     alt="Car photo"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                                                <!-- Delete Button -->
                                                <button type="button"
                                                        class="delete-btn absolute top-2 right-2 w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg"
                                                        data-id="{{ $image->id }}"
                                                        title="Delete image">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 011-1v1z"/>
                                                    </svg>
                                                </button>

                                                <!-- Position Indicator -->
                                                <div class="position-indicator absolute bottom-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded-full font-medium">
                                                    #{{ $image->position }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="p-12 text-center">
                                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No images uploaded</h3>
                                <p class="text-gray-600 mb-6">Add some photos to showcase your car</p>
                                <a href="#upload-section" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-hover text-white font-semibold rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Images
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Add New Images -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Add New Images
                    </h2>

                    <form action="{{ route('car.addImages', $car) }}" enctype="multipart/form-data" method="POST" id="uploadForm" x-data="imageManager()">
                        @csrf

                        <!-- Drag & Drop Upload Area -->
                        <div class="mb-6">
                            <div id="uploadArea" class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary hover:bg-primary/5 transition-all cursor-pointer group">
                                <input id="carFormImageUpload" type="file" name="images[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />

                                <div class="space-y-4">
                                    <div class="w-16 h-16 mx-auto bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                        <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <p class="text-lg font-semibold text-gray-700 mb-1">Drop images here or click to browse</p>
                                        <p class="text-sm text-gray-500">PNG, JPG, GIF up to 5MB each • Maximum 10 images</p>
                                    </div>

                                    <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>High-quality images work best</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Previews Grid -->
                        <div id="imagePreviews" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6 hidden">
                            <template x-for="(image, index) in selectedImages" :key="index">
                                <div class="relative group bg-white rounded-lg border border-gray-200 overflow-hidden">
                                    <div class="aspect-square">
                                        <img :src="image.preview" :alt="image.name" class="w-full h-full object-cover">
                                    </div>
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <button @click="removeImage(index)" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                                        <p class="text-white text-xs font-medium truncate" x-text="image.name"></p>
                                        <p class="text-white/80 text-xs" x-text="image.size"></p>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Upload Progress -->
                        <div id="uploadProgress" class="hidden mb-6">
                            <div class="bg-gray-200 rounded-full h-2 mb-2">
                                <div id="progressBar" class="bg-primary h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <p class="text-sm text-gray-600 text-center">
                                <span id="progressText">Uploading...</span>
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <a href="{{ route('car.show', $car) }}" class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition-all text-center">
                                Back to Car
                            </a>
                            <button type="button" id="uploadBtn" class="flex-1 px-4 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white font-bold transition-all shadow-lg shadow-primary/30 disabled:opacity-50 disabled:cursor-not-allowed" @click="submitForm()">
                                <span class="upload-text">Upload Images</span>
                                <span class="uploading-text hidden">
                                    <svg class="inline w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Uploading...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageManager', () => ({
                selectedImages: [],
                isDragging: false,

                init() {
                    this.setupDragAndDrop();
                    this.setupFileInput();
                },

                setupDragAndDrop() {
                    const uploadArea = document.getElementById('uploadArea');
                    const fileInput = document.getElementById('carFormImageUpload');

                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                        uploadArea.addEventListener(eventName, this.preventDefaults, false);
                    });

                    ['dragenter', 'dragover'].forEach(eventName => {
                        uploadArea.addEventListener(eventName, () => {
                            this.isDragging = true;
                            uploadArea.classList.add('drag-over');
                        }, false);
                    });

                    ['dragleave', 'drop'].forEach(eventName => {
                        uploadArea.addEventListener(eventName, () => {
                            this.isDragging = false;
                            uploadArea.classList.remove('drag-over');
                        }, false);
                    });

                    uploadArea.addEventListener('drop', (e) => {
                        const dt = e.dataTransfer;
                        const files = dt.files;
                        this.handleFiles(files);
                    }, false);
                },

                setupFileInput() {
                    const fileInput = document.getElementById('carFormImageUpload');
                    fileInput.addEventListener('change', (e) => {
                        this.handleFiles(e.target.files);
                    });
                },

                preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                },

                handleFiles(files) {
                    [...files].forEach(file => {
                        if (file.type.startsWith('image/')) {
                            this.addImage(file);
                        }
                    });
                },

                addImage(file) {
                    if (this.selectedImages.length >= 10) {
                        alert('Maximum 10 images allowed');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.selectedImages.push({
                            file: file,
                            preview: e.target.result,
                            name: file.name,
                            size: this.formatFileSize(file.size)
                        });
                        this.updatePreviews();
                    };
                    reader.readAsDataURL(file);
                },

                removeImage(index) {
                    this.selectedImages.splice(index, 1);
                    this.updatePreviews();
                },

                updatePreviews() {
                    const previewsContainer = document.getElementById('imagePreviews');
                    if (this.selectedImages.length > 0) {
                        previewsContainer.classList.remove('hidden');
                    } else {
                        previewsContainer.classList.add('hidden');
                    }
                },

                formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                },

                submitForm() {
                    const form = document.getElementById('uploadForm');
                    const uploadBtn = document.getElementById('uploadBtn');

                    if (this.selectedImages.length === 0) {
                        alert('Please select at least one image');
                        return;
                    }

                    // Show loading state
                    uploadBtn.disabled = true;
                    uploadBtn.querySelector('.upload-text').classList.add('hidden');
                    uploadBtn.querySelector('.uploading-text').classList.remove('hidden');

                    // Create FormData with selected files
                    const formData = new FormData(form);
                    formData.delete('images[]'); // Remove empty file inputs

                    this.selectedImages.forEach(image => {
                        formData.append('images[]', image.file);
                    });

                    // Submit via fetch for progress tracking
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.reload();
                        } else {
                            throw new Error('Upload failed');
                        }
                    })
                    .catch(error => {
                        console.error('Upload error:', error);
                        alert('Upload failed. Please try again.');
                        uploadBtn.disabled = false;
                        uploadBtn.querySelector('.upload-text').classList.remove('hidden');
                        uploadBtn.querySelector('.uploading-text').classList.add('hidden');
                    });
                }
            }));
        });

        // Gallery Management JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize sortable for drag-and-drop reordering
            const imageGrid = document.getElementById('imageGrid');
            if (imageGrid && typeof Sortable !== 'undefined') {
                Sortable.create(imageGrid.querySelector('.grid'), {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        updateImagePositions();
                    }
                });
            }

            // Delete button functionality
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const imageId = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this image?')) {
                        deleteImage(imageId);
                    }
                });
            });

            // Update image positions after drag-and-drop
            function updateImagePositions() {
                const imageItems = document.querySelectorAll('.image-item');
                const positions = {};

                imageItems.forEach((item, index) => {
                    const imageId = item.getAttribute('data-id');
                    const newPosition = index + 1;
                    positions[imageId] = newPosition;

                    // Update position indicator
                    const indicator = item.querySelector('.position-indicator');
                    if (indicator) {
                        indicator.textContent = '#' + newPosition;
                    }
                });

                // Send positions to server
                const formData = new FormData();
                formData.append('_method', 'PUT');

                // Add positions in the format expected by controller
                Object.keys(positions).forEach(imageId => {
                    formData.append('position[' + imageId + ']', positions[imageId]);
                });

                fetch('{{ route("car.updateImages", $car) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to update positions');
                    }
                })
                .catch(error => {
                    console.error('Error updating positions:', error);
                    // Reload page to revert changes
                    window.location.reload();
                });
            }

            // Delete image function
            function deleteImage(imageId) {
                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('delete[' + imageId + ']', imageId);

                fetch('{{ route("car.updateImages", $car) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        // Remove the image item from DOM
                        const imageItem = document.querySelector(`[data-id="${imageId}"]`);
                        if (imageItem) {
                            imageItem.remove();
                        }
                        // Update photo count
                        updatePhotoCount();
                    } else {
                        throw new Error('Failed to delete image');
                    }
                })
                .catch(error => {
                    console.error('Error deleting image:', error);
                    alert('Failed to delete image. Please try again.');
                });
            }

            // Update photo count display
            function updatePhotoCount() {
                const imageCount = document.querySelectorAll('.image-item').length;
                const countElement = document.querySelector('.text-sm.text-gray-600');
                if (countElement) {
                    countElement.textContent = imageCount + ' photos • Drag to reorder';
                }
            }
        });
    </script>
</x-app>
