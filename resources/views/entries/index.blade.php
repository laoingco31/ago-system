@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ url('/entries/create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus-circle"></i>  Add New Entry
        </a>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-list"></i> All Entries</h5>
        </div>
        <div class="card-body">
            @if($entries->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> No entries found.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Date Received</th>
                                <th>Branch</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Total</th>
                                <th>Date Release</th>
                                <th>Received By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($entry->date_received)->format('m-d-Y') }}</td>
                                <td>{{ $entry->branch }}</td>
                                <td>{{ $entry->description }}</td>
                                <td>{{ $entry->quantity }}</td>
                                <td class="text-success fw-bold">₱{{ number_format($entry->amount, 2) }}</td>
                                <td class="text-danger fw-bold">₱{{ number_format($entry->total, 2) }}</td>
                                <td>
                                    @if ($entry->date_release)
                                        {{ \Carbon\Carbon::parse($entry->date_release)->format('m-d-Y') }}
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($entry->received_by == "Pending")
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        {{ $entry->received_by }}
                                    @endif
                                </td>
                                <td>
                                    {{-- Show these actions only if the user is an admin --}}
                                    @if (auth()->user()->role == 'admin')
                                        <a href="{{ url('/entries/' . $entry->id . '/details') }}" class="btn btn-sm btn-info shadow-sm">
                                            <i class="fas fa-file-alt"></i> 
                                        </a>
                                        <a href="{{ url('/entries/' . $entry->id . '/edit') }}" class="btn btn-sm btn-warning shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ url('/entries/' . $entry->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm"
                                                onclick="return confirm('Are you sure you want to delete this entry?');">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @else
                                        {{-- If the user is not an admin, only show the details view --}}
                                        <a href="{{ url('/entries/' . $entry->id . '/details') }}" class="btn btn-sm btn-info shadow-sm">
                                            <i class="fas fa-file-alt"></i> 
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
