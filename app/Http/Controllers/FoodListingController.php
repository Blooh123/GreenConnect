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
            ->where('expiry_date', '>', now())
            ->latest()
            ->paginate(10);
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
            'quantity_unit' => 'required|string|in:kg,pieces,boxes,containers',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'expiry_date' => 'required|date|after:now',
            'image' => 'nullable|image|max:2048',
            'special_instructions' => 'nullable|string'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('food-listings', 'public');
            $validated['image_path'] = $path;
        }

        $validated['user_id'] = Auth::id();
        
        FoodListing::create($validated);

        return redirect()->route('food-listings.index')
            ->with('success', 'Food listing created successfully.');
    }

    public function show(FoodListing $foodListing)
    {
        return view('food-listings.show', compact('foodListing'));
    }

    public function update(Request $request, FoodListing $foodListing)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:available,reserved,collected'
        ]);

        $foodListing->update($validated);

        return redirect()->route('food-listings.show', $foodListing)
            ->with('success', 'Food listing status updated successfully.');
    }

    public function myListings()
    {
        $listings = FoodListing::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('food-listings.my-listings', compact('listings'));
    }
} 