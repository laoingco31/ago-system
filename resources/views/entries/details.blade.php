<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balibago Waterworks System Inc.</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px; /* Limit width to fit on short paper */
            margin-top: 30px;
        }

        .card {
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
        }

        .entry-section {
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ddd;
        }

        .entry-label {
            font-weight: bold;
            text-transform: uppercase;
            color: #212529;
            font-size: 13px;
        }

        .entry-value {
            font-size: 16px;
            color: #495057;
        }

        .signature-section {
            margin-top: 35px;
            text-align: center; /* Centering the signature line */
        }

        .signature-line {
            margin-top: 40px;
            border-bottom: 2px solid black; /* Creates the underline */
            width: 250px;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            color: #212529;
            display: inline-block; /* Ensures the line is inline with the label */
        }

        .logo {
            width: 150px; /* Adjust the logo size */
            height: auto;
            display: block;
            margin: 0 auto; /* Center the logo horizontally */
        }

        @media print {
            body, html {
                margin: 0 !important;
                padding: 0 !important;
                width: 100%;
            }

            .print-hide {
                display: none !important;
            }

            .container {
                margin: 10mm;
                width: auto;
                max-width: 100%;
            }

            .card {
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #ddd;
            }

            .entry-section {
                margin-bottom: 15px;
                padding-bottom: 10px;
                border-bottom: 1px solid #ddd;
            }

            @page {
                size: A4; /* A4 size or 8.5 x 11 inches */
                margin: 10mm 15mm 15mm 15mm;
            }

            .entry-label {
                font-size: 12px !important;
            }

            .entry-value {
                font-size: 14px !important;
            }

            .logo {
                display: block;
                margin: 0 auto;
                width: 150px; /* Adjust the logo size */
                height: auto;
            }

            .card-body {
                padding: 10px;
            }

            .signature-line {
                font-size: 14px;
                width: 200px; /* Adjust the signature line width for a better fit */
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <!-- Navbar content if needed -->
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-info text-white print-hide text-center">
                <!-- Optional: You can replace this with the logo if you want to -->
            </div>

            <!-- Adding logo at the top -->
            <img src="{{ asset('image/logo.png') }}" alt="Logo" class="logo"> <!-- Ensure correct image path -->

            <div class="card-body print-area" id="printArea">
                <!-- Use Blade to dynamically inject values from the controller -->
                <div class="entry-section">
                    <div class="row">
                        <div class="col-6">
                            <p class="entry-label">Date Received:</p>
                            <p class="entry-value">{{ $entry->date_received }}</p> <!-- Dynamic value -->
                        </div>
                        <div class="col-6">
                            <p class="entry-label">Branch:</p>
                            <p class="entry-value">{{ $entry->branch }}</p> <!-- Dynamic value -->
                        </div>
                    </div>
                </div>

                <div class="entry-section">
                    <p class="entry-label">Description:</p>
                    <p class="entry-value">{{ $entry->description }}</p> <!-- Dynamic value -->
                </div>

                <div class="entry-section">
                    <div class="row">
                        <div class="col-6">
                            <p class="entry-label">Quantity:</p>
                            <p class="entry-value">{{ $entry->quantity }}</p> <!-- Dynamic value -->
                        </div>
                        <div class="col-6">
                            <p class="entry-label">Amount:</p>
                            <p class="entry-value">{{ $entry->amount }}</p> <!-- Dynamic value -->
                        </div>
                    </div>
                </div>

                <div class="entry-section">
                    <p class="entry-label">Total:</p>
                    <p class="entry-value">{{ $entry->total }}</p> <!-- Dynamic value -->
                </div>

                <div class="entry-section">
                    <p class="entry-label">Date Release:</p>
                    <p class="entry-value">{{ $entry->date_release }}</p> <!-- Dynamic value -->
                </div>

                <div class="signature-section">
                    <p class="entry-label">Received By:</p>

                    <p class="signature-line">{{ $entry->received_by ?? 'Pending' }}</p> <!-- Dynamic value or 'Pending' -->
                </div>
            </div>

            <div class="text-center mt-3 print-hide">
                <button onclick="printDocument()" class="btn btn-primary">Print</button>
                <a href="/entries" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>

    <script>
        function printDocument() {
            window.print();
        }
    </script>

</body>
</html>
