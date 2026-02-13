@extends('admin.layouts.master')

@section('title', 'View Feature - Why Join Us')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    :root {
        --primary-red: #d52c2c;
        --primary-dark: #1a365d;
        --secondary-red: #b02323;
        --secondary-dark: #152a46;
        --light-red: #fef2f2;
        --light-dark: #f7fafc;
        --accent-red: #ef4444;
        --text-dark: #1e293b;
        --text-light: #64748b;
        --border-color: #cbd5e1;
        --success-green: #10b981;
        --white: #ffffff;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-dark), var(--secondary-dark));
        color: var(--white);
        padding: 20px 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-left: 5px solid var(--primary-red);
    }

    .page-header h3 {
        color: var(--white) !important;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .page-header small {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 8px 20px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-1px);
    }

    .card {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 25px;
    }

    .info-card {
        background: var(--white);
        border-radius: 12px;
        padding: 0;
        border: 1px solid var(--border-color);
        height: 100%;
    }

    .info-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .info-table tr {
        transition: all 0.3s ease;
    }

    .info-table tr:hover {
        background: var(--light-red);
    }

    .info-table th {
        background: var(--light-red);
        color: var(--primary-dark);
        font-weight: 700;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-color);
        width: 30%;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .info-table td {
        padding: 16px 20px;
        color: var(--text-dark);
        border-bottom: 1px solid var(--border-color);
        font-size: 0.95rem;
    }

    .info-table tr:last-child th,
    .info-table tr:last-child td {
        border-bottom: none;
    }

    .preview-card {
        background: linear-gradient(135deg, var(--primary-dark), var(--secondary-dark));
        color: var(--white);
        border-radius: 12px;
        padding: 25px;
        height: 100%;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .preview-card-header {
        background: rgba(255, 255, 255, 0.1);
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
    }

    .preview-card-header h5 {
        color: var(--white);
        margin: 0;
        font-weight: 600;
    }

    .icon-display {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .icon-display i {
        font-size: 36px;
        color: white;
    }

    .preview-title {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .preview-description {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 0;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .bg-success {
        background-color: var(--success-green) !important;
    }

    .bg-danger {
        background-color: var(--primary-red) !important;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 25px;
        padding-top: 25px;
        border-top: 1px solid var(--border-color);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        color: white;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, var(--primary-red), var(--secondary-red));
        border: none;
        color: white;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(213, 44, 44, 0.3);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .meta-info {
        color: var(--text-light);
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .meta-info i {
        width: 16px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 15px 20px;
        }

        .preview-card {
            margin-top: 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
        }
    }
</style>


@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1">
                    <i class="fas fa-eye me-2"></i>
                    Feature Details
                </h3>
                <small>Complete information about this feature</small>
            </div>
            <a href="{{ route('admin.why-join-features.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back To List
            </a>
        </div>

        <div class="row">
            <!-- Information Card -->
            <div class="col-md-8">
                <div class="info-card">
                    <div class="p-4">
                        <h5 class="mb-3" style="color: var(--primary-dark);">
                            <i class="fas fa-info-circle me-2"></i>
                            Feature Information
                        </h5>
                        <table class="info-table">
                            <tr>
                                <th>Title:</th>
                                <td>{{ $whyJoinFeature->title }}</td>
                            </tr>
                            <tr>
                                <th>Icon:</th>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div
                                            style="width: 40px; height: 40px; background: var(--light-red); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            <i class="{{ $whyJoinFeature->icon }} fa-lg"
                                                style="color: var(--primary-red);"></i>
                                        </div>
                                        <code>{{ $whyJoinFeature->icon }}</code>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td>
                                    @if ($whyJoinFeature->description)
                                        {{ $whyJoinFeature->description }}
                                    @else
                                        <span class="text-muted">No description provided</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Order:</th>
                                <td>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-sort-numeric-up me-1"></i>
                                        Position: {{ $whyJoinFeature->order }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span
                                        class="status-badge badge bg-{{ $whyJoinFeature->is_active ? 'success' : 'danger' }}">
                                        <i class="fas fa-{{ $whyJoinFeature->is_active ? 'check' : 'times' }} me-1"></i>
                                        {{ $whyJoinFeature->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>
                                    <span class="meta-info">
                                        <i class="far fa-calendar-plus"></i>
                                        {{ $whyJoinFeature->created_at->format('d M Y, h:i A') }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Updated:</th>
                                <td>
                                    <span class="meta-info">
                                        <i class="far fa-calendar-check"></i>
                                        {{ $whyJoinFeature->updated_at->format('d M Y, h:i A') }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-md-4">
                <div class="preview-card">
                    <div class="preview-card-header">
                        <h5>
                            <i class="fas fa-eye me-2"></i>
                            Live Preview
                        </h5>
                    </div>
                    <div class="icon-display">
                        <i class="{{ $whyJoinFeature->icon }}"></i>
                    </div>
                    <h4 class="preview-title">{{ $whyJoinFeature->title }}</h4>
                    @if ($whyJoinFeature->description)
                        <p class="preview-description">{{ $whyJoinFeature->description }}</p>
                    @else
                        <p class="preview-description" style="opacity: 0.7;">
                            <i>No description available</i>
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="action-buttons">
                            <a href="{{ route('admin.why-join-features.edit', $whyJoinFeature) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i> Edit Feature
                            </a>
                            <form action="{{ route('admin.why-join-features.destroy', $whyJoinFeature) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Are you sure you want to delete this feature?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i> Delete Feature
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let baseUrl = "{{ config('app.url') }}";
        $(document).ready(function() {
            // Add confirmation for delete
            $('form[onsubmit]').on('submit', function(e) {
                if (!confirm(
                        'Are you sure you want to delete this feature? This action cannot be undone.')) {
                    e.preventDefault();
                }
            });

            // Add smooth hover effects
            $('.btn').hover(
                function() {
                    $(this).css('transform', 'translateY(-2px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );
        });
    </script>
@endsection
