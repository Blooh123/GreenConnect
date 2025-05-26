<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Food Sharing Network') }}
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('food-listings.my-listings') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    My Listings
                </a>
                <a href="{{ route('food-listings.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Share Food
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Map Container -->
                    <div id="map" class="h-96 mb-6 rounded-lg"></div>

                    <!-- Food Listings -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4">Available Food Items</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($listings as $listing)
                                <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                                    @if($listing->image_path)
                                        <img src="{{ Storage::url($listing->image_path) }}" alt="Food Image" class="w-full h-48 object-cover rounded-lg mb-4">
                                    @endif
                                    <h4 class="font-semibold text-lg mb-2">{{ $listing->title }}</h4>
                                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($listing->description, 100) }}</p>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium">
                                            {{ number_format($listing->quantity, 2) }} {{ $listing->quantity_unit }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            Expires: {{ $listing->expiry_date->format('M d, Y') }}
                                        </span>
                                    </div>
                                    @if($listing->special_instructions)
                                        <p class="text-sm text-gray-500 mb-2">
                                            <strong>Special Instructions:</strong> {{ $listing->special_instructions }}
                                        </p>
                                    @endif
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">
                                            Shared by {{ $listing->user->name }}
                                        </span>
                                        <a href="{{ route('food-listings.show', $listing) }}" class="text-green-600 hover:text-green-800">View Details</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $listings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map
            const map = L.map('map').setView([14.5995, 120.9842], 13); // Default to Manila

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add markers for each listing
            @foreach($listings as $listing)
                L.marker([{{ $listing->latitude }}, {{ $listing->longitude }}])
                    .bindPopup(`
                        <strong>{{ $listing->title }}</strong><br>
                        {{ number_format($listing->quantity, 2) }} {{ $listing->quantity_unit }}<br>
                        Expires: {{ $listing->expiry_date->format('M d, Y') }}<br>
                        <a href="{{ route('food-listings.show', $listing) }}">View Details</a>
                    `)
                    .addTo(map);
            @endforeach
        });
    </script>
    @endpush
</x-app-layout> 