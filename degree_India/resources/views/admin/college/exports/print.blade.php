<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .table {
                font-size: 12px;
            }

            .badge {
                padding: 3px 8px;
                font-size: 10px;
            }
        }

        .print-header {
            border-bottom: 2px solid #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .print-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .print-subtitle {
            font-size: 14px;
            color: #666;
        }

        .table th {
            background-color: #f8f9fa !important;
            font-weight: 600;
        }

        .filter-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .college-logo {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <!-- Print Header -->
        <div class="print-header">
            <div class="row">
                <div class="col-8">
                    <div class="print-title">Colleges Management Report</div>
                    <div class="print-subtitle">
                        Generated on: {{ date('F j, Y, g:i a') }}
                    </div>
                </div>
                <div class="col-4 text-end">
                    <button class="btn btn-primary btn-sm no-print" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <button class="btn btn-secondary btn-sm no-print" onclick="window.close()">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter Information -->
        @if (!empty(array_filter($filters)))
            <div class="filter-info">
                <strong>Filters Applied:</strong>
                @if (isset($filters['status']) && $filters['status'])
                    <span class="badge bg-info me-2">Status: {{ ucfirst($filters['status']) }}</span>
                @endif
                @if (isset($filters['type']) && $filters['type'])
                    <span class="badge bg-info me-2">Type: {{ ucfirst($filters['type']) }}</span>
                @endif
                @if (isset($filters['state']) && $filters['state'])
                    <span class="badge bg-info me-2">State: {{ $filters['state'] }}</span>
                @endif
                @if (isset($filters['search']) && $filters['search'])
                    <span class="badge bg-info me-2">Search: {{ $filters['search'] }}</span>
                @endif
            </div>
        @endif


        <!-- Colleges Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Logo</th>
                        <th>College Name</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Courses</th>
                        <th>Status</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colleges as $index => $college)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-center">
                                <i class="fas fa-university"></i>
                            </td>
                            <td>
                                <strong>{{ $college->name }}</strong><br>
                                <small class="text-muted">{{ $college->short_description }}</small>
                            </td>
                            <td>{{ $college->city }}, {{ $college->state }}</td>
                            <td>{{ ucfirst($college->type) }}</td>
                            <td>{{ $college->courses_count ?? $college->courses->count() }}</td>
                            <td>
                                @if ($college->status == 'published')
                                    <span class="badge bg-success">Published</span>
                                @elseif($college->status == 'draft')
                                    <span class="badge bg-warning">Draft</span>
                                @else
                                    <span class="badge bg-danger">Archived</span>
                                @endif
                            </td>
                            <td>{{ $college->admin ? $college->admin->name : 'Not Assigned' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Print Footer -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <div class="text-muted small">
                    Generated by College Management System
                </div>
            </div>
        </div>
    </div>



    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        function exportToPDF() {
            window.location.href = window.location.pathname + '?export=pdf' + window.location.search;
        }

        // Auto print option
        @if (request('auto_print'))
            window.onload = function() {
                window.print();
            }
        @endif
    </script>
</body>

</html>
