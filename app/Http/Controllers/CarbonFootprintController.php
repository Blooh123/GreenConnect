<?php

namespace App\Http\Controllers;

use App\Models\CarbonFootprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarbonFootprintController extends Controller
{
    public function index()
    {
        $footprints = CarbonFootprint::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('carbon-footprints.index', compact('footprints'));
    }

    public function create()
    {
        return view('carbon-footprints.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_distance' => 'required|numeric|min:0',
            'public_transport_distance' => 'required|numeric|min:0',
            'electricity_usage' => 'required|numeric|min:0',
            'meat_meals' => 'required|integer|min:0',
            'vegetarian_meals' => 'required|integer|min:0',
            'clothing_items' => 'required|integer|min:0',
            'electronics' => 'required|integer|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Calculate carbon footprint
        $validated['total_footprint'] = $this->calculateFootprint($validated);
        $validated['user_id'] = Auth::id();

        $footprint = CarbonFootprint::create($validated);

        return redirect()->route('carbon-footprints.show', $footprint)
            ->with('success', 'Carbon footprint calculated successfully.');
    }

    public function show(CarbonFootprint $carbonFootprint)
    {
        $this->authorize('view', $carbonFootprint);
        return view('carbon-footprints.show', compact('carbonFootprint'));
    }

    public function edit(CarbonFootprint $carbonFootprint)
    {
        $this->authorize('update', $carbonFootprint);
        return view('carbon-footprints.edit', compact('carbonFootprint'));
    }

    public function update(Request $request, CarbonFootprint $carbonFootprint)
    {
        $this->authorize('update', $carbonFootprint);

        $validated = $request->validate([
            'car_distance' => 'required|numeric|min:0',
            'public_transport_distance' => 'required|numeric|min:0',
            'electricity_usage' => 'required|numeric|min:0',
            'meat_meals' => 'required|integer|min:0',
            'vegetarian_meals' => 'required|integer|min:0',
            'clothing_items' => 'required|integer|min:0',
            'electronics' => 'required|integer|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['total_footprint'] = $this->calculateFootprint($validated);
        $carbonFootprint->update($validated);

        return redirect()->route('carbon-footprints.show', $carbonFootprint)
            ->with('success', 'Carbon footprint updated successfully.');
    }

    public function destroy(CarbonFootprint $carbonFootprint)
    {
        $this->authorize('delete', $carbonFootprint);
        $carbonFootprint->delete();

        return redirect()->route('carbon-footprints.index')
            ->with('success', 'Carbon footprint deleted successfully.');
    }

    public function dashboard()
    {
        $footprints = CarbonFootprint::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get();

        $totalFootprint = CarbonFootprint::where('user_id', Auth::id())
            ->sum('total_footprint');

        $averageFootprint = CarbonFootprint::where('user_id', Auth::id())
            ->avg('total_footprint');

        return view('carbon-footprints.dashboard', compact('footprints', 'totalFootprint', 'averageFootprint'));
    }

    private function calculateFootprint($data)
    {
        // Transportation emissions (kg CO2)
        $carEmissions = $data['car_distance'] * 0.404; // 0.404 kg CO2 per km
        $publicTransportEmissions = $data['public_transport_distance'] * 0.104; // 0.104 kg CO2 per km

        // Electricity emissions (kg CO2)
        $electricityEmissions = $data['electricity_usage'] * 0.233; // 0.233 kg CO2 per kWh

        // Food emissions (kg CO2)
        $meatEmissions = $data['meat_meals'] * 2.5; // 2.5 kg CO2 per meat meal
        $vegetarianEmissions = $data['vegetarian_meals'] * 0.5; // 0.5 kg CO2 per vegetarian meal

        // Shopping emissions (kg CO2)
        $clothingEmissions = $data['clothing_items'] * 3.2; // 3.2 kg CO2 per clothing item
        $electronicsEmissions = $data['electronics'] * 50; // 50 kg CO2 per electronic item

        return $carEmissions + $publicTransportEmissions + $electricityEmissions +
               $meatEmissions + $vegetarianEmissions + $clothingEmissions + $electronicsEmissions;
    }
} 