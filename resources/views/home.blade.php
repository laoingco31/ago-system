@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><i class="fas fa-home"></i> Dashboard</h4>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h5 class="mb-3"><i class="fas fa-clock"></i> Pending Entries</h5>

                    @if($pendingEntries->isEmpty())
                        <p class="text-muted text-center">No pending entries found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Date Received</th>
                                        <th>Branch</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingEntries as $entry)
                                        <tr>
                                            <td>{{ $entry->date_received }}</td>
                                            <td>{{ $entry->branch }}</td>
                                            <td>{{ $entry->description }}</td>
                                            <td class="fw-bold">{{ $entry->quantity }}</td>
                                            <td>
                                                <a href="{{ url('/entries/' . $entry->id) }}" class="btn btn-sm btn-info shadow-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
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
    </div>
</div>
@endsection
