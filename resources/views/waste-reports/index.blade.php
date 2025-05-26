<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Waste Reports') }}
            </h2>
            <a href="{{ route('waste-reports.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Report New Issue
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Map Container -->
                    <div id="map" class="h-96 mb-6 rounded-lg"></div>

                    <!-- Reports List -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4">Recent Reports</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($reports as $report)
                                <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                                    @if($report->image_path)
                                        <img src="{{ Storage::url($report->image_path) }}" alt="Report Image" class="w-full h-48 object-cover rounded-lg mb-4">
                                    @endif
                                    <h4 class="font-semibold text-lg mb-2">{{ $report->title }}</h4>
                                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($report->description, 100) }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($report->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($report->status === 'in_progress') bg-blue-100 text-blue-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                        <a href="{{ route('waste-reports.show', $report) }}" class="text-green-600 hover:text-green-800">View Details</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $reports->links() }}
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

            // Add markers for each report
            @foreach($reports as $report)
                L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
                    .bindPopup(`
                        <strong>{{ $report->title }}</strong><br>
                        {{ Str::limit($report->description, 100) }}<br>
                        <a href="{{ route('waste-reports.show', $report) }}">View Details</a>
                    `)
                    .addTo(map);
            @endforeach
        });
    </script>
    @endpush
</x-app-layout> 