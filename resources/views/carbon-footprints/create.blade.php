<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calculate Carbon Footprint') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('carbon-footprints.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Transportation Section -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Transportation</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="car_distance" :value="__('Car Distance (km)')" />
                                        <x-text-input id="car_distance" name="car_distance" type="number" step="0.1" class="mt-1 block w-full" :value="old('car_distance')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('car_distance')" />
                                    </div>

                                    <div>
                                        <x-input-label for="public_transport_distance" :value="__('Public Transport Distance (km)')" />
                                        <x-text-input id="public_transport_distance" name="public_transport_distance" type="number" step="0.1" class="mt-1 block w-full" :value="old('public_transport_distance')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('public_transport_distance')" />
                                    </div>
                                </div>
                            </div>

                            <!-- Electricity Section -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Electricity</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="electricity_usage" :value="__('Monthly Electricity Usage (kWh)')" />
                                        <x-text-input id="electricity_usage" name="electricity_usage" type="number" step="0.1" class="mt-1 block w-full" :value="old('electricity_usage')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('electricity_usage')" />
                                    </div>
                                </div>
                            </div>

                            <!-- Food Section -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Food</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="meat_meals" :value="__('Meat-based Meals per Week')" />
                                        <x-text-input id="meat_meals" name="meat_meals" type="number" class="mt-1 block w-full" :value="old('meat_meals')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('meat_meals')" />
                                    </div>

                                    <div>
                                        <x-input-label for="vegetarian_meals" :value="__('Vegetarian Meals per Week')" />
                                        <x-text-input id="vegetarian_meals" name="vegetarian_meals" type="number" class="mt-1 block w-full" :value="old('vegetarian_meals')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('vegetarian_meals')" />
                                    </div>
                                </div>
                            </div>

                            <!-- Shopping Section -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Shopping</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="clothing_purchases" :value="__('Clothing Items per Month')" />
                                        <x-text-input id="clothing_purchases" name="clothing_purchases" type="number" class="mt-1 block w-full" :value="old('clothing_purchases')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('clothing_purchases')" />
                                    </div>

                                    <div>
                                        <x-input-label for="electronics_purchases" :value="__('Electronics per Year')" />
                                        <x-text-input id="electronics_purchases" name="electronics_purchases" type="number" class="mt-1 block w-full" :value="old('electronics_purchases')" />
                                        <x-input-error class="mt-2" :messages="$errors->get('electronics_purchases')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="recorded_date" :value="__('Date')" />
                            <x-text-input id="recorded_date" name="recorded_date" type="date" class="mt-1 block w-full" :value="old('recorded_date', date('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('recorded_date')" />
                        </div>

                        <div>
                            <x-input-label for="notes" :value="__('Notes (Optional)')" />
                            <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" rows="3">{{ old('notes') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Calculate Footprint') }}</x-primary-button>
                            <a href="{{ route('carbon-footprints.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add any client-side calculations or validations here
        });
    </script>
    @endpush
</x-app-layout> 