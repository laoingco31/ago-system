@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if(auth()->user()->role === 'admin')
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Entry</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('/entries') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- All form fields here (unchanged) -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date Received</label>
                        <input type="text" id="date_received" name="date_received" class="form-control datepicker" required readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Branch</label>
                        <input type="text" name="branch" class="form-control" placeholder="Enter Branch" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Description</label>
                        <input type="text" name="description" class="form-control" placeholder="Enter Description" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Quantity</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Amount</label>
                        <input type="number" id="amount" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Total</label>
                        <input type="number" id="total" step="0.01" name="total" class="form-control" placeholder="0.00" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date Release</label>
                        <input type="text" id="date_release" name="date_release" class="form-control datepicker" required readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Received By</label>
                        <div class="input-group">
                            <input type="text" name="received_by" id="received_by" class="form-control" placeholder="Enter Name" required>
                            <div class="input-group-text">
                                <input type="checkbox" id="pending_checkbox"> Pending
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ url('/entries') }}" class="btn btn-secondary me-2">
                        Back to List
                    </a>
                    <button type="submit" class="btn btn-success">
                        Add Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
    @else
        <div class="alert alert-danger shadow text-center">
            <i class="fas fa-ban"></i> You are not authorized to add new entries.
        </div>
    @endif
</div>

{{-- JS and CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr(".datepicker", {
            dateFormat: "m/d/Y",
            allowInput: false,
            disableMobile: true
        });

        function updateTotal() {
            let quantity = parseFloat(document.getElementById('quantity').value) || 0;
            let amount = parseFloat(document.getElementById('amount').value) || 0;
            document.getElementById('total').value = (quantity * amount).toFixed(2);
        }

        document.getElementById('quantity').addEventListener('input', updateTotal);
        document.getElementById('amount').addEventListener('input', updateTotal);

        document.getElementById('pending_checkbox').addEventListener('change', function () {
            let inputField = document.getElementById('received_by');
            if (this.checked) {
                inputField.value = 'Pending';
                inputField.setAttribute('readonly', 'readonly');
            } else {
                inputField.value = '';
                inputField.removeAttribute('readonly');
            }
        });
    });
</script>
@endsection
