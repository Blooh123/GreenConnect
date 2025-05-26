<?php

namespace App\Http\Controllers;

use App\Models\WasteReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WasteReportController extends Controller
{
    public function index()
    {
        $reports = WasteReport::latest()->paginate(10);
        return view('waste-reports.index', compact('reports'));
    }

    public function create()
    {
        return view('waste-reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:pending,processing,resolved',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('waste-reports', 'public');
        }

        $validated['user_id'] = Auth::id();
        $report = WasteReport::create($validated);

        return redirect()->route('waste-reports.show', $report)
            ->with('success', 'Waste report created successfully.');
    }

    public function show(WasteReport $wasteReport)
    {
        return view('waste-reports.show', compact('wasteReport'));
    }

    public function edit(WasteReport $wasteReport)
    {
        $this->authorize('update', $wasteReport);
        return view('waste-reports.edit', compact('wasteReport'));
    }

    public function update(Request $request, WasteReport $wasteReport)
    {
        $this->authorize('update', $wasteReport);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:pending,processing,resolved',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('waste-reports', 'public');
        }

        $wasteReport->update($validated);

        return redirect()->route('waste-reports.show', $wasteReport)
            ->with('success', 'Waste report updated successfully.');
    }

    public function destroy(WasteReport $wasteReport)
    {
        $this->authorize('delete', $wasteReport);
        $wasteReport->delete();

        return redirect()->route('waste-reports.index')
            ->with('success', 'Waste report deleted successfully.');
    }

    public function updateStatus(Request $request, WasteReport $wasteReport)
    {
        $this->authorize('update', $wasteReport);

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,resolved',
        ]);

        $wasteReport->update($validated);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}