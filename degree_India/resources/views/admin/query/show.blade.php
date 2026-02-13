@extends('admin.layouts.master')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@section('title', 'View Query Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <!-- Query Details Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Query Details #{{ $query['id'] }}</h6>
                        <div>
                            <a href="{{ route('admin.queries.edit', $query['id']) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.queries.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-list me-1"></i> All Queries
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <strong>Query ID:</strong>
                                <p class="text-muted">{{ $query['id'] }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Status:</strong>
                                <p>
                                    @if ($query['status'] == 'Pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($query['status'] == 'In Progress')
                                        <span class="badge bg-info text-white">In Progress</span>
                                    @else
                                        <span class="badge bg-success">Resolved</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <strong>Date:</strong>
                                <p class="text-muted">{{ $query['created_at'] }}</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <strong>Student Name:</strong>
                                <p class="text-muted">{{ $query['name'] }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Email:</strong>
                                <p class="text-muted">{{ $query['email'] }}</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <strong>Phone:</strong>
                                <p class="text-muted">{{ $query['phone'] }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Query Type:</strong>
                                <p><span class="badge bg-info text-white">{{ $query['query_type'] }}</span></p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <strong>College:</strong>
                                <p class="text-muted">{{ $query['college'] }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Course:</strong>
                                <p class="text-muted">{{ $query['course'] }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <strong>Query Message:</strong>
                            <div class="card mt-2">
                                <div class="card-body bg-light">
                                    <p class="mb-0">{{ $query['message'] }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($query['response'])
                            <div class="mb-4">
                                <strong>Response:</strong>
                                <div class="card mt-2 border-success">
                                    <div class="card-body bg-success bg-opacity-10">
                                        <p class="mb-0">{{ $query['response'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Response Form Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Respond to Query</h6>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="response_status" class="form-label">Update Status</label>
                                <select class="form-control" id="response_status">
                                    <option value="Pending" {{ $query['status'] == 'Pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="In Progress" {{ $query['status'] == 'In Progress' ? 'selected' : '' }}>
                                        In Progress</option>
                                    <option value="Resolved" {{ $query['status'] == 'Resolved' ? 'selected' : '' }}>
                                        Resolved</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="admin_response" class="form-label">Response Message *</label>
                                <textarea class="form-control" id="admin_response" rows="6" placeholder="Type your response here..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane me-2"></i> Send Response
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-success">
                                <i class="fas fa-check me-2"></i> Mark as Resolved
                            </button>
                            <button class="btn btn-warning">
                                <i class="fas fa-clock me-2"></i> Mark as In Progress
                            </button>
                            <button class="btn btn-info">
                                <i class="fas fa-envelope me-2"></i> Send Email
                            </button>
                            <button class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i> Delete Query
                            </button>
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
