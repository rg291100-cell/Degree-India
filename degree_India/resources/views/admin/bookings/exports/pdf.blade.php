<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 12px;
            color: #666;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }

        .table td {
            border: 1px solid #dee2e6;
            padding: 6px;
            font-size: 10px;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .filters {
            background: #f8f9fa;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 10px;
        }

        .filters strong {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Booking Sessions Report</div>
        <div class="subtitle">Generated on: {{ date('F j, Y, g:i a') }}</div>

        @if (!empty(array_filter($filters)))
            <div class="filters mt-2">
                <strong>Filters Applied:</strong>
                @if (isset($filters['month']) && $filters['month'])
                    <span>Month: {{ $filters['month'] }}</span>
                @endif
                @if (isset($filters['year']) && $filters['year'])
                    <span>Year: {{ $filters['year'] }}</span>
                @endif
                @if (isset($filters['language']) && $filters['language'])
                    <span>Language: {{ $filters['language'] }}</span>
                @endif
                @if (isset($filters['slot']) && $filters['slot'])
                    <span>Slot: {{ $filters['slot'] }}</span>
                @endif
            </div>
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Student Email</th>
                <th>Month</th>
                <th>Year</th>
                <th>Slot Time</th>
                <th>Language</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $index => $booking)
                <tr>
                    <td>#{{ $booking->id }}</td>
                    <td>{{ $booking->student->name ?? 'N/A' }}</td>
                    <td>{{ $booking->student->email ?? 'N/A' }}</td>
                    <td>{{ $booking->month }}</td>
                    <td>{{ $booking->year }}</td>
                    <td>{{ $booking->slot }}</td>
                    <td>{{ $booking->language }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: center; font-size: 9px; color: #666;">
        Total Records: {{ $bookings->count() }}
    </div>
</body>

</html>
