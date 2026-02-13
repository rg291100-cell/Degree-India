@extends('admin.layouts.master')

@section('title', 'User Details')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="row align-items-center m-4">
                        <div class="col-md-8 col-12">
                            <h2 class="page-title mb-1">User Details</h2>
                            <small class="text-muted">View and manage all users</small>
                        </div>

                        <div class="col-md-4 col-12 text-md-end mt-2 mt-md-0">

                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                ← Back to List
                            </a>
                        </div>
                    </div>


                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if ($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}"
                                        class="img-fluid rounded-circle"
                                        style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 200px; height: 200px;">
                                        <span
                                            class="text-white display-4">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <h4 class="mt-3">{{ $user->name }}</h4>
                                <span class="badge badge-{{ $user->status ? 'success' : 'danger' }}">
                                    {{ $user->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td>
                                            <span class="badge badge-info"
                                                style="color: purple">{{ $user->role->name ?? 'No Role' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $user->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $user->gender ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>{{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('d M Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <td>{{ $user->city ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td>{{ $user->state ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Education Level</th>
                                        <td>{{ $user->education_level ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Career Interest</th>
                                        <td>{{ $user->career_interest ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Account Created</th>
                                        <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated</th>
                                        <td>{{ $user->updated_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
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
