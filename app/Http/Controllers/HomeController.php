<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Kunin lahat ng pending entries
        $pendingEntries = Entry::where('received_by', 'Pending')->latest()->get();

        return view('home', compact('pendingEntries'));
    }
}
