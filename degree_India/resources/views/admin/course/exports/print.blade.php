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
    </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <!-- Print Header -->
        <div class="print-header">
            <div class="row">
                <div class="col-8">
                    <div class="print-title">Courses Report</div>
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



        <!-- Courses Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Course Type</th>
                        <th>Course Mode</th>
                        <th>Category</th>
                        <th>Duration</th>
                        <th>Fees</th>
                        <th>Status</th>
                        <th>Featured</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $index => $course)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->course_type }}</td>
                            <td>{{ $course->course_mode }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $course->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ $course->duration_text }}</td>
                            <td>{{ $course->formatted_fees }}</td>
                            <td>
                                @if ($course->status == 'published')
                                    <span class="badge bg-success">Published</span>
                                @elseif($course->status == 'draft')
                                    <span class="badge bg-warning text-dark">Draft</span>
                                @else
                                    <span class="badge bg-secondary">Archived</span>
                                @endif
                            </td>
                            <td>
                                @if ($course->featured)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
