@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">📸 Proof of Entries</h2>

    <!-- Search Form -->
    <form method="GET" action="{{ url()->current() }}" class="mb-4">
        @csrf
        <div class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search by Description or Branch">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Search</button>
                @if(request('search'))
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </div>
    </form>

    @if($entries->count())
        <div class="row">
            @foreach($entries as $entry)
                <div class="col-md-4 mb-4 d-flex">
                    <div class="card shadow-sm w-100" style="height: 100%;">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-{{ $entry->id }}">
                            @if ($entry->proof_image && file_exists(public_path('storage/' . $entry->proof_image)))
                                <img src="{{ asset('storage/' . $entry->proof_image) }}" class="card-img-top img-fluid" alt="Proof Image" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/400x300?text=No+Image" class="card-img-top img-fluid" alt="No image available" style="height: 200px; object-fit: cover;">
                            @endif
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">Entry ID: {{ $entry->id }}</h6>
                            <p class="card-text">
                                <small class="text-muted">Uploaded: {{ $entry->created_at->format('F d, Y h:i A') }}</small>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modal-{{ $entry->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $entry->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $entry->id }}">📋 Entry Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="printable-{{ $entry->id }}">
                                <div class="text-center mb-3">
                                    @if ($entry->proof_image && file_exists(public_path('storage/' . $entry->proof_image)))
                                        <img src="{{ asset('storage/' . $entry->proof_image) }}" class="img-fluid rounded" style="max-height: 300px;" alt="Proof Image">
                                    @else
                                        <img src="https://via.placeholder.com/600x400?text=No+Image" class="img-fluid rounded" alt="No image available">
                                    @endif
                                </div>

                                <table class="table table-bordered">
                                    <tr><th>Entry ID</th><td>{{ $entry->id }}</td></tr>
                                    <tr><th>Date Received</th><td>{{ $entry->date_received }}</td></tr>
                                    <tr><th>Branch</th><td>{{ $entry->branch }}</td></tr>
                                    <tr><th>Description</th><td>{{ $entry->description }}</td></tr>
                                    <tr><th>Quantity</th><td>{{ $entry->quantity }}</td></tr>
                                    <tr><th>Amount</th><td>₱{{ number_format($entry->amount, 2) }}</td></tr>
                                    <tr><th>Total</th><td>₱{{ number_format($entry->total, 2) }}</td></tr>
                                    <tr><th>Date Release</th><td>{{ $entry->date_release ?? 'N/A' }}</td></tr>
                                    <tr><th>Received By</th><td>{{ $entry->received_by ?? 'N/A' }}</td></tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button onclick="printEntry({{ $entry->id }})" class="btn btn-primary">🖨️ Print</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">No proof images available.</div>
    @endif

    <a href="{{ url('/entries') }}" class="btn btn-secondary mt-3">← Back to Entries</a>
</div>

<script>
function printEntry(id) {
    const content = document.getElementById('printable-' + id).innerHTML;
    const original = document.body.innerHTML;
    document.body.innerHTML = content;
    window.print();
    document.body.innerHTML = original;
    window.location.reload(); // optional: refresh to restore layout
}
</script>
@endsection
