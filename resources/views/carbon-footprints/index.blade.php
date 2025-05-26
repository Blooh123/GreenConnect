<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Carbon Footprint Calculator') }}
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('carbon-footprints.dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    View Dashboard
                </a>
                <a href="{{ route('carbon-footprints.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Calculate New
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Recent Calculations -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Recent Calculations</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transportation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Electricity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Food</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shopping</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($footprints as $footprint)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $footprint->recorded_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format($footprint->transportation_emissions, 2) }} kg
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format($footprint->electricity_emissions, 2) }} kg
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format($footprint->food_emissions, 2) }} kg
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ number_format($footprint->shopping_emissions, 2) }} kg
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ number_format($footprint->total_emissions, 2) }} kg
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <a href="{{ route('carbon-footprints.show', $footprint) }}" class="text-green-600 hover:text-green-900">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $footprints->links() }}
                        </div>
                    </div>

                    <!-- Tips Section -->
                    <div class="mt-8 bg-green-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Tips to Reduce Your Carbon Footprint</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h4 class="font-semibold mb-2">Transportation</h4>
                                <ul class="text-sm text-gray-600 list-disc list-inside">
                                    <li>Use public transport</li>
                                    <li>Walk or cycle for short trips</li>
                                    <li>Carpool when possible</li>
                                </ul>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h4 class="font-semibold mb-2">Electricity</h4>
                                <ul class="text-sm text-gray-600 list-disc list-inside">
                                    <li>Switch to LED bulbs</li>
                                    <li>Unplug unused devices</li>
                                    <li>Use energy-efficient appliances</li>
                                </ul>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h4 class="font-semibold mb-2">Food</h4>
                                <ul class="text-sm text-gray-600 list-disc list-inside">
                                    <li>Eat more plant-based meals</li>
                                    <li>Buy local produce</li>
                                    <li>Reduce food waste</li>
                                </ul>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h4 class="font-semibold mb-2">Shopping</h4>
                                <ul class="text-sm text-gray-600 list-disc list-inside">
                                    <li>Buy second-hand items</li>
                                    <li>Choose eco-friendly products</li>
                                    <li>Reduce single-use plastics</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 