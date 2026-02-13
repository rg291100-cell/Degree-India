@extends('admin.layouts.master')

@section('title', 'View Expert Tip')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">


                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Expert Tip Details</h4>

                    <a href="{{ route('admin.expert-tips.index') }}" class="btn btn-secondary btn-sm float-end">
                        <i class="fas fa-arrow-left"></i> Back To List
                    </a>
                </div>
                <div class="card-body" style="padding: 20px;">
                    <div class="row">
                        <div class="col-md-4">
                            @if ($expertTip->thumbnail)
                                <img src="{{ $expertTip->thumbnail }}" alt="{{ $expertTip->title }}"
                                    class="img-fluid rounded">
                            @else
                                <div class="bg-light p-5 text-center rounded">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                    <p class="mt-2">No Thumbnail</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3>{{ $expertTip->title }}</h3>

                            <div class="mb-3">
                                <strong>Description:</strong>
                                <p>{{ $expertTip->description }}</p>
                            </div>

                            @if ($expertTip->video_link)
                                <div class="mb-3">
                                    <strong>Video Link:</strong>
                                    <a href="{{ $expertTip->video_link }}" target="_blank" class="d-block">
                                        {{ $expertTip->video_link }}
                                    </a>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        <span class="badge bg-{{ $expertTip->is_active ? 'success' : 'danger' }}">
                                            {{ $expertTip->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Sort Order:</strong>
                                        {{ $expertTip->sort_order }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Created At:</strong>
                                        {{ $expertTip->created_at->format('d M, Y h:i A') }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Updated At:</strong>
                                        {{ $expertTip->updated_at->format('d M, Y h:i A') }}
                                    </div>
                                </div>
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
