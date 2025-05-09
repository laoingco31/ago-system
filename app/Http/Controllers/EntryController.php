<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EntryController extends Controller
{
    public function index(Request $request)
    {
        $query = Entry::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('description', 'like', '%' . $request->search . '%')
                  ->orWhere('branch', 'like', '%' . $request->search . '%');
        }

        $entries = $query->paginate(10); // paginate the results
        $branches = Entry::distinct()->pluck('branch'); // Get distinct branches

        return view('entries.index', compact('entries', 'branches'));
    }

    public function create()
    {
        return view('entries.create');
    }

    public function show($id)
    {
        $entry = Entry::findOrFail($id);
        return view('entries.show', compact('entry'));
    }

    public function details($id)
    {
        $entry = Entry::findOrFail($id);
        return view('entries.details', compact('entry'));
    }

    public function edit($id)
    {
        $entry = Entry::findOrFail($id);
        return view('entries.edit', compact('entry'));
    }

    public function proof($id)
    {
        $entry = Entry::findOrFail($id);
        return view('entries.proof', compact('entry'));
    }

    public function showProofImages(Request $request)
    {
        // Create a query to get entries that have proof images
        $query = Entry::query();
        $query->whereNotNull('proof_image');

        // Optional: Add a search functionality if needed
        if ($request->has('search') && $request->search) {
            $query->where('description', 'like', '%' . $request->search . '%')
                  ->orWhere('branch', 'like', '%' . $request->search . '%');
        }

        // Get the entries with proof images and paginate the results
        $entries = $query->latest()->paginate(10);

        return view('entries.proof', compact('entries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date_release' => 'nullable|date',
            'received_by' => 'required|string|max:255',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $entry = Entry::findOrFail($id);

        try {
            $date_release = $request->date_release
                ? Carbon::parse($request->date_release)->format('Y-m-d')
                : null;

            $data = [
                'date_release' => $date_release,
                'received_by' => $request->received_by,
            ];

            if ($request->hasFile('proof_image')) {
                if ($entry->proof_image && Storage::disk('public')->exists($entry->proof_image)) {
                    Storage::disk('public')->delete($entry->proof_image);
                }

                $image = $request->file('proof_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('uploads/proofs', $imageName, 'public');
                $data['proof_image'] = $path;

                Log::info('Updated proof image stored at: ' . $path);
            }

            $entry->update($data);

            return redirect('/entries')->with('success', 'Entry updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating entry: ' . $e->getMessage());
            return back()->withErrors(['date_error' => 'Invalid date format.']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_received' => 'required|date',
            'branch' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer',
            'amount' => 'required|numeric',
            'total' => 'required|numeric',
            'date_release' => 'nullable|date',
            'received_by' => 'required|string|max:255',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $date_received = Carbon::parse($request->date_received)->format('Y-m-d');
            $date_release = $request->date_release
                ? Carbon::parse($request->date_release)->format('Y-m-d')
                : null;

            $data = [
                'date_received' => $date_received,
                'branch' => $request->branch,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'amount' => $request->amount,
                'total' => $request->total,
                'date_release' => $date_release,
                'received_by' => $request->received_by,
            ];

            if ($request->hasFile('proof_image')) {
                $image = $request->file('proof_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('uploads/proofs', $imageName, 'public');
                $data['proof_image'] = $path;

                Log::info('New proof image stored at: ' . $path);
            }

            Entry::create($data);

            return redirect('/entries')->with('success', 'Entry added successfully!');
        } catch (\Exception $e) {
            Log::error('Error storing entry: ' . $e->getMessage());
            return back()->withErrors(['date_error' => 'Invalid date format.']);
        }
    }

    public function destroy($id)
    {
        $entry = Entry::findOrFail($id);
        if ($entry->proof_image && Storage::disk('public')->exists($entry->proof_image)) {
            Storage::disk('public')->delete($entry->proof_image);
        }
        $entry->delete();

        return redirect('/entries')->with('success', 'Entry deleted successfully!');
    }

    public function printAll()
    {
        $entries = Entry::latest()->get();
        return view('entries.print', compact('entries'));
    }

    // Merged showProofImages function to handle search and pagination
    public function showAllProofs()
    {
        $entries = Entry::whereNotNull('proof_image')->latest()->get();
        return view('entries.proofs', compact('entries'));
    }
}
