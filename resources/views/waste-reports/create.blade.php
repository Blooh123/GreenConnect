<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Waste Issue') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('waste-reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" rows="4" required>{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="type" :value="__('Issue Type')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required>
                                <option value="">Select type</option>
                                <option value="uncollected_garbage" {{ old('type') == 'uncollected_garbage' ? 'selected' : '' }}>Uncollected Garbage</option>
                                <option value="illegal_dumping" {{ old('type') == 'illegal_dumping' ? 'selected' : '' }}>Illegal Dumping</option>
                                <option value="overflowing_bins" {{ old('type') == 'overflowing_bins' ? 'selected' : '' }}>Overflowing Bins</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Photo (Optional)')" />
                            <input type="file" id="image" name="image" class="mt-1 block w-full" accept="image/*">
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <div>
                            <x-input-label :value="__('Location')" />
                            <div id="map" class="h-96 mt-1 rounded-lg"></div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}" required>
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" required>
                            <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                            <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Submit Report') }}</x-primary-button>
                            <a href="{{ route('waste-reports.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('map').setView([14.5995, 120.9842], 13); // Default to Manila
            let marker;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Initialize marker if coordinates exist
            if (document.getElementById('latitude').value && document.getElementById('longitude').value) {
                const lat = parseFloat(document.getElementById('latitude').value);
                const lng = parseFloat(document.getElementById('longitude').value);
                marker = L.marker([lat, lng]).addTo(map);
                map.setView([lat, lng], 15);
            }

            // Handle map click
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }
            });
        });
    </script>
    @endpush
</x-app-layout> 