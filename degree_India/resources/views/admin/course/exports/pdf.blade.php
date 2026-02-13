<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Courses Report</div>
        <div class="subtitle">Generated on: {{ date('F j, Y, g:i a') }}</div>
    </div>

    <table class="table">
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
                    <td>{{ $course->category->name ?? 'N/A' }}</td>
                    <td>{{ $course->duration_text }}</td>
                    <td>{{ $course->formatted_fees }}</td>
                    <td>
                        @if ($course->status == 'published')
                            <span class="badge badge-success">Published</span>
                        @elseif($course->status == 'draft')
                            <span class="badge badge-warning">Draft</span>
                        @else
                            <span class="badge badge-secondary">Archived</span>
                        @endif
                    </td>
                    <td>{{ $course->featured ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer text-center">
        Total Records: {{ $courses->count() }}
    </div>
</body>

</html>
