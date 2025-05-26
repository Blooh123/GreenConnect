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
            ->latest('recorded_date')
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
            'transportation_emissions' => 'required|numeric|min:0',
            'electricity_emissions' => 'required|numeric|min:0',
            'food_emissions' => 'required|numeric|min:0',
            'shopping_emissions' => 'required|numeric|min:0',
            'recorded_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['total_emissions'] = array_sum([
            $validated['transportation_emissions'],
            $validated['electricity_emissions'],
            $validated['food_emissions'],
            $validated['shopping_emissions']
        ]);

        CarbonFootprint::create($validated);

        return redirect()->route('carbon-footprints.index')
            ->with('success', 'Carbon footprint recorded successfully.');
    }

    public function show(CarbonFootprint $carbonFootprint)
    {
        return view('carbon-footprints.show', compact('carbonFootprint'));
    }

    public function dashboard()
    {
        $monthlyData = CarbonFootprint::where('user_id', Auth::id())
            ->selectRaw('MONTH(recorded_date) as month, YEAR(recorded_date) as year, AVG(total_emissions) as average_emissions')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('carbon-footprints.dashboard', compact('monthlyData'));
    }
} 