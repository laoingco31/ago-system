@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ url('/entries') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white p-2">
            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Entry Information</h6>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
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
                        <tr>
                            <td>{{ $entry->date_received }}</td>
                            <td>{{ $entry->branch }}</td>
                            <td>{{ $entry->description }}</td>
                            <td>{{ $entry->quantity }}</td>
                            <td class="text-success fw-bold">₱{{ number_format($entry->amount, 2) }}</td>
                            <td class="text-danger fw-bold">₱{{ number_format($entry->total, 2) }}</td>
                            <td>{{ $entry->date_release ?? 'N/A' }}</td>
                            <td>
                                @if($entry->received_by == "Pending")
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    {{ $entry->received_by }}
                                @endif
                            </td>
                            <td>
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ url('/entries/' . $entry->id . '/edit') }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ url('/entries/' . $entry->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this entry?');">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
