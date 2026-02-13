@extends('admin.layouts.master')

@section('title', 'Admission Management')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css"
    rel="stylesheet">
<style>
    :root {
        --primary-color: #4361ee;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --info-color: #17a2b8;
        --light-bg: #f8f9fa;
        --card-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        --border-radius: 0.75rem;
    }

    .page-container {
        background-color: #f5f7fb;
        min-height: calc(100vh - 60px);
        padding: 20px;
    }

    .stats-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
        border-left: 4px solid var(--primary-color);
        transition: transform 0.3s ease;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-card.pending {
        border-left-color: var(--warning-color);
    }

    .stats-card.approved {
        border-left-color: var(--success-color);
    }

    .stats-card.completed {
        border-left-color: var(--primary-color);
    }

    .stats-card.rejected {
        border-left-color: var(--danger-color);
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .stats-card.pending .stats-icon {
        background: rgba(255, 193, 7, 0.1);
        color: var(--warning-color);
    }

    .stats-card.approved .stats-icon {
        background: rgba(40, 167, 69, 0.1);
        color: var(--success-color);
    }

    .stats-card.completed .stats-icon {
        background: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
    }

    .stats-card.rejected .stats-icon {
        background: rgba(220, 53, 69, 0.1);
        color: var(--danger-color);
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stats-label {
        color: #6c757d;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .main-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-top: 1.5rem;
    }

    .card-header-custom {
        background: white;
        border-bottom: 1px solid #eaeaea;
        padding: 1.5rem;
    }

    .card-header-custom h4 {
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header-custom h4 i {
        color: var(--primary-color);
    }

    .filter-container {
        background: var(--light-bg);
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .filter-section-title {
        font-size: 0.875rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .student-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        margin-right: 0.75rem;
    }

    .student-info {
        display: flex;
        align-items: center;
    }

    .student-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.125rem;
    }

    .student-email {
        font-size: 0.75rem;
        color: #6c757d;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .badge-pending {
        background: rgba(255, 193, 7, 0.1);
        color: #856404;
    }

    .swal2-toast {
        font-size: 12px !important;
        padding: 6px 10px !important;
        min-width: auto !important;
        width: 220px !important;
        line-height: 1.3em !important;
    }

    .swal2-toast .swal2-icon {
        width: 24px !important;
        height: 24px !important;
        margin-right: 6px !important;
    }

    .swal2-toast .swal2-title {
        font-size: 13px !important;
    }

    .badge-approved {
        background: rgba(40, 167, 69, 0.1);
        color: #155724;
    }

    .badge-completed {
        background: rgba(67, 97, 238, 0.1);
        color: #0d47a1;
    }

    .badge-rejected {
        background: rgba(220, 53, 69, 0.1);
        color: #721c24;
    }

    .payment-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .badge-paid {
        background: rgba(40, 167, 69, 0.1);
        color: #155724;
    }

    .badge-pending-payment {
        background: rgba(255, 193, 7, 0.1);
        color: #856404;
    }

    .badge-partial {
        background: rgba(23, 162, 184, 0.1);
        color: #0c5460;
    }

    .fees-progress {
        width: 100px;
        height: 6px;
        background: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
        margin-top: 0.25rem;
    }

    .fees-progress-bar {
        height: 100%;
        background: var(--success-color);
        border-radius: 3px;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-view {
        background: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
    }

    .btn-view:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .btn-letter {
        background: rgba(255, 193, 7, 0.1);
        color: var(--warning-color);
    }

    .btn-letter:hover {
        background: var(--warning-color);
        color: white;
        transform: translateY(-2px);
    }

    .btn-download {
        background: rgba(40, 167, 69, 0.1);
        color: var(--success-color);
    }

    .btn-download:hover {
        background: var(--success-color);
        color: white;
        transform: translateY(-2px);
    }

    .dataTables_wrapper {
        padding: 0 1.5rem;
    }

    .dataTables_filter input {
        border-radius: 0.5rem !important;
        border: 1px solid #dee2e6 !important;
        padding: 0.5rem 1rem !important;
    }

    .dataTables_length select {
        border-radius: 0.5rem !important;
        border: 1px solid #dee2e6 !important;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #2c3e50;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        background: var(--light-bg);
    }

    .table td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-color: #f1f3f4;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(67, 97, 238, 0.02);
        transform: translateX(4px);
    }

    .pagination {
        margin: 1.5rem 0;
    }

    .page-link {
        border: none;
        color: #6c757d;
        border-radius: 0.5rem !important;
        margin: 0 0.25rem;
        padding: 0.5rem 0.75rem;
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .page-container {
            padding: 10px;
        }

        .stats-card {
            margin-bottom: 1rem;
        }

        .filter-container {
            padding: 1rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }
    }
</style>


@section('content')
    <div class="page-container">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card pending">
                    <div class="stats-icon">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                    <div class="stats-number">
                        {{ $stats['pending'] ?? 0 }}
                    </div>
                    <div class="stats-label">Pending Admissions</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card approved">
                    <div class="stats-icon">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                    <div class="stats-number">
                        {{ $stats['approved'] ?? 0 }}
                    </div>
                    <div class="stats-label">Approved</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card completed">
                    <div class="stats-icon">
                        <i class="fas fa-graduation-cap fa-lg"></i>
                    </div>
                    <div class="stats-number">
                        {{ $stats['completed'] ?? 0 }}
                    </div>
                    <div class="stats-label">Completed</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card rejected">
                    <div class="stats-icon">
                        <i class="fas fa-times-circle fa-lg"></i>
                    </div>
                    <div class="stats-number">
                        {{ $stats['rejected'] ?? 0 }}
                    </div>
                    <div class="stats-label">Rejected</div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="main-card">
            <div class="card-header-custom">
                <h4>
                    <i class="fas fa-user-graduate"></i>
                    Admission Applications
                </h4>
            </div>

            <!-- Filters -->
            <div class="filter-container">
                <div class="filter-section-title">
                    <i class="fas fa-filter me-2"></i>Filter Applications
                </div>
                <form method="GET" class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold">Admission Status</label>
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold">Payment Status</label>
                        <select name="payment_status" class="form-select" onchange="this.form.submit()">
                            <option value="all" {{ request('payment_status') == 'all' ? 'selected' : '' }}>All Payments
                            </option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Payment
                                Pending</option>
                            <option value="partially_paid"
                                {{ request('payment_status') == 'partially_paid' ? 'selected' : '' }}>Partially Paid
                            </option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Fully Paid
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-8">
                        <label class="form-label small fw-bold">Search Student</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Search by name or email"
                                value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.admission.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="admissionTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Sessions</th>
                                <th>Fees</th>
                                <th>Payment Progress</th>
                                <th>Status</th>
                                <th>Applied Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admissions as $admission)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark">#{{ $admission->id }}</span>
                                    </td>
                                    <td>
                                        <div class="student-info">
                                            <div class="student-avatar">
                                                {{ substr($admission->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="student-name">{{ $admission->user->name }}</div>
                                                <div class="student-email">{{ $admission->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $admission->course->title }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            {{ $admission->course->total_sessions }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">₹{{ number_format($admission->total_fees, 0) }}</div>
                                        <small class="text-muted">
                                            Paid: ₹{{ number_format($admission->paid_amount, 0) }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                {{ round(($admission->paid_amount / $admission->total_fees) * 100, 1) }}%
                                            </div>
                                            <div class="fees-progress">
                                                <div class="fees-progress-bar"
                                                    style="width: {{ ($admission->paid_amount / $admission->total_fees) * 100 }}%">
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            Due: ₹{{ number_format($admission->due_amount, 0) }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <span class="status-badge {{ 'badge-' . $admission->admission_status }}">
                                                {{ ucfirst($admission->admission_status) }}
                                            </span>
                                            <span
                                                class="payment-badge {{ 'badge-' . str_replace('_', '-', $admission->payment_status) }}">
                                                {{ ucfirst(str_replace('_', ' ', $admission->payment_status)) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-nowrap">
                                            {{ $admission->created_at->format('d M Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $admission->created_at->format('h:i A') }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.admission.show', $admission->id) }}"
                                                class="btn-action btn-view" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.admission.letter', $admission->id) }}"
                                                target="_blank" class="btn-action btn-letter" title="Generate Letter">
                                                <i class="fas fa-file-alt"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $admissions->firstItem() ?? 0 }} to {{ $admissions->lastItem() ?? 0 }} of
                        {{ $admissions->total() }} entries
                    </div>
                    <nav>
                        {{ $admissions->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js">
    </script>
    <script>
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {
            // Initialize DataTable with enhanced options
            $('#admissionTable').DataTable({
                "pageLength": 10,
                "order": [
                    [0, 'desc']
                ],
                "responsive": true,
                "language": {
                    "search": "<i class='fas fa-search'></i>",
                    "searchPlaceholder": "Search applications...",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ applications",
                    "infoEmpty": "No applications available",
                    "paginate": {
                        "previous": "<i class='fas fa-chevron-left'></i>",
                        "next": "<i class='fas fa-chevron-right'></i>"
                    }
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": [8]
                }],
                "initComplete": function() {
                    // Add custom search input styling
                    $('.dataTables_filter input').addClass('form-control form-control-sm');
                    $('.dataTables_length select').addClass('form-select form-select-sm');
                }
            });

            // Toast notification function
            function showToast(message, type = 'success') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: type === 'success' ? '#d4edda' : '#f8d7da',
                    color: type === 'success' ? '#155724' : '#721c24',
                    iconColor: type === 'success' ? '#28a745' : '#dc3545',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: type,
                    title: message
                });
            }

            // Display success/error messages from session
            @if (session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif

            @if (session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif

            // Add row hover effects
            $('#admissionTable tbody tr').hover(
                function() {
                    $(this).css('cursor', 'pointer');
                },
                function() {
                    $(this).css('cursor', 'default');
                }
            );

            // Quick view on row click (excluding action buttons area)
            $('#admissionTable tbody td:not(:last-child)').click(function() {
                const admissionId = $(this).closest('tr').find('td:first-child .badge').text().replace('#',
                    '');
                if (admissionId) {
                    window.location.href = `${baseUrl}/admin/admission/${admissionId}`;
                }
            });

            // Add tooltips to action buttons
            $('[title]').tooltip({
                trigger: 'hover',
                placement: 'top'
            });
        });
    </script>
@endsection
