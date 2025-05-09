@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Entry</h2>

    <form action="{{ url('/entries/' . $entry->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Date Release</label>
            <input type="date" name="date_release" class="form-control" 
                   value="{{ $entry->date_release ? \Carbon\Carbon::parse($entry->date_release)->format('Y-m-d') : '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Received By</label>
            <input type="text" name="received_by" class="form-control" 
                   value="{{ old('received_by', $entry->received_by) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Proof Image</label>
            <input type="file" name="proof_image" class="form-control" accept="image/*" capture="environment">
            @if ($entry->proof_image)
                <p class="mt-2">Current Image:</p>
                <img src="{{ asset('storage/' . $entry->proof_image) }}" alt="Proof Image" style="max-width: 200px;">
            @endif
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Entry</button>
            <a href="{{ url('/entries') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
