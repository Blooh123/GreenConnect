<?php

namespace App\Http\Controllers;

use App\Models\FoodListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodListingController extends Controller
{
    public function index()
    {
        $listings = FoodListing::with('user')
            ->where('status', 'available')
            ->latest()
            ->paginate(12);
        return view('food-listings.index', compact('listings'));
    }

    public function create()
    {
        return view('food-listings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'expiry_date' => 'required|date|after:today',
            'image' => 'nullable|image|max:2048',
            'special_instructions' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'pickup_location' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('food-listings', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'available';

        $listing = FoodListing::create($validated);

        return redirect()->route('food-listings.show', $listing)
            ->with('success', 'Food listing created successfully.');
    }

    public function show(FoodListing $foodListing)
    {
        return view('food-listings.show', compact('foodListing'));
    }

    public function edit(FoodListing $foodListing)
    {
        $this->authorize('update', $foodListing);
        return view('food-listings.edit', compact('foodListing'));
    }

    public function update(Request $request, FoodListing $foodListing)
    {
        $this->authorize('update', $foodListing);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'expiry_date' => 'required|date|after:today',
            'image' => 'nullable|image|max:2048',
            'special_instructions' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'pickup_location' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('food-listings', 'public');
        }

        $foodListing->update($validated);

        return redirect()->route('food-listings.show', $foodListing)
            ->with('success', 'Food listing updated successfully.');
    }

    public function destroy(FoodListing $foodListing)
    {
        $this->authorize('delete', $foodListing);
        $foodListing->delete();

        return redirect()->route('food-listings.index')
            ->with('success', 'Food listing deleted successfully.');
    }

    public function myListings()
    {
        $listings = FoodListing::where('user_id', Auth::id())
            ->latest()
            ->paginate(12);
        return view('food-listings.my-listings', compact('listings'));
    }

    public function updateStatus(Request $request, FoodListing $foodListing)
    {
        $this->authorize('update', $foodListing);

        $validated = $request->validate([
            'status' => 'required|in:available,reserved,claimed',
        ]);

        $foodListing->update($validated);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
} 