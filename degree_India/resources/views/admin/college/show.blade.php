@extends('admin.layouts.master')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $college->name }}</h1>
            <div>
                <a href="{{ route('admin.colleges.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <a href="{{ route('admin.colleges.edit', $college) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.colleges.destroy', $college) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-md-8">
                <!-- College Overview -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 text-white"> College Overview</h5>
                    </div>
                    <div class="card-body">
                        @if ($college->cover_image)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $college->cover_image) }}" alt="{{ $college->name }}"
                                    class="img-fluid rounded">
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                @if ($college->logo)
                                    <img src="{{ asset('storage/' . $college->logo) }}" alt="{{ $college->name }}"
                                        class="img-thumbnail mb-2" width="120">
                                @else
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 120px; height: 120px;">
                                        <i class="fas fa-university fa-3x"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h3>{{ $college->name }}</h3>
                                <p class="text-muted">{{ $college->short_description }}</p>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p><strong><i class="fas fa-map-marker-alt"></i> Location:</strong><br>
                                            {{ $college->address }}, {{ $college->city }}<br>
                                            {{ $college->state }}, {{ $college->country }} - {{ $college->pincode }}</p>

                                        <p><strong><i class="fas fa-calendar-alt"></i> Established:</strong>
                                            {{ $college->established_year }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong><i class="fas fa-graduation-cap"></i> Type:</strong>
                                            <span class="badge bg-info text-capitalize">{{ $college->type }}</span>
                                        </p>
                                        <p><strong><i class="fas fa-users"></i> Students:</strong>
                                            {{ number_format($college->total_students) }}</p>
                                        <p><strong><i class="fas fa-chalkboard-teacher"></i> Faculty:</strong>
                                            {{ number_format($college->total_faculty) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5><i class="fas fa-info-circle"></i> About College</h5>
                        <div class="mb-4">
                            {!! $college->description !!}
                        </div>
                    </div>
                </div>

                <!-- Courses Offered -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0 text-white"> Courses Offered</h5>
                    </div>
                    <div class="card-body">
                        @if ($college->courses->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Duration</th>
                                            <th>Fees (₹)</th>
                                            <th>Intake</th>
                                            <th>Seats</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($college->courses as $course)
                                            <tr>
                                                <td>
                                                    <strong>{{ $course->title }}</strong><br>
                                                    <small class="text-muted">{{ $course->short_description }}</small>
                                                </td>
                                                <td>{{ $course->pivot->duration ?? 'N/A' }}</td>
                                                <td>₹{{ number_format($course->pivot->fees) }}</td>
                                                <td>{{ ucfirst($course->pivot->intake ?? 'Yearly') }}</td>
                                                <td>{{ $course->pivot->seats ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> No courses assigned to this college yet.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Admission Details -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0 text-white">Admission Details</h5>
                    </div>
                    <div class="card-body">
                        <h6>Admission Process</h6>
                        <p>{!! nl2br(e($college->admission_process)) !!}</p>

                        <hr>

                        <h6>Eligibility Criteria</h6>
                        @if ($college->eligibility_criteria)
                            <ul class="list-group">
                                @foreach ($college->eligibility_criteria as $criteria)
                                    @if (is_array($criteria))
                                        <li class="list-group-item">
                                            <strong>{{ $criteria['criteria'] ?? '' }}:</strong>
                                            {{ $criteria['description'] ?? '' }}
                                        </li>
                                    @else
                                        <li class="list-group-item">{{ $criteria }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No eligibility criteria specified.</p>
                        @endif

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Application Deadline:</strong><br>
                                    {{ $college->application_deadline ? \Carbon\Carbon::parse($college->application_deadline)->format('d M, Y') : 'Not specified' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Academic Year Start:</strong><br>
                                    {{ $college->academic_year_start ? \Carbon\Carbon::parse($college->academic_year_start)->format('d M, Y') : 'Not specified' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Right Column -->
            <div class="col-md-4">
                <!-- Status Card -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0 text-white"> College Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <p><strong>Status:</strong></p>
                                @if ($college->status == 'published')
                                    <span class="badge bg-success p-2">Published</span>
                                @elseif($college->status == 'draft')
                                    <span class="badge bg-warning p-2">Draft</span>
                                @else
                                    <span class="badge bg-danger p-2">Archived</span>
                                @endif
                            </div>
                            <div class="col-6">
                                <p><strong>Featured:</strong></p>
                                @if ($college->is_featured)
                                    <span class="badge bg-primary p-2">Featured</span>
                                @else
                                    <span class="badge bg-secondary p-2">Not Featured</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <p><strong>Rating:</strong></p>
                                <div class="text-warning">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $college->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <small>({{ $college->rating }}/5)</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <p><strong>Reviews:</strong></p>
                                <p>{{ $college->review_count }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <p><strong>Created:</strong> {{ $college->created_at->format('d M, Y') }}</p>
                                <p><strong>Updated:</strong> {{ $college->updated_at->format('d M, Y') }}</p>
                                <p><strong>Views:</strong> {{ $college->views_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gallery -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0 text-white"> Gallery</h5>
                    </div>
                    <div class="card-body">
                        @if ($college->gallery_images && count($college->gallery_images) > 0)
                            <div class="row">
                                @foreach ($college->gallery_images as $index => $image)
                                    <div class="col-4 mb-3">
                                        <a href="{{ asset('storage/' . $image) }}" data-lightbox="gallery">
                                            <img src="{{ asset('storage/' . $image) }}"
                                                alt="Gallery Image {{ $index + 1 }}" class="img-thumbnail">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-muted text-center">{{ count($college->gallery_images) }} images in gallery</p>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> No gallery images uploaded.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0 text-white"> Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong><i class="fas fa-phone"></i> Phone:</strong><br>
                            {{ $college->phone ?? 'Not specified' }}</p>

                        <p><strong><i class="fas fa-envelope"></i> Email:</strong><br>
                            @if ($college->email)
                                <a href="mailto:{{ $college->email }}">{{ $college->email }}</a>
                            @else
                                Not specified
                            @endif
                        </p>

                        <p><strong><i class="fas fa-globe"></i> Website:</strong><br>
                            @if ($college->website)
                                <a href="{{ $college->website }}" target="_blank">{{ $college->website }}</a>
                            @else
                                Not specified
                            @endif
                        </p>

                    </div>
                </div>

                <!-- Placement Details -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0 text-white"> Placement Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <p><strong>Avg Package:</strong><br>
                                    ₹{{ number_format($college->average_package) }}</p>
                            </div>
                            <div class="col-6">
                                <p><strong>Highest Package:</strong><br>
                                    ₹{{ number_format($college->highest_package) }}</p>
                            </div>
                        </div>

                        <p><strong>Placement %:</strong> {{ $college->placement_percentage }}%</p>

                        @if ($college->top_recruiters)
                            <p><strong>Top Recruiters:</strong></p>
                            <div class="d-flex flex-wrap">
                                @foreach ($college->top_recruiters as $recruiter)
                                    <span class="badge bg-light text-dark me-1 mb-1">{{ $recruiter }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Compact Facilities -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white py-2">
                        <h6 class="mb-0 text-white"><i class="fas fa-building me-1"></i> Facilities</h6>
                    </div>
                    <div class="card-body p-3">
                        @if ($college->facilities && count($college->facilities) > 0)
                            <div class="d-flex flex-wrap">
                                @foreach ($college->facilities as $facility)
                                    <span class="badge bg-light text-dark me-1 mb-1">
                                        <i class="fas fa-check text-success me-1"></i>{{ $facility }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0"><i>No facilities listed</i></p>
                        @endif
                    </div>
                </div>

                <!-- Compact Social Links -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white py-2">
                        <h6 class="mb-0 text-white"><i class="fas fa-share-alt me-1"></i> Social Links</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-wrap">


                            @if ($college->facebook_url)
                                <a href="{{ $college->facebook_url }}" target="_blank"
                                    class="btn btn-sm btn-outline-facebook me-2 mb-2">
                                    <i class="fab fa-facebook"></i> Facebook
                                </a>
                            @endif

                            @if ($college->instagram_url)
                                <a href="{{ $college->instagram_url }}" target="_blank"
                                    class="btn btn-sm btn-outline-instagram me-2 mb-2">
                                    <i class="fab fa-instagram"></i> Instagram
                                </a>
                            @endif

                            @if ($college->youtube_url)
                                <a href="{{ $college->youtube_url }}" target="_blank"
                                    class="btn btn-sm btn-outline-danger me-2 mb-2">
                                    <i class="fab fa-youtube"></i> YouTube
                                </a>
                            @endif

                            @if ($college->linkedin_url)
                                <a href="{{ $college->linkedin_url }}" target="_blank"
                                    class="btn btn-sm btn-outline-linkedin me-2 mb-2">
                                    <i class="fab fa-linkedin"></i> LinkedIn
                                </a>
                            @endif




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
    @if ($college->latitude && $college->longitude)
        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
        <script>
            let baseUrl = "{{ config('app.url') }}";

            function initMap() {
                const location = {
                    lat: {{ $college->latitude }},
                    lng: {{ $college->longitude }}
                };
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: location,
                });
                new google.maps.Marker({
                    position: location,
                    map: map,
                    title: "{{ $college->name }}"
                });
            }
            initMap();
        </script>
    @endif

    <!-- Lightbox for gallery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Image %1 of %2'
        });
    </script>
@endsection
