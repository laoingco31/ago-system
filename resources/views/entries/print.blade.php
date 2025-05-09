<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Entries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            font-size: 12px;
        }
        .container {
            margin-top: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .print-btn {
            display: none;
        }
        @media print {
            .print-btn {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <button onclick="window.print()" class="btn btn-primary print-btn mb-3">
        <i class="fas fa-print"></i> Print Now
    </button>

    <h3 class="text-center">Entries Report</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Date Received</th>
                <th>Branch</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Total</th>
                <th>Date Release</th>
                <th>Received By</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entries as $entry)
            <tr>
                <td>{{ \Carbon\Carbon::parse($entry->date_received)->format('m-d-Y') }}</td>
                <td>{{ $entry->branch }}</td>
                <td>{{ $entry->description }}</td>
                <td>{{ $entry->quantity }}</td>
                <td>₱{{ number_format($entry->amount, 2) }}</td>
                <td>₱{{ number_format($entry->total, 2) }}</td>
                <td>
                    @if ($entry->date_release)
                        {{ \Carbon\Carbon::parse($entry->date_release)->format('m-d-Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $entry->received_by }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
