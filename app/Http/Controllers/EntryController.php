<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;
use Carbon\Carbon;

class EntryController extends Controller
{
    // Display all entries with search and pagination
    public function index(Request $request)
    {
        $query = Entry::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('description', 'LIKE', "%$search%")
                  ->orWhere('branch', 'LIKE', "%$search%")
                  ->orWhere('received_by', 'LIKE', "%$search%")
                  ->orWhere('date_release', 'LIKE', "%$search%");
        }

        $entries = $query->latest()->paginate(10);
        return view('entries.index', compact('entries'));
    }

    // Show form for creating a new entry
    public function create()
    {
        return view('entries.create');
    }

    // Store a new entry with proper date formatting
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
        ]);

        try {
            $date_received = Carbon::parse($request->date_received)->format('Y-m-d');
            $date_release = $request->date_release 
                            ? Carbon::parse($request->date_release)->format('Y-m-d') 
                            : null;

            Entry::create([
                'date_received' => $date_received,
                'branch' => $request->branch,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'amount' => $request->amount,
                'total' => $request->total,
                'date_release' => $date_release,
                'received_by' => $request->received_by,
            ]);

            return redirect('/entries')->with('success', 'Entry added successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['date_error' => 'Invalid date format. Please use a valid format.']);
        }
    }

    // Show a single entry
    public function show($id)
    {
        $entry = Entry::findOrFail($id);
        return view('entries.show', compact('entry'));
    }

    // Show form for editing an entry
    public function edit($id)
    {
        $entry = Entry::findOrFail($id);
        return view('entries.edit', compact('entry'));
    }

    // Update an entry with proper date formatting
    public function update(Request $request, $id)
    {
        $request->validate([
            'date_release' => 'nullable|date',
            'received_by' => 'required|string|max:255',
        ]);

        $entry = Entry::findOrFail($id);

        try {
            $date_release = $request->date_release 
                            ? Carbon::parse($request->date_release)->format('Y-m-d') 
                            : null;

            $entry->update([
                'date_release' => $date_release,
                'received_by' => $request->received_by,
            ]);

            return redirect('/entries')->with('success', 'Entry updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['date_error' => 'Invalid date format. Please use a valid format.']);
        }
    }

    // Delete an entry
    public function destroy($id)
    {
        $entry = Entry::findOrFail($id);
        $entry->delete();

        return redirect('/entries')->with('success', 'Entry deleted successfully!');
    }

   
        // Existing methods...
    
        public function details($id)
        {
            $entry = Entry::findOrFail($id);
            return view('entries.details', compact('entry'));
        }
    
}
