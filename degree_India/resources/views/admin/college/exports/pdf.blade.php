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

        .logo-cell {
            width: 40px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Colleges Management Report</div>
        <div class="subtitle">Generated on: {{ date('F j, Y, g:i a') }}</div>

        @if (!empty(array_filter($filters)))
            <div class="filters mt-2">
                <strong>Filters Applied:</strong>
                @if (isset($filters['status']) && $filters['status'])
                    <span>Status: {{ ucfirst($filters['status']) }}</span>
                @endif
                @if (isset($filters['type']) && $filters['type'])
                    <span>Type: {{ ucfirst($filters['type']) }}</span>
                @endif
                @if (isset($filters['state']) && $filters['state'])
                    <span>State: {{ $filters['state'] }}</span>
                @endif
                @if (isset($filters['search']) && $filters['search'])
                    <span>Search: {{ $filters['search'] }}</span>
                @endif
            </div>
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Name</th>
                <th>Location</th>
                <th>Type</th>
                <th>Courses</th>
                <th>Status</th>
                <th>Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colleges as $college)
                <tr>
                    <td>#{{ $college->id }}</td>
                    <td class="logo-cell">✓</td>
                    <td>{{ $college->name }}</td>
                    <td>{{ $college->city }}, {{ $college->state }}</td>
                    <td>{{ ucfirst($college->type) }}</td>
                    <td>{{ $college->courses_count ?? $college->courses->count() }}</td>
                    <td>{{ ucfirst($college->status) }}</td>
                    <td>{{ $college->admin ? $college->admin->name : 'Not Assigned' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: center; font-size: 9px; color: #666;">
        Total Records: {{ $colleges->count() }}
    </div>
</body>

</html>
