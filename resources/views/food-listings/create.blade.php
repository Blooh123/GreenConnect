<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Share Food') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('food-listings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" name="quantity" type="number" step="0.01" class="mt-1 block w-full" :value="old('quantity')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                            </div>

                            <div>
                                <x-input-label for="quantity_unit" :value="__('Unit')" />
                                <select id="quantity_unit" name="quantity_unit" class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required>
                                    <option value="">Select unit</option>
                                    <option value="kg" {{ old('quantity_unit') == 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                                    <option value="pieces" {{ old('quantity_unit') == 'pieces' ? 'selected' : '' }}>Pieces</option>
                                    <option value="boxes" {{ old('quantity_unit') == 'boxes' ? 'selected' : '' }}>Boxes</option>
                                    <option value="containers" {{ old('quantity_unit') == 'containers' ? 'selected' : '' }}>Containers</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('quantity_unit')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="expiry_date" :value="__('Expiry Date')" />
                            <x-text-input id="expiry_date" name="expiry_date" type="datetime-local" class="mt-1 block w-full" :value="old('expiry_date')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('expiry_date')" />
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Photo (Optional)')" />
                            <input type="file" id="image" name="image" class="mt-1 block w-full" accept="image/*">
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <div>
                            <x-input-label for="special_instructions" :value="__('Special Instructions (Optional)')" />
                            <textarea id="special_instructions" name="special_instructions" class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" rows="3">{{ old('special_instructions') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('special_instructions')" />
                        </div>

                        <div>
                            <x-input-label :value="__('Pickup Location')" />
                            <div id="map" class="h-96 mt-1 rounded-lg"></div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}" required>
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" required>
                            <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                            <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Share Food') }}</x-primary-button>
                            <a href="{{ route('food-listings.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
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